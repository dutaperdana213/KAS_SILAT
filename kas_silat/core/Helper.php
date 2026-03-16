<?php
/**
 * Helper Functions
 */

/**
 * Format rupiah
 */
function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

/**
 * Format tanggal Indonesia
 */
function formatTanggal($date, $format = 'full') {
    if (empty($date)) return '-';
    
    $timestamp = strtotime($date);
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $h = $hari[date('w', $timestamp)];
    $d = date('j', $timestamp);
    $m = $bulan[(int)date('n', $timestamp)];
    $y = date('Y', $timestamp);
    
    if ($format == 'full') {
        return $h . ', ' . $d . ' ' . $m . ' ' . $y;
    } elseif ($format == 'date') {
        return $d . ' ' . $m . ' ' . $y;
    } elseif ($format == 'datetime') {
        return $d . ' ' . $m . ' ' . $y . ' ' . date('H:i', $timestamp);
    }
    
    return date('d-m-Y', $timestamp);
}

/**
 * Generate random string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomString;
}

/**
 * Upload file
 */
function uploadFile($file, $targetDir, $allowedTypes = [], $maxSize = 2097152) {
    if (!isset($file['error']) || is_array($file['error'])) {
        return [
            'success' => false,
            'message' => 'Parameter tidak valid'
        ];
    }
    
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            return [
                'success' => false,
                'message' => 'Ukuran file terlalu besar'
            ];
        case UPLOAD_ERR_NO_FILE:
            return [
                'success' => false,
                'message' => 'Tidak ada file yang diupload'
            ];
        default:
            return [
                'success' => false,
                'message' => 'Error saat upload file'
            ];
    }
    
    // Check file size
    if ($file['size'] > $maxSize) {
        return [
            'success' => false,
            'message' => 'Ukuran file maksimal ' . ($maxSize / 1048576) . 'MB'
        ];
    }
    
    // Check file type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    
    if (!empty($allowedTypes) && !in_array($mimeType, $allowedTypes)) {
        return [
            'success' => false,
            'message' => 'Tipe file tidak diizinkan'
        ];
    }
    
    // Create target directory if not exists
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = date('YmdHis') . '_' . generateRandomString(8) . '.' . $extension;
    $targetPath = $targetDir . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $targetPath
        ];
    }
    
    return [
        'success' => false,
        'message' => 'Gagal menyimpan file'
    ];
}

/**
 * Create slug from string
 */
function createSlug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    return trim($string, '-');
}

/**
 * Get current URL
 */
function currentUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    
    return $protocol . '://' . $host . $uri;
}

/**
 * Check if current URL matches pattern
 */
function isActive($pattern, $class = 'active') {
    $currentUrl = currentUrl();
    
    if (strpos($currentUrl, $pattern) !== false) {
        return $class;
    }
    
    return '';
}

/**
 * Debug function
 */
function debug($data, $exit = true) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    
    if ($exit) {
        exit;
    }
}

/**
 * Get month name in Indonesian
 */
function getBulan($bulan) {
    $bulanList = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
    
    return isset($bulanList[(int)$bulan]) ? $bulanList[(int)$bulan] : '';
}
?>