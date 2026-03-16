<?php
/**
 * Core Controller Class
 */

require_once BASE_PATH . 'core/Session.php';
require_once BASE_PATH . 'core/Validation.php';
require_once BASE_PATH . 'core/Auth.php';

abstract class Controller {
    protected $session;
    protected $validation;
    protected $auth;
    
    public function __construct() {
        $this->session = Session::getInstance();
        $this->validation = new Validation();
        $this->auth = Auth::getInstance();
    }
    
    /**
     * Load model
     */
    protected function model($model) {
        $modelFile = BASE_PATH . 'models/' . $model . '.php';
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        
        throw new Exception("Model {$model} tidak ditemukan");
    }
    
    /**
     * Load view
     */
    protected function view($view, $data = []) {
        $viewFile = BASE_PATH . 'views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            extract($data);
            require_once $viewFile;
        } else {
            throw new Exception("View {$view} tidak ditemukan");
        }
    }
    
    /**
     * Load view with layout
     */
    protected function render($view, $data = [], $layout = 'layouts/main') {
        $this->view($layout, array_merge($data, [
            'content' => $view,
            'content_data' => $data
        ]));
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit;
    }
    
    /**
     * Check if request is POST
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Check if request is GET
     */
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    /**
     * Get POST data
     */
    protected function getPost($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        
        return isset($_POST[$key]) ? $this->sanitize($_POST[$key]) : $default;
    }
    
    /**
     * Get GET data
     */
    protected function getQuery($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        
        return isset($_GET[$key]) ? $this->sanitize($_GET[$key]) : $default;
    }
    
    /**
     * Sanitize input
     */
    protected function sanitize($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitize'], $input);
        }
        
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Generate CSRF token
     */
    protected function generateCsrfToken() {
        $token = bin2hex(random_bytes(32));
        $this->session->set('csrf_token', $token);
        return $token;
    }
    
    /**
     * Verify CSRF token
     */
    protected function verifyCsrfToken($token) {
        $storedToken = $this->session->get('csrf_token');
        
        if (empty($storedToken) || $token !== $storedToken) {
            return false;
        }
        
        $this->session->remove('csrf_token');
        return true;
    }
    
    /**
     * Set flash message
     */
    protected function setFlash($type, $message) {
        $this->session->set('flash', [
            'type' => $type,
            'message' => $message
        ]);
    }
    
    /**
     * Get flash message
     */
    protected function getFlash() {
        $flash = $this->session->get('flash');
        $this->session->remove('flash');
        return $flash;
    }
    
    /**
     * JSON response
     */
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Log activity
     */
    protected function logActivity($aktivitas, $tabel = null, $data_id = null) {
        $logModel = $this->model('LogAktivitas');
        
        $logModel->create([
            'user_id' => $this->auth->user()['id'] ?? null,
            'aktivitas' => $aktivitas,
            'tabel' => $tabel,
            'data_id' => $data_id,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
    }
}
?>