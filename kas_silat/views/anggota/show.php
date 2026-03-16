<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Header Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Detail Anggota</span>
                    <span class="title-badge ms-2">#<?= $anggota['id'] ?></span>
                </h1>
                <p class="title-sub mb-0">Informasi lengkap dan riwayat pembayaran anggota</p>
            </div>
            <div class="d-flex gap-2 w-100 w-md-auto">
                <a href="<?= BASE_URL ?>/anggota" class="btn btn-premium btn-outline-premium flex-fill flex-md-grow-0">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])): ?>
                <a href="<?= BASE_URL ?>/anggota/edit/<?= $anggota['id'] ?>" class="btn btn-premium btn-warning-gradient flex-fill flex-md-grow-0">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <!-- Kolom Kiri: Profile Card Premium -->
        <div class="col-12 col-md-4">
            <div class="profile-card premium-card">
                <!-- Avatar Premium -->
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        <span class="avatar-text">
                            <?= strtoupper(substr($anggota['nama'], 0, 2)) ?>
                        </span>
                    </div>
                    <div class="avatar-glow"></div>
                </div>
                
                <!-- Nama dan Status -->
                <div class="profile-info text-center">
                    <h3 class="profile-name"><?= $anggota['nama'] ?></h3>
                    <div class="profile-status mt-2">
                        <?php if ($anggota['status_aktif']): ?>
                            <span class="status-badge status-active">
                                <i class="fas fa-circle me-1"></i>Aktif
                            </span>
                        <?php else: ?>
                            <span class="status-badge status-inactive">
                                <i class="fas fa-circle me-1"></i>Non Aktif
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Info Detail Premium -->
                <div class="profile-details">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="detail-content">
                            <span class="detail-label">Kelas</span>
                            <span class="detail-value"><?= $anggota['kelas'] ?></span>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-<?= $anggota['jenis_kelamin'] == 'L' ? 'mars' : 'venus' ?>"></i>
                        </div>
                        <div class="detail-content">
                            <span class="detail-label">Jenis Kelamin</span>
                            <span class="detail-value"><?= $anggota['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></span>
                        </div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="detail-content">
                            <span class="detail-label">No. HP</span>
                            <span class="detail-value"><?= $anggota['no_hp'] ?? '-' ?></span>
                        </div>
                    </div>
                    
                    <div class="detail-item total-item">
                        <div class="detail-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="detail-content">
                            <span class="detail-label">Total Iuran</span>
                            <span class="detail-value total-value"><?= formatRupiah($total_iuran) ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="card-glow"></div>
                <div class="card-pattern"></div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Riwayat Pembayaran Premium -->
        <div class="col-12 col-md-8">
            <div class="history-card premium-card">
                <div class="card-header-premium">
                    <div class="header-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="header-title">
                        <h5 class="mb-0">Riwayat Pembayaran Kas</h5>
                        <p class="mb-0 text-muted small"><?= count($riwayat) ?> transaksi ditemukan</p>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <?php if (empty($riwayat)): ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h5>Belum Ada Riwayat</h5>
                            <p class="text-muted">Anggota ini belum memiliki riwayat pembayaran</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table premium-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th class="text-end">Jumlah</th>
                                        <th class="text-center">Metode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($riwayat as $r): ?>
                                    <tr class="history-row">
                                        <td class="text-nowrap">
                                            <div class="date-wrapper">
                                                <span class="date-day"><?= date('d', strtotime($r['tanggal'])) ?></span>
                                                <span class="date-month"><?= date('M', strtotime($r['tanggal'])) ?></span>
                                                <span class="date-year"><?= date('Y', strtotime($r['tanggal'])) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="keterangan"><?= $r['keterangan'] ?? '-' ?></span>
                                        </td>
                                        <td class="text-end">
                                            <span class="amount"><?= formatRupiah($r['jumlah']) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge metode-badge metode-<?= strtolower($r['metode']) ?>">
                                                <?= $r['metode'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="2" class="text-end fw-bold">TOTAL</td>
                                        <td class="text-end fw-bold total-amount"><?= formatRupiah($total_iuran) ?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Premium Variables */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-light: rgba(102, 126, 234, 0.1);
    --success-light: rgba(40, 167, 69, 0.1);
    --danger-light: rgba(220, 53, 69, 0.1);
    --warning-light: rgba(255, 193, 7, 0.1);
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
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    border-radius: 12px;
    transition: all 0.3s;
    z-index: 1;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
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
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
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

/* Premium Card */
.premium-card {
    background: white;
    border: none;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    transition: all 0.3s;
    overflow: hidden;
    position: relative;
}

.premium-card:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
    transform: translateY(-3px);
}

/* Profile Card Premium */
.profile-card {
    padding: 2rem 1.5rem;
    position: relative;
    z-index: 1;
}

.profile-avatar-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 1.5rem;
}

.profile-avatar {
    width: 100%;
    height: 100%;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 2;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s;
}

.profile-card:hover .profile-avatar {
    transform: scale(1.05);
}

.avatar-text {
    font-size: 3rem;
    font-weight: 700;
    color: white;
}

.avatar-glow {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: radial-gradient(circle at 30% 30%, rgba(102, 126, 234, 0.3), transparent 70%);
    border-radius: 50%;
    z-index: 1;
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

/* Status Badge Premium */
.status-badge {
    padding: 0.5rem 1.2rem;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.status-badge i {
    font-size: 0.6rem;
    margin-right: 0.5rem;
}

.status-active {
    background: var(--success-light);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.status-inactive {
    background: var(--danger-light);
    color: #dc3545;
    border: 1px solid rgba(220, 53, 69, 0.2);
}

/* Profile Details Premium */
.profile-details {
    margin-top: 2rem;
}

.detail-item {
    display: flex;
    align-items: center;
    padding: 0.8rem;
    border-radius: 16px;
    background: #f8fafc;
    margin-bottom: 0.75rem;
    transition: all 0.3s;
}

.detail-item:hover {
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.03);
    transform: translateX(5px);
}

.detail-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-light);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.detail-icon i {
    font-size: 1.2rem;
    color: #667eea;
}

.detail-content {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

.detail-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: #2c3e50;
}

.total-item {
    background: var(--primary-light);
    border: 1px solid rgba(102, 126, 234, 0.2);
}

.total-value {
    color: #667eea;
    font-size: 1.1rem;
}

/* Card Glow & Pattern */
.card-glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 30% 30%, rgba(102, 126, 234, 0.03), transparent 70%);
    z-index: -1;
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
    z-index: -1;
    pointer-events: none;
}

/* History Card Premium */
.history-card {
    height: 100%;
}

.card-header-premium {
    padding: 1.5rem 1.5rem 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-gradient);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
}

.header-icon i {
    font-size: 1.5rem;
    color: white;
}

/* Premium Table */
.premium-table {
    margin-bottom: 0;
}

.premium-table thead th {
    background: #f8fafc;
    color: #2c3e50;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 1rem;
    border-bottom: 2px solid #e2e8f0;
}

.premium-table tbody tr {
    transition: all 0.3s;
}

.premium-table tbody tr:hover {
    background: linear-gradient(90deg, var(--primary-light), transparent);
}

/* Date Wrapper */
.date-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #f8fafc;
    padding: 0.4rem;
    border-radius: 10px;
    width: 55px;
}

.date-day {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.2;
}

.date-month {
    font-size: 0.7rem;
    font-weight: 600;
    color: #667eea;
    text-transform: uppercase;
}

.date-year {
    font-size: 0.65rem;
    color: #6c757d;
}

/* Keterangan */
.keterangan {
    font-size: 0.9rem;
    color: #2c3e50;
    font-weight: 500;
}

/* Amount */
.amount {
    font-size: 0.95rem;
    font-weight: 600;
    color: #28a745;
}

/* Metode Badge */
.metode-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 500;
}

.metode-tunai {
    background: var(--info-light);
    color: #17a2b8;
}

.metode-transfer-bank {
    background: var(--warning-light);
    color: #ffc107;
}

.metode-e-wallet {
    background: var(--success-light);
    color: #28a745;
}

/* Total Row */
.total-row {
    background: linear-gradient(90deg, var(--primary-light), transparent);
}

.total-amount {
    color: #667eea !important;
    font-size: 1rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: var(--primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-icon i {
    font-size: 2.5rem;
    color: #667eea;
}

/* Responsive Breakpoints */
@media (max-width: 768px) {
    .profile-avatar-wrapper {
        width: 100px;
        height: 100px;
    }
    
    .avatar-text {
        font-size: 2.5rem;
    }
    
    .profile-name {
        font-size: 1.3rem;
    }
    
    .detail-item {
        padding: 0.6rem;
    }
    
    .detail-icon {
        width: 35px;
        height: 35px;
    }
    
    .detail-icon i {
        font-size: 1rem;
    }
    
    .detail-label {
        font-size: 0.8rem;
    }
    
    .detail-value {
        font-size: 0.9rem;
    }
    
    .total-value {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .profile-card {
        padding: 1.5rem 1rem;
    }
    
    .profile-avatar-wrapper {
        width: 80px;
        height: 80px;
    }
    
    .avatar-text {
        font-size: 2rem;
    }
    
    .date-wrapper {
        width: 45px;
        padding: 0.3rem;
    }
    
    .date-day {
        font-size: 0.9rem;
    }
    
    .date-month {
        font-size: 0.6rem;
    }
    
    .date-year {
        font-size: 0.55rem;
    }
    
    .keterangan {
        font-size: 0.8rem;
    }
    
    .amount {
        font-size: 0.85rem;
    }
    
    .metode-badge {
        padding: 0.3rem 0.6rem;
        font-size: 0.65rem;
    }
}

@media (max-width: 375px) {
    .profile-avatar-wrapper {
        width: 70px;
        height: 70px;
    }
    
    .avatar-text {
        font-size: 1.8rem;
    }
    
    .profile-name {
        font-size: 1.1rem;
    }
    
    .status-badge {
        padding: 0.4rem 1rem;
        font-size: 0.75rem;
    }
    
    .detail-item {
        padding: 0.5rem;
    }
    
    .detail-icon {
        width: 30px;
        height: 30px;
        margin-right: 0.75rem;
    }
    
    .detail-icon i {
        font-size: 0.9rem;
    }
}
</style>

<script>
$(document).ready(function() {
    // Auto hide alert jika ada
    $('.alert').delay(3000).fadeOut();
    
    // Add animation to rows
    $('.history-row').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
});
</script>