<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Header Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Detail Kas Masuk</span>
                    <span class="title-badge ms-2">#<?= $kas_masuk['id'] ?></span>
                </h1>
                <p class="title-sub mb-0">Informasi lengkap transaksi pemasukan kas</p>
            </div>
            <div class="d-flex gap-2 w-100 w-md-auto">
                <a href="<?= BASE_URL ?>/kas-masuk" class="btn btn-premium btn-outline-premium flex-fill flex-md-grow-0">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])): ?>
                <a href="<?= BASE_URL ?>/kas-masuk/edit/<?= $kas_masuk['id'] ?>" class="btn btn-premium btn-warning-gradient flex-fill flex-md-grow-0">
                    <i class="fas fa-edit me-1"></i> Edit
                    <div class="btn-glow"></div>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
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
                        <p class="mb-0 text-muted small">Detail pemasukan kas</p>
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
                                <span class="info-value"><?= formatTanggal($kas_masuk['tanggal'], 'full') ?></span>
                            </div>
                            <div class="info-glow"></div>
                        </div>
                        
                        <!-- Jumlah -->
                        <div class="info-item-premium">
                            <div class="info-icon-wrapper bg-success-soft">
                                <i class="fas fa-money-bill-wave text-success"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Jumlah</span>
                                <span class="info-value amount-value"><?= formatRupiah($kas_masuk['jumlah']) ?></span>
                            </div>
                            <div class="info-glow"></div>
                        </div>
                        
                        <!-- Metode -->
                        <div class="info-item-premium">
                            <div class="info-icon-wrapper bg-info-soft">
                                <i class="fas fa-credit-card text-info"></i>
                            </div>
                            <div class="info-content">
                                <span class="info-label">Metode Pembayaran</span>
                                <div class="mt-1">
                                    <span class="badge metode-badge metode-<?= strtolower($kas_masuk['metode']) ?>">
                                        <?= $kas_masuk['metode'] ?>
                                    </span>
                                </div>
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
                                <span class="info-value keterangan-text"><?= nl2br($kas_masuk['keterangan'] ?? '-') ?></span>
                            </div>
                            <div class="info-glow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Informasi Anggota Premium -->
        <div class="col-12 col-md-6">
            <div class="card premium-card h-100">
                <div class="card-glow"></div>
                <div class="card-pattern"></div>
                
                <div class="card-header-premium">
                    <div class="header-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="header-title">
                        <h5 class="mb-0">Informasi Anggota</h5>
                        <p class="mb-0 text-muted small">Data anggota yang melakukan pembayaran</p>
                    </div>
                </div>
                
                <div class="card-body p-3 p-md-4">
                    <div class="member-profile-card">
                        <!-- Avatar Anggota -->
                        <div class="member-avatar-wrapper">
                            <div class="member-avatar">
                                <?= strtoupper(substr($kas_masuk['nama_anggota'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="avatar-glow"></div>
                        </div>
                        
                        <!-- Nama Anggota -->
                        <div class="member-name-wrapper">
                            <h4 class="member-name"><?= $kas_masuk['nama_anggota'] ?? '-' ?></h4>
                            <span class="member-role">Anggota Ekstrakurikuler</span>
                        </div>
                        
                        <!-- Detail Anggota -->
                        <div class="member-details">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="detail-content">
                                    <span class="detail-label">Kelas</span>
                                    <span class="detail-value"><?= $kas_masuk['kelas'] ?? '-' ?></span>
                                </div>
                            </div>
                            
                            <?php if (!empty($kas_masuk['no_anggota'])): ?>
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="detail-content">
                                    <span class="detail-label">No. Anggota</span>
                                    <span class="detail-value"><?= $kas_masuk['no_anggota'] ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bukti Transfer Premium -->
    <?php if (!empty($kas_masuk['bukti_transfer'])): ?>
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
                        <h5 class="mb-0">Bukti Transfer</h5>
                        <p class="mb-0 text-muted small">Dokumen pendukung transaksi</p>
                    </div>
                </div>
                
                <div class="card-body p-3 p-md-4 text-center">
                    <?php 
                    $ext = pathinfo($kas_masuk['bukti_transfer'], PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])): 
                    ?>
                        <div class="image-preview-wrapper">
                            <div class="image-preview">
                                <img src="<?= BASE_URL ?>/assets/uploads/<?= $kas_masuk['bukti_transfer'] ?>" 
                                     alt="Bukti Transfer" 
                                     class="img-fluid">
                                <div class="image-overlay">
                                    <a href="<?= BASE_URL ?>/assets/uploads/<?= $kas_masuk['bukti_transfer'] ?>" 
                                       target="_blank" 
                                       class="btn-preview">
                                        <i class="fas fa-search-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/assets/uploads/<?= $kas_masuk['bukti_transfer'] ?>" 
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

.bg-success-soft {
    background: var(--success-light);
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

.amount-value {
    color: #28a745;
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

/* Member Profile Card */
.member-profile-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 0.5rem;
}

.member-avatar-wrapper {
    position: relative;
    width: 100px;
    height: 100px;
    margin-bottom: 1rem;
}

.member-avatar {
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    color: white;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s;
}

.premium-card:hover .member-avatar {
    transform: scale(1.05);
}

.avatar-glow {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: radial-gradient(circle at 30% 30%, rgba(102, 126, 234, 0.3), transparent 70%);
    border-radius: 50%;
    z-index: -1;
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}

.member-name-wrapper {
    margin-bottom: 1.5rem;
}

.member-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.member-role {
    font-size: 0.85rem;
    color: #6c757d;
}

.member-details {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.detail-item {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 12px;
    transition: all 0.3s;
}

.detail-item:hover {
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.02);
}

.detail-icon {
    width: 36px;
    height: 36px;
    background: var(--primary-light);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
}

.detail-icon i {
    font-size: 1rem;
    color: #667eea;
}

.detail-content {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-label {
    font-size: 0.8rem;
    color: #6c757d;
}

.detail-value {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2c3e50;
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

/* Badge */
.metode-badge {
    padding: 0.4rem 1rem;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 600;
}

.metode-tunai {
    background: var(--info-light);
    color: #17a2b8;
}

.metode-transfer-bank {
    background: var(--primary-light);
    color: #667eea;
}

.metode-e-wallet {
    background: var(--success-light);
    color: #28a745;
}

/* Responsive Breakpoints */
@media (max-width: 768px) {
    .member-avatar-wrapper {
        width: 80px;
        height: 80px;
    }
    
    .member-avatar {
        font-size: 2.5rem;
    }
    
    .member-name {
        font-size: 1.3rem;
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
    
    .member-avatar-wrapper {
        width: 70px;
        height: 70px;
    }
    
    .member-avatar {
        font-size: 2rem;
    }
    
    .member-name {
        font-size: 1.2rem;
    }
    
    .info-item-premium {
        padding: 0.7rem;
        gap: 0.8rem;
    }
    
    .info-icon-wrapper {
        width: 36px;
        height: 36px;
    }
    
    .info-value {
        font-size: 0.9rem;
    }
    
    .amount-value {
        font-size: 1.1rem;
    }
    
    .detail-item {
        padding: 0.6rem;
    }
    
    .detail-icon {
        width: 32px;
        height: 32px;
    }
    
    .detail-icon i {
        font-size: 0.9rem;
    }
}

@media (max-width: 375px) {
    .member-avatar-wrapper {
        width: 60px;
        height: 60px;
    }
    
    .member-avatar {
        font-size: 1.8rem;
    }
    
    .member-name {
        font-size: 1.1rem;
    }
    
    .btn-premium {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
}
</style>