    </div> <!-- end main-content -->
    
    <footer class="footer premium-footer">
        <div class="container-fluid px-2 px-sm-3 px-md-4">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-6 text-center text-md-start">
                    <div class="footer-info">
                        <p class="mb-0 footer-copyright">
                            <i class="fas fa-copyright me-1"></i>
                            <?= date('Y') ?> <span class="fw-bold gradient-text"><?= SCHOOL_NAME ?></span>
                            <span class="separator d-none d-sm-inline">|</span>
                            <span class="d-block d-sm-inline mt-1 mt-sm-0"><?= PERGURUAN ?></span>
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end">
                    <div class="footer-version">
                        <p class="mb-0">
                            <i class="fas fa-code-branch me-1"></i>
                            <span class="version-badge">v1.0.0</span>
                            <span class="separator mx-2 d-none d-sm-inline">•</span>
                            <span class="d-block d-sm-inline mt-1 mt-sm-0">
                                <i class="fas fa-heart text-danger me-1"></i>
                                <span class="text-muted">Sistem Kas Silat</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Footer Stats (Mobile Only) -->
            <div class="row d-md-none mt-3">
                <div class="col-12">
                    <div class="footer-stats">
                        <div class="stats-wrapper">
                            <div class="stat-item">
                                <i class="fas fa-users text-primary"></i>
                                <span class="stat-label">Online</span>
                                <span class="stat-value">1</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-clock text-success"></i>
                                <span class="stat-label">Uptime</span>
                                <span class="stat-value">99.9%</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-shield-alt text-warning"></i>
                                <span class="stat-label">Secure</span>
                                <span class="stat-value">SSL</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Back to Top Button -->
        <button id="backToTop" class="back-to-top" title="Kembali ke atas">
            <i class="fas fa-arrow-up"></i>
        </button>
    </footer>
</div> <!-- end content -->

<!-- Scripts dengan loading optimal -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Custom JS -->
<script src="<?= BASE_URL ?>/assets/js/main.js"></script>

<script>
$(document).ready(function() {
    // ======================================================
    // SIDEBAR TOGGLE - Premium Version
    // ======================================================
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
        
        // Save state to localStorage
        let sidebarState = $('#sidebar').hasClass('active') ? 'active' : 'inactive';
        localStorage.setItem('sidebarState', sidebarState);
        
        // Add animation class
        $(this).find('i').toggleClass('fa-chevron-right fa-chevron-left');
    });
    
    // Check saved sidebar state
    let savedSidebarState = localStorage.getItem('sidebarState');
    if (savedSidebarState === 'active') {
        $('#sidebar').addClass('active');
        $('#content').addClass('active');
        $('#sidebarCollapse i').removeClass('fa-chevron-right').addClass('fa-chevron-left');
    }
    
    // ======================================================
    // BACK TO TOP BUTTON - Premium
    // ======================================================
    let backToTop = $('#backToTop');
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            backToTop.addClass('show');
        } else {
            backToTop.removeClass('show');
        }
    });
    
    backToTop.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 600, 'swing');
    });
    
    // ======================================================
    // AUTO-HIDE ALERT - Premium dengan animasi
    // ======================================================
    if ($('.alert').length > 0) {
        setTimeout(function() {
            $('.alert').fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // ======================================================
    // TOOLTIPS INITIALIZATION - Premium
    // ======================================================
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            animation: true,
            delay: { show: 300, hide: 100 },
            placement: 'top'
        });
    });
    
    // ======================================================
    // POPOVERS INITIALIZATION
    // ======================================================
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            animation: true,
            trigger: 'hover'
        });
    });
    
    // ======================================================
    // CURRENCY FORMATTER - Premium
    // ======================================================
    $('.currency-input').on('keyup', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value) {
            let formatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value);
            $(this).val(formatted.replace('Rp', '').trim());
        }
    });
    
    // ======================================================
    // DATATABLES INITIALIZATION - Premium dengan konfigurasi lengkap
    // ======================================================
    if ($('.datatable').length > 0) {
        $('.datatable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json',
                search: '<i class="fas fa-search"></i>',
                searchPlaceholder: 'Cari...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                infoFiltered: '(difilter dari _MAX_ total data)',
                zeroRecords: 'Tidak ada data ditemukan',
                emptyTable: 'Tidak ada data tersedia',
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    previous: '<i class="fas fa-angle-left"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>'
                }
            },
            pageLength: 10,
            responsive: true,
            scrollX: false,
            autoWidth: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            initComplete: function() {
                // Add custom styling to search input
                $('.dataTables_filter input').addClass('form-control form-control-sm');
                $('.dataTables_filter input').attr('placeholder', 'Cari...');
            }
        });
    }
    
    // ======================================================
    // NUMBER ONLY INPUT
    // ======================================================
    $('.number-only').on('keypress', function(e) {
        let charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    });
    
    // ======================================================
    // PREVENT DOUBLE SUBMIT
    // ======================================================
    $('form').on('submit', function() {
        let btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-pulse me-1"></i> Memproses...');
    });
    
    // ======================================================
    // CONFIRM DELETE - Premium dengan SweetAlert
    // ======================================================
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        let name = $(this).data('name') || 'item ini';
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: `Data <strong>${name}</strong> akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
            background: $('#sidebar').hasClass('active') ? '#2d3748' : '#fff',
            backdrop: `
                rgba(0,0,0,0.4)
                url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 24 24' fill='%23e74c3c' opacity='0.1'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z'/></svg>")
                left top
                no-repeat
            `
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
    
    // ======================================================
    // LAZY LOAD IMAGES
    // ======================================================
    if ('IntersectionObserver' in window) {
        let lazyImages = document.querySelectorAll('img[data-src]');
        let imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    let img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    }
    
    // ======================================================
    // DETECT MOBILE DEVICE
    // ======================================================
    function isMobileDevice() {
        return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
    }
    
    if (isMobileDevice()) {
        $('body').addClass('mobile-device');
        // Adjust touch targets
        $('.btn, .nav-link, .dropdown-item').addClass('touch-target');
    }
    
    // ======================================================
    // PREVENT ZOOM ON INPUT FOCUS (Mobile)
    // ======================================================
    if (window.innerWidth <= 768) {
        $('input, select, textarea').on('focus', function() {
            $('meta[name=viewport]').attr('content', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');
        }).on('blur', function() {
            $('meta[name=viewport]').attr('content', 'width=device-width, initial-scale=1, user-scalable=yes');
        });
    }
    
    // ======================================================
    // ACTIVE PAGE HIGHLIGHT
    // ======================================================
    let currentUrl = window.location.pathname;
    $('#sidebar a').each(function() {
        let linkUrl = $(this).attr('href');
        if (currentUrl.includes(linkUrl) && linkUrl !== '') {
            $(this).closest('li').addClass('active');
        }
    });
    
    // ======================================================
    // CHART INITIALIZATION (if exists)
    // ======================================================
    if ($('#dashboardChart').length > 0) {
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Kas Masuk',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Kas Keluar',
                    data: [2, 3, 20, 5, 1, 4],
                    borderColor: '#e74c3c',
                    backgroundColor: 'rgba(231, 76, 60, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});
</script>

<!-- Service Worker untuk offline capability (optional) -->
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
            console.log('ServiceWorker registered');
        }, function(err) {
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}
</script>

<!-- Page Load Progress -->
<div class="loading-progress" id="loadingProgress">
    <div class="progress-bar"></div>
</div>

<style>
/* ======================================================
   PREMIUM FOOTER STYLES
   ====================================================== */
.premium-footer {
    position: relative;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-top: 1px solid rgba(102, 126, 234, 0.1);
    padding: 1.5rem 0;
    margin-top: auto;
    box-shadow: 0 -5px 20px rgba(0,0,0,0.02);
}

/* Dark mode footer */
@media (prefers-color-scheme: dark) {
    .premium-footer {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        border-top: 1px solid rgba(255,255,255,0.05);
    }
    
    .footer-copyright, .footer-version {
        color: #a0aec0;
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -moz-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        -moz-text-fill-color: transparent;
        color: transparent;
    }
}

.footer-copyright {
    font-size: 0.9rem;
    color: #4a5568;
}

.footer-version {
    font-size: 0.9rem;
    color: #4a5568;
}

.separator {
    color: #cbd5e0;
    margin: 0 0.5rem;
}

.version-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    display: inline-block;
    box-shadow: 0 2px 5px rgba(102, 126, 234, 0.3);
}

/* Footer Stats (Mobile) */
.footer-stats {
    border-top: 1px solid rgba(102, 126, 234, 0.1);
    padding-top: 1rem;
    margin-top: 0.5rem;
}

.stats-wrapper {
    display: flex;
    justify-content: space-around;
    align-items: center;
    gap: 0.5rem;
}

.stat-item {
    text-align: center;
    flex: 1;
    padding: 0.5rem;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.stat-item i {
    font-size: 1rem;
    margin-bottom: 0.2rem;
    display: block;
}

.stat-label {
    display: block;
    font-size: 0.65rem;
    color: #718096;
    margin-bottom: 0.1rem;
}

.stat-value {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #2d3748;
}

/* Back to Top Button */
.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 999;
    border: 2px solid transparent;
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    border-color: rgba(255,255,255,0.3);
}

.back-to-top:active {
    transform: translateY(0) scale(0.95);
}

/* Loading Progress */
.loading-progress {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
    background-size: 200% 100%;
    animation: loading 2s linear infinite;
    z-index: 9999;
    display: none;
}

.loading-progress.active {
    display: block;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Touch targets for mobile */
.touch-target {
    min-height: 44px;
    min-width: 44px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .premium-footer {
        padding: 1rem 0;
    }
    
    .footer-copyright, .footer-version {
        font-size: 0.8rem;
    }
    
    .version-badge {
        font-size: 0.7rem;
        padding: 0.15rem 0.5rem;
    }
    
    .back-to-top {
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .separator.d-none {
        display: none !important;
    }
}

@media (max-width: 576px) {
    .premium-footer {
        padding: 0.75rem 0;
    }
    
    .footer-copyright, .footer-version {
        font-size: 0.75rem;
        line-height: 1.4;
    }
    
    .version-badge {
        font-size: 0.65rem;
        padding: 0.1rem 0.4rem;
    }
    
    .stat-item i {
        font-size: 0.9rem;
    }
    
    .stat-label {
        font-size: 0.6rem;
    }
    
    .stat-value {
        font-size: 0.7rem;
    }
}

@media (max-width: 375px) {
    .footer-copyright, .footer-version {
        font-size: 0.7rem;
    }
    
    .back-to-top {
        bottom: 15px;
        right: 15px;
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
}

/* Landscape mode */
@media (max-height: 500px) and (orientation: landscape) {
    .back-to-top {
        bottom: 15px;
        right: 15px;
        width: 35px;
        height: 35px;
    }
}

/* Print styles */
@media print {
    .back-to-top, .footer-stats, .loading-progress {
        display: none !important;
    }
    
    .premium-footer {
        border-top: 1px solid #000;
        background: none;
        box-shadow: none;
    }
}
</style>

<!-- Initialize loading progress -->
<script>
// Show loading progress on AJAX requests
$(document).ajaxStart(function() {
    $('#loadingProgress').addClass('active');
}).ajaxStop(function() {
    $('#loadingProgress').removeClass('active');
});

// Show on page navigation
window.addEventListener('beforeunload', function() {
    $('#loadingProgress').addClass('active');
});

window.addEventListener('load', function() {
    $('#loadingProgress').removeClass('active');
});
</script>

</body>
</html>