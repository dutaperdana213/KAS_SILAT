<?php
/**
 * Profile Controller
 * Untuk mengelola profile user
 */

require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'models/User.php';
require_once BASE_PATH . 'models/LogAktivitas.php';

class ProfileController extends Controller {
    private $userModel;
    private $logModel;
    
    public function __construct() {
        parent::__construct();
        
        // Cek autentikasi
        if (!$this->auth->check()) {
            $this->redirect('auth/login');
        }
        
        $this->userModel = new User();
        $this->logModel = new LogAktivitas();
    }
    
    /**
     * Halaman profile
     */
    public function index() {
        $userId = $this->auth->user()['id'];
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            $this->setFlash('error', 'Data user tidak ditemukan');
            $this->redirect('dashboard');
        }
        
        // Hapus password dari data yang dikirim ke view
        unset($user['password']);
        
        $data = [
            'title' => 'Profile Saya - ' . APP_NAME,
            'user' => $user,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        $this->render('profile/index', $data, 'layouts/main');
    }
    
    /**
 * Update profile
 */
public function update() {
    if (!$this->isPost()) {
        $this->redirect('profile');
    }
    
    $userId = $this->auth->user()['id'];
    
    // Validasi CSRF token
    $csrf_token = $this->getPost('csrf_token');
    if (!$this->verifyCsrfToken($csrf_token)) {
        $this->setFlash('error', 'Invalid CSRF token');
        $this->redirect('profile');
    }
    
    // Validasi input - HANYA NAMA LENGKAP
    $rules = [
        'nama_lengkap' => 'required|min:3|max:100'
        // EMAIL DIHAPUS DARI VALIDASI
    ];
    
    if (!$this->validation->validate($_POST, $rules)) {
        $this->setFlash('error', $this->validation->errorString());
        $this->redirect('profile');
    }
    
    $data = [
        'nama_lengkap' => $this->getPost('nama_lengkap')
        // EMAIL DIHAPUS
    ];
    
    // BAGIAN UPLOAD FOTO PROFIL DIHAPUS
    
    // Update data
    $result = $this->userModel->updateProfile($userId, $data);
    
    if ($result) {
        // Update session
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        
        // Log aktivitas
        $this->logModel->create([
            'user_id' => $userId,
            'aktivitas' => 'Mengupdate profile',
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
        
        $this->setFlash('success', 'Profile berhasil diupdate');
    } else {
        $this->setFlash('error', 'Gagal mengupdate profile');
    }
    
    $this->redirect('profile');
}
    
    /**
     * Ganti password - DIHAPUS / DIKOMENTARI
     */
    public function changePassword() {
        if (!$this->isPost()) {
            $this->redirect('profile');
        }
        
        $userId = $this->auth->user()['id'];
        
        // Validasi CSRF token
        $csrf_token = $this->getPost('csrf_token');
        if (!$this->verifyCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Invalid CSRF token');
            $this->redirect('profile');
        }
        
        // Validasi input
        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|matches:password_baru'
        ];
        
        if (!$this->validation->validate($_POST, $rules)) {
            $this->setFlash('error', $this->validation->errorString());
            $this->redirect('profile');
        }
        
        $passwordLama = $this->getPost('password_lama');
        $passwordBaru = $this->getPost('password_baru');
        
        // Verifikasi password lama
        $user = $this->userModel->find($userId);
        
        if (!password_verify($passwordLama, $user['password'])) {
            $this->setFlash('error', 'Password lama salah');
            $this->redirect('profile');
        }
        
        // Update password
        $result = $this->userModel->changePassword($userId, $passwordBaru);
        
        if ($result) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $userId,
                'aktivitas' => 'Mengganti password',
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->setFlash('success', 'Password berhasil diganti');
        } else {
            $this->setFlash('error', 'Gagal mengganti password');
        }
        
        $this->redirect('profile');
    }
}
?>