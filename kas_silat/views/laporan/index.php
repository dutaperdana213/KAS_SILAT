<div class="laporan-page">
    <div class="container-fluid px-2 px-sm-3 px-md-4">
        <!-- Page Header Premium -->
        <div class="page-header-wrapper mb-4">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                <div class="header-title">
                    <h1 class="page-title">
                        <span class="title-gradient">Laporan Keuangan</span>
                    </h1>
                    <p class="title-sub mb-0">Analisis transaksi keuangan ekstrakurikuler</p>
                </div>
                <div class="header-decoration">
                    <i class="fas fa-chart-pie"></i>
                    <i class="fas fa-chart-line"></i>
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
        
        <!-- Cards Laporan Premium -->
        <div class="row g-3">
            <!-- Laporan Kas Masuk -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="laporan-card premium-card report-card">
                    <div class="card-body">
                        <!-- Icon dengan ukuran proporsional -->
                        <div class="icon-wrapper success mb-3">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        
                        <h5 class="report-title">Kas Masuk</h5>
                        <p class="report-desc">Laporan pemasukan kas berdasarkan periode</p>
                        
                        <!-- Stat badges sederhana -->
                        <div class="report-stats mb-3">
                            <span class="stat-badge">Harian</span>
                            <span class="stat-badge">Mingguan</span>
                            <span class="stat-badge">Bulanan</span>
                        </div>
                        
                        <a href="<?= BASE_URL ?>/laporan/kas-masuk" class="btn-action btn-report success w-100">
                            <span>Lihat Laporan</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Laporan Kas Keluar -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="laporan-card premium-card report-card">
                    <div class="card-body">
                        <div class="icon-wrapper danger mb-3">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        
                        <h5 class="report-title">Kas Keluar</h5>
                        <p class="report-desc">Laporan pengeluaran kas berdasarkan periode</p>
                        
                        <div class="report-stats mb-3">
                            <span class="stat-badge">Harian</span>
                            <span class="stat-badge">Mingguan</span>
                            <span class="stat-badge">Bulanan</span>
                        </div>
                        
                        <a href="<?= BASE_URL ?>/laporan/kas-keluar" class="btn-action btn-report danger w-100">
                            <span>Lihat Laporan</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Rekap Iuran Anggota -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="laporan-card premium-card report-card">
                    <div class="card-body">
                        <div class="icon-wrapper primary mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        
                        <h5 class="report-title">Rekap Iuran</h5>
                        <p class="report-desc">Rekapitulasi iuran per anggota</p>
                        
                        <div class="report-stats mb-3">
                            <span class="stat-badge">Per Kelas</span>
                            <span class="stat-badge">Total</span>
                            <span class="stat-badge">Riwayat</span>
                        </div>
                        
                        <a href="<?= BASE_URL ?>/laporan/rekap-anggota" class="btn-action btn-report primary w-100">
                            <span>Lihat Rekap</span>
                            <i class="fas fa-arrow-right ms-2"></i>
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Export Premium -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="laporan-card premium-card">
                    <div class="card-header bg-transparent border-0">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-file-export me-2 text-primary"></i>
                            Export Cepat
                        </h6>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small">Jenis Laporan</label>
                                <select class="laporan-select form-select-sm" id="jenis_export">
                                    <option value="kas_masuk">Kas Masuk</option>
                                    <option value="kas_keluar">Kas Keluar</option>
                                    <option value="rekap_anggota">Rekap Anggota</option>
                                </select>
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small">Tanggal Awal</label>
                                <input type="date" class="laporan-date form-control-sm" id="start_date" 
                                       value="<?= date('Y-m-01') ?>">
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small">Tanggal Akhir</label>
                                <input type="date" class="laporan-date form-control-sm" id="end_date" 
                                       value="<?= date('Y-m-t') ?>">
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label small d-none d-md-block">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn-action btn-excel flex-fill" onclick="exportLaporan('excel')">
                                        <i class="fas fa-file-excel me-1"></i> Excel
                                        <div class="btn-glow"></div>
                                    </button>
                                    <button type="button" class="btn-action btn-pdf flex-fill" onclick="exportLaporan('pdf')">
                                        <i class="fas fa-file-pdf me-1"></i> PDF
                                        <div class="btn-glow"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* SEMUA CSS DI-PREFIX DENGAN .laporan-page */
.laporan-page {
    font-family: 'Segoe UI', system-ui, sans-serif;
}

/* Page Header Premium */
.laporan-page .page-header-wrapper {
    margin-bottom: 1.5rem;
}

.laporan-page .page-title {
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    margin-bottom: 0.1rem;
}

.laporan-page .title-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.laporan-page .title-sub {
    color: #6c757d;
    font-size: 0.85rem;
}

.laporan-page .header-decoration {
    display: flex;
    gap: 0.5rem;
}

.laporan-page .header-decoration i {
    width: 36px;
    height: 36px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 1rem;
    animation: laporan-float 3s ease-in-out infinite;
}

.laporan-page .header-decoration i:nth-child(2) {
    animation-delay: 0.2s;
}

.laporan-page .header-decoration i:nth-child(3) {
    animation-delay: 0.4s;
}

/* Premium Card */
.laporan-page .premium-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.3s;
    height: 100%;
    overflow: hidden;
}

.laporan-page .premium-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
}

/* Report Card */
.laporan-page .report-card .card-body {
    padding: 1.5rem 1rem;
    text-align: center;
}

/* Icon Wrapper */
.laporan-page .icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.laporan-page .icon-wrapper.success {
    background: linear-gradient(135deg, #28a745, #34ce57);
    box-shadow: 0 8px 16px rgba(40, 167, 69, 0.25);
}

.laporan-page .icon-wrapper.danger {
    background: linear-gradient(135deg, #dc3545, #ff4d5e);
    box-shadow: 0 8px 16px rgba(220, 53, 69, 0.25);
}

.laporan-page .icon-wrapper.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.25);
}

.laporan-page .icon-wrapper i {
    font-size: 2rem;
    color: white;
}

/* Report Title */
.laporan-page .report-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.3rem;
}

.laporan-page .report-desc {
    color: #6c757d;
    font-size: 0.8rem;
    margin-bottom: 0.8rem;
    line-height: 1.4;
}

/* Stat Badges */
.laporan-page .report-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    justify-content: center;
    margin-bottom: 1.2rem;
}

.laporan-page .stat-badge {
    background: #f8f9fa;
    padding: 0.25rem 0.7rem;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 500;
    color: #495057;
}

/* ===== ACTION BUTTONS PREMIUM ===== */
.laporan-page .btn-action {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.7rem 1.2rem;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    overflow: hidden;
    z-index: 1;
}

/* Report Buttons */
.laporan-page .btn-report {
    min-width: 140px;
}

.laporan-page .btn-report.success {
    background: linear-gradient(135deg, #28a745, #34ce57);
    color: white;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
}

.laporan-page .btn-report.danger {
    background: linear-gradient(135deg, #dc3545, #ff4d5e);
    color: white;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
}

.laporan-page .btn-report.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

/* Export Buttons */
.laporan-page .btn-excel {
    background: linear-gradient(135deg, #28a745, #34ce57);
    color: white;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
}

.laporan-page .btn-pdf {
    background: linear-gradient(135deg, #dc3545, #ff4d5e);
    color: white;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
}

/* Hover Effects */
.laporan-page .btn-report:hover,
.laporan-page .btn-excel:hover,
.laporan-page .btn-pdf:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.laporan-page .btn-report:hover i,
.laporan-page .btn-excel:hover i,
.laporan-page .btn-pdf:hover i {
    transform: scale(1.1);
}

/* Glow Effect */
.laporan-page .btn-glow {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
    z-index: -1;
}

.laporan-page .btn-action:hover .btn-glow {
    left: 100%;
}

/* Icons in buttons */
.laporan-page .btn-action i {
    font-size: 0.9rem;
    transition: transform 0.2s;
}

/* Form Elements */
.laporan-page .form-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.2rem;
    display: block;
    letter-spacing: 0.3px;
}

.laporan-page .laporan-select,
.laporan-page .laporan-date {
    width: 100%;
    font-size: 0.85rem;
    padding: 0.6rem 1rem;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    background: white;
    transition: all 0.2s;
}

.laporan-page .laporan-select:focus,
.laporan-page .laporan-date:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

/* Card Header */
.laporan-page .card-header {
    padding: 1.25rem 1.5rem 0.25rem;
    background: transparent;
}

.laporan-page .card-header h6 {
    font-size: 0.95rem;
    color: #2c3e50;
}

.laporan-page .card-header i {
    color: #667eea;
}

/* Responsive Breakpoints */
@media (min-width: 768px) {
    .laporan-page .icon-wrapper {
        width: 80px;
        height: 80px;
    }
    
    .laporan-page .icon-wrapper i {
        font-size: 2.2rem;
    }
    
    .laporan-page .report-title {
        font-size: 1.3rem;
    }
    
    .laporan-page .report-desc {
        font-size: 0.85rem;
    }
}

@media (max-width: 768px) {
    .laporan-page .icon-wrapper {
        width: 65px;
        height: 65px;
    }
    
    .laporan-page .icon-wrapper i {
        font-size: 1.8rem;
    }
    
    .laporan-page .btn-report {
        min-width: 120px;
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .laporan-page .header-decoration {
        display: none;
    }
    
    .laporan-page .report-card .card-body {
        padding: 1.2rem 0.8rem;
    }
    
    .laporan-page .icon-wrapper {
        width: 55px;
        height: 55px;
    }
    
    .laporan-page .icon-wrapper i {
        font-size: 1.5rem;
    }
    
    .laporan-page .report-title {
        font-size: 1rem;
    }
    
    .laporan-page .report-desc {
        font-size: 0.75rem;
    }
    
    .laporan-page .stat-badge {
        font-size: 0.65rem;
        padding: 0.2rem 0.6rem;
    }
    
    .laporan-page .btn-report {
        padding: 0.5rem 0.8rem;
        font-size: 0.8rem;
        min-width: 100%;
    }
    
    .laporan-page .btn-report i {
        font-size: 0.7rem;
    }
    
    .laporan-page .btn-excel,
    .laporan-page .btn-pdf {
        padding: 0.5rem 0.6rem;
        font-size: 0.75rem;
    }
}

@media (max-width: 375px) {
    .laporan-page .icon-wrapper {
        width: 50px;
        height: 50px;
    }
    
    .laporan-page .icon-wrapper i {
        font-size: 1.3rem;
    }
    
    .laporan-page .report-title {
        font-size: 0.95rem;
    }
}

/* Animation */
@keyframes laporan-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
</style>

<script>
function exportLaporan(jenis) {
    let jenisLaporan = document.getElementById('jenis_export').value;
    let startDate = document.getElementById('start_date').value;
    let endDate = document.getElementById('end_date').value;
    
    // Validasi tanggal
    if (!startDate || !endDate) {
        alert('Harap pilih periode tanggal');
        return;
    }
    
    // Tampilkan loading pada tombol
    let buttons = document.querySelectorAll('.btn-excel, .btn-pdf');
    buttons.forEach(btn => {
        if ((jenis === 'excel' && btn.classList.contains('btn-excel')) ||
            (jenis === 'pdf' && btn.classList.contains('btn-pdf'))) {
            let originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Loading...';
            btn.style.pointerEvents = 'none';
            
            // Redirect ke URL export
            setTimeout(function() {
                window.location.href = '<?= BASE_URL ?>/laporan/export-' + jenis + 
                    '?jenis=' + jenisLaporan + 
                    '&start_date=' + startDate + 
                    '&end_date=' + endDate;
                
                // Kembalikan tombol setelah delay
                setTimeout(function() {
                    btn.innerHTML = originalText;
                    btn.style.pointerEvents = 'auto';
                }, 2000);
            }, 500);
        }
    });
}

// Format tanggal otomatis
document.addEventListener('DOMContentLoaded', function() {
    // Set default date jika kosong
    let startDate = document.getElementById('start_date');
    let endDate = document.getElementById('end_date');
    
    if (!startDate.value) {
        let today = new Date();
        let firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        startDate.value = firstDay.toISOString().split('T')[0];
    }
    
    if (!endDate.value) {
        let today = new Date();
        let lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        endDate.value = lastDay.toISOString().split('T')[0];
    }
});
</script>