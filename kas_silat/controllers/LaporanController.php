<?php
/**
 * Laporan Controller
 */

require_once BASE_PATH . 'core/Controller.php';
require_once BASE_PATH . 'models/Laporan.php';
require_once BASE_PATH . 'helpers/export_helper.php';

class LaporanController extends Controller {
    private $laporanModel;
    
    public function __construct() {
        parent::__construct();
        
        // Cek autentikasi
        if (!$this->auth->check()) {
            $this->redirect('auth/login');
        }
        
        $this->laporanModel = new Laporan();
    }
    
    /**
     * Halaman utama laporan
     */
    public function index() {
        $data = [
            'title' => 'Laporan Keuangan - ' . APP_NAME,
            'user' => $this->auth->user()
        ];
        
        $this->render('laporan/index', $data, 'layouts/main');
    }
    
    /**
     * Tampilkan laporan kas masuk
     */
    public function kasMasuk() {
        $startDate = $this->getQuery('start_date', date('Y-m-01'));
        $endDate = $this->getQuery('end_date', date('Y-m-t'));
        
        $laporan = $this->laporanModel->getLaporanKasMasuk($startDate, $endDate);
        $ringkasan = $this->laporanModel->getRingkasanKeuangan($startDate, $endDate);
        
        $data = [
            'title' => 'Laporan Kas Masuk - ' . APP_NAME,
            'laporan' => $laporan,
            'ringkasan' => $ringkasan,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user' => $this->auth->user()
        ];
        
        $this->render('laporan/kas_masuk', $data, 'layouts/main');
    }
    
    /**
     * Tampilkan laporan kas keluar
     */
    public function kasKeluar() {
        $startDate = $this->getQuery('start_date', date('Y-m-01'));
        $endDate = $this->getQuery('end_date', date('Y-m-t'));
        
        $laporan = $this->laporanModel->getLaporanKasKeluar($startDate, $endDate);
        $ringkasan = $this->laporanModel->getRingkasanKeuangan($startDate, $endDate);
        
        $data = [
            'title' => 'Laporan Kas Keluar - ' . APP_NAME,
            'laporan' => $laporan,
            'ringkasan' => $ringkasan,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user' => $this->auth->user()
        ];
        
        $this->render('laporan/kas_keluar', $data, 'layouts/main');
    }
    
    /**
     * Tampilkan rekap per anggota
     */
    public function rekapAnggota() {
        $startDate = $this->getQuery('start_date', date('Y-m-01'));
        $endDate = $this->getQuery('end_date', date('Y-m-t'));
        
        $laporan = $this->laporanModel->getRekapPerAnggota($startDate, $endDate);
        
        $data = [
            'title' => 'Rekap Iuran Anggota - ' . APP_NAME,
            'laporan' => $laporan,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user' => $this->auth->user()
        ];
        
        $this->render('laporan/rekap_anggota', $data, 'layouts/main');
    }
    
    /**
 * Export laporan ke Excel
 */
public function exportExcel() {
    $jenis = $this->getQuery('jenis', 'kas_masuk');
    $startDate = $this->getQuery('start_date', date('Y-m-01'));
    $endDate = $this->getQuery('end_date', date('Y-m-t'));
    
    // Get data
    $data = $this->laporanModel->getLaporanExport($jenis, $startDate, $endDate);
    
    // Set filename
    $filename = 'laporan_' . $jenis . '_' . date('Ymd') . '.xls';
    
    // Set headers for Excel download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    // Create Excel content
    echo "<table border='1'>";
    
    // Header berdasarkan jenis laporan
    echo "<tr>";
    if ($jenis == 'kas_masuk') {
        echo "<th>No</th>";
        echo "<th>Tanggal</th>";
        echo "<th>Nama Anggota</th>";
        echo "<th>Kelas</th>";
        echo "<th>Keterangan</th>";
        echo "<th>Jumlah</th>";
        echo "<th>Metode</th>";
    } elseif ($jenis == 'kas_keluar') {
        echo "<th>No</th>";
        echo "<th>Tanggal</th>";
        echo "<th>Keterangan</th>";
        echo "<th>Jumlah</th>";
        echo "<th>Penanggung Jawab</th>";
        echo "<th>Kategori</th>";
        echo "<th>Status</th>";
    } elseif ($jenis == 'rekap_anggota') {
        echo "<th>No</th>";
        // KOLOM NO ANGGOTA DIHAPUS
        echo "<th>Nama</th>";
        echo "<th>Kelas</th>";
        echo "<th>Status</th>";
        echo "<th>Jumlah Bayar</th>";
        echo "<th>Total Iuran</th>";
        echo "<th>Total Sebelumnya</th>";
    }
    echo "</tr>";
    
    // Data
    $no = 1;
    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        
        if ($jenis == 'kas_masuk') {
            echo "<td>" . formatTanggal($row['tanggal'], 'date') . "</td>";
            echo "<td>" . ($row['nama_anggota'] ?? '-') . "</td>";
            echo "<td>" . ($row['kelas'] ?? '-') . "</td>";
            echo "<td>" . ($row['keterangan'] ?? '-') . "</td>";
            echo "<td>" . formatRupiah($row['jumlah']) . "</td>";
            echo "<td>" . ($row['metode'] ?? '-') . "</td>";
        } elseif ($jenis == 'kas_keluar') {
            echo "<td>" . formatTanggal($row['tanggal'], 'date') . "</td>";
            echo "<td>" . ($row['keterangan'] ?? '-') . "</td>";
            echo "<td>" . formatRupiah($row['jumlah']) . "</td>";
            echo "<td>" . ($row['penanggung_jawab'] ?? '-') . "</td>";
            echo "<td>" . ($row['kategori'] ?? '-') . "</td>";
            $status = isset($row['penyetuju']) && $row['penyetuju'] ? 'Disetujui' : 'Menunggu';
            echo "<td>" . $status . "</td>";
        } elseif ($jenis == 'rekap_anggota') {
            // KOLOM NO ANGGOTA DIHAPUS
            echo "<td>" . ($row['nama'] ?? '-') . "</td>";
            echo "<td>" . ($row['kelas'] ?? '-') . "</td>";
            echo "<td>" . (isset($row['status_aktif']) && $row['status_aktif'] ? 'Aktif' : 'Non Aktif') . "</td>";
            echo "<td>" . ($row['jumlah_bayar'] ?? '0') . "x</td>";
            echo "<td>" . formatRupiah($row['total_bayar'] ?? 0) . "</td>";
            echo "<td>" . formatRupiah($row['total_sebelumnya'] ?? 0) . "</td>";
        }
        
        echo "</tr>";
    }
    
    echo "</table>";
    exit;
}
    
    /**
     * Export laporan ke PDF - DIPERBAIKI
     */
    public function exportPdf() {
        $jenis = $this->getQuery('jenis', 'kas_masuk');
        $startDate = $this->getQuery('start_date', date('Y-m-01'));
        $endDate = $this->getQuery('end_date', date('Y-m-t'));
        
        // Get data
        $data = $this->laporanModel->getLaporanExport($jenis, $startDate, $endDate);
        $ringkasan = $this->laporanModel->getRingkasanKeuangan($startDate, $endDate);
        
        $title = '';
        switch ($jenis) {
            case 'kas_masuk':
                $title = 'Laporan Kas Masuk';
                break;
            case 'kas_keluar':
                $title = 'Laporan Kas Keluar';
                break;
            case 'rekap_anggota':
                $title = 'Rekap Iuran Anggota';
                break;
        }
        
        $dataView = [
            'title' => $title,
            'jenis' => $jenis,
            'laporan' => $data,
            'ringkasan' => $ringkasan,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'sekolah' => SCHOOL_NAME,
            'perguruan' => PERGURUAN
        ];
        
        // LANGSUNG TAMPILKAN VIEW PRINT, BUKAN REDIRECT
        $this->view('laporan/print', $dataView);
        exit;
    }
    
    /**
     * Halaman print-friendly - TETAP DI PERTAHANKAN UNTUK AKSES LANGSUNG
     */
    public function print() {
        $jenis = $this->getQuery('jenis', 'kas_masuk');
        $startDate = $this->getQuery('start_date', date('Y-m-01'));
        $endDate = $this->getQuery('end_date', date('Y-m-t'));
        
        $data = $this->laporanModel->getLaporanExport($jenis, $startDate, $endDate);
        $ringkasan = $this->laporanModel->getRingkasanKeuangan($startDate, $endDate);
        
        $title = '';
        switch ($jenis) {
            case 'kas_masuk':
                $title = 'Laporan Kas Masuk';
                break;
            case 'kas_keluar':
                $title = 'Laporan Kas Keluar';
                break;
            case 'rekap_anggota':
                $title = 'Rekap Iuran Anggota';
                break;
        }
        
        $dataView = [
            'title' => $title,
            'jenis' => $jenis,
            'laporan' => $data,
            'ringkasan' => $ringkasan,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'sekolah' => SCHOOL_NAME,
            'perguruan' => PERGURUAN
        ];
        
        $this->view('laporan/print', $dataView);
    }
}
?>