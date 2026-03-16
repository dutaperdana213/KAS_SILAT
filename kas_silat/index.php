<?php
/**
 * Index.php - Front Controller
 * Sistem Informasi Kas Ekstrakurikuler Silat
 * SMPN 1 Suranenggala - Perguruan Singa Barwang
 */

// Load konfigurasi
require_once __DIR__ . '/config/constants.php';

// Autoloader sederhana
spl_autoload_register(function ($class) {
    // Daftar direktori yang akan dicari
    $directories = [
        'controllers/',
        'models/',
        'core/',
        'middleware/',
        'helpers/'
    ];
    
    foreach ($directories as $directory) {
        $file = BASE_PATH . $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Load helper functions
require_once BASE_PATH . 'core/Helper.php';

// Inisialisasi Router
require_once BASE_PATH . 'core/Router.php';
$router = new Router();

// ======================================================
// DAFTAR ROUTE
// ======================================================

// Route Auth
$router->get('auth/login', 'AuthController', 'loginForm');
$router->post('auth/login', 'AuthController', 'login');
$router->get('auth/logout', 'AuthController', 'logout');
$router->get('auth/forgot-password', 'AuthController', 'forgotPassword');
$router->post('auth/forgot-password', 'AuthController', 'sendResetLink');

// Route Dashboard
$router->get('dashboard', 'DashboardController', 'index');
$router->post('dashboard/getWidgetData', 'DashboardController', 'getWidgetData');

// Route Anggota
$router->get('anggota', 'AnggotaController', 'index');
$router->get('anggota/create', 'AnggotaController', 'create');
$router->post('anggota/store', 'AnggotaController', 'store');
$router->get('anggota/edit/([0-9]+)', 'AnggotaController', 'edit');
$router->post('anggota/update/([0-9]+)', 'AnggotaController', 'update');
$router->post('anggota/delete/([0-9]+)', 'AnggotaController', 'delete');
$router->get('anggota/show/([0-9]+)', 'AnggotaController', 'show');
$router->get('anggota/search', 'AnggotaController', 'search');

// Route Kas Masuk
$router->get('kas-masuk', 'KasMasukController', 'index');
$router->get('kas-masuk/create', 'KasMasukController', 'create');
$router->post('kas-masuk/store', 'KasMasukController', 'store');
$router->get('kas-masuk/edit/([0-9]+)', 'KasMasukController', 'edit');
$router->post('kas-masuk/update/([0-9]+)', 'KasMasukController', 'update');
$router->post('kas-masuk/delete/([0-9]+)', 'KasMasukController', 'delete');
$router->get('kas-masuk/show/([0-9]+)', 'KasMasukController', 'show');

// Route Kas Keluar
$router->get('kas-keluar', 'KasKeluarController', 'index');
$router->get('kas-keluar/create', 'KasKeluarController', 'create');
$router->post('kas-keluar/store', 'KasKeluarController', 'store');
$router->get('kas-keluar/edit/([0-9]+)', 'KasKeluarController', 'edit');
$router->post('kas-keluar/update/([0-9]+)', 'KasKeluarController', 'update');
$router->post('kas-keluar/delete/([0-9]+)', 'KasKeluarController', 'delete');
$router->post('kas-keluar/approve/([0-9]+)', 'KasKeluarController', 'approve');
$router->get('kas-keluar/show/([0-9]+)', 'KasKeluarController', 'show');

// Route Laporan
$router->get('laporan', 'LaporanController', 'index');
$router->get('laporan/kas-masuk', 'LaporanController', 'kasMasuk');
$router->get('laporan/kas-keluar', 'LaporanController', 'kasKeluar');
$router->get('laporan/rekap-anggota', 'LaporanController', 'rekapAnggota');
$router->get('laporan/export-excel', 'LaporanController', 'exportExcel');
$router->get('laporan/export-pdf', 'LaporanController', 'exportPdf');
$router->get('laporan/print', 'LaporanController', 'print');

// Route Profile (akan ditambahkan nanti)
$router->get('profile', 'ProfileController', 'index');
$router->post('profile/update', 'ProfileController', 'update');
$router->post('profile/change-password', 'ProfileController', 'changePassword');

// Route Users (khusus admin)
$router->get('users', 'UserController', 'index');
$router->get('users/create', 'UserController', 'create');
$router->post('users/store', 'UserController', 'store');
$router->get('users/edit/([0-9]+)', 'UserController', 'edit');
$router->post('users/update/([0-9]+)', 'UserController', 'update');
$router->post('users/delete/([0-9]+)', 'UserController', 'delete');
$router->post('users/toggle-status/([0-9]+)', 'UserController', 'toggleStatus');

// Default route - PAKAI REDIRECT LANGSUNG
if ($_SERVER['REQUEST_URI'] == '/KAS_SILAT/' || $_SERVER['REQUEST_URI'] == '/KAS_SILAT/index.php') {
    header('Location: ' . BASE_URL . '/dashboard');
    exit;
}

// Dispatch request
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$router->dispatch($url);
?>