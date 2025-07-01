<div class="container">
    <!-- Header Section -->
    <div class="page-header rounded shadow-sm mb-4 bg-info-gradient">
        <div class="page-inner p-4">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="mb-3 mb-md-0">
                    <h2 class="fw-bold text-white mb-1">Dashboard Santri</h2>
                    <p class="text-white opacity-80 mb-0">Selamat datang, <?= $nama_user ?></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('pembayaran') ?>" class="btn btn-light btn-round d-flex align-items-center">
                        <i class="fas fa-money-check-alt me-2"></i>Lihat Tagihan
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
                <div class="card card-stats card-round h-100 shadow border-0">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-info-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-file-invoice text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Total Tagihan</p>
                            <h4 class="card-title fw-bold mb-0"><?= $total_tagihan ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-stats card-round h-100 shadow border-0">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-success-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-check-circle text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Diterima</p>
                            <h4 class="card-title fw-bold mb-0"><?= $diterima ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-stats card-round h-100 shadow border-0">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-warning-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-clock text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Menunggu Konfirmasi</p>
                            <h4 class="card-title fw-bold mb-0"><?= $menunggu_konfirmasi ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-stats card-round h-100 shadow border-0">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-danger-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-exclamation-triangle text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Belum Dibayar</p>
                            <h4 class="card-title fw-bold mb-0"><?= $belum_bayar ?? 0 ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Grafik & Tagihan -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-transparent py-3">
                        <h5 class="card-title fw-bold mb-0">Status Pembayaran</h5>
                        <p class="card-category text-muted mb-0 mt-1">Distribusi status pembayaran Anda</p>
                    </div>
                    <div class="card-body">
                        <!-- Legend -->
                        <div class="mb-3">
                            <!-- First row of legends -->
                            
                        </div>
                        
                        <div style="position: relative; height: 250px;">
                            <canvas id="paymentStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-transparent py-3">
                        <h5 class="card-title fw-bold mb-0">Tagihan Akan Datang</h5>
                        <p class="card-category text-muted mb-0 mt-1">Tagihan dengan jatuh tempo terdekat</p>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Tagihan</th>
                                        <th>Jatuh Tempo</th>
                                        <th class="text-end pe-3">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($tagihan_akan_datang)): ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted">Tidak ada tagihan yang akan datang</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach($tagihan_akan_datang as $tagihan): ?>
                                        <tr>
                                            <td class="ps-3"><?= $tagihan->nama_tagihan ?? 'Tagihan' ?></td>
                                            <td><?= !empty($tagihan->tanggal_jatuh_tempo) ? date('d M Y', strtotime($tagihan->tanggal_jatuh_tempo)) : '-' ?></td>
                                            <td class="text-end pe-3">Rp <?= number_format($tagihan->nominal ?? 0) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center py-3">
                        <a href="<?= base_url('pembayaran') ?>" class="btn btn-sm btn-primary btn-round px-3">
                            <i class="fas fa-list me-1"></i> Lihat Semua Tagihan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Riwayat Pembayaran -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent py-3">
                        <h5 class="card-title fw-bold mb-0">Riwayat Pembayaran Terbaru</h5>
                        <p class="card-category text-muted mb-0 mt-1">Transaksi pembayaran terakhir Anda</p>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Tanggal</th>
                                        <th>Nominal</th>
                                        <th class="text-end pe-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($riwayat_pembayaran)): ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted">Tidak ada riwayat pembayaran</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach($riwayat_pembayaran as $pembayaran): ?>
                                        <?php if($pembayaran->status != 'belum_bayar'): ?>
                                        <tr>
                                            <td class="ps-3"><?= date('d M Y', strtotime($pembayaran->tanggal_bayar ?? $pembayaran->created_at)) ?></td>
                                            <td>Rp <?= number_format($pembayaran->nominal_bayar ?? $pembayaran->nominal) ?></td>
                                            <td class="text-end pe-3">
                                                <?php
                                                $status_class = '';
                                                $status_text = '';
                                                
                                                switch ($pembayaran->status) {
                                                    case 'diterima':
                                                        $status_class = 'success';
                                                        $status_text = 'Diterima';
                                                        break;
                                                    case 'menunggu_konfirmasi':
                                                        $status_class = 'warning';
                                                        $status_text = 'Menunggu';
                                                        break;
                                                    case 'ditolak':
                                                        $status_class = 'danger';
                                                        $status_text = 'Ditolak';
                                                        break;
                                                    default:
                                                        $status_class = 'secondary';
                                                        $status_text = ucfirst($pembayaran->status);
                                                        break;
                                                }
                                                ?>
                                                <span class="badge bg-<?= $status_class ?> rounded-pill"><?= $status_text ?></span>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center py-3">
                        <a href="<?= base_url('pembayaran') ?>" class="btn btn-sm btn-primary btn-round px-3">
                            <i class="fas fa-history me-1"></i> Lihat Semua Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
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
    overflow: hidden;
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

.bg-success-gradient { background: linear-gradient(135deg, #31ce36 0%, #2bb930 100%); }
.bg-warning-gradient { background: linear-gradient(135deg, #ffad46 0%, #ff9500 100%); }
.bg-danger-gradient { background: linear-gradient(135deg, #f25961 0%, #e8394a 100%); }
.bg-info-gradient { background: linear-gradient(135deg, #48abf7 0%, #0082e7 100%); }

/* Button Styling */
.btn-round {
    border-radius: 30px;
    padding: 0.5rem 1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load Chart.js - ensures it's available
    if (!window.Chart) {
        var script = document.createElement('script');
        script.src = '<?= base_url('assets/js/plugin/chart.js/chart.min.js') ?>';
        script.onload = function() {
            initializeChart();
        };
        script.onerror = function() {
            // Fallback to CDN if local file fails
            var cdnScript = document.createElement('script');
            cdnScript.src = 'https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js';
            cdnScript.onload = function() {
                initializeChart();
            };
            cdnScript.onerror = function() {
                console.error('Failed to load Chart.js');
                document.getElementById('paymentStatusChart').parentElement.innerHTML = 
                    '<div class="alert alert-warning">Failed to load chart library. Please refresh the page.</div>';
            };
            document.head.appendChild(cdnScript);
        };
        document.head.appendChild(script);
    } else {
        initializeChart();
    }
    
    function initializeChart() {
        const ctx = document.getElementById('paymentStatusChart');
        if (!ctx) return;
        
        // Log values for debugging
        console.log('Chart Data:', {
            diterima: <?= $diterima ?? 0 ?>,
            menunggu_konfirmasi: <?= $menunggu_konfirmasi ?? 0 ?>,
            belum_bayar: <?= $belum_bayar ?? 0 ?>,
            ditolak: <?= $ditolak ?? 0 ?>
        });
        
        const diterima = <?= (int)($diterima ?? 0) ?>;
        const menungguKonfirmasi = <?= (int)($menunggu_konfirmasi ?? 0) ?>;
        const belumBayar = <?= (int)($belum_bayar ?? 0) ?>;
        const ditolak = <?= (int)($ditolak ?? 0) ?>;
        
        // Create chart data ensuring all statuses are included
        const chartData = {
            labels: ['Diterima', 'Menunggu Konfirmasi', 'Belum Dibayar', 'Ditolak'],
            datasets: [{
                data: [diterima, menungguKonfirmasi, belumBayar, ditolak],
                backgroundColor: [
                    '#31ce36',  // success - green
                    '#ffad46',  // warning - orange
                    '#6c757d',  // secondary - gray
                    '#f25961'   // danger - red
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        };
        
        // Check if all values are 0, show a message
        const totalItems = diterima + menungguKonfirmasi + belumBayar + ditolak;
        if (totalItems === 0) {
            ctx.parentElement.innerHTML = '<div class="alert alert-info text-center my-5">Belum ada data pembayaran</div>';
            return;
        }
        
        try {
            // Destroy existing chart if any
            if (window.paymentChart) {
                window.paymentChart.destroy();
            }
            
            // Chart options focused on simplicity and reliability
            window.paymentChart = new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // We use a custom legend
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const percentage = Math.round((value / totalItems) * 100);
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        } catch (e) {
            console.error('Chart error:', e);
            ctx.parentElement.innerHTML = '<div class="alert alert-danger">Error displaying chart</div>';
        }
    }
});
</script>