<?php
/**
 * Log Aktivitas Model
 */

require_once BASE_PATH . 'core/Model.php';

class LogAktivitas extends Model {
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'aktivitas', 'tabel', 'data_id', 
        'ip_address', 'user_agent'
    ];
    protected $timestamps = false;
    
    /**
     * Get logs with user info
     */
    public function getLogs($limit = 50) {
        $sql = "SELECT l.*, u.nama_lengkap, u.username
                FROM {$this->table} l
                LEFT JOIN users u ON l.user_id = u.id
                ORDER BY l.created_at DESC
                LIMIT ?";
        
        return $this->db->query($sql)->bind([$limit])->resultSet();
    }
    
    /**
     * Get logs by user
     */
    public function getByUser($userId, $limit = 20) {
        $sql = "SELECT * FROM {$this->table}
                WHERE user_id = ?
                ORDER BY created_at DESC
                LIMIT ?";
        
        return $this->db->query($sql)->bind([$userId, $limit])->resultSet();
    }
    
    /**
     * Get logs by date range
     */
    public function getByDateRange($startDate, $endDate) {
        $sql = "SELECT l.*, u.nama_lengkap
                FROM {$this->table} l
                LEFT JOIN users u ON l.user_id = u.id
                WHERE DATE(l.created_at) BETWEEN ? AND ?
                ORDER BY l.created_at DESC";
        
        return $this->db->query($sql)->bind([$startDate, $endDate])->resultSet();
    }
    
    /**
     * Clear old logs
     */
    public function clearOldLogs($days = 30) {
        $sql = "DELETE FROM {$this->table} 
                WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)";
        
        return $this->db->query($sql)->bind([$days])->execute();
    }
    
    /**
     * Get activity statistics
     */
    public function getStats() {
        $sql = "SELECT 
                    DATE(created_at) as tanggal,
                    COUNT(*) as jumlah_aktivitas,
                    COUNT(DISTINCT user_id) as jumlah_user
                FROM {$this->table}
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                GROUP BY DATE(created_at)
                ORDER BY tanggal DESC";
        
        return $this->db->query($sql)->resultSet();
    }
}
?>