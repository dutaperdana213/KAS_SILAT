<?php
/**
 * Core Database Class
 * Mengelola koneksi database dengan PDO
 */

class Database {
    private static $instance = null;
    protected $pdo;
    protected $stmt;
    protected $transactionCounter = 0;
    
    // Constructor dengan koneksi PDO
    public function __construct() {
        $host = 'localhost';
        $dbname = 'kas_silat';
        $username = 'root';
        $password = '';
        $charset = 'utf8mb4';
        
        try {
            $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
    
    /**
     * Prepare query
     */
    public function query($sql) {
        $this->stmt = $this->pdo->prepare($sql);
        return $this;
    }
    
    /**
     * Bind parameters
     */
    public function bind($params = []) {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (is_int($value)) {
                    $type = PDO::PARAM_INT;
                } elseif (is_bool($value)) {
                    $type = PDO::PARAM_BOOL;
                } elseif (is_null($value)) {
                    $type = PDO::PARAM_NULL;
                } else {
                    $type = PDO::PARAM_STR;
                }
                
                if (is_int($key)) {
                    $this->stmt->bindValue($key + 1, $value, $type);
                } else {
                    $this->stmt->bindValue(':' . $key, $value, $type);
                }
            }
        }
        return $this;
    }
    
    /**
     * Execute query
     */
    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            $this->logError($e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get single record
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }
    
    /**
     * Get multiple records
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }
    
    /**
     * Get row count
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    
    /**
     * Get last insert ID
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Begin transaction
     */
    public function beginTransaction() {
        if ($this->transactionCounter == 0) {
            $this->pdo->beginTransaction();
        }
        $this->transactionCounter++;
        return true;
    }
    
    /**
     * Commit transaction
     */
    public function commit() {
        $this->transactionCounter--;
        if ($this->transactionCounter == 0) {
            $this->pdo->commit();
        }
        return true;
    }
    
    /**
     * Rollback transaction
     */
    public function rollback() {
        $this->transactionCounter = 0;
        $this->pdo->rollback();
        return true;
    }
    
    /**
     * Log database error
     */
    private function logError($message) {
        $logFile = BASE_PATH . 'logs/db_error.log';
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] ERROR: $message" . PHP_EOL;
        $logMessage .= "Query: " . $this->stmt->queryString . PHP_EOL;
        $logMessage .= "----------------------------------------" . PHP_EOL;
        
        error_log($logMessage, 3, $logFile);
    }
    
    /**
     * Escape string for safe output
     */
    public function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
?>