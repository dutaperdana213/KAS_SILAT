<?php
/**
 * Laporan Model
 */

require_once BASE_PATH . 'core/Model.php';

class Laporan extends Model {
    protected $table = null; // Not directly associated with a table
    
    /**
     * Get ringkasan keuangan
     */
    public function getRingkasanKeuangan($startDate = null, $endDate = null) {
        $db = new Database();
        
        // Set default date range jika tidak ada
        if (!$startDate) {
            $startDate = date('Y-m-01'); // Awal bulan ini
        }
        if (!$endDate) {
            $endDate = date('Y-m-t'); // Akhir bulan ini
        }
        
        // Get total kas masuk
        $sqlMasuk = "SELECT COALESCE(SUM(jumlah), 0) as total 
                     FROM kas_masuk 
                     WHERE tanggal BETWEEN ? AND ?";
        $totalMasuk = $db->query($sqlMasuk)->bind([$startDate, $endDate])->single()['total'];
        
        // Get total kas keluar
        $sqlKeluar = "SELECT COALESCE(SUM(jumlah), 0) as total 
                      FROM kas_keluar 
                      WHERE tanggal BETWEEN ? AND ?";
        $totalKeluar = $db->query($sqlKeluar)->bind([$startDate, $endDate])->single()['total'];
        
        // Get saldo awal (sebelum start date)
        $sqlSaldoAwal = "SELECT 
                            (SELECT COALESCE(SUM(jumlah), 0) FROM kas_masuk WHERE tanggal < ?) -
                            (SELECT COALESCE(SUM(jumlah), 0) FROM kas_keluar WHERE tanggal < ?) as saldo";
        $saldoAwal = $db->query($sqlSaldoAwal)->bind([$startDate, $startDate])->single()['saldo'];
        
        // Get saldo akhir
        $saldoAkhir = $saldoAwal + $totalMasuk - $totalKeluar;
        
        return [
            'periode' => [
                'start' => $startDate,
                'end' => $endDate
            ],
            'saldo_awal' => $saldoAwal,
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo_akhir' => $saldoAkhir
        ];
    }
    
    /**
 * Get laporan kas masuk detail
 */
public function getLaporanKasMasuk($startDate, $endDate) {
    $db = new Database();
    
    // HAPUS km.no_transaksi dari SELECT
    $sql = "SELECT 
                km.tanggal,
                a.nama as nama_anggota,
                a.kelas,
                km.keterangan,
                km.jumlah,
                km.metode,
                u.nama_lengkap as petugas
            FROM kas_masuk km
            JOIN anggota a ON km.anggota_id = a.id
            LEFT JOIN users u ON km.created_by = u.id
            WHERE km.tanggal BETWEEN ? AND ?
            ORDER BY km.tanggal DESC, km.created_at DESC";
    
    return $db->query($sql)->bind([$startDate, $endDate])->resultSet();
}
    
    /**
 * Get laporan kas keluar detail
 */
public function getLaporanKasKeluar($startDate, $endDate) {
    $db = new Database();
    
    // HAPUS kk.no_transaksi dari SELECT
    $sql = "SELECT 
                kk.tanggal,
                kk.keterangan,
                kk.jumlah,
                kk.penanggung_jawab,
                kk.kategori,
                u2.nama_lengkap as penyetuju
            FROM kas_keluar kk
            LEFT JOIN users u2 ON kk.approved_by = u2.id
            WHERE kk.tanggal BETWEEN ? AND ?
            ORDER BY kk.tanggal DESC, kk.created_at DESC";
    
    return $db->query($sql)->bind([$startDate, $endDate])->resultSet();
}
    
    /**
 * Get laporan rekap per anggota
 */
public function getRekapPerAnggota($startDate, $endDate) {
    $db = new Database();
    
    // HAPUS a.no_anggota dari SELECT
    $sql = "SELECT 
                a.id,
                a.nama,
                a.kelas,
                a.status_aktif,
                COUNT(km.id) as jumlah_bayar,
                COALESCE(SUM(km.jumlah), 0) as total_bayar,
                (SELECT COALESCE(SUM(jumlah), 0) 
                 FROM kas_masuk 
                 WHERE anggota_id = a.id 
                 AND tanggal < ?) as total_sebelumnya
            FROM anggota a
            LEFT JOIN kas_masuk km ON a.id = km.anggota_id 
                AND km.tanggal BETWEEN ? AND ?
            GROUP BY a.id
            ORDER BY a.kelas, a.nama";
    
    return $db->query($sql)->bind([$startDate, $startDate, $endDate])->resultSet();
}
    
    /**
 * Get laporan grafik bulanan
 */
public function getGrafikBulanan($tahun) {
    $db = new Database();
    
    $sql = "SELECT 
                MONTH(tanggal) as bulan,
                SUM(CASE WHEN jenis = 'masuk' THEN jumlah ELSE 0 END) as total_masuk,
                SUM(CASE WHEN jenis = 'keluar' THEN jumlah ELSE 0 END) as total_keluar
            FROM (
                SELECT 
                    tanggal,
                    jumlah,
                    'masuk' as jenis
                FROM kas_masuk
                WHERE YEAR(tanggal) = ?
                
                UNION ALL
                
                SELECT 
                    tanggal,
                    jumlah,
                    'keluar' as jenis
                FROM kas_keluar
                WHERE YEAR(tanggal) = ?
            ) as data
            GROUP BY bulan
            ORDER BY bulan";
    
    return $db->query($sql)->bind([$tahun, $tahun])->resultSet();
}
    
    /**
 * Get laporan untuk export
 */
public function getLaporanExport($jenis, $startDate, $endDate) {
    switch ($jenis) {
        case 'kas_masuk':
            return $this->getLaporanKasMasuk($startDate, $endDate);
        case 'kas_keluar':
            return $this->getLaporanKasKeluar($startDate, $endDate);
        case 'rekap_anggota':
            return $this->getRekapPerAnggota($startDate, $endDate);
        default:
            return [];
    }
}
}
?>