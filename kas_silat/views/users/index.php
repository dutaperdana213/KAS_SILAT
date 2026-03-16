<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Header Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Manajemen User</span>
                </h1>
                <p class="title-sub mb-0">Kelola pengguna dan hak akses sistem</p>
            </div>
            <div class="header-decoration">
                <i class="fas fa-users-cog"></i>
                <i class="fas fa-user-shield"></i>
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
    </div>
    
    <!-- Filter & Search Premium -->
    <div class="filter-card mb-4">
        <div class="filter-body">
            <form method="GET" action="<?= BASE_URL ?>/users" id="searchForm">
                <div class="filter-grid">
                    <div class="filter-item search-item">
                        <label class="filter-label">Pencarian</label>
                        <div class="search-input-group">
                            <i class="fas fa-search input-icon"></i>
                            <input type="text" name="search" id="searchInput" 
                                   placeholder="Cari username, nama, atau email..." 
                                   value="<?= $search ?>">
                            <?php if ($search): ?>
                            <button type="button" class="clear-search" id="clearSearch">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="filter-item filter-button">
                        <label class="filter-label d-none d-md-block">&nbsp;</label>
                        <div class="action-btn-group">
                            <button type="submit" class="btn-filter">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                            <?php if ($search): ?>
                            <a href="<?= BASE_URL ?>/users" class="btn-reset">
                                <i class="fas fa-times me-1"></i> Reset
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Stats Cards Premium -->
    <div class="stats-grid mb-4">
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Users</div>
                <div class="stat-value"><?= $pagination['total'] ?? 0 ?></div>
                <div class="stat-period">Terdaftar</div>
            </div>
        </div>
        
        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">User Aktif</div>
                <div class="stat-value"><?= $stats['active'] ?? 0 ?></div>
                <div class="stat-period">Online</div>
            </div>
        </div>
        
        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Administrator</div>
                <div class="stat-value"><?= $stats['admin'] ?? 0 ?></div>
                <div class="stat-period">Hak akses penuh</div>
            </div>
        </div>
    </div>
    
    <!-- Data Table Premium -->
    <div class="table-card">
        <div class="table-header">
            <h5 class="table-title">
                <i class="fas fa-list me-2 text-primary"></i>
                Daftar Pengguna
            </h5>
            <div class="table-actions">
                <a href="<?= BASE_URL ?>/users/create" class="btn-add">
                    <i class="fas fa-plus-circle me-1"></i>
                    <span>Tambah User</span>
                    <div class="btn-glow"></div>
                </a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="premium-table" id="userTable">
                <thead>
                    <tr>
                        <th class="text-center" width="50">No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th class="d-none d-lg-table-cell">Email</th>
                        <th class="text-center" width="80">Role</th>
                        <th class="text-center" width="70">Status</th>
                        <th class="d-none d-md-table-cell">Terakhir Login</th>
                        <th class="text-center" width="110">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="8" class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <h5>Belum Ada Data User</h5>
                            <p class="text-muted">Mulai dengan menambahkan user baru</p>
                            <a href="<?= BASE_URL ?>/users/create" class="btn-add mt-3">
                                <i class="fas fa-plus-circle me-1"></i> Tambah User
                            </a>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php $no = ($pagination['current_page'] - 1) * ITEMS_PER_PAGE + 1; ?>
                        <?php foreach ($users as $u): ?>
                        <tr class="data-row">
                            <td class="text-center fw-medium"><?= $no++ ?></td>
                            <td>
                                <div class="user-info">
                                    <span class="user-name"><?= htmlspecialchars($u['username']) ?></span>
                                    <!-- Mobile meta -->
                                    <div class="mobile-meta d-block d-lg-none">
                                        <span class="meta-item">
                                            <i class="fas fa-envelope me-1"></i><?= $u['email'] ?? '-' ?>
                                        </span>
                                    </div>
                                    <div class="mobile-meta d-block d-md-none">
                                        <span class="meta-item">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= $u['last_login'] ? formatTanggal($u['last_login'], 'datetime') : 'Never' ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="user-fullname"><?= htmlspecialchars($u['nama_lengkap']) ?></span>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="user-email"><?= $u['email'] ?? '-' ?></span>
                            </td>
                            <td class="text-center">
                                <span class="role-badge role-<?= $u['role'] ?>">
                                    <?php if ($u['role'] == 'admin'): ?>
                                        <i class="fas fa-crown me-1"></i>
                                    <?php elseif ($u['role'] == 'bendahara'): ?>
                                        <i class="fas fa-wallet me-1"></i>
                                    <?php else: ?>
                                        <i class="fas fa-users me-1"></i>
                                    <?php endif; ?>
                                    <?= ucfirst($u['role']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($u['is_active']): ?>
                                    <span class="status-badge status-active">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge status-inactive">
                                        <i class="fas fa-ban me-1"></i>Non Aktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="login-info">
                                    <?php if ($u['last_login']): ?>
                                        <i class="fas fa-clock text-muted me-1"></i>
                                        <span title="<?= formatTanggal($u['last_login'], 'full') ?>">
                                            <?= formatTanggal($u['last_login'], 'datetime') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">
                                            <i class="fas fa-minus me-1"></i>Never
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?= BASE_URL ?>/users/edit/<?= $u['id'] ?>" 
                                       class="btn-action btn-edit" 
                                       title="Edit User">
                                        <i class="fas fa-edit"></i>
                                        <div class="btn-glow"></div>
                                    </a>
                                    
                                    <?php if ($u['id'] != $user['id']): ?>
                                        <button onclick="toggleStatus(<?= $u['id'] ?>, '<?= $u['username'] ?>', <?= $u['is_active'] ?>)" 
                                                class="btn-action btn-<?= $u['is_active'] ? 'inactive' : 'active' ?>" 
                                                title="<?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                            <i class="fas fa-<?= $u['is_active'] ? 'ban' : 'check' ?>"></i>
                                            <div class="btn-glow"></div>
                                        </button>
                                        
                                        <button onclick="deleteUser(<?= $u['id'] ?>, '<?= $u['username'] ?>')" 
                                                class="btn-action btn-delete" 
                                                title="Hapus User">
                                            <i class="fas fa-trash"></i>
                                            <div class="btn-glow"></div>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Premium -->
        <?php if (isset($pagination) && $pagination['last_page'] > 1): ?>
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span class="info-badge">
                    <i class="fas fa-database me-1"></i>
                    Menampilkan <?= $pagination['from'] ?? 0 ?> - <?= $pagination['to'] ?? 0 ?> 
                    dari <?= $pagination['total'] ?> data
                </span>
            </div>
            
            <nav aria-label="Page navigation" class="pagination-nav">
                <ul class="pagination-list">
                    <li class="page-item <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= BASE_URL ?>/users?page=<?= $pagination['current_page'] - 1 ?>&search=<?= $search ?>" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    
                    <?php
                    $start = max(1, $pagination['current_page'] - 2);
                    $end = min($pagination['last_page'], $pagination['current_page'] + 2);
                    
                    if ($start > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= BASE_URL ?>/users?page=1&search=<?= $search ?>">1</a>
                        </li>
                        <?php if ($start > 2): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                            <a class="page-link" href="<?= BASE_URL ?>/users?page=<?= $i ?>&search=<?= $search ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($end < $pagination['last_page']): ?>
                        <?php if ($end < $pagination['last_page'] - 1): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= BASE_URL ?>/users?page=<?= $pagination['last_page'] ?>&search=<?= $search ?>">
                                <?= $pagination['last_page'] ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="page-item <?= $pagination['current_page'] >= $pagination['last_page'] ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= BASE_URL ?>/users?page=<?= $pagination['current_page'] + 1 ?>&search=<?= $search ?>" aria-label="Next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* ===== VARIABLES ===== */
:root {
    --primary: #667eea;
    --primary-dark: #5a67d8;
    --secondary: #764ba2;
    --success: #28a745;
    --success-dark: #218838;
    --danger: #dc3545;
    --danger-dark: #c82333;
    --warning: #ffc107;
    --warning-dark: #e0a800;
    --info: #17a2b8;
    --dark: #2c3e50;
    --gray: #6c757d;
    --light: #f8f9fa;
    --border: #e9ecef;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.02);
    --shadow-md: 0 5px 15px rgba(0,0,0,0.05);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.08);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
}

/* ===== HEADER PREMIUM ===== */
.page-header-wrapper {
    margin-bottom: 1.5rem;
}

.page-title {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    margin-bottom: 0.1rem;
}

.title-gradient {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.title-sub {
    color: var(--gray);
    font-size: 0.85rem;
}

.header-decoration {
    display: flex;
    gap: 0.5rem;
}

.header-decoration i {
    width: 40px;
    height: 40px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.1rem;
    animation: float 3s ease-in-out infinite;
}

.header-decoration i:nth-child(2) {
    animation-delay: 0.2s;
    background: rgba(118, 75, 162, 0.1);
    color: var(--secondary);
}

.header-decoration i:nth-child(3) {
    animation-delay: 0.4s;
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

/* ===== FILTER PREMIUM ===== */
.filter-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    padding: 1.2rem;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.filter-grid {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 1rem;
    align-items: end;
}

@media (max-width: 768px) {
    .filter-grid {
        grid-template-columns: 1fr;
    }
}

.filter-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.3rem;
    display: block;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.search-input-group {
    position: relative;
}

.search-input-group .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    z-index: 2;
    font-size: 0.9rem;
}

.search-input-group input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.6rem;
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    transition: all 0.2s;
    background: var(--light);
}

.search-input-group input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
    background: white;
}

.clear-search {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.clear-search:hover {
    background: var(--light);
    color: var(--danger);
}

.action-btn-group {
    display: flex;
    gap: 0.5rem;
}

.btn-filter {
    padding: 0.7rem 1.5rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 100px;
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.btn-reset {
    padding: 0.7rem 1.5rem;
    background: transparent;
    color: var(--gray);
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    min-width: 100px;
}

.btn-reset:hover {
    background: var(--light);
    color: var(--danger);
    border-color: var(--danger);
    transform: translateY(-2px);
}

/* ===== STATS CARDS ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 0.8rem;
    }
}

@media (min-width: 769px) and (max-width: 992px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.stat-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 1.2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.stat-card.stat-primary {
    border-left: 4px solid var(--primary);
}

.stat-card.stat-success {
    border-left: 4px solid var(--success);
}

.stat-card.stat-info {
    border-left: 4px solid var(--info);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-primary .stat-icon {
    background: rgba(102, 126, 234, 0.1);
    color: var(--primary);
}

.stat-success .stat-icon {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
}

.stat-info .stat-icon {
    background: rgba(23, 162, 184, 0.1);
    color: var(--info);
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: var(--gray);
    letter-spacing: 0.5px;
    margin-bottom: 0.2rem;
}

.stat-value {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
    margin-bottom: 0.1rem;
}

.stat-period {
    font-size: 0.65rem;
    color: var(--gray);
}

/* ===== TABLE PREMIUM ===== */
.table-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    margin-top: 1.5rem;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(to right, white, var(--light));
}

.table-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    color: var(--dark);
}

.btn-add {
    position: relative;
    display: inline-flex;
    align-items: center;
    padding: 0.6rem 1.2rem;
    background: linear-gradient(135deg, var(--success) 0%, #34ce57 100%);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    overflow: hidden;
    z-index: 1;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
    transition: all 0.3s;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
}

.btn-add .btn-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
    z-index: -1;
}

.btn-add:hover .btn-glow {
    left: 100%;
}

/* Table Premium Styles */
.premium-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.premium-table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f4f9 100%);
    padding: 1rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--dark);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--primary);
    white-space: nowrap;
}

.premium-table tbody tr {
    transition: all 0.2s;
    border-bottom: 1px solid var(--border);
}

.premium-table tbody tr:hover {
    background: rgba(102, 126, 234, 0.02);
}

.premium-table tbody td {
    padding: 1rem 0.75rem;
    font-size: 0.9rem;
    color: var(--dark);
    border-bottom: 1px solid var(--border);
}

/* User Info */
.user-info .user-name {
    font-weight: 600;
    color: var(--dark);
}

.user-fullname {
    color: var(--dark);
}

.user-email {
    color: var(--gray);
}

.mobile-meta {
    margin-top: 0.3rem;
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.meta-item {
    font-size: 0.7rem;
    color: var(--gray);
    display: inline-flex;
    align-items: center;
}

.meta-item i {
    font-size: 0.6rem;
    color: var(--primary);
}

/* Role Badge */
.role-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
}

.role-admin {
    background: linear-gradient(135deg, #dc3545, #ff4d5e);
    color: white;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
}

.role-bendahara {
    background: linear-gradient(135deg, #ffc107, #ffdb6d);
    color: #2c3e50;
    box-shadow: 0 2px 8px rgba(255, 193, 7, 0.2);
}

.role-pembina {
    background: linear-gradient(135deg, #17a2b8, #54d1ed);
    color: white;
    box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2);
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-active {
    background: linear-gradient(135deg, #28a745, #34ce57);
    color: white;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
}

.status-inactive {
    background: linear-gradient(135deg, #6c757d, #868e96);
    color: white;
    box-shadow: 0 2px 8px rgba(108, 117, 125, 0.2);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.3rem;
    justify-content: center;
}

.btn-action {
    position: relative;
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: var(--radius-sm);
    color: white;
    cursor: pointer;
    overflow: hidden;
    z-index: 1;
    transition: all 0.2s;
}

.btn-action i {
    font-size: 1rem;
    z-index: 2;
}

.btn-action .btn-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
    z-index: 0;
}

.btn-action:hover .btn-glow {
    left: 100%;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.btn-edit {
    background: linear-gradient(135deg, #ffc107, #ffdb6d);
}

.btn-active {
    background: linear-gradient(135deg, #28a745, #34ce57);
}

.btn-inactive {
    background: linear-gradient(135deg, #6c757d, #868e96);
}

.btn-delete {
    background: linear-gradient(135deg, #dc3545, #ff4d5e);
}

/* Login Info */
.login-info {
    font-size: 0.8rem;
    color: var(--gray);
}

.login-info i {
    font-size: 0.7rem;
}

/* ===== PAGINATION PREMIUM ===== */
.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
    background: var(--light);
}

@media (max-width: 768px) {
    .pagination-wrapper {
        flex-direction: column;
        gap: 1rem;
    }
}

.info-badge {
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 30px;
    font-size: 0.8rem;
    color: var(--dark);
    box-shadow: var(--shadow-sm);
}

.pagination-list {
    display: flex;
    gap: 0.3rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.page-item {
    margin: 0;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: white;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    color: var(--dark);
    text-decoration: none;
    font-size: 0.85rem;
    transition: all 0.2s;
}

.page-link:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-color: transparent;
    color: white;
    font-weight: 600;
}

.page-item.disabled .page-link {
    background: var(--light);
    color: var(--gray);
    cursor: not-allowed;
    pointer-events: none;
    border-color: var(--border);
}

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-icon i {
    font-size: 2.5rem;
    color: var(--primary);
}

.empty-state h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--gray);
    font-size: 0.9rem;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .premium-table thead {
        display: none;
    }
    
    .premium-table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 1rem;
        background: white;
    }
    
    .premium-table tbody td {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        border: none;
        border-bottom: 1px dashed var(--border);
    }
    
    .premium-table tbody td:last-child {
        border-bottom: none;
    }
    
    .premium-table tbody td:before {
        content: attr(data-label);
        width: 40%;
        font-weight: 600;
        color: var(--gray);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .action-buttons {
        justify-content: flex-start;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
    }
    
    .btn-action i {
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .premium-table tbody td:before {
        width: 45%;
    }
    
    .page-link {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
    
    .info-badge {
        font-size: 0.7rem;
        padding: 0.4rem 0.8rem;
    }
    
    .role-badge, .status-badge {
        padding: 0.3rem 0.6rem;
        font-size: 0.7rem;
    }
    
    .btn-action {
        width: 28px;
        height: 28px;
    }
    
    .btn-action i {
        font-size: 0.75rem;
    }
}

/* ===== ANIMATIONS ===== */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.data-row {
    animation: fadeIn 0.3s ease-out forwards;
}
</style>

<script>
$(document).ready(function() {
    // Clear search
    $('#clearSearch').on('click', function() {
        $('#searchInput').val('');
        $('#searchForm').submit();
    });
    
    // Debounce search
    let searchTimer;
    $('#searchInput').on('keyup', function(e) {
        if (e.key === 'Enter') {
            $('#searchForm').submit();
            return;
        }
        
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            $('#searchForm').submit();
        }, 500);
    });
    
    // Initialize DataTable if needed
    if ($.fn.DataTable && $('#userTable').length && $('#userTable thead').is(':visible')) {
        $('#userTable').DataTable({
            paging: false,
            searching: false,
            info: false,
            responsive: false,
            columnDefs: [
                { targets: [3], visible: window.innerWidth >= 992 }, // Email
                { targets: [6], visible: window.innerWidth >= 768 }  // Last Login
            ]
        });
    }
});

function toggleStatus(id, username, currentStatus) {
    let action = currentStatus ? 'menonaktifkan' : 'mengaktifkan';
    Swal.fire({
        title: 'Konfirmasi',
        text: `Yakin ingin ${action} user ${username}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: currentStatus ? '#dc3545' : '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, ' + (currentStatus ? 'Nonaktifkan' : 'Aktifkan'),
        cancelButtonText: 'Batal',
        background: 'white',
        customClass: {
            confirmButton: 'swal2-confirm-btn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= BASE_URL ?>/users/toggle-status/' + id,
                type: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Loading...',
                        text: 'Sedang memproses',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.error || response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan'
                    });
                }
            });
        }
    });
}

function deleteUser(id, username) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Yakin ingin menghapus user ${username}? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        background: 'white',
        customClass: {
            confirmButton: 'swal2-confirm-btn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= BASE_URL ?>/users/delete/' + id,
                type: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    Swal.fire({
                        title: 'Loading...',
                        text: 'Sedang memproses',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.error || response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan'
                    });
                }
            });
        }
    });
}
</script>