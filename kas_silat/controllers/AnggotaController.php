<?php
/**
 * Anggota Controller
 * Manajemen data anggota
 */

require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'models/Anggota.php';
require_once BASE_PATH . 'models/KasMasuk.php';
require_once BASE_PATH . 'models/LogAktivitas.php';

class AnggotaController extends Controller {
    private $anggotaModel;
    private $kasMasukModel;
    private $logModel;
    
    public function __construct() {
        parent::__construct();
        
        // Cek autentikasi
        if (!$this->auth->check()) {
            $this->redirect('auth/login');
        }
        
        $this->anggotaModel = new Anggota();
        $this->kasMasukModel = new KasMasuk();
        $this->logModel = new LogAktivitas();
    }
    
    /**
     * Daftar anggota
     */
    public function index() {
        // Cek role (admin dan bendahara bisa akses, pembina hanya lihat)
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA, ROLE_PEMBINA])) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('dashboard');
        }
        
        $page = $this->getQuery('page', 1);
        $search = $this->getQuery('search', '');
        
        $result = $this->anggotaModel->getAnggota($page, ITEMS_PER_PAGE, $search);
        
        $data = [
            'title' => 'Data Anggota - ' . APP_NAME,
            'anggota' => $result['data'],
            'pagination' => [
                'current_page' => $result['current_page'],
                'last_page' => $result['last_page'],
                'total' => $result['total']
            ],
            'search' => $search,
            'user' => $this->auth->user(),
            'can_edit' => $this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA]),
            'can_delete' => $this->auth->isAdmin() // Only admin can delete
        ];
        
        $this->render('anggota/index', $data, 'layouts/main');
    }
    
    /**
     * Form tambah anggota
     */
    public function create() {
        // Cek role (hanya admin dan bendahara)
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('anggota');
        }
        
        $data = [
            'title' => 'Tambah Anggota - ' . APP_NAME,
            'csrf_token' => $this->generateCsrfToken(),
            'user' => $this->auth->user()
        ];
        
        $this->render('anggota/create', $data, 'layouts/main');
    }
    
    /**
     * Proses simpan anggota baru
     */
    public function store() {
        // Cek role
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->jsonResponse(['error' => 'Unauthorized'], 403);
        }
        
        if (!$this->isPost()) {
            $this->redirect('anggota/create');
        }
        
        // Validasi CSRF token
        $csrf_token = $this->getPost('csrf_token');
        if (!$this->verifyCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Invalid CSRF token');
            $this->redirect('anggota/create');
        }
        
        // Validasi input
        $rules = [
            'nama' => 'required|min:3|max:100',
            'kelas' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'numeric' // opsional
        ];
        
        if (!$this->validation->validate($_POST, $rules)) {
            $this->setFlash('error', $this->validation->errorString());
            $this->redirect('anggota/create');
        }
        
        $data = [
            'nama' => $this->getPost('nama'),
            'kelas' => $this->getPost('kelas'),
            'jenis_kelamin' => $this->getPost('jenis_kelamin'),
            'no_hp' => $this->getPost('no_hp'),
            'tanggal_gabung' => date('Y-m-d'), // OTOMATIS HARI INI
            'status_aktif' => $this->getPost('status_aktif', 1),
            'created_by' => $this->auth->user()['id']
        ];
        
        // Simpan data
        $id = $this->anggotaModel->create($data);
        
        if ($id) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Menambah anggota baru: ' . $data['nama'],
                'tabel' => 'anggota',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->setFlash('success', 'Data anggota berhasil disimpan');
            $this->redirect('anggota');
        } else {
            $this->setFlash('error', 'Gagal menyimpan data anggota');
            $this->redirect('anggota/create');
        }
    }
    
    /**
     * Form edit anggota
     */
    public function edit($id) {
        // Cek role (hanya admin dan bendahara)
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('anggota');
        }
        
        $anggota = $this->anggotaModel->find($id);
        
        if (!$anggota) {
            $this->setFlash('error', 'Data anggota tidak ditemukan');
            $this->redirect('anggota');
        }
        
        $data = [
            'title' => 'Edit Anggota - ' . APP_NAME,
            'anggota' => $anggota,
            'csrf_token' => $this->generateCsrfToken(),
            'user' => $this->auth->user()
        ];
        
        $this->render('anggota/edit', $data, 'layouts/main');
    }
    
    /**
     * Proses update anggota
     */
    public function update($id) {
        // Cek role
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->jsonResponse(['error' => 'Unauthorized'], 403);
        }
        
        if (!$this->isPost()) {
            $this->redirect('anggota');
        }
        
        // Validasi CSRF token
        $csrf_token = $this->getPost('csrf_token');
        if (!$this->verifyCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Invalid CSRF token');
            $this->redirect('anggota/edit/' . $id);
        }
        
        // Validasi input
        $rules = [
            'nama' => 'required|min:3|max:100',
            'kelas' => 'required',
            'jenis_kelamin' => 'required'
        ];
        
        if (!$this->validation->validate($_POST, $rules)) {
            $this->setFlash('error', $this->validation->errorString());
            $this->redirect('anggota/edit/' . $id);
        }
        
        $data = [
            'nama' => $this->getPost('nama'),
            'kelas' => $this->getPost('kelas'),
            'jenis_kelamin' => $this->getPost('jenis_kelamin'),
            'no_hp' => $this->getPost('no_hp'),
            'status_aktif' => $this->getPost('status_aktif', 1),
            // TANGGAL GABUNG TETAP MENGGUNAKAN DATA LAMA (tidak perlu diupdate)
        ];
        
        // Update data
        $result = $this->anggotaModel->update($id, $data);
        
        if ($result) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Mengupdate anggota: ' . $data['nama'],
                'tabel' => 'anggota',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->setFlash('success', 'Data anggota berhasil diupdate');
        } else {
            $this->setFlash('error', 'Gagal mengupdate data anggota');
        }
        
        $this->redirect('anggota');
    }
    
    /**
     * Hapus anggota
     */
    public function delete($id) {
        // Cek role (hanya admin)
        if (!$this->auth->isAdmin()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 403);
        }
        
        if (!$this->isPost()) {
            $this->redirect('anggota');
        }
        
        $anggota = $this->anggotaModel->find($id);
        
        if (!$anggota) {
            $this->jsonResponse(['error' => 'Data tidak ditemukan'], 404);
        }
        
        $result = $this->anggotaModel->delete($id);
        
        if ($result) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Menghapus anggota: ' . $anggota['nama'],
                'tabel' => 'anggota',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Data anggota berhasil dihapus'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Gagal menghapus data anggota'
            ], 500);
        }
    }
    
    /**
     * Detail anggota
     */
    public function show($id) {
        $anggota = $this->anggotaModel->find($id);
        
        if (!$anggota) {
            $this->setFlash('error', 'Data anggota tidak ditemukan');
            $this->redirect('anggota');
        }
        
        // Get total iuran
        $total_iuran = $this->anggotaModel->getTotalIuran($id);
        
        // Get riwayat pembayaran
        $riwayat = $this->kasMasukModel->getByAnggota($id);
        
        $data = [
            'title' => 'Detail Anggota - ' . APP_NAME,
            'anggota' => $anggota,
            'total_iuran' => $total_iuran,
            'riwayat' => $riwayat,
            'user' => $this->auth->user()
        ];
        
        $this->render('anggota/show', $data, 'layouts/main');
    }
    
    /**
 * Search anggota untuk select2
 */
public function search() {
    $query = $this->getQuery('q', '');
    
    if (strlen($query) < 2) {
        $this->jsonResponse([]);
    }
    
    $results = $this->anggotaModel->searchForSelect($query);
    
    $formatted = [];
    foreach ($results as $item) {
        // HAPUS no_anggota dari text
        $formatted[] = [
            'id' => $item['id'],
            'text' => $item['nama'] . ' (Kelas ' . $item['kelas'] . ')'
        ];
    }
    
    $this->jsonResponse([
        'results' => $formatted
    ]);
}
}
?>