<div class="container-fluid px-2 px-sm-3 px-md-4">
    <!-- Page Heading dengan Animasi -->
    <div class="d-flex align-items-center justify-content-between mb-3 mb-md-4">
        <h1 class="page-title">
            <span class="title-gradient">Dashboard</span>
            <small class="title-sub d-block d-sm-inline-block ms-0 ms-sm-2 mt-1 mt-sm-0">Overview & Statistik</small>
        </h1>
    </div>
    
    <!-- Stats Cards Premium -->
    <div class="row g-3 g-md-4">
        <!-- Saldo Kas -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stats-card premium-card card-saldo" data-aos="fade-up" data-aos-delay="100">
                <div class="stats-card-inner">
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-wallet stats-icon"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Saldo Kas</span>
                        <div class="stats-value-wrapper">
                            <span class="stats-value" id="saldo-kas"><?= formatRupiah($ringkasan['saldo_akhir']) ?></span>
                        </div>
                        <div class="stats-footer">
                            <i class="fas fa-clock me-1"></i>
                            <span>Update: <?= date('d/m/Y H:i') ?></span>
                        </div>
                    </div>
                    <div class="stats-bg-pattern"></div>
                </div>
            </div>
        </div>
        
        <!-- Kas Masuk -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stats-card premium-card card-masuk" data-aos="fade-up" data-aos-delay="200">
                <div class="stats-card-inner">
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-arrow-down stats-icon"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Kas Masuk</span>
                        <div class="stats-value-wrapper">
                            <span class="stats-value" id="total-masuk"><?= formatRupiah($ringkasan['total_masuk']) ?></span>
                        </div>
                        <div class="stats-footer">
                            <i class="fas fa-calendar me-1"></i>
                            <span><?= date('F Y') ?></span>
                        </div>
                    </div>
                    <div class="stats-bg-pattern"></div>
                </div>
            </div>
        </div>
        
        <!-- Kas Keluar -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stats-card premium-card card-keluar" data-aos="fade-up" data-aos-delay="300">
                <div class="stats-card-inner">
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-arrow-up stats-icon"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Kas Keluar</span>
                        <div class="stats-value-wrapper">
                            <span class="stats-value" id="total-keluar"><?= formatRupiah($ringkasan['total_keluar']) ?></span>
                        </div>
                        <div class="stats-footer">
                            <i class="fas fa-calendar me-1"></i>
                            <span><?= date('F Y') ?></span>
                        </div>
                    </div>
                    <div class="stats-bg-pattern"></div>
                </div>
            </div>
        </div>
        
        <!-- Total Anggota -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stats-card premium-card card-anggota" data-aos="fade-up" data-aos-delay="400">
                <div class="stats-card-inner">
                    <div class="stats-icon-wrapper">
                        <i class="fas fa-users stats-icon"></i>
                    </div>
                    <div class="stats-content">
                        <span class="stats-label">Total Anggota</span>
                        <div class="stats-value-wrapper">
                            <span class="stats-value" id="total-anggota"><?= $total_anggota ?></span>
                        </div>
                        <div class="stats-footer">
                            <i class="fas fa-graduation-cap me-1"></i>
                            <span>Kelas 7-9</span>
                        </div>
                    </div>
                    <div class="stats-bg-pattern"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart Row Premium -->
    <div class="row g-3 g-md-4 mt-2 mt-md-3">
        <!-- Grafik Keuangan -->
        <div class="col-12 col-lg-8">
            <div class="card premium-chart-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon bg-primary-soft">
                            <i class="fas fa-chart-line text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Grafik Keuangan</h5>
                            <small class="text-muted">Tahun <?= date('Y') ?></small>
                        </div>
                    </div>
                    <div class="chart-legend">
                        <span class="legend-item">
                            <span class="legend-dot bg-success"></span> Kas Masuk
                        </span>
                        <span class="legend-item ms-3">
                            <span class="legend-dot bg-danger"></span> Kas Keluar
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="keuanganChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistik Kelas Premium -->
        <div class="col-12 col-lg-4">
            <div class="card premium-chart-card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon bg-success-soft">
                            <i class="fas fa-chart-pie text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold">Statistik Kelas</h5>
                            <small class="text-muted">Distribusi Anggota</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $kelas7 = 0;
                    $kelas8 = 0;
                    $kelas9 = 0;
                    
                    foreach ($statistik_kelas as $stat) {
                        if ($stat['kelas'] == '7') $kelas7 = $stat['aktif'];
                        elseif ($stat['kelas'] == '8') $kelas8 = $stat['aktif'];
                        elseif ($stat['kelas'] == '9') $kelas9 = $stat['aktif'];
                    }
                    
                    $total = $kelas7 + $kelas8 + $kelas9;
                    $persen7 = $total > 0 ? round(($kelas7 / $total) * 100) : 0;
                    $persen8 = $total > 0 ? round(($kelas8 / $total) * 100) : 0;
                    $persen9 = $total > 0 ? round(($kelas9 / $total) * 100) : 0;
                    ?>
                    
                    <!-- Pie Chart -->
                    <div class="pie-chart-wrapper">
                        <canvas id="kelasChart"></canvas>
                    </div>
                    
                    <!-- Statistik Detail Premium -->
                    <div class="stats-detail mt-4">
                        <div class="detail-item">
                            <div class="d-flex align-items-center mb-2">
                                <span class="color-dot bg-primary"></span>
                                <span class="flex-grow-1 ms-2">Kelas 7</span>
                                <span class="fw-bold"><?= $kelas7 ?> siswa</span>
                                <span class="badge-percentage ms-2"><?= $persen7 ?>%</span>
                            </div>
                            <div class="progress premium-progress">
                                <div class="progress-bar bg-primary" style="width: <?= $persen7 ?>%"></div>
                            </div>
                        </div>
                        
                        <div class="detail-item mt-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="color-dot bg-success"></span>
                                <span class="flex-grow-1 ms-2">Kelas 8</span>
                                <span class="fw-bold"><?= $kelas8 ?> siswa</span>
                                <span class="badge-percentage ms-2"><?= $persen8 ?>%</span>
                            </div>
                            <div class="progress premium-progress">
                                <div class="progress-bar bg-success" style="width: <?= $persen8 ?>%"></div>
                            </div>
                        </div>
                        
                        <div class="detail-item mt-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="color-dot bg-info"></span>
                                <span class="flex-grow-1 ms-2">Kelas 9</span>
                                <span class="fw-bold"><?= $kelas9 ?> siswa</span>
                                <span class="badge-percentage ms-2"><?= $persen9 ?>%</span>
                            </div>
                            <div class="progress premium-progress">
                                <div class="progress-bar bg-info" style="width: <?= $persen9 ?>%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Card -->
                    <div class="total-card mt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Anggota Aktif</span>
                            <span class="total-value"><?= $total ?> siswa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Import Font Premium */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --warning-gradient: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f8fafd;
}

/* Page Title Premium */
.page-title {
    font-size: clamp(1.5rem, 4vw, 2.2rem);
    font-weight: 800;
    line-height: 1.2;
}

.title-gradient {
    background: linear-gradient(135deg, #2c3e50, #3498db);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.title-sub {
    font-size: clamp(0.8rem, 2vw, 1rem);
    font-weight: 400;
    color: #6c757d;
}

/* Premium Stats Cards */
.premium-card {
    position: relative;
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    height: 100%;
}

.premium-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.1);
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
}

.premium-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.premium-card:hover::before {
    opacity: 1;
}

.stats-card-inner {
    position: relative;
    padding: 1.8rem 1.5rem;
    z-index: 1;
}

/* Card Specific Gradients */
.card-saldo { background: linear-gradient(145deg, #667eea, #764ba2); }
.card-masuk { background: linear-gradient(145deg, #f093fb, #f5576c); }
.card-keluar { background: linear-gradient(145deg, #5f2c82, #49a09d); }
.card-anggota { background: linear-gradient(145deg, #4facfe, #00f2fe); }

/* Stats Icon */
.stats-icon-wrapper {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.15);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
    transition: all 0.3s;
}

.premium-card:hover .stats-icon-wrapper {
    transform: scale(1.1) rotate(5deg);
    background: rgba(255,255,255,0.25);
}

.stats-icon {
    font-size: 2rem;
    color: white;
}

/* Stats Content */
.stats-content {
    position: relative;
    z-index: 2;
    color: white;
    padding-right: 80px;
}

.stats-label {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.8;
    margin-bottom: 0.5rem;
    display: block;
}

.stats-value-wrapper {
    margin-bottom: 1rem;
}

.stats-value {
    font-size: clamp(1.5rem, 5vw, 2.2rem);
    font-weight: 800;
    line-height: 1.2;
    display: inline-block;
}

.stats-footer {
    font-size: 0.75rem;
    opacity: 0.7;
    display: flex;
    align-items: center;
}

/* Background Pattern */
.stats-bg-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.1) 0%, transparent 30%);
    opacity: 0.3;
    pointer-events: none;
}

/* Premium Chart Cards */
.premium-chart-card {
    border: none;
    border-radius: 20px;
    background: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s;
    height: 100%;
}

.premium-chart-card:hover {
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    transform: translateY(-3px);
}

.premium-chart-card .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.5rem 1.5rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-primary-soft { background: rgba(102, 126, 234, 0.1); }
.bg-success-soft { background: rgba(40, 167, 69, 0.1); }

.chart-legend {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
}

.legend-item {
    display: flex;
    align-items: center;
}

.legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 6px;
}

/* Chart Wrapper */
.chart-wrapper {
    position: relative;
    height: 250px;
    width: 100%;
}

.pie-chart-wrapper {
    position: relative;
    height: 180px;
    width: 100%;
}

/* Statistik Detail */
.stats-detail {
    padding: 0.5rem;
}

.detail-item {
    margin-bottom: 1rem;
}

.color-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}

/* Premium Progress Bar */
.premium-progress {
    height: 8px;
    border-radius: 10px;
    background-color: #e9ecef;
    overflow: hidden;
}

.premium-progress .progress-bar {
    border-radius: 10px;
    transition: width 1s ease;
}

/* Badge Percentage */
.badge-percentage {
    background: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    color: #495057;
}

/* Total Card */
.total-card {
    background: linear-gradient(145deg, #f8f9fa, #e9ecef);
    padding: 1rem 1.2rem;
    border-radius: 15px;
    border: 1px solid rgba(0,0,0,0.05);
}

.total-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
}

/* Responsive Breakpoints */
@media (max-width: 576px) {
    .stats-card-inner {
        padding: 1.2rem 1rem;
    }
    
    .stats-icon-wrapper {
        width: 45px;
        height: 45px;
        top: 1rem;
        right: 1rem;
    }
    
    .stats-icon {
        font-size: 1.5rem;
    }
    
    .stats-content {
        padding-right: 60px;
    }
    
    .chart-wrapper {
        height: 200px;
    }
    
    .pie-chart-wrapper {
        height: 150px;
    }
    
    .premium-chart-card .card-header {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (min-width: 577px) and (max-width: 768px) {
    .chart-wrapper {
        height: 220px;
    }
    
    .pie-chart-wrapper {
        height: 160px;
    }
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

.premium-card {
    animation: float 6s ease-in-out infinite;
}

.premium-card:nth-child(1) { animation-delay: 0s; }
.premium-card:nth-child(2) { animation-delay: 0.2s; }
.premium-card:nth-child(3) { animation-delay: 0.4s; }
.premium-card:nth-child(4) { animation-delay: 0.6s; }

/* Loading Animation untuk Chart */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.chart-wrapper canvas, .pie-chart-wrapper canvas {
    animation: pulse 3s ease-in-out infinite;
}
</style>

<script>
// Grafik Keuangan Premium
var ctx = document.getElementById('keuanganChart').getContext('2d');
var keuanganChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chart_labels) ?>,
        datasets: [{
            label: 'Kas Masuk',
            data: <?= json_encode($chart_masuk) ?>,
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            borderColor: '#28a745',
            borderWidth: 3,
            tension: 0.3,
            fill: true,
            pointBackgroundColor: '#28a745',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: window.innerWidth < 768 ? 3 : 4,
            pointHoverRadius: window.innerWidth < 768 ? 5 : 6,
        }, {
            label: 'Kas Keluar',
            data: <?= json_encode($chart_keluar) ?>,
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            borderColor: '#dc3545',
            borderWidth: 3,
            tension: 0.3,
            fill: true,
            pointBackgroundColor: '#dc3545',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: window.innerWidth < 768 ? 3 : 4,
            pointHoverRadius: window.innerWidth < 768 ? 5 : 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(255,255,255,0.95)',
                titleColor: '#2c3e50',
                bodyColor: '#6c757d',
                borderColor: '#e9ecef',
                borderWidth: 1,
                padding: 12,
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        label += ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        return label;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.03)'
                },
                ticks: {
                    callback: function(value) {
                        return window.innerWidth < 768 ? 
                            'Rp' + (value/1000) + 'rb' : 
                            'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Pie Chart Premium
var ctx2 = document.getElementById('kelasChart').getContext('2d');
var kelasChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Kelas 7', 'Kelas 8', 'Kelas 9'],
        datasets: [{
            data: [<?= $kelas7 ?? 0 ?>, <?= $kelas8 ?? 0 ?>, <?= $kelas9 ?? 0 ?>],
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
            borderWidth: 0,
            hoverOffset: window.innerWidth < 768 ? 3 : 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: window.innerWidth < 768 ? '65%' : '60%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(255,255,255,0.95)',
                titleColor: '#2c3e50',
                bodyColor: '#6c757d',
                borderColor: '#e9ecef',
                borderWidth: 1,
                padding: 12,
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.raw || 0;
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                        return label + ': ' + value + ' siswa (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Resize handler
window.addEventListener('resize', function() {
    // Update point radius
    keuanganChart.data.datasets[0].pointRadius = window.innerWidth < 768 ? 3 : 4;
    keuanganChart.data.datasets[1].pointRadius = window.innerWidth < 768 ? 3 : 4;
    keuanganChart.options.scales.y.ticks.callback = function(value) {
        return window.innerWidth < 768 ? 
            'Rp' + (value/1000) + 'rb' : 
            'Rp ' + new Intl.NumberFormat('id-ID').format(value);
    };
    keuanganChart.update();
    
    // Update cutout
    kelasChart.options.cutout = window.innerWidth < 768 ? '65%' : '60%';
    kelasChart.update();
});

// Animate progress bars on load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        document.querySelectorAll('.premium-progress .progress-bar').forEach(bar => {
            bar.style.transition = 'width 1.5s ease';
        });
    }, 100);
});
</script>