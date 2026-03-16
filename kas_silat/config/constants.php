<?php
/**
 * Konstanta Aplikasi
 */

// Base URL - OTOMATIS DETECT
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base_folder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

define('BASE_URL', $protocol . '://' . $host . $base_folder);
define('BASE_PATH', dirname(__DIR__) . '/');

// Nama Aplikasi
define('APP_NAME', 'Sistem Informasi Kas Ekstrakurikuler Silat');
define('SCHOOL_NAME', 'SMPN 1 Suranenggala');
define('PERGURUAN', 'Singa Barwang');

// Session
define('SESSION_NAME', 'kas_silat_session');
define('SESSION_EXPIRE', 7200); // 2 jam

// Upload Path
define('UPLOAD_PATH', BASE_PATH . 'assets/uploads/');
define('UPLOAD_URL', BASE_URL . '/assets/uploads/');

// Role Definitions
define('ROLE_ADMIN', 'admin');
define('ROLE_BENDAHARA', 'bendahara');
define('ROLE_PEMBINA', 'pembina');

// Pagination
define('ITEMS_PER_PAGE', 10);

// Date Format
define('DATE_FORMAT', 'd-m-Y');
define('DATETIME_FORMAT', 'd-m-Y H:i:s');

// Currency Format
define('CURRENCY', 'Rp');
define('CURRENCY_FORMAT', 'IDR');

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', BASE_PATH . 'logs/error.log');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Session Start
if (session_status() == PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}
?>