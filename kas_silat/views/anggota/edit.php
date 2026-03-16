<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Header Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Edit Anggota</span>
                    <span class="title-badge ms-2">ID: #<?= $anggota['id'] ?></span>
                </h1>
                <p class="title-sub mb-0">Ubah data anggota ekstrakurikuler silat</p>
            </div>
            <div class="d-flex gap-2 w-100 w-md-auto">
                <a href="<?= BASE_URL ?>/anggota" class="btn btn-premium btn-outline-premium flex-fill flex-md-grow-0">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    
    <!-- Form Card Premium -->
    <div class="form-card premium-card">
        <div class="card-glow"></div>
        <div class="card-pattern"></div>
        
        <div class="card-body p-3 p-md-5">
            <form action="<?= BASE_URL ?>/anggota/update/<?= $anggota['id'] ?>" method="POST" id="formAnggota" class="premium-form">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="row g-4">
                    <!-- Data Pribadi Section -->
                    <div class="col-12 col-md-6">
                        <div class="form-section">
                            <div class="section-header">
                                <div class="header-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h5 class="section-title">Data Pribadi</h5>
                            </div>
                            
                            <div class="section-body">
                                <!-- Nama Lengkap -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group premium-input">
                                        <span class="input-icon">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="nama" 
                                               name="nama" value="<?= $anggota['nama'] ?>" 
                                               placeholder="Masukkan nama lengkap" required>
                                        <div class="input-focus-bg"></div>
                                    </div>
                                    <div class="form-hint">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Minimal 3 karakter
                                    </div>
                                </div>
                                
                                <!-- Kelas -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Kelas <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group premium-input">
                                        <span class="input-icon">
                                            <i class="fas fa-graduation-cap"></i>
                                        </span>
                                        <select class="form-control" id="kelas" name="kelas" required>
                                            <option value="">Pilih Kelas</option>
                                            <option value="7" <?= $anggota['kelas'] == '7' ? 'selected' : '' ?>>Kelas 7</option>
                                            <option value="8" <?= $anggota['kelas'] == '8' ? 'selected' : '' ?>>Kelas 8</option>
                                            <option value="9" <?= $anggota['kelas'] == '9' ? 'selected' : '' ?>>Kelas 9</option>
                                        </select>
                                        <div class="input-focus-bg"></div>
                                    </div>
                                    <div class="select-arrow">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                
                                <!-- Jenis Kelamin -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Jenis Kelamin <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group premium-input">
                                        <span class="input-icon">
                                            <i class="fas fa-venus-mars"></i>
                                        </span>
                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" <?= $anggota['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                            <option value="P" <?= $anggota['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                        </select>
                                        <div class="input-focus-bg"></div>
                                    </div>
                                    <div class="select-arrow">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kontak & Keanggotaan Section -->
                    <div class="col-12 col-md-6">
                        <div class="form-section">
                            <div class="section-header">
                                <div class="header-icon">
                                    <i class="fas fa-address-card"></i>
                                </div>
                                <h5 class="section-title">Kontak & Keanggotaan</h5>
                            </div>
                            
                            <div class="section-body">
                                <!-- No. HP -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        No. HP
                                    </label>
                                    <div class="input-group premium-input">
                                        <span class="input-icon">
                                            <i class="fas fa-phone-alt"></i>
                                        </span>
                                        <input type="text" class="form-control" id="no_hp" 
                                               name="no_hp" value="<?= $anggota['no_hp'] ?>" 
                                               placeholder="081234567890">
                                        <div class="input-focus-bg"></div>
                                    </div>
                                    <div class="form-hint">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Hanya angka
                                    </div>
                                </div>
                                
                                <!-- Status -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Status
                                    </label>
                                    <div class="status-toggle-wrapper">
                                        <div class="status-toggle">
                                            <input type="checkbox" id="status_aktif" name="status_aktif" value="1" 
                                                   <?= $anggota['status_aktif'] ? 'checked' : '' ?> class="status-checkbox">
                                            <label for="status_aktif" class="status-label">
                                                <span class="status-on">Aktif</span>
                                                <span class="status-off">Non Aktif</span>
                                                <span class="status-handle"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="tanggal_gabung" value="<?= $anggota['tanggal_gabung'] ?>">
                                
                                <!-- BAGIAN TANGGAL BERGABUNG TELAH DIHAPUS -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions mt-5">
                    <div class="d-flex flex-column flex-md-row justify-content-end gap-3">
                        <a href="<?= BASE_URL ?>/anggota" class="btn btn-premium btn-outline-premium flex-fill flex-md-grow-0">
                            <i class="fas fa-times me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-premium btn-primary-gradient flex-fill flex-md-grow-0">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                            <div class="btn-glow"></div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Premium Variables */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-light: rgba(102, 126, 234, 0.1);
    --primary-soft: rgba(102, 126, 234, 0.05);
    --success-light: rgba(40, 167, 69, 0.1);
    --danger-light: rgba(220, 53, 69, 0.1);
}

/* Page Header Premium */
.page-header-wrapper {
    margin-bottom: 2rem;
}

.page-title {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.title-gradient {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.title-badge {
    background: var(--primary-light);
    color: #667eea;
    padding: 0.25rem 0.75rem;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 500;
}

.title-sub {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Premium Button */
.btn-premium {
    position: relative;
    overflow: hidden;
    border: none;
    padding: 0.7rem 1.8rem;
    font-weight: 600;
    border-radius: 14px;
    transition: all 0.3s;
    z-index: 1;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    letter-spacing: 0.3px;
}

.btn-premium::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
    z-index: -1;
}

.btn-premium:hover::before {
    left: 100%;
}

.btn-outline-premium {
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
}

.btn-outline-premium:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.btn-primary-gradient {
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-glow {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.2), transparent 70%);
    opacity: 0;
    transition: opacity 0.3s;
    z-index: -1;
}

.btn-premium:hover .btn-glow {
    opacity: 1;
}

/* Premium Card */
.premium-card {
    background: white;
    border: none;
    border-radius: 30px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.02);
    position: relative;
    overflow: hidden;
    transition: all 0.3s;
}

.premium-card:hover {
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.05);
}

.card-glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 30% 30%, rgba(102, 126, 234, 0.03), transparent 70%);
    z-index: 0;
    pointer-events: none;
}

.card-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: radial-gradient(circle at 30% 50%, rgba(102, 126, 234, 0.02) 1px, transparent 1px);
    background-size: 30px 30px;
    z-index: 0;
    pointer-events: none;
}

.card-body {
    position: relative;
    z-index: 1;
}

/* Form Sections */
.form-section {
    background: #fafbfc;
    border-radius: 24px;
    padding: 1.5rem;
    height: 100%;
    transition: all 0.3s;
    border: 1px solid rgba(102, 126, 234, 0.05);
}

.form-section:hover {
    background: white;
    border-color: rgba(102, 126, 234, 0.1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(102, 126, 234, 0.1);
}

.header-icon {
    width: 48px;
    height: 48px;
    background: var(--primary-gradient);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
}

.header-icon i {
    font-size: 1.4rem;
    color: white;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

/* Premium Input */
.premium-input {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1rem;
    z-index: 10;
    transition: all 0.3s;
}

.premium-input .form-control {
    width: 100%;
    padding: 0.9rem 1rem 0.9rem 2.8rem;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    font-size: 0.95rem;
    transition: all 0.3s;
    background: white;
    position: relative;
    z-index: 1;
}

.premium-input .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    outline: none;
}

.premium-input .form-control:focus + .input-icon {
    color: #667eea;
}

.premium-input select.form-control {
    appearance: none;
    padding-right: 2.5rem;
}

.select-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
    z-index: 10;
    transition: all 0.3s;
}

.premium-input select.form-control:focus ~ .select-arrow {
    color: #667eea;
    transform: translateY(-50%) rotate(180deg);
}

.input-focus-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--primary-gradient);
    border-radius: 16px;
    opacity: 0;
    transition: opacity 0.3s;
    z-index: 0;
}

.premium-input .form-control:focus ~ .input-focus-bg {
    opacity: 0.02;
}

.form-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    display: block;
}

.form-hint {
    font-size: 0.7rem;
    color: #94a3b8;
    margin-top: 0.3rem;
    display: flex;
    align-items: center;
}

.form-hint i {
    font-size: 0.7rem;
}

/* Status Toggle Premium */
.status-toggle-wrapper {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 16px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s;
}

.status-toggle-wrapper:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.status-toggle {
    position: relative;
    display: inline-block;
    width: 100%;
}

.status-checkbox {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.status-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem;
    background: white;
    border-radius: 40px;
    cursor: pointer;
    transition: all 0.3s;
    border: 2px solid #e2e8f0;
}

.status-on, .status-off {
    flex: 1;
    text-align: center;
    font-size: 0.9rem;
    font-weight: 600;
    padding: 0.5rem;
    border-radius: 30px;
    transition: all 0.3s;
    z-index: 2;
}

.status-on {
    color: #28a745;
    background: var(--success-light);
}

.status-off {
    color: #dc3545;
    background: var(--danger-light);
}

.status-checkbox:checked + .status-label .status-on {
    background: #28a745;
    color: white;
    box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
}

.status-checkbox:not(:checked) + .status-label .status-off {
    background: #dc3545;
    color: white;
    box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
}

.status-handle {
    position: absolute;
    width: 2px;
    height: 30px;
    background: #e2e8f0;
    left: 50%;
    transform: translateX(-50%);
    transition: all 0.3s;
}

/* Form Actions */
.form-actions {
    border-top: 2px solid rgba(102, 126, 234, 0.1);
    padding-top: 2rem;
}

/* Responsive Breakpoints */
@media (max-width: 768px) {
    .form-section {
        padding: 1.2rem;
    }
    
    .section-header {
        margin-bottom: 1.5rem;
    }
    
    .header-icon {
        width: 40px;
        height: 40px;
    }
    
    .header-icon i {
        font-size: 1.2rem;
    }
    
    .section-title {
        font-size: 1.1rem;
    }
    
    .premium-input .form-control {
        padding: 0.8rem 1rem 0.8rem 2.6rem;
    }
}

@media (max-width: 576px) {
    .form-section {
        padding: 1rem;
    }
    
    .section-header {
        gap: 0.8rem;
    }
    
    .header-icon {
        width: 36px;
        height: 36px;
    }
    
    .header-icon i {
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 1rem;
    }
    
    .premium-input .form-control {
        padding: 0.7rem 1rem 0.7rem 2.4rem;
        font-size: 0.9rem;
    }
    
    .input-icon {
        font-size: 0.9rem;
        left: 0.8rem;
    }
    
    .form-label {
        font-size: 0.8rem;
    }
    
    .status-label {
        padding: 0.3rem;
    }
    
    .status-on, .status-off {
        font-size: 0.8rem;
        padding: 0.4rem;
    }
}

@media (max-width: 375px) {
    .btn-premium {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
    }
    
    .premium-input .form-control {
        padding: 0.6rem 1rem 0.6rem 2.2rem;
    }
    
    .input-icon {
        left: 0.7rem;
        font-size: 0.8rem;
    }
}
</style>

<script>
$(document).ready(function() {
    // Format No. HP (hanya angka)
    $('#no_hp').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 13) {
            this.value = this.value.slice(0, 13);
        }
    });
    
    // Form validation dengan SweetAlert
    $('#formAnggota').on('submit', function(e) {
        let valid = true;
        let errorMsg = [];
        
        if ($('#nama').val().trim().length < 3) {
            errorMsg.push('Nama minimal 3 karakter');
            valid = false;
        }
        
        if (!$('#kelas').val()) {
            errorMsg.push('Pilih kelas');
            valid = false;
        }
        
        if (!$('#jenis_kelamin').val()) {
            errorMsg.push('Pilih jenis kelamin');
            valid = false;
        }
        
        if (!valid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: errorMsg.map(err => '• ' + err).join('<br>'),
                confirmButtonColor: '#667eea'
            });
        } else {
            // Show loading
            let btn = $(this).find('button[type="submit"]');
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            btn.prop('disabled', true);
        }
        
        return valid;
    });
    
    // Auto format input
    $('#nama').on('input', function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });
});
</script>