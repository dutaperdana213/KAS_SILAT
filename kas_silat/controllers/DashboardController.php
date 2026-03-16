<?php
/**
 * Dashboard Controller
 */

require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'models/Anggota.php';
require_once BASE_PATH . 'models/KasMasuk.php';
require_once BASE_PATH . 'models/KasKeluar.php';
require_once BASE_PATH . 'models/Laporan.php';

class DashboardController extends Controller {
    private $anggotaModel;
    private $kasMasukModel;
    private $kasKeluarModel;
    private $laporanModel;
    
    public function __construct() {
        parent::__construct();
        
        // Cek autentikasi
        if (!$this->auth->check()) {
            $this->redirect('auth/login');
        }
        
        $this->anggotaModel = new Anggota();
        $this->kasMasukModel = new KasMasuk();
        $this->kasKeluarModel = new KasKeluar();
        $this->laporanModel = new Laporan();
    }
    
    /**
     * Halaman utama dashboard
     */
    public function index() {
        // Get current month
        $bulan = date('m');
        $tahun = date('Y');
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');
        
        // Get ringkasan keuangan
        $ringkasan = $this->laporanModel->getRingkasanKeuangan($startDate, $endDate);
        
        // Get total anggota aktif
        $totalAnggota = $this->anggotaModel->getActiveCount();
        
        // Get statistik per kelas - INI YANG PENTING!
        $statistik_kelas = $this->anggotaModel->getStatsPerClass();
        
        // Get data grafik bulanan
        $grafikData = $this->laporanModel->getGrafikBulanan($tahun);
        
        // Format data untuk chart
        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = getBulan($i);
            $dataMasuk[$i] = 0;
            $dataKeluar[$i] = 0;
        }
        
        foreach ($grafikData as $item) {
            $dataMasuk[$item['bulan']] = (float)$item['total_masuk'];
            $dataKeluar[$item['bulan']] = (float)$item['total_keluar'];
        }
        
        // Get transaksi terbaru
        $recentMasuk = $this->kasMasukModel->getAllWithAnggota(1, 5)['data'];
        $recentKeluar = $this->kasKeluarModel->getAllWithApprover(1, 5)['data'];
        
        // Get top contributors
        $topContributors = $this->kasMasukModel->getTopContributors(5);
        
        // KIRIM SEMUA VARIABLE KE VIEW
        $data = [
            'title' => 'Dashboard - ' . APP_NAME,
            'ringkasan' => $ringkasan,
            'total_anggota' => $totalAnggota,
            'statistik_kelas' => $statistik_kelas, // <-- INI YANG MISSING!
            'chart_labels' => $labels,
            'chart_masuk' => array_values($dataMasuk),
            'chart_keluar' => array_values($dataKeluar),
            'recent_masuk' => $recentMasuk,
            'recent_keluar' => $recentKeluar,
            'top_contributors' => $topContributors,
            'user' => $this->auth->user()
        ];
        
        $this->render('dashboard/index', $data, 'layouts/main');
    }
    
    /**
     * Get data untuk refresh widget (AJAX)
     */
    public function getWidgetData() {
        if (!$this->isPost()) {
            $this->jsonResponse(['error' => 'Method not allowed'], 405);
        }
        
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');
        
        $ringkasan = $this->laporanModel->getRingkasanKeuangan($startDate, $endDate);
        $totalAnggota = $this->anggotaModel->getActiveCount();
        
        $this->jsonResponse([
            'success' => true,
            'data' => [
                'saldo' => 'Rp ' . number_format($ringkasan['saldo_akhir'] ?? 0, 0, ',', '.'),
                'total_masuk' => 'Rp ' . number_format($ringkasan['total_masuk'] ?? 0, 0, ',', '.'),
                'total_keluar' => 'Rp ' . number_format($ringkasan['total_keluar'] ?? 0, 0, ',', '.'),
                'total_anggota' => $totalAnggota
            ]
        ]);
    }
}
?>