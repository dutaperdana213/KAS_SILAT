<?php
/**
 * Role-based Access Control Middleware
 */

require_once BASE_PATH . 'core/Auth.php';

class RoleMiddleware {
    protected $allowedRoles = [];
    
    public function __construct($roles = []) {
        $this->allowedRoles = $roles;
    }
    
    public function handle() {
        $auth = Auth::getInstance();
        
        if (!$auth->check()) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
        
        if (!empty($this->allowedRoles)) {
            $userRole = $auth->user()['role'];
            
            if (!in_array($userRole, $this->allowedRoles)) {
                // Log akses tidak sah
                error_log("Unauthorized access attempt by user with role: {$userRole}");
                
                // Redirect ke dashboard dengan pesan error
                $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini';
                header('Location: ' . BASE_URL . '/dashboard');
                exit;
            }
        }
    }
}

/**
 * Helper function untuk middleware roles
 */
function role($roles) {
    return new RoleMiddleware($roles);
}

// Role constants
define('ROLE_ADMIN_ONLY', [ROLE_ADMIN]);
define('ROLE_BENDAHARA_ONLY', [ROLE_BENDAHARA]);
define('ROLE_PEMBINA_ONLY', [ROLE_PEMBINA]);
define('ROLE_ADMIN_BENDAHARA', [ROLE_ADMIN, ROLE_BENDAHARA]);
define('ROLE_ADMIN_PEMBINA', [ROLE_ADMIN, ROLE_PEMBINA]);
define('ROLE_BENDAHARA_PEMBINA', [ROLE_BENDAHARA, ROLE_PEMBINA]);
define('ROLE_ALL', [ROLE_ADMIN, ROLE_BENDAHARA, ROLE_PEMBINA]);
?>