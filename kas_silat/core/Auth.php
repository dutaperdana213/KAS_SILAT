<?php
/**
 * Authentication Class
 */

require_once BASE_PATH . 'core/Session.php';
require_once BASE_PATH . 'models/User.php';

class Auth {
    private static $instance = null;
    private $session;
    private $userModel;
    
    private function __construct() {
        $this->session = Session::getInstance();
        $this->userModel = new User();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Attempt login
     */
    public function attempt($username, $password, $remember = false) {
        $user = $this->userModel->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_active'] == 0) {
                return [
                    'success' => false,
                    'message' => 'Akun Anda tidak aktif'
                ];
            }
            
            // Set session
            $this->session->setUser($user);
            
            // Update last login
            $this->userModel->updateLastLogin($user['id']);
            
            // Set remember me cookie
            if ($remember) {
                $this->setRememberMe($user['id']);
            }
            
            return [
                'success' => true,
                'user' => $user
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Username atau password salah'
        ];
    }
    
    /**
     * Check if user is authenticated
     */
    public function check() {
        if (!$this->session->isLoggedIn()) {
            return false;
        }
        
        // Check session expiration
        if ($this->session->isExpired()) {
            $this->logout();
            return false;
        }
        
        return true;
    }
    
    /**
     * Get authenticated user
     */
    public function user() {
        if (!$this->check()) {
            return null;
        }
        
        return [
            'id' => $this->session->get('user_id'),
            'username' => $this->session->get('username'),
            'nama_lengkap' => $this->session->get('nama_lengkap'),
            'role' => $this->session->get('role')
        ];
    }
    
    /**
     * Check if user has role
     */
    public function hasRole($role) {
        $userRole = $this->session->get('role');
        
        if (is_array($role)) {
            return in_array($userRole, $role);
        }
        
        return $userRole === $role;
    }
    
    /**
     * Check if user is admin
     */
    public function isAdmin() {
        return $this->hasRole(ROLE_ADMIN);
    }
    
    /**
     * Check if user is bendahara
     */
    public function isBendahara() {
        return $this->hasRole(ROLE_BENDAHARA);
    }
    
    /**
     * Check if user is pembina
     */
    public function isPembina() {
        return $this->hasRole(ROLE_PEMBINA);
    }
    
    /**
     * Logout user
     */
    public function logout() {
        // Clear remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        $this->session->destroy();
    }
    
    /**
     * Set remember me cookie
     */
    private function setRememberMe($userId) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (86400 * 30); // 30 days
        
        // Store token in database
        $this->userModel->storeRememberToken($userId, $token, date('Y-m-d H:i:s', $expiry));
        
        // Set cookie
        setcookie('remember_token', $token, $expiry, '/', '', false, true);
    }
    
    /**
     * Check remember me
     */
    public function checkRememberMe() {
        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $user = $this->userModel->findByRememberToken($token);
            
            if ($user && strtotime($user['token_expiry']) > time()) {
                $this->session->setUser($user);
                return true;
            }
        }
        
        return false;
    }
    
    private function __clone() {}
    
    public function __wakeup() {}
}
?>