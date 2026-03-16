<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Header Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Tambah User</span>
                </h1>
                <p class="title-sub mb-0">Buat user baru untuk mengakses sistem</p>
            </div>
            <div class="header-decoration">
                <i class="fas fa-user-plus"></i>
                <i class="fas fa-user-cog"></i>
                <i class="fas fa-user-shield"></i>
            </div>
        </div>
    </div>
    
    <!-- Back Button Premium -->
    <div class="back-button-wrapper mb-3">
        <a href="<?= BASE_URL ?>/users" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>
            <span>Kembali ke Manajemen User</span>
            <div class="btn-glow"></div>
        </a>
    </div>
    
    <!-- Form Card Premium -->
    <div class="form-card">
        <div class="form-card-header">
            <div class="d-flex align-items-center">
                <div class="header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="ms-3">
                    <h5 class="card-title mb-1">Tambah User Baru</h5>
                    <p class="card-subtitle">Isi form berikut untuk menambahkan user</p>
                </div>
            </div>
        </div>
        
        <div class="form-card-body">
            <form action="<?= BASE_URL ?>/users/store" method="POST" id="formUser">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <!-- Card untuk Informasi Pribadi -->
                        <div class="form-section-card">
                            <div class="section-header">
                                <i class="fas fa-id-card"></i>
                                <h6>Informasi Pribadi</h6>
                            </div>
                            
                            <!-- Username -->
                            <div class="mb-4">
                                <label for="username" class="form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <div class="premium-input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-user-circle"></i>
                                    </span>
                                    <input type="text" class="premium-input" id="username" 
                                           name="username" placeholder="Masukkan username" 
                                           value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" 
                                           required autofocus>
                                    <div class="input-border"></div>
                                </div>
                                <small class="input-hint">
                                    <i class="fas fa-info-circle me-1"></i>Minimal 3 karakter, unik
                                </small>
                            </div>
                            
                            <!-- Nama Lengkap -->
                            <div class="mb-4">
                                <label for="nama_lengkap" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <div class="premium-input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="premium-input" id="nama_lengkap" 
                                           name="nama_lengkap" placeholder="Masukkan nama lengkap"
                                           value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : '' ?>" 
                                           required>
                                    <div class="input-border"></div>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="premium-input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="premium-input" id="email" 
                                           name="email" placeholder="Masukkan email (opsional)"
                                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                                    <div class="input-border"></div>
                                </div>
                                <small class="input-hint">
                                    <i class="fas fa-info-circle me-1"></i>Email valid untuk notifikasi
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-lg-6">
                        <!-- Card untuk Keamanan & Hak Akses -->
                        <div class="form-section-card">
                            <div class="section-header">
                                <i class="fas fa-shield-alt"></i>
                                <h6>Keamanan & Hak Akses</h6>
                            </div>
                            
                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <div class="premium-input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="premium-input" id="password" 
                                           name="password" placeholder="Masukkan password" required>
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                    <div class="input-border"></div>
                                </div>
                                <div class="password-strength mt-2" id="passwordStrength">
                                    <div class="strength-bar"></div>
                                    <div class="strength-bar"></div>
                                    <div class="strength-bar"></div>
                                    <div class="strength-bar"></div>
                                    <div class="strength-bar"></div>
                                </div>
                                <small class="input-hint">
                                    <i class="fas fa-info-circle me-1"></i>Minimal 6 karakter, kombinasi huruf dan angka
                                </small>
                            </div>
                            
                            <!-- Role -->
                            <div class="mb-4">
                                <label for="role" class="form-label">
                                    Role <span class="text-danger">*</span>
                                </label>
                                <div class="premium-select-group">
                                    <span class="select-icon">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <select class="premium-select" id="role" name="role" required>
                                        <option value="" disabled <?= !isset($_POST['role']) ? 'selected' : '' ?>>Pilih Role</option>
                                        <option value="admin" <?= (isset($_POST['role']) && $_POST['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                                        <option value="bendahara" <?= (isset($_POST['role']) && $_POST['role'] == 'bendahara') ? 'selected' : '' ?>>Bendahara</option>
                                        <option value="pembina" <?= (isset($_POST['role']) && $_POST['role'] == 'pembina') ? 'selected' : '' ?>>Pembina</option>
                                    </select>
                                    <div class="select-border"></div>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                                <div class="role-description mt-2" id="roleDescription">
                                    <span class="role-desc-text">
                                        <i class="fas fa-info-circle me-1"></i>Pilih role untuk menentukan hak akses user
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="mb-4">
                                <label for="is_active" class="form-label">Status Akun</label>
                                <div class="status-toggle-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               id="is_active" name="is_active" value="1" 
                                               <?= (!isset($_POST['is_active']) || $_POST['is_active'] == '1') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_active">
                                            <span class="status-indicator active">
                                                <i class="fas fa-check-circle me-1"></i>Aktif
                                            </span>
                                        </label>
                                    </div>
                                    <small class="input-hint">
                                        <i class="fas fa-info-circle me-1"></i>
                                        User dapat langsung login jika status Aktif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Alert Success (Jika ada) -->
                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert-premium alert-success-premium mt-4">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <?= $_SESSION['success'] ?>
                    </div>
                    <div class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <!-- Alert Error (Jika ada) -->
                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert-premium alert-danger-premium mt-4">
                    <div class="alert-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="alert-content">
                        <?= $_SESSION['error'] ?>
                    </div>
                    <div class="alert-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <!-- Form Actions Premium -->
                <div class="form-actions">
                    <button type="reset" class="btn-outline-premium btn-reset">
                        <i class="fas fa-undo me-2"></i>
                        Reset
                        <div class="btn-glow"></div>
                    </button>
                    <button type="submit" class="btn-premium btn-primary-premium">
                        <i class="fas fa-save me-2"></i>
                        Simpan User
                        <div class="btn-glow"></div>
                    </button>
                </div>
            </form>
        </div>
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
    --border: #e2e8f0;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.02);
    --shadow-md: 0 5px 15px rgba(0,0,0,0.05);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.08);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
}

/* ===== HEADER PREMIUM ===== */
.page-header-wrapper {
    margin-bottom: 1rem;
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

/* ===== BACK BUTTON PREMIUM ===== */
.back-button-wrapper {
    margin-bottom: 1.5rem;
}

.btn-back {
    position: relative;
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.5rem;
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    overflow: hidden;
    z-index: 1;
    transition: all 0.3s;
}

.btn-back:hover {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    border-color: transparent;
}

.btn-back .btn-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
    z-index: -1;
}

.btn-back:hover .btn-glow {
    left: 100%;
}

/* ===== FORM CARD PREMIUM ===== */
.form-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.form-card-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
    border-bottom: 1px solid var(--border);
}

.header-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-icon i {
    font-size: 1.5rem;
    color: white;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
}

.card-subtitle {
    font-size: 0.85rem;
    color: var(--gray);
    margin: 0;
}

.form-card-body {
    padding: 2rem;
}

@media (max-width: 768px) {
    .form-card-body {
        padding: 1.5rem;
    }
}

@media (max-width: 576px) {
    .form-card-body {
        padding: 1rem;
    }
}

/* ===== FORM SECTION CARDS ===== */
.form-section-card {
    background: var(--light);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    height: 100%;
    border: 1px solid var(--border);
    transition: all 0.3s;
}

.form-section-card:hover {
    box-shadow: var(--shadow-md);
    border-color: rgba(102, 126, 234, 0.3);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid transparent;
    border-image: linear-gradient(to right, var(--primary), var(--secondary));
    border-image-slice: 1;
}

.section-header i {
    font-size: 1.2rem;
    color: var(--primary);
}

.section-header h6 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin: 0;
}

/* ===== PREMIUM INPUTS ===== */
.form-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    letter-spacing: 0.3px;
}

.premium-input-group,
.premium-select-group {
    position: relative;
    width: 100%;
}

.input-icon,
.select-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    z-index: 2;
    font-size: 1rem;
    transition: all 0.3s;
}

.premium-input,
.premium-select {
    width: 100%;
    padding: 0.8rem 1rem 0.8rem 2.8rem;
    font-size: 0.95rem;
    color: var(--dark);
    background: white;
    border: 2px solid var(--border);
    border-radius: var(--radius-md);
    transition: all 0.3s;
    position: relative;
    z-index: 1;
}

.premium-select {
    appearance: none;
    cursor: pointer;
    padding-right: 3rem;
}

.select-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    pointer-events: none;
    z-index: 2;
    font-size: 0.8rem;
}

.input-border,
.select-border {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(to right, var(--primary), var(--secondary));
    transition: all 0.3s;
    border-radius: 2px;
    z-index: 3;
}

.premium-input:focus,
.premium-select:focus {
    outline: none;
    border-color: transparent;
}

.premium-input:focus ~ .input-border,
.premium-select:focus ~ .select-border {
    width: 100%;
    left: 0;
}

.premium-input:focus ~ .input-icon,
.premium-select:focus ~ .select-icon {
    color: var(--primary);
}

/* Password Toggle */
.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    z-index: 2;
    padding: 5px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.password-toggle:hover {
    background: var(--light);
    color: var(--primary);
}

/* Input Hints */
.input-hint {
    display: block;
    font-size: 0.75rem;
    color: var(--gray);
    margin-top: 0.5rem;
}

.input-hint i {
    font-size: 0.7rem;
}

/* ===== PASSWORD STRENGTH ===== */
.password-strength {
    display: flex;
    gap: 0.3rem;
    margin-top: 0.5rem;
}

.strength-bar {
    height: 4px;
    flex: 1;
    background: var(--border);
    border-radius: 2px;
    transition: all 0.3s;
}

/* ===== ROLE DESCRIPTION ===== */
.role-description {
    font-size: 0.8rem;
}

.role-desc-text {
    display: inline-flex;
    align-items: center;
    padding: 0.3rem 0.8rem;
    background: white;
    border-radius: 30px;
    color: var(--gray);
    border: 1px solid var(--border);
}

/* ===== STATUS TOGGLE ===== */
.status-toggle-group {
    padding: 0.5rem 0;
}

.form-switch {
    padding-left: 2.5em;
}

.form-switch .form-check-input {
    width: 2.5em;
    height: 1.25em;
    margin-left: -2.5em;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    background-color: var(--gray);
    border: none;
    transition: all 0.3s;
    cursor: pointer;
}

.form-switch .form-check-input:checked {
    background-color: var(--success);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
}

.status-indicator {
    display: inline-flex;
    align-items: center;
    padding: 0.3rem 0.8rem;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 500;
    margin-left: 0.5rem;
    transition: all 0.3s;
}

.status-indicator.active {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success);
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.status-indicator.inactive {
    background: rgba(108, 117, 125, 0.1);
    color: var(--gray);
    border: 1px solid rgba(108, 117, 125, 0.2);
}

/* ===== ALERT PREMIUM ===== */
.alert-premium {
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-radius: var(--radius-md);
    animation: slideIn 0.3s ease-out;
}

.alert-success-premium {
    background: rgba(40, 167, 69, 0.1);
    border: 1px solid rgba(40, 167, 69, 0.2);
    color: var(--success);
}

.alert-danger-premium {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.2);
    color: var(--danger);
}

.alert-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.alert-content {
    flex: 1;
    font-size: 0.9rem;
}

.alert-close {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}

.alert-close:hover {
    background: rgba(0,0,0,0.05);
}

/* ===== FORM ACTIONS ===== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

@media (max-width: 576px) {
    .form-actions {
        flex-direction: column;
    }
}

.btn-outline-premium,
.btn-premium {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.8rem 2rem;
    border: none;
    border-radius: var(--radius-md);
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    overflow: hidden;
    z-index: 1;
    transition: all 0.3s;
    min-width: 140px;
}

.btn-outline-premium {
    background: transparent;
    color: var(--gray);
    border: 2px solid var(--border);
}

.btn-outline-premium:hover {
    border-color: var(--warning);
    color: var(--warning-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 193, 7, 0.15);
}

.btn-reset:hover {
    border-color: var(--warning);
    color: var(--warning-dark);
}

.btn-primary-premium {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-primary-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
}

.btn-premium .btn-glow,
.btn-outline-premium .btn-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
    z-index: -1;
}

.btn-premium:hover .btn-glow,
.btn-outline-premium:hover .btn-glow {
    left: 100%;
}

/* ===== ANIMATIONS ===== */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .form-section-card {
        padding: 1.2rem;
    }
    
    .section-header {
        margin-bottom: 1.2rem;
    }
    
    .premium-input,
    .premium-select {
        padding: 0.7rem 1rem 0.7rem 2.5rem;
        font-size: 0.9rem;
    }
    
    .input-icon,
    .select-icon {
        left: 0.8rem;
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .form-card-header {
        padding: 1rem;
    }
    
    .header-icon {
        width: 40px;
        height: 40px;
    }
    
    .header-icon i {
        font-size: 1.2rem;
    }
    
    .card-title {
        font-size: 1rem;
    }
    
    .card-subtitle {
        font-size: 0.75rem;
    }
    
    .form-section-card {
        padding: 1rem;
    }
    
    .section-header i {
        font-size: 1rem;
    }
    
    .section-header h6 {
        font-size: 0.9rem;
    }
    
    .form-label {
        font-size: 0.8rem;
    }
    
    .premium-input,
    .premium-select {
        padding: 0.6rem 1rem 0.6rem 2.3rem;
        font-size: 0.85rem;
    }
    
    .btn-outline-premium,
    .btn-premium {
        padding: 0.6rem 1.5rem;
        font-size: 0.85rem;
        min-width: 120px;
    }
    
    .alert-content {
        font-size: 0.8rem;
    }
    
    .status-indicator {
        font-size: 0.75rem;
        padding: 0.2rem 0.6rem;
    }
}

@media (max-width: 375px) {
    .btn-outline-premium,
    .btn-premium {
        padding: 0.5rem 1.2rem;
        font-size: 0.8rem;
        min-width: 100px;
    }
    
    .premium-input,
    .premium-select {
        padding: 0.5rem 1rem 0.5rem 2.2rem;
        font-size: 0.8rem;
    }
    
    .input-icon,
    .select-icon {
        left: 0.6rem;
        font-size: 0.8rem;
    }
}

/* Landscape Mode */
@media (max-height: 500px) and (orientation: landscape) {
    .form-card-body {
        padding: 1rem;
    }
    
    .form-section-card {
        padding: 1rem;
    }
    
    .mb-4 {
        margin-bottom: 0.8rem !important;
    }
}

/* ===== UTILITIES ===== */
.text-danger {
    color: var(--danger) !important;
}

.text-success {
    color: var(--success) !important;
}

.text-warning {
    color: var(--warning) !important;
}

.text-primary {
    color: var(--primary) !important;
}

.text-secondary {
    color: var(--secondary) !important;
}

.mt-2 {
    margin-top: 0.5rem;
}

.mt-4 {
    margin-top: 1.5rem;
}

.mb-0 {
    margin-bottom: 0;
}
</style>

<script>
$(document).ready(function() {
    // Form validation
    $('#formUser').on('submit', function(e) {
        let username = $('#username').val().trim();
        let nama = $('#nama_lengkap').val().trim();
        let password = $('#password').val();
        let role = $('#role').val();
        let errors = [];
        
        if (username.length < 3) {
            errors.push('Username minimal 3 karakter');
        }
        
        if (nama.length < 3) {
            errors.push('Nama lengkap minimal 3 karakter');
        }
        
        if (password.length < 6) {
            errors.push('Password minimal 6 karakter');
        }
        
        if (!role) {
            errors.push('Pilih role');
        }
        
        // Validasi email (opsional, format email)
        let email = $('#email').val().trim();
        if (email && !isValidEmail(email)) {
            errors.push('Format email tidak valid');
        }
        
        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: errors.map(err => `• ${err}`).join('<br>'),
                confirmButtonColor: '#dc3545',
                background: 'white',
                customClass: {
                    confirmButton: 'swal2-confirm-btn'
                }
            });
            e.preventDefault();
            return false;
        }
        
        return true;
    });
    
    // Fungsi validasi email
    function isValidEmail(email) {
        let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    // Password strength checker
    $('#password').on('input', function() {
        let password = $(this).val();
        let strength = 0;
        
        if (password.length >= 6) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;
        
        $('.strength-bar').each(function(index) {
            if (index < strength) {
                if (strength <= 2) {
                    $(this).css('background', '#dc3545');
                } else if (strength <= 3) {
                    $(this).css('background', '#ffc107');
                } else if (strength <= 4) {
                    $(this).css('background', '#17a2b8');
                } else {
                    $(this).css('background', '#28a745');
                }
            } else {
                $(this).css('background', '#e2e8f0');
            }
        });
    });
    
    // Role description update
    $('#role').on('change', function() {
        let role = $(this).val();
        let description = '';
        let color = '';
        
        switch(role) {
            case 'admin':
                description = 'Admin: Akses penuh ke semua fitur';
                color = '#dc3545';
                break;
            case 'bendahara':
                description = 'Bendahara: Manajemen keuangan dan laporan';
                color = '#ffc107';
                break;
            case 'pembina':
                description = 'Pembina: Manajemen anggota dan absensi';
                color = '#17a2b8';
                break;
            default:
                description = 'Pilih role untuk menentukan hak akses user';
                color = '#6c757d';
        }
        
        $('#roleDescription').html(`
            <span class="role-desc-text" style="color: ${color}; border-color: ${color}20; background: ${color}10;">
                <i class="fas fa-info-circle me-1"></i>${description}
            </span>
        `);
    });
    
    // Reset form
    $('button[type="reset"]').on('click', function(e) {
        e.preventDefault();
        $('#formUser')[0].reset();
        $('#roleDescription').html(`
            <span class="role-desc-text">
                <i class="fas fa-info-circle me-1"></i>Pilih role untuk menentukan hak akses user
            </span>
        `);
        $('.strength-bar').css('background', '#e2e8f0');
        $('.status-indicator').removeClass('inactive').addClass('active');
        $('.status-indicator').html('<i class="fas fa-check-circle me-1"></i>Aktif');
    });
    
    // Auto-hide alert
    setTimeout(function() {
        $('.alert-premium').fadeOut('slow');
    }, 5000);
    
    // Status toggle update
    $('#is_active').on('change', function() {
        let statusLabel = $('.status-indicator');
        if ($(this).is(':checked')) {
            statusLabel.removeClass('inactive').addClass('active');
            statusLabel.html('<i class="fas fa-check-circle me-1"></i>Aktif');
        } else {
            statusLabel.removeClass('active').addClass('inactive');
            statusLabel.html('<i class="fas fa-ban me-1"></i>Non Aktif');
        }
    });
});

function togglePassword() {
    let passwordInput = $('#password');
    let toggleIcon = $('#toggleIcon');
    
    if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
        toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        passwordInput.attr('type', 'password');
        toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
}
</script>