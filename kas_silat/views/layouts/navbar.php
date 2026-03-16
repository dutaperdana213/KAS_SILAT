<!-- Page Content -->
<div id="content">
    <!-- Navbar Premium -->
    <nav class="navbar navbar-premium">
        <div class="container-fluid">
            <!-- Toggle Button untuk Mobile -->
            <button class="navbar-toggler d-lg-none" type="button" id="sidebarToggle" aria-label="Toggle sidebar">
                <span class="toggle-icon">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            
            <!-- Breadcrumb Premium -->
            <div class="navbar-breadcrumb">
                <div class="breadcrumb-wrapper">
                    <i class="fas fa-home breadcrumb-home"></i>
                    <span class="breadcrumb-item">Dashboard</span>
                    <?php 
                    $currentUrl = $_SERVER['REQUEST_URI'];
                    $breadcrumbText = '';
                    
                    if (strpos($currentUrl, 'anggota') !== false) {
                        $breadcrumbText = 'Data Anggota';
                    } elseif (strpos($currentUrl, 'kas-masuk') !== false) {
                        $breadcrumbText = 'Kas Masuk';
                    } elseif (strpos($currentUrl, 'kas-keluar') !== false) {
                        $breadcrumbText = 'Kas Keluar';
                    } elseif (strpos($currentUrl, 'laporan') !== false) {
                        $breadcrumbText = 'Laporan';
                    } elseif (strpos($currentUrl, 'users') !== false) {
                        $breadcrumbText = 'Manajemen User';
                    } elseif (strpos($currentUrl, 'profile') !== false) {
                        $breadcrumbText = 'Profile';
                    }
                    
                    if ($breadcrumbText) {
                        echo '<span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>';
                        echo '<span class="breadcrumb-item active">' . $breadcrumbText . '</span>';
                    }
                    ?>
                </div>
            </div>
            
            <!-- User Dropdown Premium -->
            <div class="user-dropdown-wrapper">
                <div class="dropdown user-dropdown">
                    <button class="btn user-dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                        <div class="user-info">
                            <div class="user-avatar">
                                <?php 
                                $inisial = substr($this->auth->user()['nama_lengkap'] ?? 'User', 0, 2);
                                echo strtoupper($inisial);
                                ?>
                            </div>
                            <div class="user-details">
                                <span class="user-name"><?= $this->auth->user()['nama_lengkap'] ?? 'User' ?></span>
                                <span class="user-role-badge badge bg-<?= 
                                    $this->auth->user()['role'] == 'admin' ? 'danger' : 
                                    ($this->auth->user()['role'] == 'bendahara' ? 'warning' : 'info') 
                                ?>">
                                    <?= ucfirst($this->auth->user()['role'] ?? '') ?>
                                </span>
                            </div>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                    </button>
                    
                    <!-- Dropdown Menu Premium -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li class="dropdown-header">
                            <div class="dropdown-user-info">
                                <div class="dropdown-user-avatar">
                                    <?php 
                                    $inisial = substr($this->auth->user()['nama_lengkap'] ?? 'User', 0, 2);
                                    echo strtoupper($inisial);
                                    ?>
                                </div>
                                <div class="dropdown-user-details">
                                    <span class="dropdown-user-name"><?= $this->auth->user()['nama_lengkap'] ?? 'User' ?></span>
                                    <span class="dropdown-user-email"><?= $this->auth->user()['username'] ?? '' ?>@<?= SCHOOL_NAME ?></span>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/profile">
                                <span class="icon-wrapper">
                                    <i class="fas fa-user"></i>
                                </span>
                                <span class="item-text">Profile Saya</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout" onclick="return confirm('Yakin ingin logout?')">
                                <span class="icon-wrapper">
                                    <i class="fas fa-sign-out-alt"></i>
                                </span>
                                <span class="item-text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content Area -->
    <div class="main-content">

<style>
/* Navbar Premium */
.navbar-premium {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 0.5rem 1rem;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    transition: all 0.3s ease;
}

.navbar-premium .container-fluid {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

/* Toggle Button Premium */
.navbar-toggler {
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s;
}

.toggle-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    color: white;
    font-size: 1.2rem;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    transition: all 0.3s;
}

.navbar-toggler:hover .toggle-icon {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.navbar-toggler:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

/* Breadcrumb Premium */
.navbar-breadcrumb {
    flex: 1;
    min-width: 0;
}

.breadcrumb-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    background: rgba(102, 126, 234, 0.05);
    padding: 0.4rem 1rem;
    border-radius: 30px;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.breadcrumb-home {
    color: #667eea;
    font-size: 0.9rem;
}

.breadcrumb-item {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
    white-space: nowrap;
}

.breadcrumb-item.active {
    color: #2c3e50;
    font-weight: 600;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.breadcrumb-separator {
    color: #cbd5e1;
    font-size: 0.65rem;
}

/* User Dropdown Premium */
.user-dropdown-wrapper {
    flex-shrink: 0;
}

.user-dropdown-toggle {
    background: transparent !important;
    border: none !important;
    padding: 0.25rem 0.5rem !important;
    box-shadow: none !important;
    transition: all 0.3s;
    border-radius: 40px !important;
}

.user-dropdown-toggle:hover {
    background: rgba(102, 126, 234, 0.05) !important;
}

.user-dropdown-toggle::after {
    display: none !important;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    transition: all 0.3s;
}

.user-dropdown-toggle:hover .user-avatar {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.user-details {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.user-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
    line-height: 1.3;
}

.user-role-badge {
    font-size: 0.65rem;
    padding: 0.15rem 0.5rem;
    border-radius: 30px;
    font-weight: 500;
}

.dropdown-arrow {
    color: #94a3b8;
    font-size: 0.7rem;
    transition: transform 0.3s;
    margin-left: 0.25rem;
}

.user-dropdown-toggle[aria-expanded="true"] .dropdown-arrow {
    transform: rotate(180deg);
}

/* Dropdown Menu Premium */
.dropdown-menu {
    background: white;
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 0.5rem 0;
    margin-top: 0.5rem !important;
    min-width: 280px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    animation: dropdownFade 0.3s ease;
}

@keyframes dropdownFade {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-header {
    padding: 1rem 1rem 0.5rem;
}

.dropdown-user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.dropdown-user-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.2rem;
}

.dropdown-user-details {
    display: flex;
    flex-direction: column;
}

.dropdown-user-name {
    font-weight: 700;
    color: #2c3e50;
    font-size: 1rem;
}

.dropdown-user-email {
    font-size: 0.7rem;
    color: #6c757d;
}

.dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.2rem;
    color: #2c3e50;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.dropdown-item .icon-wrapper {
    width: 32px;
    height: 32px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.8rem;
    transition: all 0.2s;
}

.dropdown-item .icon-wrapper i {
    font-size: 0.9rem;
    color: #667eea;
}

.dropdown-item:hover {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.05), transparent);
}

.dropdown-item:hover .icon-wrapper {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.dropdown-item:hover .icon-wrapper i {
    color: white;
}

.dropdown-item.text-danger .icon-wrapper i {
    color: #ef4444;
}

.dropdown-item.text-danger:hover .icon-wrapper {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.dropdown-item.text-danger:hover .icon-wrapper i {
    color: white;
}

.dropdown-item.text-danger:hover {
    background: rgba(239, 68, 68, 0.05);
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-color: rgba(0, 0, 0, 0.05);
}

/* Main Content */
.main-content {
    padding: 1.5rem;
    min-height: calc(100vh - 70px);
    background: #f8fafd;
    transition: all 0.3s;
}

/* Responsive Breakpoints */
@media (min-width: 992px) {
    .navbar-premium {
        padding: 0.75rem 1.5rem;
    }
    
    .breadcrumb-wrapper {
        margin-left: 0.5rem;
    }
}

@media (max-width: 991px) {
    .navbar-breadcrumb {
        display: none;
    }
    
    .user-name {
        display: none;
    }
    
    .user-role-badge {
        display: none;
    }
    
    .user-avatar {
        width: 38px;
        height: 38px;
        font-size: 0.9rem;
    }
}

@media (max-width: 768px) {
    .navbar-premium {
        padding: 0.5rem;
    }
    
    .dropdown-menu {
        min-width: 250px;
        right: 10px !important;
        left: auto !important;
        position: fixed !important;
        top: 70px !important;
    }
    
    .main-content {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .user-avatar {
        width: 35px;
        height: 35px;
        font-size: 0.85rem;
    }
    
    .dropdown-menu {
        min-width: 220px;
        right: 5px !important;
    }
    
    .dropdown-user-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .dropdown-user-name {
        font-size: 0.9rem;
    }
    
    .dropdown-user-email {
        font-size: 0.65rem;
    }
    
    .main-content {
        padding: 0.75rem;
    }
}

/* Loading Animation */
@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.navbar-premium.loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
}

/* Accessibility */
.navbar-toggler:focus-visible,
.user-dropdown-toggle:focus-visible,
.dropdown-item:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}
</style>

<script>
$(document).ready(function() {
    // Toggle sidebar untuk mobile
    $('#sidebarToggle').on('click', function(e) {
        e.preventDefault();
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });
    
    // Close sidebar ketika klik di luar di mobile
    $(document).on('click', function(e) {
        if ($(window).width() < 992) {
            if (!$(e.target).closest('#sidebar').length && 
                !$(e.target).closest('#sidebarToggle').length && 
                $('#sidebar').hasClass('active')) {
                $('#sidebar').removeClass('active');
                $('#content').removeClass('active');
                $('#sidebarToggle i').removeClass('fa-times').addClass('fa-bars');
            }
        }
    });
    
    // Handle resize window
    $(window).on('resize', function() {
        if ($(window).width() >= 992) {
            $('#sidebar').removeClass('active');
            $('#content').removeClass('active');
            $('#sidebarToggle i').removeClass('fa-times').addClass('fa-bars');
        }
    });
    
    // Update breadcrumb berdasarkan URL (untuk mobile)
    function updateMobileTitle() {
        var path = window.location.pathname;
        var title = 'Dashboard';
        
        if (path.includes('anggota')) {
            title = 'Data Anggota';
        } else if (path.includes('kas-masuk')) {
            title = 'Kas Masuk';
        } else if (path.includes('kas-keluar')) {
            title = 'Kas Keluar';
        } else if (path.includes('laporan')) {
            title = 'Laporan';
        } else if (path.includes('users')) {
            title = 'Manajemen User';
        } else if (path.includes('profile')) {
            title = 'Profile';
        }
        
        // Update page title di mobile jika diperlukan
        $('.mobile-page-title').text(title);
    }
    
    updateMobileTitle();
    
    // Dropdown positioning untuk mobile
    function adjustDropdownPosition() {
        if ($(window).width() < 768) {
            $('.dropdown-menu').css({
                'position': 'fixed',
                'top': '70px',
                'right': '10px',
                'left': 'auto'
            });
        } else {
            $('.dropdown-menu').css({
                'position': 'absolute',
                'top': '100%',
                'right': '0',
                'left': 'auto'
            });
        }
    }
    
    adjustDropdownPosition();
    $(window).on('resize', adjustDropdownPosition);
    
    // Animasi loading state (opsional)
    $(window).on('beforeunload', function() {
        $('.navbar-premium').addClass('loading');
    });
    
    $(window).on('load', function() {
        $('.navbar-premium').removeClass('loading');
    });
});
</script>