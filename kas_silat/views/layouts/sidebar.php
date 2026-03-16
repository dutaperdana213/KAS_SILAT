<!-- Sidebar Premium -->
<nav id="sidebar" class="sidebar-premium">
    <!-- Sidebar Header dengan Logo -->
    <div class="sidebar-header">
        <div class="header-content">
            <!-- Logo Perguruan -->
            <div class="logo-wrapper">
                <?php if (file_exists(BASE_PATH . 'assets/img/logo-perguruan.png')): ?>
                    <img src="<?= BASE_URL ?>/assets/img/logo-perguruan.png" alt="Logo Singa Barwang" class="sidebar-logo">
                <?php elseif (file_exists(BASE_PATH . 'assets/img/logo-perguruan.jpg')): ?>
                    <img src="<?= BASE_URL ?>/assets/img/logo-perguruan.jpg" alt="Logo Singa Barwang" class="sidebar-logo">
                <?php else: ?>
                    <i class="fas fa-fist-raised"></i>
                <?php endif; ?>
            </div>
            
            <!-- Teks Ringkas -->
            <div class="brand-text">
                <h3>SISTEM KAS</h3>
                <p>SMPN 1 Suranenggala</p>
                <span class="badge-perguruan">SINGA BARWANG</span>
            </div>
        </div>
        <div class="header-glow"></div>
    </div>

    <!-- User Info Mini (untuk mobile) -->
    <div class="user-info-mini d-md-none">
        <div class="user-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="user-details">
            <span class="user-name"><?= $this->auth->user()['nama_lengkap'] ?? 'User' ?></span>
            <span class="user-role"><?= ucfirst($this->auth->user()['role'] ?? '') ?></span>
        </div>
    </div>

    <!-- Menu Navigation -->
    <ul class="components">
        <!-- Dashboard -->
        <li class="<?= isActive('dashboard') ?>">
            <a href="<?= BASE_URL ?>/dashboard" class="menu-link">
                <span class="icon-wrapper">
                    <i class="fas fa-tachometer-alt"></i>
                </span>
                <span class="menu-text">Dashboard</span>
            </a>
        </li>
        
        <!-- Data Anggota -->
        <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA, ROLE_PEMBINA])): ?>
        <li class="<?= isActive('anggota') ?>">
            <a href="<?= BASE_URL ?>/anggota" class="menu-link">
                <span class="icon-wrapper">
                    <i class="fas fa-users"></i>
                </span>
                <span class="menu-text">Anggota</span>
            </a>
        </li>
        <?php endif; ?>
        
        <!-- Kas Masuk -->
        <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA, ROLE_PEMBINA])): ?>
        <li class="<?= isActive('kas-masuk') ?>">
            <a href="<?= BASE_URL ?>/kas-masuk" class="menu-link">
                <span class="icon-wrapper">
                    <i class="fas fa-money-bill-wave"></i>
                </span>
                <span class="menu-text">Kas Masuk</span>
            </a>
        </li>
        <?php endif; ?>
        
        <!-- Kas Keluar -->
        <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA, ROLE_PEMBINA])): ?>
        <li class="<?= isActive('kas-keluar') ?>">
            <a href="<?= BASE_URL ?>/kas-keluar" class="menu-link">
                <span class="icon-wrapper">
                    <i class="fas fa-money-bill-wave-alt"></i>
                </span>
                <span class="menu-text">Kas Keluar</span>
            </a>
        </li>
        <?php endif; ?>
        
        <!-- Laporan -->
        <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])): ?>
        <li class="<?= isActive('laporan') ?>">
            <a href="<?= BASE_URL ?>/laporan" class="menu-link">
                <span class="icon-wrapper">
                    <i class="fas fa-chart-bar"></i>
                </span>
                <span class="menu-text">Laporan</span>
            </a>
        </li>
        <?php endif; ?>
        
        <!-- Manajemen User (khusus admin) -->
        <?php if ($this->auth->isAdmin()): ?>
        <li class="<?= isActive('users') ?>">
            <a href="<?= BASE_URL ?>/users" class="menu-link">
                <span class="icon-wrapper">
                    <i class="fas fa-user-cog"></i>
                </span>
                <span class="menu-text">Manajemen User</span>
            </a>
        </li>
        <?php endif; ?>
        
        <!-- Profile -->
        <li class="<?= isActive('profile') ?>">
            <a href="<?= BASE_URL ?>/profile" class="menu-link">
                <span class="icon-wrapper">
                    <i class="fas fa-user"></i>
                </span>
                <span class="menu-text">Profile</span>
            </a>
        </li>
        
        <!-- Logout -->
        <li class="logout-item">
            <a href="<?= BASE_URL ?>/auth/logout" class="menu-link" onclick="return confirm('Yakin ingin logout?')">
                <span class="icon-wrapper">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span class="menu-text">Logout</span>
            </a>
        </li>
    </ul>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="footer-content">
            <small>&copy; <?= date('Y') ?> <?= SCHOOL_NAME ?></small>
        </div>
        <div class="footer-glow"></div>
    </div>
</nav>

<style>
/* Import Font */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

:root {
    --sidebar-width: 260px;
    --sidebar-collapsed-width: 80px;
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --sidebar-bg: linear-gradient(180deg, #1a1f2f 0%, #0f1422 100%);
    --menu-hover: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    --active-gradient: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

/* Sidebar Premium */
.sidebar-premium {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--sidebar-bg);
    box-shadow: 5px 0 30px rgba(0, 0, 0, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.2) transparent;
}

/* Custom Scrollbar */
.sidebar-premium::-webkit-scrollbar {
    width: 5px;
}

.sidebar-premium::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-premium::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
}

.sidebar-premium::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.3);
}

/* Sidebar Header */
.sidebar-header {
    position: relative;
    padding: 1.5rem 1.2rem;
    margin-bottom: 1rem;
    overflow: hidden;
}

.header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.logo-wrapper {
    width: 45px;
    height: 45px;
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 2px solid rgba(255,215,0,0.3);
}

.sidebar-logo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.logo-wrapper i {
    font-size: 1.5rem;
    color: rgba(255,255,255,0.5);
}

.brand-text h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    margin: 0;
    line-height: 1.2;
    letter-spacing: 1px;
}

.brand-text p {
    font-size: 0.65rem;
    color: rgba(255,255,255,0.5);
    margin: 0;
    line-height: 1.2;
}

.badge-perguruan {
    font-size: 0.6rem;
    background: rgba(255,215,0,0.2);
    color: #ffd700;
    padding: 0.2rem 0.5rem;
    border-radius: 20px;
    display: inline-block;
    margin-top: 0.2rem;
    border: 1px solid rgba(255,215,0,0.3);
    font-weight: 600;
    letter-spacing: 0.5px;
}

.header-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 30%, rgba(102, 126, 234, 0.2), transparent 70%);
    z-index: 1;
}

/* User Info Mini (Mobile) */
.user-info-mini {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    margin: 0 1rem 1.5rem;
    padding: 1rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid rgba(255,255,255,0.1);
}

.user-avatar i {
    font-size: 2.5rem;
    color: rgba(255,255,255,0.5);
}

.user-details {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 600;
    color: white;
    font-size: 0.9rem;
}

.user-role {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.5);
}

/* Menu Items */
.components {
    list-style: none;
    padding: 0;
    margin: 0;
}

.components li {
    margin: 2px 0;
    position: relative;
}

.menu-link {
    display: flex;
    align-items: center;
    padding: 0.7rem 1.2rem;
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.menu-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent);
    transition: width 0.3s;
}

.menu-link:hover::before {
    width: 100%;
}

.menu-link:hover {
    color: white;
    transform: translateX(5px);
}

.icon-wrapper {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: rgba(255,255,255,0.05);
    margin-right: 10px;
    transition: all 0.3s;
}

.menu-link:hover .icon-wrapper {
    background: var(--active-gradient);
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.icon-wrapper i {
    font-size: 1rem;
    transition: all 0.3s;
}

.menu-text {
    flex: 1;
    font-weight: 500;
    font-size: 0.85rem;
}

/* Active Menu Item */
.components li.active .menu-link {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.15), transparent);
    color: white;
}

.components li.active .icon-wrapper {
    background: var(--active-gradient);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.components li.active .icon-wrapper i {
    color: white;
}

.components li.active::after {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 25px;
    background: var(--active-gradient);
    border-radius: 0 3px 3px 0;
    animation: pulse 2s infinite;
}

/* Logout Item Special */
.logout-item .menu-link:hover {
    background: rgba(239, 68, 68, 0.1);
}

.logout-item .menu-link:hover .icon-wrapper {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

/* Sidebar Footer */
.sidebar-footer {
    position: relative;
    margin-top: 2rem;
    padding: 1.2rem;
    overflow: hidden;
}

.footer-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.footer-content small {
    color: rgba(255,255,255,0.3);
    font-size: 0.65rem;
}

.footer-glow {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: radial-gradient(circle at bottom, rgba(102, 126, 234, 0.1), transparent 70%);
    z-index: 1;
}

/* Animations */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Responsive Breakpoints */
@media (min-width: 992px) {
    #sidebar {
        width: var(--sidebar-width);
    }
    
    #content {
        width: calc(100% - var(--sidebar-width));
        margin-left: var(--sidebar-width);
    }
}

@media (max-width: 991px) {
    #sidebar {
        width: 100%;
        height: auto;
        min-height: auto;
        position: relative;
    }
    
    .sidebar-header {
        padding: 1rem;
    }
    
    .logo-wrapper {
        width: 40px;
        height: 40px;
    }
    
    .brand-text h3 {
        font-size: 1rem;
    }
    
    .brand-text p {
        font-size: 0.6rem;
    }
    
    .badge-perguruan {
        font-size: 0.55rem;
    }
    
    .user-info-mini {
        margin: 0 1rem;
    }
    
    .components {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0 0.5rem;
    }
    
    .components li {
        width: calc(50% - 8px);
        margin: 4px;
    }
    
    .menu-link {
        flex-direction: column;
        text-align: center;
        padding: 0.8rem 0.5rem;
    }
    
    .icon-wrapper {
        margin: 0 0 0.5rem 0;
        width: 35px;
        height: 35px;
    }
    
    .menu-text {
        font-size: 0.75rem;
    }
    
    .components li.active::after {
        display: none;
    }
    
    .sidebar-footer {
        display: none;
    }
}

@media (max-width: 576px) {
    .components li {
        width: 100%;
    }
    
    .menu-link {
        flex-direction: row;
        text-align: left;
    }
    
    .icon-wrapper {
        margin: 0 0.5rem 0 0;
        width: 32px;
        height: 32px;
    }
    
    .menu-text {
        font-size: 0.8rem;
    }
}

/* Dark Mode Optimization */
@media (prefers-color-scheme: dark) {
    .sidebar-premium {
        background: linear-gradient(180deg, #0f1422 0%, #0a0e1a 100%);
    }
}

/* Touch-friendly untuk Mobile */
@media (hover: none) and (pointer: coarse) {
    .menu-link:active {
        background: var(--menu-hover);
        transform: scale(0.98);
    }
    
    .menu-link:active .icon-wrapper {
        transform: scale(0.95);
    }
}
</style>

<script>
$(document).ready(function() {
    // Toggle sidebar untuk mobile
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });
    
    // Auto close sidebar di mobile setelah klik menu
    if (window.innerWidth < 992) {
        $('.menu-link').on('click', function() {
            $('#sidebar').removeClass('active');
            $('#content').removeClass('active');
        });
    }
    
    // Highlight active menu
    var currentUrl = window.location.href;
    $('.menu-link').each(function() {
        if (currentUrl.indexOf($(this).attr('href')) > -1) {
            $(this).closest('li').addClass('active');
        }
    });
});
</script>