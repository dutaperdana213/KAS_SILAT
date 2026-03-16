<?php
/**
 * Kas Keluar Controller
 */

require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'models/KasKeluar.php';
require_once BASE_PATH . 'models/LogAktivitas.php';

class KasKeluarController extends Controller {
    private $kasKeluarModel;
    private $logModel;
    
    public function __construct() {
        parent::__construct();
        
        // Cek autentikasi
        if (!$this->auth->check()) {
            $this->redirect('auth/login');
        }
        
        $this->kasKeluarModel = new KasKeluar();
        $this->logModel = new LogAktivitas();
    }
    
    /**
     * Daftar kas keluar
     */
    public function index() {
        // Cek role
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA, ROLE_PEMBINA])) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('dashboard');
        }
        
        $page = $this->getQuery('page', 1);
        $search = $this->getQuery('search', '');
        
        $result = $this->kasKeluarModel->getAllWithApprover($page, ITEMS_PER_PAGE, $search);
        
        $data = [
            'title' => 'Kas Keluar - ' . APP_NAME,
            'kas_keluar' => $result['data'],
            'pagination' => [
                'current_page' => $result['current_page'],
                'last_page' => $result['last_page'],
                'total' => $result['total']
            ],
            'search' => $search,
            'user' => $this->auth->user(),
            'can_edit' => $this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA]),
            'can_approve' => $this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA]),
            'can_delete' => $this->auth->isAdmin()
        ];
        
        $this->render('kas_keluar/index', $data, 'layouts/main');
    }
    
    /**
     * Form tambah kas keluar
     */
    public function create() {
        // Cek role (hanya admin dan bendahara yang bisa menambah)
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('kas-keluar');
        }
        
        $data = [
            'title' => 'Tambah Kas Keluar - ' . APP_NAME,
            'csrf_token' => $this->generateCsrfToken(),
            'user' => $this->auth->user()
        ];
        
        $this->render('kas_keluar/create', $data, 'layouts/main');
    }
    
    /**
 * Proses simpan kas keluar
 */
public function store() {
    // Cek role
    if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
        $this->jsonResponse(['error' => 'Unauthorized'], 403);
    }
    
    if (!$this->isPost()) {
        $this->redirect('kas-keluar/create');
    }
    
    // Validasi CSRF token
    $csrf_token = $this->getPost('csrf_token');
    if (!$this->verifyCsrfToken($csrf_token)) {
        $this->setFlash('error', 'Invalid CSRF token');
        $this->redirect('kas-keluar/create');
    }
    
    // Validasi input
    $rules = [
        'tanggal' => 'required|date',
        'jumlah' => 'required',
        'keterangan' => 'required|min:5',
        'penanggung_jawab' => 'required|min:3',
        'kategori' => 'required'
    ];
    
    if (!$this->validation->validate($_POST, $rules)) {
        $this->setFlash('error', $this->validation->errorString());
        $this->redirect('kas-keluar/create');
    }
    
    // BERSIHKAN FORMAT RUPIAH
    $jumlah = $this->getPost('jumlah');
    $jumlah = preg_replace('/[^0-9]/', '', $jumlah);
    $jumlah = (int)$jumlah;
    
    if ($jumlah < 1000) {
        $this->setFlash('error', 'Jumlah minimal Rp 1.000');
        $this->redirect('kas-keluar/create');
    }
    
    // Cek apakah perlu approval (untuk pembina yang membuat)
    $approved_by = null;
    if ($this->auth->isAdmin() || $this->auth->isBendahara()) {
        $approved_by = $this->auth->user()['id']; // Auto approve untuk admin/bendahara
    }
    
    // UPLOAD BUKTI PENGELUARAN DIHAPUS
    
    $data = [
        'tanggal' => $this->getPost('tanggal'),
        'keterangan' => $this->getPost('keterangan'),
        'jumlah' => $jumlah,
        'penanggung_jawab' => $this->getPost('penanggung_jawab'),
        'kategori' => $this->getPost('kategori'),
        'approved_by' => $approved_by,
        'created_by' => $this->auth->user()['id']
    ];
    
    // Simpan data
    $id = $this->kasKeluarModel->create($data);
    
    if ($id) {
        $status = $approved_by ? 'disetujui otomatis' : 'menunggu persetujuan';
        
        // Log aktivitas
        $this->logModel->create([
            'user_id' => $this->auth->user()['id'],
            'aktivitas' => 'Menambah kas keluar: ' . formatRupiah($data['jumlah']) . ' (' . $status . ')',
            'tabel' => 'kas_keluar',
            'data_id' => $id,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
        
        $this->setFlash('success', 'Data kas keluar berhasil disimpan');
        $this->redirect('kas-keluar');
    } else {
        $this->setFlash('error', 'Gagal menyimpan data kas keluar');
        $this->redirect('kas-keluar/create');
    }
}
    
    /**
     * Form edit kas keluar
     */
    public function edit($id) {
        // Cek role (hanya admin dan bendahara)
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('kas-keluar');
        }
        
        $kasKeluar = $this->kasKeluarModel->getWithDetail($id);
        
        if (!$kasKeluar) {
            $this->setFlash('error', 'Data tidak ditemukan');
            $this->redirect('kas-keluar');
        }
        
        // Cek apakah sudah di-approve, jika sudah hanya admin yang bisa edit
        if ($kasKeluar['approved_by'] && !$this->auth->isAdmin()) {
            $this->setFlash('error', 'Data yang sudah disetujui tidak dapat diedit');
            $this->redirect('kas-keluar');
        }
        
        $data = [
            'title' => 'Edit Kas Keluar - ' . APP_NAME,
            'kas_keluar' => $kasKeluar,
            'csrf_token' => $this->generateCsrfToken(),
            'user' => $this->auth->user()
        ];
        
        $this->render('kas_keluar/edit', $data, 'layouts/main');
    }
    
    /**
 * Proses update kas keluar
 */
public function update($id) {
    // Cek role
    if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
        $this->jsonResponse(['error' => 'Unauthorized'], 403);
    }
    
    if (!$this->isPost()) {
        $this->redirect('kas-keluar');
    }
    
    $kasKeluar = $this->kasKeluarModel->find($id);
    
    if (!$kasKeluar) {
        $this->setFlash('error', 'Data tidak ditemukan');
        $this->redirect('kas-keluar');
    }
    
    // Cek apakah sudah di-approve, jika sudah hanya admin yang bisa edit
    if ($kasKeluar['approved_by'] && !$this->auth->isAdmin()) {
        $this->setFlash('error', 'Data yang sudah disetujui tidak dapat diedit');
        $this->redirect('kas-keluar/edit/' . $id);
    }
    
    // Validasi CSRF token
    $csrf_token = $this->getPost('csrf_token');
    if (!$this->verifyCsrfToken($csrf_token)) {
        $this->setFlash('error', 'Invalid CSRF token');
        $this->redirect('kas-keluar/edit/' . $id);
    }
    
    // Validasi input
    $rules = [
        'tanggal' => 'required|date',
        'jumlah' => 'required',
        'keterangan' => 'required|min:5',
        'penanggung_jawab' => 'required|min:3',
        'kategori' => 'required'
    ];
    
    if (!$this->validation->validate($_POST, $rules)) {
        $this->setFlash('error', $this->validation->errorString());
        $this->redirect('kas-keluar/edit/' . $id);
    }
    
    // PERBAIKAN: BERSIHKAN FORMAT RUPIAH
    $jumlah = $this->getPost('jumlah');
    // Hapus semua karakter non-angka (titik, koma, spasi, dll)
    $jumlah = preg_replace('/[^0-9]/', '', $jumlah);
    $jumlah = (int)$jumlah;
    
    if ($jumlah < 1000) {
        $this->setFlash('error', 'Jumlah minimal Rp 1.000');
        $this->redirect('kas-keluar/edit/' . $id);
    }
    
    // Jika data sudah di-approve sebelumnya, reset approval
    $approved_by = $kasKeluar['approved_by'];
    if ($kasKeluar['approved_by'] && $this->auth->isAdmin()) {
        // Admin bisa edit tanpa merubah status approval
        $approved_by = $kasKeluar['approved_by'];
    } else {
        // Jika diedit oleh bendahara atau admin, reset approval
        $approved_by = null;
    }
    
    $data = [
        'tanggal' => $this->getPost('tanggal'),
        'keterangan' => $this->getPost('keterangan'),
        'jumlah' => $jumlah,
        'penanggung_jawab' => $this->getPost('penanggung_jawab'),
        'kategori' => $this->getPost('kategori'),
        'approved_by' => $approved_by
        // BUKTI PENGELUARAN TIDAK DIUPDATE
    ];
    
    // Update data
    $result = $this->kasKeluarModel->update($id, $data);
    
    if ($result) {
        // Log aktivitas
        $this->logModel->create([
            'user_id' => $this->auth->user()['id'],
            'aktivitas' => 'Mengupdate kas keluar ID: ' . $id,
            'tabel' => 'kas_keluar',
            'data_id' => $id,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
        
        $this->setFlash('success', 'Data kas keluar berhasil diupdate');
    } else {
        $this->setFlash('error', 'Gagal mengupdate data kas keluar');
    }
    
    $this->redirect('kas-keluar');
}
    
    /**
     * Hapus kas keluar
     */
    public function delete($id) {
        // Cek role (hanya admin)
        if (!$this->auth->isAdmin()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 403);
        }
        
        if (!$this->isPost()) {
            $this->redirect('kas-keluar');
        }
        
        $kasKeluar = $this->kasKeluarModel->find($id);
        
        if (!$kasKeluar) {
            $this->jsonResponse(['error' => 'Data tidak ditemukan'], 404);
        }
        
        // Hapus file bukti jika ada
        if ($kasKeluar['bukti_pengeluaran'] && file_exists(UPLOAD_PATH . $kasKeluar['bukti_pengeluaran'])) {
            unlink(UPLOAD_PATH . $kasKeluar['bukti_pengeluaran']);
        }
        
        $result = $this->kasKeluarModel->delete($id);
        
        if ($result) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Menghapus kas keluar ID: ' . $id,
                'tabel' => 'kas_keluar',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Data kas keluar berhasil dihapus'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Gagal menghapus data kas keluar'
            ], 500);
        }
    }
    
   /**
 * Detail kas keluar
 */
public function show($id) {
    $kasKeluar = $this->kasKeluarModel->getWithDetail($id);
    
    if (!$kasKeluar) {
        $this->setFlash('error', 'Data tidak ditemukan');
        $this->redirect('kas-keluar');
    }
    
    $data = [
        'title' => 'Detail Kas Keluar - ' . APP_NAME,
        'kas_keluar' => $kasKeluar,
        'user' => $this->auth->user()
    ];
    
    $this->render('kas_keluar/show', $data, 'layouts/main');
}
    
    /**
     * Approve kas keluar (khusus bendahara/admin)
     */
    public function approve($id) {
        // Cek role (hanya admin dan bendahara yang bisa approve)
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->jsonResponse(['error' => 'Unauthorized'], 403);
        }
        
        if (!$this->isPost()) {
            $this->redirect('kas-keluar');
        }
        
        $kasKeluar = $this->kasKeluarModel->find($id);
        
        if (!$kasKeluar) {
            $this->jsonResponse(['error' => 'Data tidak ditemukan'], 404);
        }
        
        if ($kasKeluar['approved_by']) {
            $this->jsonResponse(['error' => 'Data sudah disetujui sebelumnya'], 400);
        }
        
        $result = $this->kasKeluarModel->approve($id, $this->auth->user()['id']);
        
        if ($result) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Menyetujui kas keluar ID: ' . $id,
                'tabel' => 'kas_keluar',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Data kas keluar berhasil disetujui'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Gagal menyetujui data kas keluar'
            ], 500);
        }
    }
}
?>