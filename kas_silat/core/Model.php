<?php
/**
 * Core Model Class
 * Base model untuk semua model
 */

require_once BASE_PATH . 'core/Database.php';

abstract class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = ['id'];
    protected $hidden = [];
    protected $timestamps = true;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    /**
     * Get all records
     */
    public function all() {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC";
        return $this->db->query($sql)->resultSet();
    }
    
    /**
     * Find record by ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->query($sql)->bind([$id])->single();
    }
    
    /**
     * Find records by condition
     */
    public function where($conditions = [], $orderBy = null, $limit = null) {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $sql .= " AND {$field} {$value[0]} ?";
                $params[] = $value[1];
            } else {
                $sql .= " AND {$field} = ?";
                $params[] = $value;
            }
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return $this->db->query($sql)->bind($params)->resultSet();
    }
    
    /**
     * Create new record
     */
    public function create($data) {
        // Filter data berdasarkan fillable
        $data = $this->filterFillable($data);
        
        // Add timestamps
        if ($this->timestamps) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $fields = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$values})";
        
        if ($this->db->query($sql)->bind(array_values($data))->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Update record
     */
    public function update($id, $data) {
        // Filter data berdasarkan fillable
        $data = $this->filterFillable($data);
        
        // Add timestamps
        if ($this->timestamps) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $setClause = implode(' = ?, ', array_keys($data)) . ' = ?';
        $values = array_values($data);
        $values[] = $id;
        
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
        
        return $this->db->query($sql)->bind($values)->execute();
    }
    
    /**
     * Delete record
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->query($sql)->bind([$id])->execute();
    }
    
    /**
     * Get count
     */
    public function count($conditions = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $params = [];
        
        foreach ($conditions as $field => $value) {
            $sql .= " AND {$field} = ?";
            $params[] = $value;
        }
        
        $result = $this->db->query($sql)->bind($params)->single();
        return $result['total'];
    }
    
    /**
     * Filter data berdasarkan fillable
     */
    protected function filterFillable($data) {
        if (empty($this->fillable)) {
            return $data;
        }
        
        $filtered = [];
        foreach ($this->fillable as $field) {
            if (isset($data[$field])) {
                $filtered[$field] = $data[$field];
            }
        }
        
        return $filtered;
    }
    
    /**
     * Paginate records
     */
    public function paginate($page = 1, $perPage = 10, $conditions = []) {
        $offset = ($page - 1) * $perPage;
        
        $whereClause = "";
        $params = [];
        
        if (!empty($conditions)) {
            $whereClause = "WHERE 1=1";
            foreach ($conditions as $field => $value) {
                $whereClause .= " AND {$field} = ?";
                $params[] = $value;
            }
        }
        
        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} {$whereClause}";
        $total = $this->db->query($countSql)->bind($params)->single()['total'];
        
        // Get data
        $sql = "SELECT * FROM {$this->table} {$whereClause} ORDER BY {$this->primaryKey} DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        
        $data = $this->db->query($sql)->bind($params)->resultSet();
        
        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total)
        ];
    }
}
?>