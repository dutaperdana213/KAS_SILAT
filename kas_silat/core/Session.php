<?php
/**
 * Session Management Class
 */

class Session {
    private static $instance = null;
    
    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Set session value
     */
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Get session value
     */
    public function get($key, $default = null) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    /**
     * Check if session key exists
     */
    public function has($key) {
        return isset($_SESSION[$key]);
    }
    
    /**
     * Remove session key
     */
    public function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Destroy session
     */
    public function destroy() {
        session_destroy();
    }
    
    /**
     * Get all session data
     */
    public function all() {
        return $_SESSION;
    }
    
    /**
     * Regenerate session ID
     */
    public function regenerate() {
        session_regenerate_id(true);
    }
    
    /**
     * Set flash message
     */
    public function setFlash($type, $message) {
        $this->set('flash', [
            'type' => $type,
            'message' => $message
        ]);
    }
    
    /**
     * Get flash message
     */
    public function getFlash() {
        $flash = $this->get('flash');
        $this->remove('flash');
        return $flash;
    }
    
    /**
     * Set user data after login
     */
    public function setUser($user) {
        $this->set('user_id', $user['id']);
        $this->set('username', $user['username']);
        $this->set('nama_lengkap', $user['nama_lengkap']);
        $this->set('role', $user['role']);
        $this->set('logged_in', true);
        $this->set('login_time', time());
    }
    
    /**
     * Check if user is logged in
     */
    public function isLoggedIn() {
        return $this->get('logged_in') === true;
    }
    
    /**
     * Get current user role
     */
    public function getUserRole() {
        return $this->get('role');
    }
    
    /**
     * Get current user ID
     */
    public function getUserId() {
        return $this->get('user_id');
    }
    
    /**
     * Check if session expired
     */
    public function isExpired() {
        $loginTime = $this->get('login_time');
        
        if ($loginTime && (time() - $loginTime) > SESSION_EXPIRE) {
            return true;
        }
        
        return false;
    }
    
    private function __clone() {}
    
    public function __wakeup() {}
}
?>