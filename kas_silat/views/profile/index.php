<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Heading dengan Tombol Kembali -->
    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-3 mb-md-4 gap-2">
        <h1 class="h4 h3-sm h2-md mb-0 text-gray-800 position-relative">
            <span class="gradient-text">Profile Saya</span>
            <span class="heading-badge"></span>
        </h1>
        <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-secondary btn-sm w-100 w-sm-auto back-btn">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
    
    <div class="row g-3 g-lg-4">
        <!-- Kolom Kiri: Profile Card -->
        <div class="col-12 col-md-5 col-lg-4">
            <!-- Profile Card -->
            <div class="card shadow-lg border-0 mb-3 profile-card hover-card">
                <div class="card-body text-center p-3 p-md-4">
                    <!-- Avatar dengan inisial dan efek glow -->
                    <div class="avatar-wrapper mx-auto mb-3">
                        <div class="avatar-circle">
                            <span class="avatar-initials">
                                <?= strtoupper(substr($user['nama_lengkap'], 0, 2)) ?>
                            </span>
                        </div>
                        <div class="avatar-glow"></div>
                    </div>
                    
                    <h4 class="mb-1 h5 h4-md fw-bold gradient-name"><?= htmlspecialchars($user['nama_lengkap']) ?></h4>
                    <p class="text-muted small mb-2 username-text">
                        <i class="fas fa-at me-1"></i><?= htmlspecialchars($user['username']) ?>
                    </p>
                    
                    <!-- Badge Role Premium -->
                    <div class="mb-2">
                        <span class="badge role-badge role-<?= $user['role'] ?>">
                            <?php if ($user['role'] == 'admin'): ?>
                                <i class="fas fa-crown me-1"></i> Administrator
                            <?php elseif ($user['role'] == 'bendahara'): ?>
                                <i class="fas fa-wallet me-1"></i> Bendahara
                            <?php else: ?>
                                <i class="fas fa-users me-1"></i> Pembina
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <!-- Info tambahan dengan desain premium -->
                    <?php if (!empty($user['email'])): ?>
                    <div class="mt-3 pt-3 border-top border-gradient">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div class="email-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span class="small fw-medium email-text">
                                <?= htmlspecialchars($user['email']) ?>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Informasi Akun Premium -->
            <div class="card shadow-lg border-0 mb-3 info-card">
                <div class="card-header bg-transparent py-2 py-md-3 border-0">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2 text-gradient"></i>
                        Informasi Akun
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="info-item d-flex align-items-center py-2">
                        <div class="info-icon-wrapper">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <span class="small text-muted">Username</span>
                        <span class="small fw-bold ms-auto username-value">@<?= htmlspecialchars($user['username']) ?></span>
                    </div>
                    
                    <?php if (!empty($user['email'])): ?>
                    <div class="info-item d-flex align-items-center py-2 mt-1">
                        <div class="info-icon-wrapper">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <span class="small text-muted">Email</span>
                        <span class="small fw-bold ms-auto email-value">
                            <?= htmlspecialchars($user['email']) ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="info-item d-flex align-items-center py-2 mt-1">
                        <div class="info-icon-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <span class="small text-muted">Bergabung</span>
                        <span class="small fw-bold ms-auto join-date">
                            <?= isset($user['created_at']) ? formatTanggal($user['created_at'], 'date') : '-' ?>
                        </span>
                    </div>
                    
                    <div class="info-item d-flex align-items-center py-2 mt-1">
                        <div class="info-icon-wrapper">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="small text-muted">Terakhir Login</span>
                        <span class="small fw-bold ms-auto last-login">
                            <?= isset($user['last_login']) ? formatTanggal($user['last_login'], 'datetime') : '-' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Edit Profile Form -->
        <div class="col-12 col-md-7 col-lg-8">
            <div class="card shadow-lg border-0 form-card">
                <div class="card-header bg-transparent py-2 py-md-3 border-0">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-user-edit me-2 text-gradient"></i>
                        Edit Profile
                        <?php if ($user['role'] != 'admin'): ?>
                        <span class="badge bg-warning text-dark ms-2 small">Hanya Nama yang Bisa Diedit</span>
                        <?php endif; ?>
                    </h6>
                </div>
                <div class="card-body p-3 p-md-4">
                    <form action="<?= BASE_URL ?>/profile/update" method="POST" id="profileForm">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        
                        <!-- Nama Lengkap (Bisa diedit semua user) -->
                        <div class="mb-4 form-group">
                            <label for="nama_lengkap" class="form-label small fw-bold">
                                Nama Lengkap <span class="text-danger">*</span>
                                <span class="label-badge">Bisa Diedit</span>
                            </label>
                            <div class="input-group premium-input">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-user text-gradient"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="nama_lengkap" 
                                       name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" 
                                       placeholder="Masukkan nama lengkap" required>
                            </div>
                            <small class="text-muted mt-1 d-block edit-hint">
                                <i class="fas fa-pencil-alt me-1"></i> Anda dapat mengubah nama lengkap Anda
                            </small>
                        </div>
                        
                        <!-- Email - Tampilan berbeda berdasarkan role -->
                        <div class="mb-4 form-group">
                            <label for="email" class="form-label small fw-bold">
                                Email
                                <?php if ($user['role'] == 'admin'): ?>
                                    <span class="label-badge bg-success">Bisa Diedit</span>
                                <?php else: ?>
                                    <span class="label-badge bg-secondary">Hanya Bisa Dilihat</span>
                                <?php endif; ?>
                            </label>
                            
                            <?php if ($user['role'] == 'admin'): ?>
                                <!-- Admin bisa edit email -->
                                <div class="input-group premium-input">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="fas fa-envelope text-gradient"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0" id="email" 
                                           name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" 
                                           placeholder="Masukkan email">
                                </div>
                            <?php else: ?>
                                <!-- User biasa hanya bisa lihat email -->
                                <div class="email-readonly-container">
                                    <div class="input-group premium-input readonly">
                                        <span class="input-group-text bg-transparent border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 readonly-field" 
                                               value="<?= htmlspecialchars($user['email'] ?? 'Belum diisi') ?>" 
                                               readonly disabled>
                                        <span class="input-group-text bg-transparent border-start-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                    </div>
                                    <!-- Hidden field untuk mengirim email yang ada (readonly) -->
                                    <input type="hidden" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-info-circle me-1"></i> Email hanya dapat diubah oleh Administrator
                                </small>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Tombol Aksi Premium -->
                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-2 action-buttons">
                            <button type="reset" class="btn btn-outline-secondary btn-sm w-100 w-sm-auto reset-btn" id="resetBtn">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm w-100 w-sm-auto submit-btn" id="submitBtn">
                                <i class="fas fa-save me-1"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Gradient Text - Fixed for compatibility */
.gradient-text {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    -moz-text-fill-color: transparent;
    color: transparent; /* Fallback */
    position: relative;
}

/* Text Gradient - Fixed */
.text-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    -moz-text-fill-color: transparent;
    color: #667eea; /* Fallback */
}

/* Gradient Name - Fixed */
.gradient-name {
    background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    -moz-text-fill-color: transparent;
    color: #2d3748; /* Fallback */
}

/* Username Value - Fixed */
.username-value, .email-value, .join-date, .last-login {
    background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
    -webkit-background-clip: text;
    -moz-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    -moz-text-fill-color: transparent;
    color: #2d3748; /* Fallback */
    font-weight: 600;
}

/* Dark mode support dengan fallback */
@media (prefers-color-scheme: dark) {
    .gradient-name {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        -webkit-background-clip: text;
        -moz-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        -moz-text-fill-color: transparent;
        color: #e2e8f0; /* Fallback */
    }
    
    .username-value, .email-value, .join-date, .last-login {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        -webkit-background-clip: text;
        -moz-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        -moz-text-fill-color: transparent;
        color: #e2e8f0; /* Fallback */
    }
}

/* Heading Badge */
.heading-badge {
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 3px;
}

/* Back Button */
.back-btn {
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.5rem 1.2rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white !important;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

/* Avatar Premium */
.avatar-wrapper {
    position: relative;
    width: fit-content;
    margin: 0 auto;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.avatar-glow {
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    opacity: 0.3;
    filter: blur(10px);
    z-index: 1;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 0.3; }
    50% { transform: scale(1.1); opacity: 0.5; }
    100% { transform: scale(1); opacity: 0.3; }
}

.avatar-circle:hover {
    transform: scale(1.05);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.avatar-initials {
    font-size: 2rem;
    color: white;
    font-weight: 700;
    text-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

/* Username Text */
.username-text {
    color: #718096 !important;
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Role Badge Premium */
.role-badge {
    font-weight: 600;
    padding: 0.5rem 1.2rem;
    font-size: 0.8rem;
    border-radius: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(5px);
    letter-spacing: 0.5px;
}

.role-admin {
    background: linear-gradient(135deg, #dc3545, #c82333) !important;
    color: white;
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
}

.role-bendahara {
    background: linear-gradient(135deg, #ffc107, #e0a800) !important;
    color: #212529;
    box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
}

.role-pembina {
    background: linear-gradient(135deg, #17a2b8, #138496) !important;
    color: white;
    box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
}

/* Email Icon */
.email-icon {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
}

.email-text {
    color: #4a5568;
    font-weight: 500;
}

/* Border Gradient */
.border-gradient {
    border-top: 1px solid transparent;
    border-image: linear-gradient(90deg, #667eea, #764ba2);
    border-image-slice: 1;
}

/* Cards Premium */
.profile-card, .info-card, .form-card {
    border-radius: 20px !important;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.95);
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2) !important;
    transition: all 0.3s ease;
}

.profile-card:hover, .info-card:hover, .form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

/* Info Items Premium */
.info-item {
    padding: 0.75rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    background: transparent;
}

.info-item:hover {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    transform: translateX(5px);
}

.info-icon-wrapper {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    color: white;
    font-size: 0.9rem;
    box-shadow: 0 5px 10px rgba(102, 126, 234, 0.2);
}

/* Form Premium */
.form-group {
    position: relative;
}

.label-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 0.65rem;
    padding: 0.2rem 0.5rem;
    border-radius: 12px;
    margin-left: 8px;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.premium-input {
    border-radius: 15px !important;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    transition: all 0.3s ease;
}

.premium-input:hover {
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
}

.premium-input .input-group-text {
    border: 2px solid #e2e8f0;
    border-right: none;
    border-radius: 15px 0 0 15px !important;
    color: #667eea;
}

.premium-input .form-control {
    border: 2px solid #e2e8f0;
    border-left: none;
    border-radius: 0 15px 15px 0 !important;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.premium-input .form-control:focus {
    border-color: #667eea;
    box-shadow: none;
}

/* Readonly Field Premium */
.premium-input.readonly {
    opacity: 0.9;
}

.premium-input.readonly .form-control.readonly-field {
    background-color: #f8fafc;
    color: #64748b;
    cursor: not-allowed;
}

.premium-input.readonly .input-group-text {
    background-color: #f8fafc;
}

/* Edit Hint */
.edit-hint {
    color: #667eea !important;
    font-size: 0.75rem;
}

/* Action Buttons Premium */
.action-buttons .btn {
    border-radius: 12px;
    padding: 0.6rem 1.5rem;
    font-weight: 500;
    letter-spacing: 0.3px;
    transition: all 0.3s ease;
}

.reset-btn {
    border: 1.5px solid #e2e8f0;
    background: transparent;
}

.reset-btn:hover {
    background: #f8fafc;
    border-color: #cbd5e0;
    transform: translateY(-2px);
}

.submit-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .profile-card, .info-card, .form-card {
        background: rgba(26, 32, 44, 0.95);
    }
    
    .gradient-name {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        -webkit-background-clip: text;
        -moz-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        -moz-text-fill-color: transparent;
        color: #e2e8f0;
    }
    
    .username-value, .email-value, .join-date, .last-login {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        -webkit-background-clip: text;
        -moz-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        -moz-text-fill-color: transparent;
        color: #e2e8f0;
    }
    
    .premium-input .input-group-text,
    .premium-input .form-control {
        background-color: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }
    
    .premium-input .input-group-text i {
        color: #a0aec0;
    }
    
    .premium-input.readonly .form-control.readonly-field {
        background-color: #1a202c;
        color: #a0aec0;
    }
    
    .premium-input.readonly .input-group-text {
        background-color: #1a202c;
    }
    
    .email-text {
        color: #a0aec0;
    }
}

/* Responsive Adjustments */
@media (max-width: 576px) {
    .avatar-circle {
        width: 70px;
        height: 70px;
    }
    
    .avatar-initials {
        font-size: 1.6rem;
    }
    
    .role-badge {
        font-size: 0.7rem;
        padding: 0.4rem 1rem;
    }
    
    .info-icon-wrapper {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
    }
    
    .info-item .small {
        font-size: 0.7rem;
    }
    
    .premium-input .form-control {
        padding: 0.6rem 0.8rem;
        font-size: 0.9rem;
    }
    
    .label-badge {
        font-size: 0.6rem;
        padding: 0.15rem 0.4rem;
    }
    
    .action-buttons .btn {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 375px) {
    .avatar-circle {
        width: 60px;
        height: 60px;
    }
    
    .avatar-initials {
        font-size: 1.4rem;
    }
    
    .gradient-name {
        font-size: 1.2rem;
    }
    
    .username-text {
        font-size: 0.7rem;
    }
    
    .info-item {
        padding: 0.5rem;
    }
    
    .info-icon-wrapper {
        width: 24px;
        height: 24px;
        font-size: 0.7rem;
        margin-right: 8px;
    }
    
    .email-text {
        font-size: 0.7rem;
    }
}

@media (max-width: 320px) {
    .avatar-circle {
        width: 50px;
        height: 50px;
    }
    
    .avatar-initials {
        font-size: 1.2rem;
    }
    
    .gradient-name {
        font-size: 1rem;
    }
    
    .role-badge {
        font-size: 0.65rem !important;
        padding: 0.3rem 0.8rem !important;
    }
    
    .info-icon-wrapper {
        width: 22px;
        height: 22px;
        font-size: 0.65rem;
    }
    
    .info-item .small {
        font-size: 0.65rem;
    }
    
    .premium-input .form-control {
        padding: 0.5rem 0.6rem;
        font-size: 0.85rem;
    }
}

/* Landscape Mode */
@media (max-height: 500px) and (orientation: landscape) {
    .row {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .avatar-circle {
        width: 50px;
        height: 50px;
    }
    
    .avatar-initials {
        font-size: 1.2rem;
    }
    
    .card-body {
        padding: 0.8rem !important;
    }
}
</style>

<script>
$(document).ready(function() {
    // Form validation hanya untuk nama
    $('#profileForm').on('submit', function(e) {
        let nama = $('#nama_lengkap').val().trim();
        let errors = [];
        
        if (nama.length < 3) {
            errors.push('Nama lengkap minimal 3 karakter');
        }
        
        <?php if ($user['role'] == 'admin'): ?>
        // Admin bisa validasi email
        let email = $('#email').val().trim();
        if (email && !isValidEmail(email)) {
            errors.push('Format email tidak valid');
        }
        <?php endif; ?>
        
        if (errors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: errors.map(err => '• ' + err).join('<br>'),
                confirmButtonColor: '#667eea',
                background: '#fff',
                backdrop: `
                    rgba(102, 126, 234, 0.1)
                    url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 24 24' fill='%23667eea' opacity='0.1'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z'/></svg>")
                    left top
                    no-repeat
                `
            });
            e.preventDefault();
            return false;
        }
        
        // Show loading premium
        $('#submitBtn').html('<i class="fas fa-spinner fa-pulse me-1"></i> Menyimpan...');
        $('#submitBtn').prop('disabled', true);
        
        return true;
    });
    
    // Reset button dengan animasi premium
    $('#resetBtn').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Reset Form?',
            text: 'Semua perubahan yang belum disimpan akan hilang.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal',
            background: '#fff',
            backdrop: `
                rgba(102, 126, 234, 0.1)
                url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 24 24' fill='%23667eea' opacity='0.1'><path d='M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z'/></svg>")
                left top
                no-repeat
            `
        }).then((result) => {
            if (result.isConfirmed) {
                $('#profileForm')[0].reset();
                
                // Animasi success
                Swal.fire({
                    icon: 'success',
                    title: 'Form Direset',
                    text: 'Form telah dikembalikan ke nilai awal.',
                    timer: 1500,
                    showConfirmButton: false,
                    background: '#fff'
                });
            }
        });
    });
    
    // Validasi email
    function isValidEmail(email) {
        let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    
    // Tooltip initialization premium
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            animation: true,
            delay: { show: 500, hide: 100 }
        });
    });
    
    // Auto-hide alert dengan fade premium
    setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 3000);
    
    // Input animation
    $('.form-control').on('focus', function() {
        $(this).closest('.premium-input').addClass('shadow-lg');
    }).on('blur', function() {
        $(this).closest('.premium-input').removeClass('shadow-lg');
    });
});
</script>