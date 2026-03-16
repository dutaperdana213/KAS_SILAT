<?php
/**
 * Kas Masuk Controller
 */

require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'models/KasMasuk.php';
require_once BASE_PATH . 'models/Anggota.php';
require_once BASE_PATH . 'models/LogAktivitas.php';

class KasMasukController extends Controller {
    private $kasMasukModel;
    private $anggotaModel;
    private $logModel;
    
    public function __construct() {
        parent::__construct();
        
        // Cek autentikasi
        if (!$this->auth->check()) {
            $this->redirect('auth/login');
        }
        
        $this->kasMasukModel = new KasMasuk();
        $this->anggotaModel = new Anggota();
        $this->logModel = new LogAktivitas();
    }
    
    /**
 * Daftar kas masuk
 */
public function index() {
    // Cek role
    if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA, ROLE_PEMBINA])) {
        $this->setFlash('error', 'Anda tidak memiliki akses');
        $this->redirect('dashboard');
    }
    
    $page = $this->getQuery('page', 1);
    $search = $this->getQuery('search', '');
    
    $result = $this->kasMasukModel->getAllWithAnggota($page, ITEMS_PER_PAGE, $search);
    
    $data = [
        'title' => 'Kas Masuk - ' . APP_NAME,
        'kas_masuk' => $result['data'],
        'pagination' => [
            'current_page' => $result['current_page'],
            'last_page' => $result['last_page'],
            'total' => $result['total'],
            'from' => ($result['current_page'] - 1) * ITEMS_PER_PAGE + 1,
            'to' => min($result['current_page'] * ITEMS_PER_PAGE, $result['total'])
        ],
        'search' => $search,
        'user' => $this->auth->user(),
        'can_edit' => $this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA]),
        'can_delete' => $this->auth->isAdmin()
    ];
    
    $this->render('kas_masuk/index', $data, 'layouts/main');
}
    
    /**
     * Form tambah kas masuk
     */
    public function create() {
        // Cek role (hanya admin dan bendahara)
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('kas-masuk');
        }
        
        // Get daftar anggota aktif untuk dropdown
        $anggota = $this->anggotaModel->where(['status_aktif' => 1], 'nama ASC');
        
        $data = [
            'title' => 'Tambah Kas Masuk - ' . APP_NAME,
            'anggota' => $anggota,
            'csrf_token' => $this->generateCsrfToken(),
            'user' => $this->auth->user()
        ];
        
        $this->render('kas_masuk/create', $data, 'layouts/main');
    }
    
    /**
 * Proses simpan kas masuk
 */
public function store() {
    // Cek role
    if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
        $this->jsonResponse(['error' => 'Unauthorized'], 403);
    }
    
    if (!$this->isPost()) {
        $this->redirect('kas-masuk/create');
    }
    
    // Validasi CSRF token
    $csrf_token = $this->getPost('csrf_token');
    if (!$this->verifyCsrfToken($csrf_token)) {
        $this->setFlash('error', 'Invalid CSRF token');
        $this->redirect('kas-masuk/create');
    }
    
    // Validasi input
    $rules = [
        'tanggal' => 'required|date',
        'anggota_id' => 'required|numeric',
        'jumlah' => 'required',
        'pertemuan' => 'required|numeric|between:1,12'
    ];
    
    if (!$this->validation->validate($_POST, $rules)) {
        $this->setFlash('error', $this->validation->errorString());
        $this->redirect('kas-masuk/create');
    }
    
    // Bersihkan format rupiah
    $jumlah = $this->getPost('jumlah');
    $jumlah = preg_replace('/[^0-9]/', '', $jumlah);
    $jumlah = (int)$jumlah;
    
    if ($jumlah < 1000) {
        $this->setFlash('error', 'Jumlah minimal Rp 1.000');
        $this->redirect('kas-masuk/create');
    }
    
    // Generate keterangan berdasarkan pertemuan
    $pertemuan = $this->getPost('pertemuan');
    $keterangan = "Pertemuan ke-" . $pertemuan;
    
    $data = [
        'tanggal' => $this->getPost('tanggal'),
        'anggota_id' => $this->getPost('anggota_id'),
        'keterangan' => $keterangan,
        'jumlah' => $jumlah,
        'metode' => 'Tunai', // LANGSUNG TUNAI
        'created_by' => $this->auth->user()['id']
    ];
    
    // Simpan data
    $id = $this->kasMasukModel->create($data);
    
    if ($id) {
        // Get nama anggota untuk log
        $anggota = $this->anggotaModel->find($data['anggota_id']);
        
        // Log aktivitas
        $this->logModel->create([
            'user_id' => $this->auth->user()['id'],
            'aktivitas' => 'Menambah kas masuk: ' . formatRupiah($data['jumlah']) . ' untuk ' . ($anggota['nama'] ?? '') . ' ' . $data['keterangan'],
            'tabel' => 'kas_masuk',
            'data_id' => $id,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
        
        $this->setFlash('success', 'Data kas masuk berhasil disimpan');
        $this->redirect('kas-masuk');
    } else {
        $this->setFlash('error', 'Gagal menyimpan data kas masuk');
        $this->redirect('kas-masuk/create');
    }
}
    
    /**
     * Form edit kas masuk
     */
    public function edit($id) {
        // Cek role (hanya admin dan bendahara)
        if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
            $this->setFlash('error', 'Anda tidak memiliki akses');
            $this->redirect('kas-masuk');
        }
        
        $kasMasuk = $this->kasMasukModel->getWithDetail($id);
        
        if (!$kasMasuk) {
            $this->setFlash('error', 'Data tidak ditemukan');
            $this->redirect('kas-masuk');
        }
        
        // Get daftar anggota aktif untuk dropdown
        $anggota = $this->anggotaModel->where(['status_aktif' => 1], 'nama ASC');
        
        $data = [
            'title' => 'Edit Kas Masuk - ' . APP_NAME,
            'kas_masuk' => $kasMasuk,
            'anggota' => $anggota,
            'csrf_token' => $this->generateCsrfToken(),
            'user' => $this->auth->user()
        ];
        
        $this->render('kas_masuk/edit', $data, 'layouts/main');
    }
    
   /**
 * Proses update kas masuk
 */
public function update($id) {
    // Cek role
    if (!$this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])) {
        $this->jsonResponse(['error' => 'Unauthorized'], 403);
    }
    
    if (!$this->isPost()) {
        $this->redirect('kas-masuk');
    }
    
    // Validasi CSRF token
    $csrf_token = $this->getPost('csrf_token');
    if (!$this->verifyCsrfToken($csrf_token)) {
        $this->setFlash('error', 'Invalid CSRF token');
        $this->redirect('kas-masuk/edit/' . $id);
    }
    
    // Validasi input
    $rules = [
        'tanggal' => 'required|date',
        'anggota_id' => 'required|numeric',
        'pertemuan' => 'required|numeric|between:1,12'
    ];
    
    if (!$this->validation->validate($_POST, $rules)) {
        $this->setFlash('error', $this->validation->errorString());
        $this->redirect('kas-masuk/edit/' . $id);
    }
    
    // Generate keterangan berdasarkan pertemuan (HANYA "Pertemuan ke-X")
    $pertemuan = $this->getPost('pertemuan');
    $keterangan = "Pertemuan ke-" . $pertemuan;
    
    $data = [
        'tanggal' => $this->getPost('tanggal'),
        'anggota_id' => $this->getPost('anggota_id'),
        'keterangan' => $keterangan, // HANYA "Pertemuan ke-X"
        'jumlah' => 2000, // Tetap Rp 2.000
        'metode' => 'Tunai' // Tetap Tunai
    ];
    
    // Update data
    $result = $this->kasMasukModel->update($id, $data);
    
    if ($result) {
        // Log aktivitas
        $this->logModel->create([
            'user_id' => $this->auth->user()['id'],
            'aktivitas' => 'Mengupdate kas masuk ID: ' . $id,
            'tabel' => 'kas_masuk',
            'data_id' => $id,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ]);
        
        $this->setFlash('success', 'Data kas masuk berhasil diupdate');
    } else {
        $this->setFlash('error', 'Gagal mengupdate data kas masuk');
    }
    
    $this->redirect('kas-masuk');
}
    
    /**
     * Hapus kas masuk
     */
    public function delete($id) {
        // Cek role (hanya admin)
        if (!$this->auth->isAdmin()) {
            $this->jsonResponse(['error' => 'Unauthorized'], 403);
        }
        
        if (!$this->isPost()) {
            $this->redirect('kas-masuk');
        }
        
        $kasMasuk = $this->kasMasukModel->find($id);
        
        if (!$kasMasuk) {
            $this->jsonResponse(['error' => 'Data tidak ditemukan'], 404);
        }
        
        // Hapus file bukti transfer jika ada
        if ($kasMasuk['bukti_transfer'] && file_exists(UPLOAD_PATH . $kasMasuk['bukti_transfer'])) {
            unlink(UPLOAD_PATH . $kasMasuk['bukti_transfer']);
        }
        
        $result = $this->kasMasukModel->delete($id);
        
        if ($result) {
            // Log aktivitas
            $this->logModel->create([
                'user_id' => $this->auth->user()['id'],
                'aktivitas' => 'Menghapus kas masuk ID: ' . $id,
                'tabel' => 'kas_masuk',
                'data_id' => $id,
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->jsonResponse([
                'success' => true,
                'message' => 'Data kas masuk berhasil dihapus'
            ]);
        } else {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Gagal menghapus data kas masuk'
            ], 500);
        }
    }
    
    /**
     * Detail kas masuk
     */
    public function show($id) {
        $kasMasuk = $this->kasMasukModel->getWithDetail($id);
        
        if (!$kasMasuk) {
            $this->setFlash('error', 'Data tidak ditemukan');
            $this->redirect('kas-masuk');
        }
        
        $data = [
            'title' => 'Detail Kas Masuk - ' . APP_NAME,
            'kas_masuk' => $kasMasuk,
            'user' => $this->auth->user()
        ];
        
        $this->render('kas_masuk/show', $data, 'layouts/main');
    }
}
?>