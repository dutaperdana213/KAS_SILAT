<?php
/**
 * Kas Masuk Model
 */

require_once BASE_PATH . 'core/Model.php';

class KasMasuk extends Model {
    protected $table = 'kas_masuk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_transaksi', 'tanggal', 'anggota_id', 'keterangan',
        'jumlah', 'metode', 'bukti_transfer', 'created_by'
    ];
    
    /**
 * Get kas masuk with relations
 */
public function getAllWithAnggota($page = 1, $perPage = 10, $search = '') {
    $offset = ($page - 1) * $perPage;
    $params = [];
    
    // HAPUS a.no_anggota dari SELECT
    $sql = "SELECT km.*, a.nama as nama_anggota, a.kelas,
                   u.nama_lengkap as created_by_name
            FROM {$this->table} km
            LEFT JOIN anggota a ON km.anggota_id = a.id
            LEFT JOIN users u ON km.created_by = u.id
            WHERE 1=1";
    
    if (!empty($search)) {
        $sql .= " AND (a.nama LIKE ?)"; // HAPUS no_anggota dari search
        $searchTerm = "%{$search}%";
        $params = [$searchTerm];
    }
    
    // Get total count
    $countSql = "SELECT COUNT(*) as total FROM {$this->table} km";
    if (!empty($search)) {
        $countSql .= " LEFT JOIN anggota a ON km.anggota_id = a.id";
        $countSql .= " WHERE a.nama LIKE ?";
    }
    
    $total = $this->db->query($countSql)->bind($params)->single()['total'];
    
    // Get data with pagination
    $sql .= " ORDER BY km.tanggal DESC, km.created_at DESC LIMIT ? OFFSET ?";
    $params[] = $perPage;
    $params[] = $offset;
    
    $data = $this->db->query($sql)->bind($params)->resultSet();
    
    return [
        'data' => $data,
        'total' => $total,
        'per_page' => $perPage,
        'current_page' => $page,
        'last_page' => ceil($total / $perPage)
    ];
}
    
    /**
     * Get total kas masuk
     */
    public function getTotalMasuk($startDate = null, $endDate = null) {
        $sql = "SELECT COALESCE(SUM(jumlah), 0) as total FROM {$this->table}";
        $params = [];
        
        if ($startDate && $endDate) {
            $sql .= " WHERE tanggal BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }
        
        $result = $this->db->query($sql)->bind($params)->single();
        return $result['total'];
    }
    
    /**
     * Get kas masuk by date range
     */
    public function getByDateRange($startDate, $endDate) {
        $sql = "SELECT km.*, a.nama as nama_anggota, a.no_anggota
                FROM {$this->table} km
                LEFT JOIN anggota a ON km.anggota_id = a.id
                WHERE km.tanggal BETWEEN ? AND ?
                ORDER BY km.tanggal DESC";
        
        return $this->db->query($sql)->bind([$startDate, $endDate])->resultSet();
    }
    
    /**
     * Get monthly statistics for chart
     */
    public function getMonthlyStats($tahun) {
        $sql = "SELECT 
                    MONTH(tanggal) as bulan,
                    COUNT(*) as jumlah_transaksi,
                    SUM(jumlah) as total
                FROM {$this->table}
                WHERE YEAR(tanggal) = ?
                GROUP BY MONTH(tanggal)
                ORDER BY bulan";
        
        return $this->db->query($sql)->bind([$tahun])->resultSet();
    }
    
    /**
     * Get top contributors
     */
    public function getTopContributors($limit = 5) {
        $sql = "SELECT 
                    a.id,
                    a.nama,
                    a.kelas,
                    COUNT(km.id) as jumlah_bayar,
                    SUM(km.jumlah) as total
                FROM {$this->table} km
                JOIN anggota a ON km.anggota_id = a.id
                WHERE a.status_aktif = 1
                GROUP BY a.id
                ORDER BY total DESC
                LIMIT ?";
        
        return $this->db->query($sql)->bind([$limit])->resultSet();
    }
    
  /**
 * Get kas masuk with detail by ID
 */
public function getWithDetail($id) {
    // HAPUS a.no_anggota dari SELECT
    $sql = "SELECT km.*, 
                   a.nama as nama_anggota, 
                   a.kelas,
                   u.nama_lengkap as created_by_name
            FROM {$this->table} km
            LEFT JOIN anggota a ON km.anggota_id = a.id
            LEFT JOIN users u ON km.created_by = u.id
            WHERE km.id = ?";
    
    return $this->db->query($sql)->bind([$id])->single();
}

    /**
 * Get riwayat pembayaran by anggota ID
 */
public function getByAnggota($anggotaId) {
    $sql = "SELECT * FROM {$this->table} 
            WHERE anggota_id = ? 
            ORDER BY tanggal DESC, created_at DESC";
    
    return $this->db->query($sql)->bind([$anggotaId])->resultSet();
}
}
?>