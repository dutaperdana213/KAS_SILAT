<?php
/**
 * User Controller
 * Manajemen pengguna sistem (Admin, Bendahara, Pembina)
 */

require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'models/User.php';
require_once BASE_PATH . 'models/LogAktivitas.php';

class UserController extends Controller {
    private $userModel;
    private $logModel;
    
    public function __construct() {
        parent::__construct();
        
        // Cek autentikasi
        if (!$this->auth->check()) {
            $this->redirect('auth/login');
        }
        
        // Hanya admin yang bisa akses manajemen user
        if (!$this->auth->isAdmin()) {
            $this->setFlash('error', 'Anda tidak memiliki akses ke halaman ini');
            $this->redirect('dashboard');
        }
        
        $this->userModel = new User();
        $this->logModel = new LogAktivitas();
    }
    
    /**
     * Daftar semua user
     */
    public function index() {
        $page = $this->getQuery('page', 1);
        $search = $this->getQuery('search', '');
        
        // Ambil data user dengan pagination
        $users = $this->userModel->getAllUsers($page, ITEMS_PER_PAGE, $search);
        
        $data = [
            'title' => 'Manajemen User - ' . APP_NAME,
            'users' => $users['data'],
            'pagination' => [
                'current_page' => $users['current_page'],
                'last_page' => $users['last_page'],
                'total' => $users['total'],
                'from' => ($users['current_page'] - 1) * ITEMS_PER_PAGE + 1,
                'to' => min($users['current_page'] * ITEMS_PER_PAGE, $users['total'])
            ],
            'search' => $search,
            'user' => $this->auth->user()
        ];
        
        $this->render('users/index', $data, 'layouts/main');
    }
    
    /**
     * Form tambah user baru
     */
    public function create() {
        $data = [
            'title' => 'Tambah User - ' . APP_NAME,
            'csrf_token' => $this->generateCsrfToken(),
            'user' => $this->auth->user()
        ];
        
        $this->render('users/create', $data, 'layouts/main');
    }
    
    /**
     * Proses simpan user baru
     */
    public function store() {
        if (!$this->isPost()) {
            $this->redirect('users/create');
        }
        
        // Validasi CSRF token
        $csrf_token = $this->getPost('csrf_token');
        if (!$this->verifyCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Invalid CSRF token');
            $this->redirect('users/create');
        }
        
        // Validasi input
        $rules = [
            'username' => 'required|min:3|max:50',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required|min:3|max:100',
            'email' => 'email',
            'role' => 'required'
        ];
        
        if (!$this->validation->validate($_POST, $rules)) {
            $this->setFlash('error', $this->validation->errorString());
            $this->redirect('users/create');
        }
        
        // Cek username sudah ada atau belum
        $existingUser = $this->userModel->findByUsername($this->getPost('username'));
        if ($existingUser) {
            $this->setFlash('error', 'Username sudah digunakan');
            $this->redirect('users/create');
        }
        
        $data = [
            'username' => $this->getPost('username'),
            'password' => password_hash($this->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->getPost('nama_lengkap'),
            'email' => $this->getPost('email'),
            'role' => $this->getPost('role'),
            'is_active' => $this->getPost('is_active', 1)
        ];
        
        $id = $this->userModel->create($data);
        
        if ($id) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Menambah user baru: ' . $data['username'],
                'tabel' => 'users',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->setFlash('success', 'User berhasil ditambahkan');
            $this->redirect('users');
        } else {
            $this->setFlash('error', 'Gagal menambah user');
            $this->redirect('users/create');
        }
    }
    
    /**
     * Form edit user
     */
    public function edit($id) {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            $this->setFlash('error', 'User tidak ditemukan');
            $this->redirect('users');
        }
        
        // Hapus password dari data
        unset($user['password']);
        
        $data = [
            'title' => 'Edit User - ' . APP_NAME,
            'user' => $user,
            'csrf_token' => $this->generateCsrfToken(),
            'current_user' => $this->auth->user()
        ];
        
        $this->render('users/edit', $data, 'layouts/main');
    }
    
    /**
     * Proses update user
     */
    public function update($id) {
        if (!$this->isPost()) {
            $this->redirect('users');
        }
        
        // Validasi CSRF token
        $csrf_token = $this->getPost('csrf_token');
        if (!$this->verifyCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Invalid CSRF token');
            $this->redirect('users/edit/' . $id);
        }
        
        // Validasi input
        $rules = [
            'username' => 'required|min:3|max:50',
            'nama_lengkap' => 'required|min:3|max:100',
            'email' => 'email',
            'role' => 'required'
        ];
        
        if (!$this->validation->validate($_POST, $rules)) {
            $this->setFlash('error', $this->validation->errorString());
            $this->redirect('users/edit/' . $id);
        }
        
        $data = [
            'username' => $this->getPost('username'),
            'nama_lengkap' => $this->getPost('nama_lengkap'),
            'email' => $this->getPost('email'),
            'role' => $this->getPost('role'),
            'is_active' => $this->getPost('is_active', 1)
        ];
        
        // Update password jika diisi
        $password = $this->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        $result = $this->userModel->update($id, $data);
        
        if ($result) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Mengupdate user: ' . $data['username'],
                'tabel' => 'users',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->setFlash('success', 'User berhasil diupdate');
        } else {
            $this->setFlash('error', 'Gagal mengupdate user');
        }
        
        $this->redirect('users');
    }
    
    /**
     * Hapus user
     */
    public function delete($id) {
        if (!$this->isPost()) {
            $this->redirect('users');
        }
        
        $user = $this->userModel->find($id);
        
        if (!$user) {
            $this->jsonResponse(['error' => 'User tidak ditemukan'], 404);
        }
        
        // Cegah admin menghapus diri sendiri
        if ($id == $this->auth->user()['id']) {
            $this->jsonResponse(['error' => 'Tidak dapat menghapus akun sendiri'], 400);
        }
        
        $result = $this->userModel->delete($id);
        
        if ($result) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Menghapus user: ' . $user['username'],
                'tabel' => 'users',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Gagal menghapus user'
            ], 500);
        }
    }
    
    /**
     * Aktifkan/nonaktifkan user
     */
    public function toggleStatus($id) {
        if (!$this->isPost()) {
            $this->redirect('users');
        }
        
        $user = $this->userModel->find($id);
        
        if (!$user) {
            $this->jsonResponse(['error' => 'User tidak ditemukan'], 404);
        }
        
        // Cegah admin menonaktifkan diri sendiri
        if ($id == $this->auth->user()['id']) {
            $this->jsonResponse(['error' => 'Tidak dapat menonaktifkan akun sendiri'], 400);
        }
        
        $status = $user['is_active'] ? 0 : 1;
        $result = $this->userModel->update($id, ['is_active' => $status]);
        
        if ($result) {
            $message = $status ? 'User diaktifkan' : 'User dinonaktifkan';
            
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => $message . ': ' . $user['username'],
                'tabel' => 'users',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->jsonResponse([
                'success' => true,
                'message' => $message
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Gagal mengubah status user'
            ], 500);
        }
    }
}
?>