<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Header Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Detail Kas Keluar</span>
                    <span class="title-badge ms-2">#<?= $kas_keluar['id'] ?></span>
                </h1>
                <p class="title-sub mb-0">Informasi lengkap transaksi pengeluaran kas</p>
            </div>
            <div class="d-flex flex-wrap gap-2 w-100 w-md-auto">
                <a href="<?= BASE_URL ?>/kas-keluar" class="btn btn-premium btn-outline-premium flex-fill flex-md-grow-0">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA]) && (!$kas_keluar['approved_by'] || $this->auth->isAdmin())): ?>
                <a href="<?= BASE_URL ?>/kas-keluar/edit/<?= $kas_keluar['id'] ?>" class="btn btn-premium btn-warning-gradient flex-fill flex-md-grow-0">
                    <i class="fas fa-edit me-1"></i> Edit
                    <div class="btn-glow"></div>
                </a>
                <?php endif; ?>
                
                <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA]) && !$kas_keluar['approved_by'] && $kas_keluar['created_by'] != $this->auth->user()['id']): ?>
                <button onclick="approveKasKeluar(<?= $kas_keluar['id'] ?>)" class="btn btn-premium btn-success-gradient flex-fill flex-md-grow-0">
                    <i class="fas fa-check me-1"></i> Setujui
                    <div class="btn-glow"></div>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Flash Message Premium -->
    <?php if ($flash = $this->getFlash()): ?>
        <div class="alert-premium alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> mb-4">
            <div class="alert-icon">
                <i class="fas fa-<?= $flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle' ?>"></i>
            </div>
            <div class="alert-content">
                <?= $flash['message'] ?>
            </div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>
    
    <div class="row g-4">
        <!-- Informasi Transaksi Premium -->
        <div class="col-12 col-md-6">
            <div class="card premium-card h-100">
                <div class="card-glow"></div>
                <div class="card-pattern"></div>
                
                <div class="card-header-premium">
                    <div class="header-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="header-title">
                        <h5 class="mb-0">Informasi Transaksi</h5>
                        <p class="mb-0 text-muted small">Detail pengeluaran kas</p>
                    </div>
                </div>
                
                <div class="card-body p-3 p-md-4">
                    <div class="info-list-premium">
                        <!-- Tanggal -->
                        <div class="info-item-premium">
                            <div class="info-icon-wrapper bg-primary-soft">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Tanggal Transaksi</span>
                                <span class="info-value"><?= formatTanggal($kas_keluar['tanggal'], 'full') ?></span>
                            </div>
                            <div class="info-glow"></div>
                        </div>
                        
                        <!-- Jumlah -->
                        <div class="info-item-premium">
                            <div class="info-icon-wrapper bg-danger-soft">
                                <i class="fas fa-money-bill-wave text-danger"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Jumlah</span>
                                <span class="info-value amount-out"><?= formatRupiah($kas_keluar['jumlah']) ?></span>
                            </div>
                            <div class="info-glow"></div>
                        </div>
                        
                        <!-- Kategori -->
                        <div class="info-item-premium">
                            <div class="info-icon-wrapper bg-info-soft">
                                <i class="fas fa-tag text-info"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Kategori</span>
                                <div class="mt-1">
                                    <span class="badge kategori-badge kategori-<?= strtolower($kas_keluar['kategori']) ?>">
                                        <?= $kas_keluar['kategori'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="info-glow"></div>
                        </div>
                        
                        <!-- Penanggung Jawab -->
                        <div class="info-item-premium">
                            <div class="info-icon-wrapper bg-secondary-soft">
                                <i class="fas fa-user-circle text-secondary"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Penanggung Jawab</span>
                                <span class="info-value"><?= $kas_keluar['penanggung_jawab'] ?></span>
                            </div>
                            <div class="info-glow"></div>
                        </div>
                        
                        <!-- Keterangan -->
                        <div class="info-item-premium">
                            <div class="info-icon-wrapper bg-secondary-soft">
                                <i class="fas fa-align-left text-secondary"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Keterangan</span>
                                <span class="info-value keterangan-text"><?= nl2br($kas_keluar['keterangan']) ?></span>
                            </div>
                            <div class="info-glow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Status Persetujuan Premium -->
        <div class="col-12 col-md-6">
            <div class="card premium-card h-100">
                <div class="card-glow"></div>
                <div class="card-pattern"></div>
                
                <div class="card-header-premium">
                    <div class="header-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="header-title">
                        <h5 class="mb-0">Status Persetujuan</h5>
                        <p class="mb-0 text-muted small">Informasi approval transaksi</p>
                    </div>
                </div>
                
                <div class="card-body p-3 p-md-4 d-flex align-items-center">
                    <?php if ($kas_keluar['approved_by']): ?>
                        <div class="status-card approved">
                            <div class="status-icon-wrapper approved">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="status-content">
                                <div class="status-badge approved">DISETUJUI</div>
                                <div class="status-detail">
                                    <div class="approver-info">
                                        <i class="fas fa-user-check me-1"></i>
                                        <span>Oleh: <strong><?= $kas_keluar['approved_by_name'] ?? 'Bendahara' ?></strong></span>
                                    </div>
                                    <div class="approver-time">
                                        <i class="fas fa-clock me-1"></i>
                                        <?= isset($kas_keluar['updated_at']) ? formatTanggal($kas_keluar['updated_at'], 'datetime') : '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="status-glow"></div>
                        </div>
                    <?php else: ?>
                        <div class="status-card pending">
                            <div class="status-icon-wrapper pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="status-content">
                                <div class="status-badge pending">MENUNGGU PERSETUJUAN</div>
                                <div class="status-detail">
                                    <p class="mb-0">Menunggu persetujuan dari</p>
                                    <p class="mb-0">Bendahara atau Admin</p>
                                </div>
                            </div>
                            <div class="status-glow"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bukti Pengeluaran Premium -->
    <?php if (!empty($kas_keluar['bukti_pengeluaran'])): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card premium-card">
                <div class="card-glow"></div>
                <div class="card-pattern"></div>
                
                <div class="card-header-premium">
                    <div class="header-icon">
                        <i class="fas fa-file-image"></i>
                    </div>
                    <div class="header-title">
                        <h5 class="mb-0">Bukti Pengeluaran</h5>
                        <p class="mb-0 text-muted small">Dokumen pendukung transaksi</p>
                    </div>
                </div>
                
                <div class="card-body p-3 p-md-4 text-center">
                    <?php 
                    $ext = pathinfo($kas_keluar['bukti_pengeluaran'], PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): 
                    ?>
                        <div class="image-preview-wrapper">
                            <div class="image-preview">
                                <img src="<?= BASE_URL ?>/assets/uploads/<?= $kas_keluar['bukti_pengeluaran'] ?>" 
                                     alt="Bukti Pengeluaran" 
                                     class="img-fluid">
                                <div class="image-overlay">
                                    <a href="<?= BASE_URL ?>/assets/uploads/<?= $kas_keluar['bukti_pengeluaran'] ?>" 
                                       target="_blank" 
                                       class="btn-preview">
                                        <i class="fas fa-search-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/assets/uploads/<?= $kas_keluar['bukti_pengeluaran'] ?>" 
                           target="_blank" 
                           class="btn btn-premium btn-outline-premium">
                            <i class="fas fa-file-pdf me-2"></i>Lihat File Bukti
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
/* Premium Variables */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-light: rgba(102, 126, 234, 0.1);
    --primary-soft: rgba(102, 126, 234, 0.05);
    --success-light: rgba(40, 167, 69, 0.1);
    --danger-light: rgba(220, 53, 69, 0.1);
    --warning-light: rgba(255, 193, 7, 0.1);
    --info-light: rgba(23, 162, 184, 0.1);
    --secondary-light: rgba(108, 117, 125, 0.1);
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
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s;
    z-index: 1;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
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

.btn-warning-gradient {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
}

.btn-warning-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 87, 108, 0.4);
    color: white;
}

.btn-success-gradient {
    background: linear-gradient(135deg, #28a745, #218838);
    color: white;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-success-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
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
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    position: relative;
    overflow: hidden;
    transition: all 0.3s;
}

.premium-card:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
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

/* Card Header Premium */
.card-header-premium {
    padding: 1.5rem 1.5rem 0.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    z-index: 1;
}

.card-header-premium .header-icon {
    width: 48px;
    height: 48px;
    background: var(--primary-gradient);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
}

.card-header-premium .header-icon i {
    font-size: 1.4rem;
    color: white;
}

/* Info List Premium */
.info-list-premium {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item-premium {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #fafbfc;
    border-radius: 16px;
    transition: all 0.3s;
    overflow: hidden;
}

.info-item-premium:hover {
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.02);
    transform: translateX(5px);
}

.info-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.bg-primary-soft {
    background: var(--primary-light);
}

.bg-danger-soft {
    background: var(--danger-light);
}

.bg-info-soft {
    background: var(--info-light);
}

.bg-secondary-soft {
    background: var(--secondary-light);
}

.info-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 0.7rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
}

.amount-out {
    color: #dc3545;
    font-size: 1.2rem;
}

.keterangan-text {
    font-weight: 400;
    color: #4a5568;
    line-height: 1.5;
}

.info-glow {
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 70% 30%, rgba(102, 126, 234, 0.05), transparent 70%);
    pointer-events: none;
}

/* Status Card Premium */
.status-card {
    position: relative;
    width: 100%;
    padding: 2rem;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 1.5rem;
    overflow: hidden;
    transition: all 0.3s;
}

.status-card.approved {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.05), white);
    border: 2px solid rgba(40, 167, 69, 0.2);
}

.status-card.pending {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.05), white);
    border: 2px solid rgba(255, 193, 7, 0.2);
}

.status-icon-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    position: relative;
    z-index: 2;
    transition: all 0.3s;
}

.status-card:hover .status-icon-wrapper {
    transform: scale(1.05);
}

.status-icon-wrapper.approved {
    background: linear-gradient(135deg, #28a745, #34ce57);
    color: white;
}

.status-icon-wrapper.pending {
    background: linear-gradient(135deg, #ffc107, #ffcd39);
    color: white;
}

.status-content {
    position: relative;
    z-index: 2;
}

.status-badge {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.status-badge.approved {
    color: #28a745;
}

.status-badge.pending {
    color: #ffc107;
}

.status-detail {
    font-size: 0.9rem;
    color: #4a5568;
}

.approver-info {
    margin-bottom: 0.5rem;
}

.approver-info i {
    color: #667eea;
}

.approver-time {
    font-size: 0.8rem;
    color: #6c757d;
}

.status-glow {
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 70% 30%, rgba(102, 126, 234, 0.05), transparent 70%);
    pointer-events: none;
}

/* Kategori Badge */
.kategori-badge {
    padding: 0.4rem 1rem;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 600;
}

.kategori-operasional {
    background: var(--info-light);
    color: #17a2b8;
}

.kategori-peralatan {
    background: var(--warning-light);
    color: #856404;
}

.kategori-konsumsi {
    background: var(--success-light);
    color: #28a745;
}

.kategori-dokumentasi {
    background: var(--primary-light);
    color: #667eea;
}

.kategori-lainnya {
    background: var(--danger-light);
    color: #dc3545;
}

/* Alert Premium */
.alert-premium {
    position: relative;
    padding: 1rem 3rem 1rem 1rem;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 1rem;
    overflow: hidden;
    animation: slideIn 0.3s ease;
}

.alert-premium.danger {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.05), white);
    border: 1px solid rgba(220, 53, 69, 0.2);
}

.alert-premium.success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.05), white);
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.alert-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.alert-premium.danger .alert-icon i {
    color: #dc3545;
}

.alert-premium.success .alert-icon i {
    color: #28a745;
}

.alert-content {
    flex: 1;
    font-weight: 500;
    color: #2c3e50;
}

.alert-close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: transparent;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    transition: all 0.3s;
}

.alert-close:hover {
    color: #667eea;
    transform: rotate(90deg);
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

/* Image Preview */
.image-preview-wrapper {
    display: inline-block;
    position: relative;
    max-width: 100%;
}

.image-preview {
    position: relative;
    display: inline-block;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.image-preview img {
    max-height: 300px;
    width: auto;
    transition: all 0.3s;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.image-preview:hover .image-overlay {
    opacity: 1;
}

.image-preview:hover img {
    transform: scale(1.05);
}

.btn-preview {
    width: 50px;
    height: 50px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 1.2rem;
    transition: all 0.3s;
}

.btn-preview:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Responsive Breakpoints */
@media (max-width: 768px) {
    .status-icon-wrapper {
        width: 70px;
        height: 70px;
        font-size: 1.8rem;
    }
    
    .status-badge {
        font-size: 1.1rem;
    }
}

@media (max-width: 576px) {
    .card-header-premium {
        padding: 1rem 1rem 0.5rem;
    }
    
    .card-header-premium .header-icon {
        width: 40px;
        height: 40px;
    }
    
    .card-header-premium .header-icon i {
        font-size: 1.2rem;
    }
    
    .info-item-premium {
        padding: 0.8rem;
    }
    
    .info-icon-wrapper {
        width: 40px;
        height: 40px;
    }
    
    .info-icon-wrapper i {
        font-size: 1rem;
    }
    
    .info-value {
        font-size: 0.9rem;
    }
    
    .amount-out {
        font-size: 1.1rem;
    }
    
    .status-card {
        padding: 1.5rem;
    }
    
    .status-icon-wrapper {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .status-badge {
        font-size: 1rem;
    }
}

@media (max-width: 375px) {
    .status-card {
        padding: 1.2rem;
    }
    
    .status-icon-wrapper {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .status-badge {
        font-size: 0.9rem;
    }
}
</style>

<script>
function approveKasKeluar(id) {
    Swal.fire({
        title: 'Konfirmasi Persetujuan',
        text: 'Setujui pengeluaran kas ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= BASE_URL ?>/kas-keluar/approve/' + id,
                type: 'POST',
                dataType: 'json',
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

$(document).ready(function() {
    // Auto-hide alert setelah 3 detik
    setTimeout(function() {
        $('.alert-premium').fadeOut('slow');
    }, 3000);
});
</script>