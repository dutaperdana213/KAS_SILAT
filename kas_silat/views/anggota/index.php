<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Heading Premium -->
    <div class="page-header-wrapper mb-4">
        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
            <div class="header-title">
                <h1 class="page-title">
                    <span class="title-gradient">Data Anggota</span>
                    <span class="title-badge ms-2"><?= $pagination['total'] ?? 0 ?> Total</span>
                </h1>
                <p class="title-sub mb-0">Kelola data anggota ekstrakurikuler silat</p>
            </div>
            <?php if ($can_edit): ?>
            <a href="<?= BASE_URL ?>/anggota/create" class="btn btn-premium btn-primary-gradient w-100 w-sm-auto">
                <i class="fas fa-plus-circle me-2"></i>
                <span>Tambah Anggota</span>
                <div class="btn-glow"></div>
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Filter & Search Premium -->
    <div class="card premium-card mb-4">
        <div class="card-body p-3">
            <form method="GET" action="<?= BASE_URL ?>/anggota">
                <div class="d-flex flex-column flex-md-row gap-3">
                    <div class="flex-grow-1 search-wrapper">
                        <div class="input-group premium-input">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" name="search" 
                                   placeholder="Cari nama atau kelas..." value="<?= $search ?>"
                                   autocomplete="off">
                            <?php if ($search): ?>
                            <button class="btn btn-outline-secondary clear-search" type="button" onclick="window.location.href='<?= BASE_URL ?>/anggota'">
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
                        <a href="<?= BASE_URL ?>/anggota" class="btn btn-premium btn-secondary-gradient flex-fill flex-md-grow-0">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                        <?php endif; ?>
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
                            <th>Nama Anggota</th>
                            <th class="text-center" width="70">Kelas</th>
                            <th class="d-none d-sm-table-cell">Jenis Kelamin</th>
                            <th class="d-none d-md-table-cell">No. HP</th>
                            <th class="text-center" width="80">Status</th>
                            <th class="text-center" width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($anggota)): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state py-5">
                                    <div class="empty-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h5>Belum Ada Data Anggota</h5>
                                    <p class="text-muted">Mulai dengan menambahkan anggota baru</p>
                                    <?php if ($can_edit): ?>
                                    <a href="<?= BASE_URL ?>/anggota/create" class="btn btn-premium btn-primary-gradient mt-3">
                                        <i class="fas fa-plus-circle me-2"></i>Tambah Anggota
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php $no = ($pagination['current_page'] - 1) * ITEMS_PER_PAGE + 1; ?>
                            <?php foreach ($anggota as $a): ?>
                            <tr class="member-row">
                                <td class="text-center fw-medium"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="member-avatar me-2">
                                            <?= strtoupper(substr($a['nama'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <a href="<?= BASE_URL ?>/anggota/show/<?= $a['id'] ?>" class="member-name">
                                                <?= $a['nama'] ?>
                                            </a>
                                            <!-- Tampilkan info tambahan di mobile -->
                                            <div class="d-block d-sm-none member-mobile-info">
                                                <?= $a['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                                <?php if (!empty($a['no_hp'])): ?> • <?= $a['no_hp'] ?><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge kelas-badge bg-soft-primary">
                                        Kelas <?= $a['kelas'] ?>
                                    </span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="gender-icon">
                                        <i class="fas fa-<?= $a['jenis_kelamin'] == 'L' ? 'mars' : 'venus' ?> text-<?= $a['jenis_kelamin'] == 'L' ? 'info' : 'danger' ?> me-1"></i>
                                        <?= $a['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                    </span>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <?php if (!empty($a['no_hp'])): ?>
                                        <span class="phone-number">
                                            <i class="fas fa-phone-alt text-muted me-1"></i>
                                            <?= $a['no_hp'] ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($a['status_aktif']): ?>
                                        <span class="badge status-badge status-active">
                                            <i class="fas fa-circle me-1"></i>Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge status-badge status-inactive">
                                            <i class="fas fa-circle me-1"></i>Non Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?= BASE_URL ?>/anggota/show/<?= $a['id'] ?>" 
                                           class="btn-action btn-info" title="Detail" data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <?php if ($can_edit): ?>
                                        <a href="<?= BASE_URL ?>/anggota/edit/<?= $a['id'] ?>" 
                                           class="btn-action btn-warning" title="Edit" data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($can_delete): ?>
                                        <button onclick="deleteAnggota(<?= $a['id'] ?>, '<?= $a['nama'] ?>')" 
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
                                <a class="page-link" href="<?= BASE_URL ?>/anggota?page=<?= $pagination['current_page'] - 1 ?>&search=<?= $search ?>" aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            
                            <?php
                            $start = max(1, $pagination['current_page'] - 2);
                            $end = min($pagination['last_page'], $pagination['current_page'] + 2);
                            
                            if ($start > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>/anggota?page=1&search=<?= $search ?>">1</a>
                                </li>
                                <?php if ($start > 2): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>/anggota?page=<?= $i ?>&search=<?= $search ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($end < $pagination['last_page']): ?>
                                <?php if ($end < $pagination['last_page'] - 1): ?>
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                <?php endif; ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>/anggota?page=<?= $pagination['last_page'] ?>&search=<?= $search ?>">
                                        <?= $pagination['last_page'] ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <li class="page-item <?= $pagination['current_page'] >= $pagination['last_page'] ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>/anggota?page=<?= $pagination['current_page'] + 1 ?>&search=<?= $search ?>" aria-label="Next">
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
    --warning-light: rgba(255, 193, 7, 0.1);
}

/* Page Header Premium */
.page-header-wrapper {
    margin-bottom: 1.5rem;
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
    font-weight: 500;
    border-radius: 12px;
    transition: all 0.3s;
    z-index: 1;
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

.btn-secondary-gradient {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.2);
}

.btn-secondary-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
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
    overflow: hidden;
}

.premium-card:hover {
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
}

/* Premium Input */
.premium-input .input-group-text {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-right: none;
    border-radius: 12px 0 0 12px;
    padding-left: 1rem;
    padding-right: 1rem;
}

.premium-input .form-control {
    border: 2px solid #e2e8f0;
    border-left: none;
    border-radius: 0 12px 12px 0;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.premium-input .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.clear-search {
    border: 2px solid #e2e8f0;
    border-left: none;
    border-radius: 0 12px 12px 0;
    background: #f8fafc;
    color: #6c757d;
}

.clear-search:hover {
    background: #e2e8f0;
    color: #2c3e50;
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
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 1rem;
    border-bottom: 2px solid #e2e8f0;
}

.table-premium tbody tr {
    transition: all 0.2s;
}

.table-premium tbody tr:hover {
    background: linear-gradient(90deg, var(--primary-light), transparent);
}

/* Member Avatar */
.member-avatar {
    width: 36px;
    height: 36px;
    background: var(--primary-gradient);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 4px 10px rgba(102, 126, 234, 0.2);
}

.member-name {
    color: #2c3e50;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.member-name:hover {
    color: #667eea;
}

.member-mobile-info {
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Kelas Badge */
.kelas-badge {
    background: var(--primary-light);
    color: #667eea;
    font-weight: 500;
    padding: 0.4rem 0.8rem;
    border-radius: 30px;
    font-size: 0.75rem;
}

.bg-soft-primary {
    background: var(--primary-light);
}

/* Gender Icon */
.gender-icon {
    font-size: 0.9rem;
    color: #4a5568;
}

/* Phone Number */
.phone-number {
    font-size: 0.9rem;
    color: #2c3e50;
}

/* Status Badge Premium */
.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.status-badge i {
    font-size: 0.5rem;
}

.status-active {
    background: var(--success-light);
    color: #28a745;
}

.status-inactive {
    background: var(--danger-light);
    color: #dc3545;
}

/* Action Buttons Premium */
.action-buttons {
    display: flex;
    gap: 0.3rem;
    justify-content: center;
}

.btn-action {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.2s;
    color: white;
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
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

.btn-action:active {
    transform: translateY(0);
}

.btn-action i {
    font-size: 0.9rem;
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
.pagination-premium {
    gap: 0.3rem;
}

.pagination-premium .page-item .page-link {
    border: none;
    padding: 0.5rem 0.9rem;
    border-radius: 10px;
    color: #4a5568;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.2s;
    background: transparent;
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

.pagination-premium .page-item.disabled .page-link {
    background: transparent;
    color: #cbd5e1;
}

.pagination-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Responsive Breakpoints */
@media (max-width: 768px) {
    .btn-action {
        width: 32px;
        height: 32px;
    }
    
    .btn-action i {
        font-size: 0.8rem;
    }
    
    .member-avatar {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .btn-action {
        width: 30px;
        height: 30px;
    }
    
    .pagination-premium .page-link {
        padding: 0.4rem 0.7rem;
        font-size: 0.8rem;
    }
    
    .status-badge {
        padding: 0.3rem 0.6rem;
        font-size: 0.7rem;
    }
    
    .kelas-badge {
        padding: 0.3rem 0.6rem;
        font-size: 0.7rem;
    }
}
</style>

<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Auto-hide alert setelah 3 detik
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
});

function deleteAnggota(id, nama) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Yakin ingin menghapus anggota ${nama}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= BASE_URL ?>/anggota/delete/' + id,
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
</script>