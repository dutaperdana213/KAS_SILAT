<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Header Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Kas Masuk</span>
                    <span class="title-badge ms-2"><?= $pagination['total'] ?? 0 ?> Transaksi</span>
                </h1>
                <p class="title-sub mb-0">Kelola pemasukan kas ekstrakurikuler silat</p>
            </div>
            <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])): ?>
            <div class="d-flex gap-2 w-100 w-md-auto">
                <a href="<?= BASE_URL ?>/kas-masuk/create" class="btn btn-premium btn-primary-gradient flex-fill flex-md-grow-0">
                    <i class="fas fa-plus-circle me-2"></i> Tambah
                    <div class="btn-glow"></div>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Filter & Search Premium -->
    <div class="card premium-card mb-4">
        <div class="card-body p-3">
            <form method="GET" action="<?= BASE_URL ?>/kas-masuk">
                <div class="d-flex flex-column flex-md-row gap-3">
                    <div class="flex-grow-1 search-wrapper">
                        <div class="input-group premium-input">
                            <span class="input-group-text">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Cari nama anggota..." value="<?= $search ?>"
                                   autocomplete="off">
                            <?php if ($search): ?>
                            <button class="btn btn-clear" type="button" onclick="window.location.href='<?= BASE_URL ?>/kas-masuk'">
                                <i class="fas fa-times"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-premium btn-primary-gradient flex-fill flex-md-grow-0" type="submit">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <?php if ($search): ?>
                        <a href="<?= BASE_URL ?>/kas-masuk" class="btn btn-premium btn-outline-premium flex-fill flex-md-grow-0">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>/laporan/kas-masuk" class="btn btn-premium btn-info-gradient flex-fill flex-md-grow-0">
                            <i class="fas fa-chart-bar me-1"></i> Laporan
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Data Table Premium -->
    <div class="card premium-table-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th width="100">Tanggal</th>
                            <th>Nama Anggota</th>
                            <th class="text-center" width="60">Kelas</th>
                            <th class="d-none d-lg-table-cell">Keterangan</th>
                            <th class="text-end" width="100">Jumlah</th>
                            <th class="text-center d-none d-md-table-cell" width="90">Metode</th>
                            <th class="text-center" width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kas_masuk)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state py-5">
                                    <div class="empty-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <h5>Belum Ada Data Kas Masuk</h5>
                                    <p class="text-muted">Mulai dengan menambahkan transaksi baru</p>
                                    <?php if ($this->auth->hasRole([ROLE_ADMIN, ROLE_BENDAHARA])): ?>
                                    <a href="<?= BASE_URL ?>/kas-masuk/create" class="btn btn-premium btn-primary-gradient mt-3">
                                        <i class="fas fa-plus-circle me-2"></i>Tambah Kas Masuk
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php $no = ($pagination['current_page'] - 1) * ITEMS_PER_PAGE + 1; ?>
                            <?php foreach ($kas_masuk as $km): ?>
                            <tr class="transaction-row">
                                <td class="text-center fw-medium"><?= $no++ ?></td>
                                <td>
                                    <div class="date-wrapper">
                                        <span class="date-day"><?= date('d', strtotime($km['tanggal'])) ?></span>
                                        <span class="date-month"><?= date('M', strtotime($km['tanggal'])) ?></span>
                                        <span class="date-year"><?= date('Y', strtotime($km['tanggal'])) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="member-info">
                                        <span class="member-name"><?= $km['nama_anggota'] ?? '-' ?></span>
                                        <!-- Tampilkan info tambahan di mobile -->
                                        <div class="d-block d-lg-none member-meta">
                                            <?= $km['keterangan'] ?? '' ?>
                                            <?php if (!empty($km['metode'])): ?> 
                                                <span class="meta-separator">•</span> 
                                                <span class="badge metode-badge metode-<?= strtolower($km['metode']) ?>">
                                                    <?= $km['metode'] ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge kelas-badge">Kelas <?= $km['kelas'] ?? '-' ?></span>
                                </td>
                                <td class="d-none d-lg-table-cell">
                                    <span class="keterangan"><?= $km['keterangan'] ?? '-' ?></span>
                                </td>
                                <td class="text-end">
                                    <span class="amount amount-in"><?= formatRupiah($km['jumlah']) ?></span>
                                </td>
                                <td class="text-center d-none d-md-table-cell">
                                    <span class="badge metode-badge metode-<?= strtolower($km['metode']) ?>">
                                        <?= $km['metode'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= BASE_URL ?>/kas-masuk/show/<?= $km['id'] ?>" 
                                           class="btn-action btn-info" title="Detail" data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <?php if ($can_edit): ?>
                                        <a href="<?= BASE_URL ?>/kas-masuk/edit/<?= $km['id'] ?>" 
                                           class="btn-action btn-warning" title="Edit" data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($can_delete): ?>
                                        <button onclick="deleteKasMasuk(<?= $km['id'] ?>)" 
                                                class="btn-action btn-danger" title="Hapus" data-bs-toggle="tooltip">
                                            <i class="fas fa-trash"></i>
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
            <?php if ($pagination['last_page'] > 1): ?>
            <div class="pagination-wrapper px-3 py-3 border-top">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                    <div class="pagination-info">
                        <i class="fas fa-info-circle me-1 text-primary"></i>
                        <span class="small text-muted">
                            Menampilkan <span class="fw-semibold"><?= $pagination['from'] ?? 0 ?></span> 
                            - <span class="fw-semibold"><?= $pagination['to'] ?? 0 ?></span> 
                            dari <span class="fw-semibold"><?= $pagination['total'] ?></span> data
                        </span>
                    </div>
                    
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-premium mb-0">
                            <li class="page-item <?= $pagination['current_page'] <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>/kas-masuk?page=<?= $pagination['current_page'] - 1 ?>&search=<?= $search ?>" aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            
                            <?php
                            $start = max(1, $pagination['current_page'] - 2);
                            $end = min($pagination['last_page'], $pagination['current_page'] + 2);
                            
                            if ($start > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>/kas-masuk?page=1&search=<?= $search ?>">1</a>
                                </li>
                                <?php if ($start > 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/kas-masuk?page=<?= $i ?>&search=<?= $search ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($end < $pagination['last_page']): ?>
                                <?php if ($end < $pagination['last_page'] - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>/kas-masuk?page=<?= $pagination['last_page'] ?>&search=<?= $search ?>">
                                        <?= $pagination['last_page'] ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <li class="page-item <?= $pagination['current_page'] >= $pagination['last_page'] ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>/kas-masuk?page=<?= $pagination['current_page'] + 1 ?>&search=<?= $search ?>" aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <?php endif; ?>
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
    --info-light: rgba(23, 162, 184, 0.1);
    --warning-light: rgba(255, 193, 7, 0.1);
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

.btn-info-gradient {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
    box-shadow: 0 4px 15px rgba(23, 162, 184, 0.2);
}

.btn-info-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(23, 162, 184, 0.3);
    color: white;
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
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
    transition: all 0.3s;
}

.premium-card:hover {
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
}

/* Premium Input */
.premium-input {
    display: flex;
    align-items: stretch;
}

.premium-input .input-group-text {
    background: white;
    border: 2px solid #e2e8f0;
    border-right: none;
    border-radius: 12px 0 0 12px;
    color: #667eea;
}

.premium-input .form-control {
    border: 2px solid #e2e8f0;
    border-left: none;
    border-radius: 0 12px 12px 0;
    padding: 0.6rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s;
}

.premium-input .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.btn-clear {
    background: white;
    border: 2px solid #e2e8f0;
    border-left: none;
    border-radius: 0 12px 12px 0;
    color: #94a3b8;
    padding: 0 1rem;
    transition: all 0.3s;
}

.btn-clear:hover {
    color: #667eea;
    background: #f8fafc;
}

/* Premium Table */
.premium-table-card {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.02);
}

.table-premium {
    margin-bottom: 0;
}

.table-premium thead th {
    background: #f8fafc;
    color: #2c3e50;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
    border-bottom: 2px solid #e2e8f0;
}

.table-premium tbody tr {
    transition: all 0.3s;
}

.table-premium tbody tr:hover {
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

/* Member Info */
.member-info {
    display: flex;
    flex-direction: column;
}

.member-name {
    font-weight: 600;
    color: #2c3e50;
    text-decoration: none;
}

.member-name:hover {
    color: #667eea;
}

.member-meta {
    font-size: 0.7rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.meta-separator {
    margin: 0 0.25rem;
    color: #cbd5e1;
}

/* Kelas Badge */
.kelas-badge {
    background: var(--primary-light);
    color: #667eea;
    font-weight: 500;
    padding: 0.3rem 0.8rem;
    border-radius: 30px;
    font-size: 0.7rem;
}

/* Keterangan */
.keterangan {
    font-size: 0.85rem;
    color: #4a5568;
}

/* Amount */
.amount {
    font-size: 0.95rem;
    font-weight: 600;
}

.amount-in {
    color: #28a745;
}

/* Metode Badge */
.metode-badge {
    padding: 0.3rem 0.8rem;
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
    color: #856404;
}

.metode-e-wallet {
    background: var(--success-light);
    color: #28a745;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.3rem;
    justify-content: center;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.2s;
    color: white;
    text-decoration: none;
    cursor: pointer;
}

.btn-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.btn-action i {
    font-size: 0.85rem;
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

/* Pagination Premium */
.pagination-wrapper {
    background: #fafbfc;
}

.pagination-premium {
    gap: 0.3rem;
}

.pagination-premium .page-link {
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    color: #4a5568;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.2s;
    background: white;
}

.pagination-premium .page-item.active .page-link {
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
}

.pagination-premium .page-item:not(.active):not(.disabled) .page-link:hover {
    background: var(--primary-light);
    color: #667eea;
    transform: translateY(-2px);
}

.pagination-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Responsive Breakpoints */
@media (max-width: 768px) {
    .btn-action {
        width: 30px;
        height: 30px;
    }
    
    .btn-action i {
        font-size: 0.8rem;
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
}

@media (max-width: 576px) {
    .btn-action {
        width: 28px;
        height: 28px;
    }
    
    .btn-action i {
        font-size: 0.75rem;
    }
    
    .pagination-premium .page-link {
        padding: 0.3rem 0.6rem;
        font-size: 0.75rem;
    }
    
    .kelas-badge {
        padding: 0.2rem 0.6rem;
        font-size: 0.65rem;
    }
    
    .metode-badge {
        padding: 0.2rem 0.6rem;
        font-size: 0.65rem;
    }
}
</style>

<script>
function deleteKasMasuk(id) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Yakin ingin menghapus data kas masuk ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= BASE_URL ?>/kas-masuk/delete/' + id,
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
                            text: response.message
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
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>