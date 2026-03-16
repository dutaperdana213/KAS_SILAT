<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Header Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Tambah Kas Keluar</span>
                    <span class="title-badge ms-2">Baru</span>
                </h1>
                <p class="title-sub mb-0">Tambahkan transaksi pengeluaran kas baru</p>
            </div>
            <div class="d-flex gap-2 w-100 w-md-auto">
                <a href="<?= BASE_URL ?>/kas-keluar" class="btn btn-premium btn-outline-premium flex-fill flex-md-grow-0">
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
            <form action="<?= BASE_URL ?>/kas-keluar/store" method="POST" id="formKasKeluar" class="premium-form">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="row g-4">
                    <!-- Kolom Kiri -->
                    <div class="col-12 col-md-6">
                        <div class="form-section">
                            <div class="section-header">
                                <div class="header-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <h5 class="section-title">Detail Transaksi</h5>
                            </div>
                            
                            <div class="section-body">
                                <!-- Tanggal -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Tanggal <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group premium-input">
                                        <span class="input-icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input type="date" class="form-control" id="tanggal" 
                                               name="tanggal" value="<?= date('Y-m-d') ?>" required>
                                        <div class="input-focus-bg"></div>
                                    </div>
                                </div>
                                
                                <!-- Kategori -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group premium-input">
                                        <span class="input-icon">
                                            <i class="fas fa-tag"></i>
                                        </span>
                                        <select class="form-control" id="kategori" name="kategori" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="Operasional">Operasional</option>
                                            <option value="Peralatan">Peralatan</option>
                                            <option value="Konsumsi">Konsumsi</option>
                                            <option value="Dokumentasi">Dokumentasi</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        <div class="input-focus-bg"></div>
                                    </div>
                                    <div class="select-arrow">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                                
                                <!-- Jumlah -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Jumlah (Rp) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group premium-input">
                                        <span class="input-icon">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </span>
                                        <input type="text" class="form-control currency-input" 
                                               id="jumlah" name="jumlah" placeholder="Contoh: 50000" required>
                                        <div class="input-focus-bg"></div>
                                    </div>
                                    <div class="form-hint">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Minimal Rp 1.000
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div class="col-12 col-md-6">
                        <div class="form-section">
                            <div class="section-header">
                                <div class="header-icon">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <h5 class="section-title">Detail Pengeluaran</h5>
                            </div>
                            
                            <div class="section-body">
                                <!-- Penanggung Jawab -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Penanggung Jawab <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group premium-input">
                                        <span class="input-icon">
                                            <i class="fas fa-user-circle"></i>
                                        </span>
                                        <input type="text" class="form-control" id="penanggung_jawab" 
                                               name="penanggung_jawab" placeholder="Nama yang bertanggung jawab" required>
                                        <div class="input-focus-bg"></div>
                                    </div>
                                </div>
                                
                                <!-- Keterangan -->
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        Keterangan <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group premium-input textarea">
                                        <span class="input-icon textarea-icon">
                                            <i class="fas fa-align-left"></i>
                                        </span>
                                        <textarea class="form-control" id="keterangan" 
                                                  name="keterangan" rows="5" 
                                                  placeholder="Jelaskan tujuan pengeluaran" required></textarea>
                                        <div class="input-focus-bg"></div>
                                    </div>
                                    <div class="form-hint">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Minimal 5 karakter
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Informasi Approval Premium -->
                <div class="info-approval-card mt-4">
                    <div class="info-approval-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="info-approval-content">
                        <strong>Informasi Persetujuan</strong>
                        <?php if ($this->auth->isAdmin() || $this->auth->isBendahara()): ?>
                            <span>Sebagai <span class="role-badge"><?= $this->auth->user()['role'] ?></span>, data akan langsung disetujui.</span>
                        <?php else: ?>
                            <span>Data perlu persetujuan dari Bendahara atau Admin.</span>
                        <?php endif; ?>
                    </div>
                    <div class="info-approval-glow"></div>
                </div>
                
                <!-- Form Actions Premium -->
                <div class="form-actions mt-5">
                    <div class="d-flex flex-column flex-md-row justify-content-end gap-3">
                        <button type="reset" class="btn btn-premium btn-outline-premium flex-fill flex-md-grow-0">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-premium btn-primary-gradient flex-fill flex-md-grow-0">
                            <i class="fas fa-save me-1"></i> Simpan Transaksi
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
    --info-light: rgba(23, 162, 184, 0.1);
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
    transform: translateY(-3px);
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

.premium-input.textarea .input-icon {
    top: 1.5rem;
    transform: none;
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

.premium-input textarea.form-control {
    padding-top: 1rem;
    min-height: 120px;
    resize: vertical;
}

.premium-input .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    outline: none;
}

.premium-input .form-control:focus + .input-icon {
    color: #667eea;
}

.premium-input .form-control:focus ~ .input-focus-bg {
    opacity: 0.02;
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

/* Info Approval Card */
.info-approval-card {
    position: relative;
    background: linear-gradient(135deg, rgba(23, 162, 184, 0.05), white);
    border: 1px solid rgba(23, 162, 184, 0.2);
    border-radius: 20px;
    padding: 1.2rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    overflow: hidden;
    transition: all 0.3s;
}

.info-approval-card:hover {
    background: linear-gradient(135deg, rgba(23, 162, 184, 0.08), white);
    border-color: rgba(23, 162, 184, 0.3);
}

.info-approval-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #17a2b8, #138496);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(23, 162, 184, 0.2);
    flex-shrink: 0;
}

.info-approval-icon i {
    font-size: 1.4rem;
    color: white;
}

.info-approval-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.info-approval-content strong {
    color: #17a2b8;
    font-size: 1rem;
}

.info-approval-content span {
    color: #2c3e50;
    font-size: 0.9rem;
}

.role-badge {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
    padding: 0.2rem 0.6rem;
    border-radius: 30px;
    font-weight: 600;
    display: inline-block;
}

.info-approval-glow {
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 70% 30%, rgba(23, 162, 184, 0.1), transparent 70%);
    pointer-events: none;
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
    
    .premium-input textarea.form-control {
        min-height: 100px;
    }
    
    .info-approval-card {
        padding: 1rem 1.2rem;
    }
    
    .info-approval-icon {
        width: 40px;
        height: 40px;
    }
    
    .info-approval-icon i {
        font-size: 1.2rem;
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
    
    .premium-input.textarea .input-icon {
        top: 1.2rem;
    }
    
    .premium-input textarea.form-control {
        min-height: 80px;
    }
    
    .form-label {
        font-size: 0.8rem;
    }
    
    .info-approval-card {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }
    
    .info-approval-content {
        align-items: center;
    }
    
    .info-approval-content strong {
        font-size: 0.95rem;
    }
    
    .info-approval-content span {
        font-size: 0.85rem;
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
    
    .premium-input.textarea .input-icon {
        top: 1rem;
    }
    
    .premium-input textarea.form-control {
        min-height: 70px;
    }
}

/* Landscape Mode */
@media (max-height: 500px) and (orientation: landscape) {
    .form-section {
        padding: 1rem;
    }
    
    .section-header {
        margin-bottom: 1rem;
    }
    
    .form-group {
        margin-bottom: 1rem !important;
    }
    
    .premium-input textarea.form-control {
        min-height: 60px;
    }
}
</style>

<script>
$(document).ready(function() {
    // Format currency untuk input jumlah
    $('#jumlah').on('keyup', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value) {
            $(this).val(parseInt(value).toLocaleString('id-ID'));
        }
    });
    
    // Format saat input kehilangan fokus (blur)
    $('#jumlah').on('blur', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value) {
            $(this).val(parseInt(value).toLocaleString('id-ID'));
        }
    });
    
    // Form validation dengan SweetAlert
    $('#formKasKeluar').on('submit', function(e) {
        let jumlah = $('#jumlah').val().replace(/\D/g, '');
        let errors = [];
        
        if (parseInt(jumlah) < 1000) {
            errors.push('Jumlah minimal Rp 1.000');
        }
        
        if ($('#keterangan').val().trim().length < 5) {
            errors.push('Keterangan minimal 5 karakter');
        }
        
        if (!$('#kategori').val()) {
            errors.push('Pilih kategori');
        }
        
        if (!$('#penanggung_jawab').val().trim()) {
            errors.push('Penanggung jawab harus diisi');
        }
        
        if (errors.length > 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: errors.map(err => '• ' + err).join('<br>'),
                confirmButtonColor: '#667eea'
            });
        } else {
            // Show loading
            let btn = $(this).find('button[type="submit"]');
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
            btn.prop('disabled', true);
        }
        
        return errors.length === 0;
    });
    
    // Reset button confirmation
    $('button[type="reset"]').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Reset Form?',
            text: 'Semua data yang belum disimpan akan hilang',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formKasKeluar')[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Form Direset',
                    text: 'Form telah dikembalikan ke keadaan awal',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });
    
    // Auto-hide alert setelah 3 detik
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
});
</script>