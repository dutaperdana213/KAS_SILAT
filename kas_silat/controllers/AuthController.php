<?php
/**
 * Auth Controller
 * Menangani autentikasi pengguna
 */

require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'models/User.php';
require_once BASE_PATH . 'models/LogAktivitas.php';

class AuthController extends Controller {
    private $userModel;
    private $logModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->logModel = new LogAktivitas();
    }
    
    /**
     * Tampilkan halaman login
     */
    public function loginForm() {
        // Jika sudah login, redirect ke dashboard
        if ($this->auth->check()) {
            $this->redirect('dashboard');
        }
        
        $data = [
            'title' => 'Login - ' . APP_NAME,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        $this->view('auth/login', $data);
    }
    
    /**
     * Proses login
     */
    public function login() {
        if (!$this->isPost()) {
            $this->redirect('auth/login');
        }
        
        // Validasi CSRF token
        $csrf_token = $this->getPost('csrf_token');
        if (!$this->verifyCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Invalid CSRF token');
            $this->redirect('auth/login');
        }
        
        // Validasi input
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        
        if (!$this->validation->validate($_POST, $rules)) {
            $this->setFlash('error', $this->validation->errorString());
            $this->redirect('auth/login');
        }
        
        $username = $this->getPost('username');
        $password = $this->getPost('password');
        $remember = $this->getPost('remember') ? true : false;
        
        // Attempt login
        $result = $this->auth->attempt($username, $password, $remember);
        
        if ($result['success']) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $result['user']['id'],
                'aktivitas' => 'Login ke sistem',
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT']
            ]);
            
            $this->setFlash('success', 'Selamat datang, ' . $result['user']['nama_lengkap']);
            $this->redirect('dashboard');
        } else {
            $this->setFlash('error', $result['message']);
            $this->redirect('auth/login');
        }
    }
    
    /**
     * Logout
     */
    public function logout() {
        if ($this->auth->check()) {
            $user = $this->auth->user();
            
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $user['id'],
                'aktivitas' => 'Logout dari sistem',
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT']
            ]);
        }
        
        $this->auth->logout();
        $this->setFlash('success', 'Anda telah logout');
        $this->redirect('auth/login');
    }
    
    /**
     * Tampilkan form lupa password
     */
    public function forgotPassword() {
        $data = [
            'title' => 'Lupa Password - ' . APP_NAME,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        $this->view('auth/forgot-password', $data);
    }
    
    /**
     * Proses lupa password
     */
    public function sendResetLink() {
        if (!$this->isPost()) {
            $this->redirect('auth/forgot-password');
        }
        
        // Validasi CSRF token
        $csrf_token = $this->getPost('csrf_token');
        if (!$this->verifyCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Invalid CSRF token');
            $this->redirect('auth/forgot-password');
        }
        
        $email = $this->getPost('email');
        
        // Validasi email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setFlash('error', 'Format email tidak valid');
            $this->redirect('auth/forgot-password');
        }
        
        // Cek apakah email terdaftar
        $user = $this->userModel->findByUsername($email);
        
        if ($user) {
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Simpan token ke database (tambahkan field reset_token dan reset_expiry di tabel users)
            $this->userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_expiry' => $expiry
            ]);
            
            // Kirim email (implementasi sesuai kebutuhan)
            // $this->sendResetEmail($email, $token);
        }
        
        // Selalu tampilkan pesan sukses untuk keamanan (jangan beri tahu apakah email terdaftar atau tidak)
        $this->setFlash('success', 'Jika email terdaftar, link reset password akan dikirim');
        $this->redirect('auth/login');
    }
}
?>