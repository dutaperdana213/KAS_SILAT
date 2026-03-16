<?php
/**
 * Kas Keluar Model
 */

require_once BASE_PATH . 'core/Model.php';

class KasKeluar extends Model {
    protected $table = 'kas_keluar';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_transaksi', 'tanggal', 'keterangan', 'jumlah',
        'penanggung_jawab', 'kategori', 'bukti_pengeluaran',
        'approved_by', 'created_by'
    ];
    
    /**
     * Get kas keluar with relations
     */
    public function getAllWithApprover($page = 1, $perPage = 10, $search = '') {
        $offset = ($page - 1) * $perPage;
        $params = [];
        
        $sql = "SELECT kk.*, 
                       u1.nama_lengkap as created_by_name,
                       u2.nama_lengkap as approved_by_name
                FROM {$this->table} kk
                LEFT JOIN users u1 ON kk.created_by = u1.id
                LEFT JOIN users u2 ON kk.approved_by = u2.id
                WHERE 1=1";
        
        if (!empty($search)) {
            $sql .= " AND (kk.no_transaksi LIKE ? OR kk.keterangan LIKE ? OR kk.penanggung_jawab LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} kk";
        if (!empty($search)) {
            $countSql .= " WHERE kk.no_transaksi LIKE ? OR kk.keterangan LIKE ? OR kk.penanggung_jawab LIKE ?";
        }
        
        $total = $this->db->query($countSql)->bind($params)->single()['total'];
        
        // Get data with pagination
        $sql .= " ORDER BY kk.tanggal DESC, kk.created_at DESC LIMIT ? OFFSET ?";
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
     * Get total kas keluar
     */
    public function getTotalKeluar($startDate = null, $endDate = null) {
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
     * Get kas keluar by category
     */
    public function getByCategory($kategori, $startDate = null, $endDate = null) {
        $sql = "SELECT * FROM {$this->table} WHERE kategori = ?";
        $params = [$kategori];
        
        if ($startDate && $endDate) {
            $sql .= " AND tanggal BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
        }
        
        $sql .= " ORDER BY tanggal DESC";
        
        return $this->db->query($sql)->bind($params)->resultSet();
    }
    
    /**
     * Get monthly statistics for chart
     */
    public function getMonthlyStats($tahun) {
        $sql = "SELECT 
                    MONTH(tanggal) as bulan,
                    COUNT(*) as jumlah_transaksi,
                    SUM(jumlah) as total,
                    kategori
                FROM {$this->table}
                WHERE YEAR(tanggal) = ?
                GROUP BY MONTH(tanggal), kategori
                ORDER BY bulan, kategori";
        
        return $this->db->query($sql)->bind([$tahun])->resultSet();
    }
    
    /**
     * Get summary by category
     */
    public function getSummaryByCategory($startDate = null, $endDate = null) {
        $sql = "SELECT 
                    kategori,
                    COUNT(*) as jumlah_transaksi,
                    SUM(jumlah) as total
                FROM {$this->table}";
        
        $params = [];
        
        if ($startDate && $endDate) {
            $sql .= " WHERE tanggal BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }
        
        $sql .= " GROUP BY kategori ORDER BY total DESC";
        
        return $this->db->query($sql)->bind($params)->resultSet();
    }
    
    /**
     * Get pending approvals (for bendahara role)
     */
    public function getPendingApprovals() {
        $sql = "SELECT kk.*, u.nama_lengkap as created_by_name
                FROM {$this->table} kk
                LEFT JOIN users u ON kk.created_by = u.id
                WHERE kk.approved_by IS NULL
                ORDER BY kk.tanggal ASC
                LIMIT 10";
        
        return $this->db->query($sql)->resultSet();
    }
    
    /**
     * Approve kas keluar
     */
    public function approve($id, $approvedBy) {
        $sql = "UPDATE {$this->table} 
                SET approved_by = ?, updated_at = NOW() 
                WHERE id = ?";
        
        return $this->db->query($sql)->bind([$approvedBy, $id])->execute();
    }
    
   /**
 * Get kas keluar with detail by ID
 */
public function getWithDetail($id) {
    $sql = "SELECT kk.*, 
                   u1.nama_lengkap as created_by_name,
                   u2.nama_lengkap as approved_by_name
            FROM {$this->table} kk
            LEFT JOIN users u1 ON kk.created_by = u1.id
            LEFT JOIN users u2 ON kk.approved_by = u2.id
            WHERE kk.id = ?";
    
    return $this->db->query($sql)->bind([$id])->single();
}
}
?>