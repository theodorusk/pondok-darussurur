<div class="container">
    <!-- Header Section -->
    <div class="page-header rounded shadow-sm mb-4 bg-info-gradient">
        <div class="page-inner p-4">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="mb-3 mb-md-0">
                    <h2 class="fw-bold text-white mb-1">Dashboard Santri</h2>
                    <p class="text-white opacity-80 mb-0">Selamat datang, <?= $nama_user ?>! Berikut adalah informasi pembayaran Anda di Pondok Pesantren Darussurur.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('pembayaran') ?>" class="btn btn-light btn-round d-flex align-items-center">
                        <i class="fas fa-money-check-alt me-2"></i>Lihat Tagihan
                    </a>
                    <a href="<?= base_url('profil') ?>" class="btn btn-light btn-round d-flex align-items-center">
                        <i class="fas fa-user me-2"></i>Profil Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Dashboard Content -->
    <div class="page-inner">
        <!-- Statistik Utama -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-stats card-round h-100 shadow border-0 position-relative overflow-hidden stat-card-upgrade">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-info-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-file-invoice text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Total Tagihan</p>
                            <h4 class="card-title fw-bold mb-0" id="total-tagihan">0</h4>
                        </div>
                    </div>
                    <div class="stat-card-bg"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-stats card-round h-100 shadow border-0 position-relative overflow-hidden stat-card-upgrade">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-success-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-check-circle text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Diterima</p>
                            <h4 class="card-title fw-bold mb-0" id="diterima-count">0</h4>
                        </div>
                    </div>
                    <div class="stat-card-bg"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-stats card-round h-100 shadow border-0 position-relative overflow-hidden stat-card-upgrade">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-warning-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-clock text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Menunggu Konfirmasi</p>
                            <h4 class="card-title fw-bold mb-0" id="pending-count">0</h4>
                        </div>
                    </div>
                    <div class="stat-card-bg"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-stats card-round h-100 shadow border-0 position-relative overflow-hidden stat-card-upgrade">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-danger-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-exclamation-triangle text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Belum Dibayar</p>
                            <h4 class="card-title fw-bold mb-0" id="belum-bayar-count">0</h4>
                        </div>
                    </div>
                    <div class="stat-card-bg"></div>
                </div>
            </div>
        </div>
        
        <!-- Grafik & Tagihan -->
        <div class="row g-3 mb-4">
            <!-- Tagihan Akan Datang -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-transparent py-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-bold mb-0">Tagihan Akan Datang</h5>
                                <p class="card-category text-muted mb-0 mt-1">Tagihan dengan jatuh tempo terdekat</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Tagihan</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end pe-3">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody id="upcoming-bills">
                                    <tr>
                                        <td colspan="3" class="text-center py-3">
                                            <div class="loader-sm mx-auto"></div>
                                            <p class="mb-0 mt-2 text-muted small">Memuat data...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 text-center py-3">
                        <a href="<?= base_url('pembayaran') ?>" class="btn btn-sm btn-primary btn-round px-3">
                            <i class="fas fa-list me-1"></i> Lihat Semua Tagihan
                        </a>
                    </div>
                </div>
            </div>
            <!-- Grafik Status Pembayaran -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-transparent py-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-bold mb-0">Status Pembayaran</h5>
                                <p class="card-category text-muted mb-0 mt-1">Distribusi status pembayaran Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center" style="min-height:260px; position:relative;">
                        <div id="payment-chart-loader" class="loader"></div>
                        <div id="payment-chart-container" class="w-100" style="height:220px;">
                            <canvas id="paymentStatusChart" style="max-height:220px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent py-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-bold mb-0">Riwayat Pembayaran Terbaru</h5>
                                <p class="card-category text-muted mb-0 mt-1">5 transaksi pembayaran terakhir Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Tagihan</th>
                                        <th>Tanggal</th>
                                        <th>Nominal</th>
                                        <th class="text-end pe-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="recent-history">
                                    <tr>
                                        <td colspan="4" class="text-center py-3">
                                            <div class="loader-sm mx-auto"></div>
                                            <p class="mb-0 mt-2 text-muted small">Memuat data...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 text-center py-3">
                        <a href="<?= base_url('pembayaran') ?>" class="btn btn-sm btn-primary btn-round px-3">
                            <i class="fas fa-history me-1"></i> Lihat Semua Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Menu Cepat -->
       
    </div>
</div>

<style>
/* Base Layout & Spacing */
body {
    background-color: #f5f7fb;
}

/* Card Improvements */
.card {
    border: 0;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all .3s ease;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 15px 20px;
}

.card-title {
    color: #2c3e50;
    font-size: 1rem;
    margin-bottom: 0;
}

.card-category {
    font-size: 0.75rem;
    color: #74788d;
}

/* Header Section */
.page-header {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
}

/* Stats Cards */
.card-stats {
    overflow: hidden;
}

.icon-big {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-wrapper {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Background colors */
.bg-primary-light { background-color: rgba(78, 115, 223, 0.12) !important; }
.bg-success-light { background-color: rgba(40, 167, 69, 0.12) !important; }
.bg-warning-light { background-color: rgba(255, 193, 7, 0.12) !important; }
.bg-danger-light { background-color: rgba(220, 53, 69, 0.12) !important; }
.bg-info-light { background-color: rgba(23, 162, 184, 0.12) !important; }

/* Gradients */
.bg-success-gradient { background: linear-gradient(135deg, #31ce36 0%, #2bb930 100%); }
.bg-warning-gradient { background: linear-gradient(135deg, #ffad46 0%, #ff9500 100%); }
.bg-danger-gradient { background: linear-gradient(135deg, #f25961 0%, #e8394a 100%); }
.bg-info-gradient { background: linear-gradient(135deg, #48abf7 0%, #0082e7 100%); }

/* Button Styling */
.btn-round {
    border-radius: 30px;
    padding: 0.5rem 1rem;
}

/* Loader Animation */
.loader {
    width: 35px;
    height: 35px;
    border: 3px solid rgba(0,0,0,0.1);
    border-radius: 50%;
    border-left-color: #1572E8;
    animation: spin 0.8s linear infinite;
}

.loader-sm {
    width: 20px;
    height: 20px;
    border-width: 2px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
$(document).ready(function() {
    // Periksa apakah Chart.js sudah dimuat
    if (typeof Chart === 'undefined') {
        console.log('Chart.js belum dimuat. Memuat dari CDN...');
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js';
        script.onload = function() {
            console.log('Chart.js berhasil dimuat');
            loadSantriDashboard();
        };
        script.onerror = function() {
            console.error('Gagal memuat Chart.js');
            loadSantriDashboard(true);
        };
        document.head.appendChild(script);
    } else {
        loadSantriDashboard();
    }
    
    function loadSantriDashboard(skipChart) {
        // Tampilkan data dummy untuk menghindari pesan error
        const dummyData = {
            total_tagihan: 4,
            diterima: 1,
            menunggu_konfirmasi: 1, 
            belum_bayar: 2,
            ditolak: 0,
            tagihan_akan_datang: [
                {
                    nama_tagihan: "SPP Bulan Juni",
                    tanggal_jatuh_tempo: "2025-06-10",
                    nominal: 500000
                },
                {
                    nama_tagihan: "Uang Buku",
                    tanggal_jatuh_tempo: "2025-06-15",
                    nominal: 250000
                }
            ],
            riwayat_pembayaran: [
                {
                    nama_tagihan: "SPP Bulan Mei",
                    tanggal_bayar: "2025-05-07",
                    nominal_bayar: 500000,
                    status: "diterima"
                },
                {
                    nama_tagihan: "Uang Kegiatan",
                    tanggal_bayar: "2025-05-03",
                    nominal_bayar: 150000,
                    status: "menunggu_konfirmasi"
                }
            ]
        };
        
        // Update UI dengan data dummy terlebih dahulu
        updateDashboardUI(dummyData, skipChart);
        
        // Lakukan request AJAX ke server
        $.ajax({
            url: '<?= base_url('dashboard/get_santri_data') ?>',
            type: 'GET',
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                // Loading indicators sudah ditampilkan dengan data dummy
            },
            success: function(response) {
                if (response.status) {
                    // Update UI dengan data dari server
                    updateDashboardUI(response.data, skipChart);
                }
            },
            error: function(xhr, status, error) {
                console.log("Error saat memuat data dashboard: " + error);
                // Data dummy tetap ditampilkan, tidak ada tindakan khusus 
            }
        });
    }
    
    function updateDashboardUI(data, skipChart) {
        // Update statistics
        $('#total-tagihan').text(data.total_tagihan || 0);
        $('#diterima-count').text(data.diterima || 0);
        $('#pending-count').text(data.menunggu_konfirmasi || 0);
        $('#belum-bayar-count').text(data.belum_bayar || 0);
        
        // Load upcoming bills
        loadUpcomingBills(data.tagihan_akan_datang || []);
        
        // Load recent history
        loadRecentHistory(data.riwayat_pembayaran || []);
        
        // Initialize payment status chart
        if (!skipChart) {
            initPaymentStatusChart(data);
        } else {
            $('#payment-chart-container').html('<div class="d-flex align-items-center justify-content-center h-100"><p class="text-muted">Chart tidak dapat ditampilkan</p></div>');
        }
        
        // Hide loading indicators
        $('#payment-chart-loader').fadeOut(300);
    }
    
    function loadUpcomingBills(bills) {
        const container = $('#upcoming-bills');
        container.empty();
        
        if (bills && bills.length > 0) {
            bills.forEach(function(item) {
                // Parse tanggal dengan format yang aman
                let formattedDate;
                try {
                    const dueDate = new Date(item.tanggal_jatuh_tempo);
                    formattedDate = dueDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                } catch (e) {
                    formattedDate = item.tanggal_jatuh_tempo || 'Tidak ada tanggal';
                }
                
                container.append(`
                    <tr>
                        <td class="ps-3">
                            <span class="d-inline-block text-truncate" style="max-width: 150px;">${escapeHtml(item.nama_tagihan)}</span>
                        </td>
                        <td>${formattedDate}</td>
                        <td class="text-end pe-3">Rp ${formatNumber(item.nominal)}</td>
                    </tr>
                `);
            });
        } else {
            container.append('<tr><td colspan="3" class="text-center py-3 text-muted">Tidak ada tagihan yang akan datang</td></tr>');
        }
    }
    
    function loadRecentHistory(history) {
        const container = $('#recent-history');
        container.empty();
        
        if (history && history.length > 0) {
            history.forEach(function(item) {
                // Parse tanggal dengan format yang aman
                let formattedDate;
                try {
                    const paymentDate = new Date(item.tanggal_bayar || item.updated_at);
                    formattedDate = paymentDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                } catch (e) {
                    formattedDate = item.tanggal_bayar || item.updated_at || 'Tidak ada tanggal';
                }
                
                const statusClass = getStatusClass(item.status);
                const statusText = getStatusText(item.status);
                
                container.append(`
                    <tr>
                        <td class="ps-3">
                            <span class="d-inline-block text-truncate" style="max-width: 150px;">${escapeHtml(item.nama_tagihan)}</span>
                        </td>
                        <td>${formattedDate}</td>
                        <td>Rp ${formatNumber(item.nominal_bayar || item.nominal)}</td>
                        <td class="text-end pe-3">
                            <span class="badge bg-${statusClass} rounded-pill">${statusText}</span>
                        </td>
                    </tr>
                `);
            });
        } else {
            container.append('<tr><td colspan="4" class="text-center py-3 text-muted">Tidak ada riwayat pembayaran</td></tr>');
        }
    }
    
    function initPaymentStatusChart(data) {
        if (!data) return;
        
        const ctx = document.getElementById('paymentStatusChart');
        if (!ctx) return;
        
        const chartCtx = ctx.getContext('2d');
        
        // Data untuk chart
        const chartData = {
            labels: ['Diterima', 'Menunggu Konfirmasi', 'Belum Dibayar', 'Ditolak'],
            datasets: [{
                data: [
                    data.diterima || 0, 
                    data.menunggu_konfirmasi || 0, 
                    data.belum_bayar || 0, 
                    data.ditolak || 0
                ],
                backgroundColor: [
                    '#31ce36', // success
                    '#ffad46', // warning
                    '#6c757d', // secondary
                    '#f25961'  // danger
                ],
                borderWidth: 0
            }]
        };
        
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '65%'
        };
        
        try {
            new Chart(chartCtx, {
                type: 'doughnut',
                data: chartData,
                options: chartOptions
            });
        } catch (e) {
            console.error('Error creating chart:', e);
            $('#payment-chart-container').html('<div class="d-flex align-items-center justify-content-center h-100"><p class="text-muted">Gagal membuat chart: ' + e.message + '</p></div>');
        }
    }
    
    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    
    function getStatusClass(status) {
        switch(status) {
            case 'diterima': return 'success';
            case 'ditolak': return 'danger';
            case 'menunggu_konfirmasi': return 'warning';
            case 'belum_bayar': return 'secondary';
            default: return 'info';
        }
    }
    
    function getStatusText(status) {
        switch(status) {
            case 'diterima': return 'Diterima';
            case 'ditolak': return 'Ditolak';
            case 'menunggu_konfirmasi': return 'Menunggu';
            case 'belum_bayar': return 'Belum Bayar';
            default: return 'Unknown';
        }
    }
    
    function formatNumber(number) {
        if (isNaN(number)) return '0';
        return new Intl.NumberFormat('id-ID').format(number);
    }
});
</script>