<?php
/**
 * Anggota Model
 */

require_once BASE_PATH . 'core/Model.php';

class Anggota extends Model {
    protected $table = 'anggota';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_anggota', 'nama', 'kelas', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat', 'no_hp', 'nama_orangtua', 'no_hp_orangtua',
        'tanggal_gabung', 'status_aktif', 'created_by'
    ];
    
    /**
     * Get anggota with pagination and search
     */
    public function getAnggota($page = 1, $perPage = 10, $search = '') {
        $offset = ($page - 1) * $perPage;
        $params = [];
        
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        
        if (!empty($search)) {
            $sql .= " AND (nama LIKE ? OR no_anggota LIKE ? OR kelas LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        // Get total count
        $countSql = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
        $total = $this->db->query($countSql)->bind($params)->single()['total'];
        
        // Get data with pagination
        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
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
     * Get active members count
     */
    public function getActiveCount() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status_aktif = 1";
        $result = $this->db->query($sql)->single();
        return $result['total'];
    }
    
    /**
     * Get members by class
     */
    public function getByClass($kelas) {
        $sql = "SELECT * FROM {$this->table} WHERE kelas = ? AND status_aktif = 1";
        return $this->db->query($sql)->bind([$kelas])->resultSet();
    }
    
    /**
     * Get statistics per class
     */
    public function getStatsPerClass() {
        $sql = "SELECT 
                    kelas,
                    COUNT(*) as total,
                    SUM(CASE WHEN status_aktif = 1 THEN 1 ELSE 0 END) as aktif,
                    SUM(CASE WHEN status_aktif = 0 THEN 1 ELSE 0 END) as non_aktif
                FROM {$this->table}
                GROUP BY kelas
                ORDER BY kelas";
        
        return $this->db->query($sql)->resultSet();
    }
    
    /**
     * Get recent members
     */
    public function getRecent($limit = 5) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status_aktif = 1 
                ORDER BY created_at DESC 
                LIMIT ?";
        
        return $this->db->query($sql)->bind([$limit])->resultSet();
    }
    
    /**
 * Search anggota for autocomplete
 */
public function searchForSelect($query) {
    // HAPUS no_anggota dari SELECT
    $sql = "SELECT id, nama, kelas 
            FROM {$this->table} 
            WHERE status_aktif = 1 
            AND (nama LIKE ?)
            LIMIT 10";
    
    $searchTerm = "%{$query}%";
    return $this->db->query($sql)->bind([$searchTerm])->resultSet();
}
    
    /**
     * Get total iuran per anggota
     */
    public function getTotalIuran($anggotaId) {
        $sql = "SELECT COALESCE(SUM(jumlah), 0) as total 
                FROM kas_masuk 
                WHERE anggota_id = ?";
        
        $result = $this->db->query($sql)->bind([$anggotaId])->single();
        return $result['total'];
    }
    
    /**
     * Override create method to handle custom logic
     */
    public function create($data) {
        // Generate no_anggota will be handled by trigger
        return parent::create($data);
    }
}
?>