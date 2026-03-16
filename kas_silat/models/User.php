<?php
/**
 * User Model
 */

require_once BASE_PATH . 'core/Model.php';

class User extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username', 'password', 'nama_lengkap', 'email', 
        'role', 'foto_profil', 'is_active'
    ];
    protected $hidden = ['password'];
    
    /**
     * Find user by username
     */
    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = ? OR email = ?";
        return $this->db->query($sql)->bind([$username, $username])->single();
    }
    
    /**
     * Update last login
     */
    public function updateLastLogin($id) {
        $sql = "UPDATE {$this->table} SET last_login = NOW() WHERE id = ?";
        return $this->db->query($sql)->bind([$id])->execute();
    }
    
    /**
     * Store remember token
     */
    public function storeRememberToken($userId, $token, $expiry) {
        $sql = "UPDATE {$this->table} 
                SET remember_token = ?, token_expiry = ? 
                WHERE id = ?";
        return $this->db->query($sql)->bind([$token, $expiry, $userId])->execute();
    }
    
    /**
     * Find user by remember token
     */
    public function findByRememberToken($token) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE remember_token = ? AND token_expiry > NOW()";
        return $this->db->query($sql)->bind([$token])->single();
    }
    
    /**
     * Get users by role
     */
    public function getByRole($role) {
        $sql = "SELECT * FROM {$this->table} WHERE role = ? AND is_active = 1";
        return $this->db->query($sql)->bind([$role])->resultSet();
    }
    
    /**
     * Change password
     */
    public function changePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE {$this->table} SET password = ? WHERE id = ?";
        return $this->db->query($sql)->bind([$hashedPassword, $id])->execute();
    }
    
    /**
 * Update profile
 */
public function updateProfile($id, $data) {
    $setClause = [];
    $params = [];
    
    foreach ($data as $field => $value) {
        if (in_array($field, $this->fillable) && $field != 'password') {
            $setClause[] = "{$field} = ?";
            $params[] = $value;
        }
    }
    
    if (empty($setClause)) {
        return false;
    }
    
    $params[] = $id;
    $sql = "UPDATE {$this->table} SET " . implode(', ', $setClause) . ", updated_at = NOW() WHERE id = ?";
    
    return $this->db->query($sql)->bind($params)->execute();
}
    
    /**
     * Get user statistics
     */
    public function getStats() {
        $sql = "SELECT 
                    COUNT(*) as total_users,
                    SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as total_admin,
                    SUM(CASE WHEN role = 'bendahara' THEN 1 ELSE 0 END) as total_bendahara,
                    SUM(CASE WHEN role = 'pembina' THEN 1 ELSE 0 END) as total_pembina,
                    SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_users
                FROM {$this->table}";
        
        return $this->db->query($sql)->single();
    }

    /**
 * Get all users with pagination
 */
public function getAllUsers($page = 1, $perPage = 10, $search = '') {
    $offset = ($page - 1) * $perPage;
    $params = [];
    
    $sql = "SELECT id, username, nama_lengkap, email, role, is_active, last_login, created_at 
            FROM {$this->table} WHERE 1=1";
    
    if (!empty($search)) {
        $sql .= " AND (username LIKE ? OR nama_lengkap LIKE ? OR email LIKE ?)";
        $searchTerm = "%{$search}%";
        $params = [$searchTerm, $searchTerm, $searchTerm];
    }
    
    $sql .= " ORDER BY id DESC";
    
    // Get total count
    $countSql = str_replace("SELECT id, username, nama_lengkap, email, role, is_active, last_login, created_at", 
                           "SELECT COUNT(*) as total", $sql);
    $total = $this->db->query($countSql)->bind($params)->single()['total'];
    
    // Get data with pagination
    $sql .= " LIMIT ? OFFSET ?";
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
}
?>