<?php
/**
 * Authentication Middleware
 */

require_once BASE_PATH . 'core/Auth.php';

class AuthMiddleware {
    public function handle() {
        $auth = Auth::getInstance();
        
        if (!$auth->check()) {
            // Check remember me
            if (!$auth->checkRememberMe()) {
                header('Location: ' . BASE_URL . '/auth/login');
                exit;
            }
        }
    }
}
?>