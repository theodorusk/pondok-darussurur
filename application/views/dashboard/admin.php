
<div class="container">
    <!-- Header Section -->
    <div class="page-header rounded shadow-sm mb-4 bg-info-gradient">
        <div class="page-inner p-4">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="mb-3 mb-md-0">
                    <h2 class="fw-bold text-white mb-12">Dashboard Admin</h2>
                    <p class="text-white opacity-80 mb-0">Selamat datang, <?= $nama_user ?></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('laporan') ?>" class="btn btn-light btn-round d-flex align-items-center">
                        <i class="fas fa-file-alt me-2"></i>Laporan
                    </a>
                    <a href="<?= base_url('konfirmasi') ?>" class="btn btn-light btn-round d-flex align-items-center">
                        <i class="fas fa-tasks me-2"></i>Konfirmasi
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
                            <i class="fas fa-users text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Total Santri</p>
                            <h4 class="card-title fw-bold mb-0"><?= number_format($santri_count) ?></h4>
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
                            <h4 class="card-title fw-bold mb-0"><?= number_format($menunggu_konfirmasi) ?></h4>
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
                            <p class="card-category mb-1 text-muted small fw-semibold">Belum Bayar</p>
                            <h4 class="card-title fw-bold mb-0"><?= number_format($belum_bayar) ?></h4>
                        </div>
                    </div>
                    <div class="stat-card-bg"></div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-stats card-round h-100 shadow border-0 position-relative overflow-hidden stat-card-upgrade">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="icon-big text-center me-3 rounded-circle bg-success-gradient d-flex align-items-center justify-content-center shadow" style="width:56px;height:56px;">
                            <i class="fas fa-wallet text-white fa-lg"></i>
                        </div>
                        <div>
                            <p class="card-category mb-1 text-muted small fw-semibold">Saldo</p>
                            <h4 class="card-title fw-bold mb-0">Rp <?= number_format($saldo) ?></h4>
                        </div>
                    </div>
                    <div class="stat-card-bg"></div>
                </div>
            </div>
        </div>

    
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-transparent py-3">
                        <h5 class="card-title fw-bold mb-0">Ringkasan Keuangan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success-light me-3 rounded-circle">
                                        <i class="fas fa-arrow-up text-success"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block">Total Pemasukan</span>
                                        <h4 class="mb-0 fw-bold">Rp <?= number_format($total_pemasukan) ?></h4>
                                    </div>
                                </div>
                                <div class="progress mb-1" style="height: 8px">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                </div>
                                <p class="text-muted small">Keseluruhan</p>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-danger-light me-3 rounded-circle">
                                        <i class="fas fa-arrow-down text-danger"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block">Total Pengeluaran</span>
                                        <h4 class="mb-0 fw-bold">Rp <?= number_format($total_pengeluaran) ?></h4>
                                    </div>
                                </div>
                                <div class="progress mb-1" style="height: 8px">
                                    <div class="progress-bar bg-danger" role="progressbar" 
                                        style="width: <?= ($total_pengeluaran / ($total_pemasukan ?: 1)) * 100 ?>%"></div>
                                </div>
                                <p class="text-muted small">Keseluruhan</p>
                            </div>
                        </div>
                        <div class="row g-4 mt-2">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-success-light me-3 rounded-circle">
                                        <i class="fas fa-calendar-check text-success"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block">Pemasukan Bulan Ini</span>
                                        <h5 class="mb-0 fw-bold">Rp <?= number_format($pemasukan_bulan_ini) ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-wrapper bg-danger-light me-3 rounded-circle">
                                        <i class="fas fa-calendar-times text-danger"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block">Pengeluaran Bulan Ini</span>
                                        <h5 class="mb-0 fw-bold">Rp <?= number_format($pengeluaran_bulan_ini) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-transparent py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-bold mb-0">Distribusi Kategori Pembayaran</h5>
                                <p class="card-category text-muted mb-0 mt-1">Berdasarkan total pemasukan</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container position-relative" style="height: 250px">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Chart Bulanan & Pembayaran Terbaru -->
        <div class="row g-3 mb-4">
            <div class="col-lg-8 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-bold mb-0">Statistik Bulanan <?= date('Y') ?></h5>
                                <p class="card-category text-muted mb-0 mt-1">Pemasukan dan pengeluaran per bulan</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container position-relative" style="height: 300px">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-bold mb-0">Pembayaran Terbaru</h5>
                                <p class="card-category text-muted mb-0 mt-1">10 Transaksi terakhir</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Santri</th>
                                        <th>Tagihan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($pembayaran_terbaru)): ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-3">Tidak ada data pembayaran terbaru</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($pembayaran_terbaru as $pembayaran): ?>
                                        <tr>
                                            <td>
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                                    <?= htmlspecialchars($pembayaran->nama_user ?? 'N/A') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;">
                                                    <?= htmlspecialchars($pembayaran->nama_tagihan ?? 'N/A') ?>
                                                </span>
                                            </td>
                                            <td>
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
                                                    case 'belum_bayar':
                                                        $status_class = 'secondary';
                                                        $status_text = 'Belum Bayar';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge bg-<?= $status_class ?> rounded-pill"><?= $status_text ?></span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center py-3">
                        <a href="<?= base_url('konfirmasi') ?>" class="btn btn-sm btn-primary btn-round px-3">
                            <i class="fas fa-list me-1"></i> Lihat Semua Transaksi
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parse data from PHP
    let categoryData = JSON.parse('<?= $category_data ?>');
    let monthlyData = JSON.parse('<?= $monthly_data ?>');
    
    // Initialize Category Distribution Chart
    if (document.getElementById('categoryChart')) {
        let ctxCategory = document.getElementById('categoryChart').getContext('2d');
        let categoryChart = new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: categoryData.labels,
                datasets: [{
                    data: categoryData.values,
                    backgroundColor: categoryData.colors,
                    borderWidth: 0
                }]
            },
            options: {
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
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                let percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: Rp ${value.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }
    
    // Initialize Monthly Chart
    if (document.getElementById('monthlyChart')) {
        let ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        let monthlyChart = new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: monthlyData.months,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: monthlyData.income,
                        backgroundColor: 'rgba(40, 167, 69, 0.4)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: monthlyData.expense,
                        backgroundColor: 'rgba(220, 53, 69, 0.4)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + ' JT';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + ' RB';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.raw || 0;
                                return label + ': Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>