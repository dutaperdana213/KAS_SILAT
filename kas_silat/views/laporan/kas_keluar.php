<div class="laporan-kas-keluar-page">
    <div class="container-fluid px-2 px-sm-3 px-md-4">
        <!-- Page Header Premium -->
        <div class="page-header-wrapper mb-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                <div class="header-title">
                    <h1 class="page-title">
                        <span class="title-gradient">Laporan Kas Keluar</span>
                    </h1>
                    <p class="title-sub mb-0">Detail pengeluaran kas per periode</p>
                </div>
                
                <!-- ACTION BUTTONS PREMIUM ELEGAN -->
                <div class="action-buttons">
                    <a href="<?= BASE_URL ?>/laporan" class="btn-action btn-back">
                        <i class="fas fa-arrow-left me-2"></i>
                        <span>Kembali</span>
                        <div class="btn-glow"></div>
                    </a>
                    <a href="<?= BASE_URL ?>/laporan/export-excel?jenis=kas_keluar&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn-action btn-excel">
                        <i class="fas fa-file-excel me-2"></i>
                        <span>Excel</span>
                        <div class="btn-glow"></div>
                    </a>
                    <a href="<?= BASE_URL ?>/laporan/export-pdf?jenis=kas_keluar&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn-action btn-pdf">
                        <i class="fas fa-file-pdf me-2"></i>
                        <span>PDF</span>
                        <div class="btn-glow"></div>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Filter Periode Premium -->
        <div class="filter-card mb-4">
            <div class="filter-body">
                <form method="GET" action="<?= BASE_URL ?>/laporan/kas-keluar">
                    <div class="filter-grid">
                        <div class="filter-item">
                            <label class="filter-label">Tanggal Awal</label>
                            <div class="date-input">
                                <i class="fas fa-calendar-alt input-icon"></i>
                                <input type="date" name="start_date" value="<?= $start_date ?>" required>
                            </div>
                        </div>
                        <div class="filter-item">
                            <label class="filter-label">Tanggal Akhir</label>
                            <div class="date-input">
                                <i class="fas fa-calendar-alt input-icon"></i>
                                <input type="date" name="end_date" value="<?= $end_date ?>" required>
                            </div>
                        </div>
                        <div class="filter-item filter-button">
                            <label class="filter-label d-none d-md-block">&nbsp;</label>
                            <button type="submit" class="btn-filter">
                                <i class="fas fa-filter me-1"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Statistik Cards Premium -->
        <div class="stats-grid mb-4">
            <div class="stat-card stat-danger">
                <div class="stat-icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Kas Keluar</div>
                    <div class="stat-value"><?= formatRupiah($ringkasan['total_keluar']) ?></div>
                    <div class="stat-period"><?= formatTanggal($start_date, 'date') ?> - <?= formatTanggal($end_date, 'date') ?></div>
                </div>
            </div>
            
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Saldo Akhir</div>
                    <div class="stat-value"><?= formatRupiah($ringkasan['saldo_akhir']) ?></div>
                    <div class="stat-period">Per <?= formatTanggal($end_date, 'date') ?></div>
                </div>
            </div>
            
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Jumlah Transaksi</div>
                    <div class="stat-value"><?= count($laporan) ?> Transaksi</div>
                    <div class="stat-period">Dalam periode terpilih</div>
                </div>
            </div>
        </div>
        
        <!-- Tabel Laporan Premium -->
        <div class="table-card">
            <div class="table-header">
                <h5 class="table-title">
                    <i class="fas fa-list me-2 text-danger"></i>
                    Detail Kas Keluar
                </h5>
                <div class="table-info">
                    <span class="info-badge">
                        <i class="fas fa-info-circle me-1"></i>
                        <?= count($laporan) ?> data ditemukan
                    </span>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="premium-table" id="kasKeluarTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th width="100">Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-end" width="100">Jumlah</th>
                            <th class="d-none d-md-table-cell">Penanggung Jawab</th>
                            <th class="d-none d-lg-table-cell" width="100">Kategori</th>
                            <th class="text-center" width="90">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($laporan)): ?>
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-money-bill-wave-alt"></i>
                                </div>
                                <h5>Tidak Ada Data</h5>
                                <p class="text-muted">Tidak ada transaksi pada periode ini</p>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php $no = 1; ?>
                            <?php foreach ($laporan as $item): ?>
                            <tr class="data-row">
                                <td class="text-center fw-medium"><?= $no++ ?></td>
                                <td>
                                    <div class="date-badge">
                                        <span class="date-day"><?= date('d', strtotime($item['tanggal'])) ?></span>
                                        <span class="date-month"><?= date('M', strtotime($item['tanggal'])) ?></span>
                                        <span class="date-year"><?= date('Y', strtotime($item['tanggal'])) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="keterangan-info">
                                        <span class="keterangan-text"><?= $item['keterangan'] ?></span>
                                        <!-- Mobile meta -->
                                        <div class="mobile-meta d-block d-md-none">
                                            <span class="meta-item">
                                                <i class="fas fa-user me-1"></i><?= $item['penanggung_jawab'] ?>
                                            </span>
                                            <span class="meta-item">
                                                <i class="fas fa-tag me-1"></i><?= $item['kategori'] ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="amount amount-out"><?= formatRupiah($item['jumlah']) ?></span>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <span class="pj-name"><?= $item['penanggung_jawab'] ?></span>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <span class="kategori-badge kategori-<?= strtolower($item['kategori']) ?>">
                                        <?= $item['kategori'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($item['penyetuju']): ?>
                                        <span class="status-badge status-approved">
                                            <i class="fas fa-check-circle me-1"></i>Disetujui
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="3" class="text-end fw-bold">TOTAL</td>
                            <td class="text-end fw-bold total-amount-out"><?= formatRupiah($ringkasan['total_keluar']) ?></td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Laporan Kas Keluar Premium Styles */
.laporan-kas-keluar-page {
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

/* ===== HEADER PREMIUM ===== */
.laporan-kas-keluar-page .page-header-wrapper {
    margin-bottom: 1.5rem;
}

.laporan-kas-keluar-page .page-title {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    margin-bottom: 0.1rem;
}

.laporan-kas-keluar-page .title-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.laporan-kas-keluar-page .title-sub {
    color: #6c757d;
    font-size: 0.85rem;
}

/* ===== ACTION BUTTONS PREMIUM ELEGAN ===== */
.laporan-kas-keluar-page .action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.laporan-kas-keluar-page .btn-action {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.6rem 1.2rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    overflow: hidden;
    z-index: 1;
    min-width: 90px;
}

/* Button Back - Outline Premium */
.laporan-kas-keluar-page .btn-back {
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
}

.laporan-kas-keluar-page .btn-back:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    border-color: transparent;
}

/* Button Excel - Gradient Solid */
.laporan-kas-keluar-page .btn-excel {
    background: linear-gradient(135deg, #28a745, #34ce57);
    color: white;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
    border: none;
}

.laporan-kas-keluar-page .btn-excel:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
}

/* Button PDF - Gradient Solid */
.laporan-kas-keluar-page .btn-pdf {
    background: linear-gradient(135deg, #dc3545, #ff4d5e);
    color: white;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
    border: none;
}

.laporan-kas-keluar-page .btn-pdf:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
}

/* Glow Effect */
.laporan-kas-keluar-page .btn-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
    z-index: -1;
}

.laporan-kas-keluar-page .btn-action:hover .btn-glow {
    left: 100%;
}

/* Icons in buttons */
.laporan-kas-keluar-page .btn-action i {
    font-size: 0.9rem;
    transition: transform 0.2s;
}

.laporan-kas-keluar-page .btn-action:hover i {
    transform: scale(1.1);
}

/* ===== FILTER PREMIUM ===== */
.laporan-kas-keluar-page .filter-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    padding: 1.2rem;
}

.laporan-kas-keluar-page .filter-grid {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 1rem;
    align-items: end;
}

@media (max-width: 768px) {
    .laporan-kas-keluar-page .filter-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

.laporan-kas-keluar-page .filter-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.3rem;
    display: block;
}

.laporan-kas-keluar-page .date-input {
    position: relative;
}

.laporan-kas-keluar-page .date-input .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    z-index: 2;
    font-size: 0.9rem;
}

.laporan-kas-keluar-page .date-input input {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.6rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.laporan-kas-keluar-page .date-input input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.laporan-kas-keluar-page .btn-filter {
    width: 100%;
    padding: 0.7rem 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
}

.laporan-kas-keluar-page .btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

/* ===== STATISTIK CARDS ===== */
.laporan-kas-keluar-page .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

@media (max-width: 768px) {
    .laporan-kas-keluar-page .stats-grid {
        grid-template-columns: 1fr;
        gap: 0.8rem;
    }
}

@media (min-width: 769px) and (max-width: 992px) {
    .laporan-kas-keluar-page .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.laporan-kas-keluar-page .stat-card {
    background: white;
    border-radius: 20px;
    padding: 1.2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.02);
    transition: all 0.3s;
}

.laporan-kas-keluar-page .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.laporan-kas-keluar-page .stat-card.stat-danger {
    border-left: 4px solid #dc3545;
}

.laporan-kas-keluar-page .stat-card.stat-success {
    border-left: 4px solid #28a745;
}

.laporan-kas-keluar-page .stat-card.stat-info {
    border-left: 4px solid #17a2b8;
}

.laporan-kas-keluar-page .stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.laporan-kas-keluar-page .stat-danger .stat-icon {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.laporan-kas-keluar-page .stat-success .stat-icon {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.laporan-kas-keluar-page .stat-info .stat-icon {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
}

.laporan-kas-keluar-page .stat-content {
    flex: 1;
}

.laporan-kas-keluar-page .stat-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #6c757d;
    letter-spacing: 0.5px;
    margin-bottom: 0.2rem;
}

.laporan-kas-keluar-page .stat-value {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.2;
    margin-bottom: 0.1rem;
}

.laporan-kas-keluar-page .stat-period {
    font-size: 0.65rem;
    color: #94a3b8;
}

/* ===== TABEL PREMIUM ===== */
.laporan-kas-keluar-page .table-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.02);
    overflow: hidden;
    margin-top: 1.5rem;
}

.laporan-kas-keluar-page .table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.laporan-kas-keluar-page .table-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    color: #2c3e50;
}

.laporan-kas-keluar-page .info-badge {
    background: #f8f9fa;
    padding: 0.3rem 0.8rem;
    border-radius: 30px;
    font-size: 0.75rem;
    color: #495057;
}

.laporan-kas-keluar-page .premium-table {
    width: 100%;
    border-collapse: collapse;
}

.laporan-kas-keluar-page .premium-table thead th {
    background: #f8fafc;
    padding: 1rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: #2c3e50;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
}

.laporan-kas-keluar-page .premium-table tbody tr {
    transition: all 0.2s;
}

.laporan-kas-keluar-page .premium-table tbody tr:hover {
    background: rgba(220, 53, 69, 0.02);
}

.laporan-kas-keluar-page .premium-table td {
    padding: 0.75rem;
    border-bottom: 1px solid #e9ecef;
}

/* Date Badge */
.laporan-kas-keluar-page .date-badge {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    background: #f8f9fa;
    padding: 0.3rem 0.6rem;
    border-radius: 10px;
    min-width: 55px;
}

.laporan-kas-keluar-page .date-day {
    font-size: 1rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.2;
}

.laporan-kas-keluar-page .date-month {
    font-size: 0.65rem;
    font-weight: 600;
    color: #667eea;
    text-transform: uppercase;
}

.laporan-kas-keluar-page .date-year {
    font-size: 0.6rem;
    color: #94a3b8;
}

/* Keterangan Info */
.laporan-kas-keluar-page .keterangan-info {
    display: flex;
    flex-direction: column;
}

.laporan-kas-keluar-page .keterangan-text {
    font-weight: 500;
    color: #2c3e50;
}

.laporan-kas-keluar-page .mobile-meta {
    margin-top: 0.3rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.laporan-kas-keluar-page .meta-item {
    font-size: 0.7rem;
    color: #6c757d;
    display: inline-flex;
    align-items: center;
    background: #f8f9fa;
    padding: 0.2rem 0.5rem;
    border-radius: 20px;
}

.laporan-kas-keluar-page .meta-item i {
    font-size: 0.6rem;
    color: #667eea;
}

/* Amount */
.laporan-kas-keluar-page .amount {
    font-size: 0.95rem;
    font-weight: 600;
}

.laporan-kas-keluar-page .amount-out {
    color: #dc3545;
}

/* PJ Name */
.laporan-kas-keluar-page .pj-name {
    font-weight: 500;
    color: #2c3e50;
}

/* Kategori Badge */
.laporan-kas-keluar-page .kategori-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 500;
    display: inline-block;
}

.laporan-kas-keluar-page .kategori-operasional {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
}

.laporan-kas-keluar-page .kategori-peralatan {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.laporan-kas-keluar-page .kategori-konsumsi {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.laporan-kas-keluar-page .kategori-dokumentasi {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.laporan-kas-keluar-page .kategori-lainnya {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

/* Status Badge */
.laporan-kas-keluar-page .status-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
}

.laporan-kas-keluar-page .status-badge i {
    font-size: 0.6rem;
    margin-right: 0.3rem;
}

.laporan-kas-keluar-page .status-approved {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.laporan-kas-keluar-page .status-pending {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

/* Total Row */
.laporan-kas-keluar-page .total-row {
    background: #f8f9fa;
    font-weight: 600;
}

.laporan-kas-keluar-page .total-amount-out {
    color: #dc3545;
    font-size: 1rem;
}

/* Empty State */
.laporan-kas-keluar-page .empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.laporan-kas-keluar-page .empty-icon {
    width: 70px;
    height: 70px;
    background: rgba(220, 53, 69, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.laporan-kas-keluar-page .empty-icon i {
    font-size: 2rem;
    color: #dc3545;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .laporan-kas-keluar-page .action-buttons {
        width: 100%;
        justify-content: stretch;
    }
    
    .laporan-kas-keluar-page .btn-action {
        flex: 1;
        justify-content: center;
        padding: 0.5rem 0.8rem;
        min-width: 0;
    }
    
    .laporan-kas-keluar-page .btn-action i {
        margin-right: 0.3rem;
    }
    
    .laporan-kas-keluar-page .date-badge {
        min-width: 45px;
        padding: 0.2rem 0.4rem;
    }
    
    .laporan-kas-keluar-page .date-day {
        font-size: 0.9rem;
    }
    
    .laporan-kas-keluar-page .date-month {
        font-size: 0.6rem;
    }
    
    .laporan-kas-keluar-page .date-year {
        font-size: 0.55rem;
    }
    
    .laporan-kas-keluar-page .stat-value {
        font-size: 1.1rem;
    }
}

@media (max-width: 576px) {
    .laporan-kas-keluar-page .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .laporan-kas-keluar-page .btn-action {
        width: 100%;
        padding: 0.6rem 1rem;
    }
    
    .laporan-kas-keluar-page .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .laporan-kas-keluar-page .premium-table td {
        padding: 0.5rem;
    }
    
    .laporan-kas-keluar-page .kategori-badge,
    .laporan-kas-keluar-page .status-badge {
        padding: 0.2rem 0.5rem;
        font-size: 0.65rem;
    }
    
    .laporan-kas-keluar-page .amount {
        font-size: 0.85rem;
    }
    
    .laporan-kas-keluar-page .mobile-meta {
        flex-direction: column;
        gap: 0.2rem;
    }
}

/* Loading spinner animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.laporan-kas-keluar-page .fa-spinner {
    animation: spin 1s linear infinite;
}
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable
    if ($.fn.DataTable) {
        $('#kasKeluarTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
            },
            pageLength: 10,
            responsive: true,
            autoWidth: false,
            columnDefs: [
                { targets: [4], visible: window.innerWidth >= 768 }, // Penanggung Jawab
                { targets: [5], visible: window.innerWidth >= 992 }  // Kategori
            ],
            drawCallback: function() {
                // Add animation to rows
                $('.data-row').each(function(i) {
                    $(this).css('animation-delay', (i * 0.05) + 's');
                });
            }
        });
    }
    
    // Handle window resize
    $(window).on('resize', function() {
        if ($.fn.DataTable && $('#kasKeluarTable').DataTable()) {
            let table = $('#kasKeluarTable').DataTable();
            table.column(4).visible(window.innerWidth >= 768);
            table.column(5).visible(window.innerWidth >= 992);
        }
    });
    
    // Export with loading
    $('.btn-excel, .btn-pdf').on('click', function(e) {
        let btn = $(this);
        let originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Loading...');
        btn.css('pointer-events', 'none');
        
        setTimeout(function() {
            btn.html(originalText);
            btn.css('pointer-events', 'auto');
        }, 1000);
    });
    
    // Auto-hide alert setelah 3 detik
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
});
</script>