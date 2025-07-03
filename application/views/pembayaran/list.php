<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="<?= base_url('dashboard/santri') ?>">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Pembayaran</span>
                </li>
            </ul>
        </div>
        

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Daftar Tagihan & Riwayat Pembayaran</h4>
                            <div class="card-tools">
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#alurPembayaranModal">
                                    <i class="fas fa-info-circle"></i> Alur Pembayaran
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?= $this->session->flashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table id="pembayaran-table" class="display table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Tagihan</th>
                                        <th>Kategori</th>
                                        <th>Nominal Tagihan</th>
                                        <th>Nominal Bayar</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Status</th>
                                        <th>Tanggal Konfirmasi</th>
                                        <th>Dikonfirmasi Oleh</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($tagihan)): ?>
                                        <?php foreach ($tagihan as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($item->nama_tagihan, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($item->nama_kategori, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>Rp <?= number_format($item->nominal, 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($item->nominal_bayar ?? 0, 0, ',', '.') ?></td>
                                                <td class="<?= strtotime($item->tanggal_jatuh_tempo) < time() && $item->status === 'belum_bayar' ? 'text-danger font-weight-bold' : '' ?>">
                                                    <?= tanggal_indo($item->tanggal_jatuh_tempo) ?>
                                                    <?= strtotime($item->tanggal_jatuh_tempo) < time() && $item->status === 'belum_bayar' ? ' (Lewat)' : '' ?>
                                                </td>
                                                <td>
                                                    <?= isset($item->tanggal_bayar) && !empty($item->tanggal_bayar) ?
                                                        tanggal_waktu_indo($item->tanggal_bayar) : '-' ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    switch ($item->status) {
                                                        case 'belum_bayar':
                                                            echo '<span class="badge badge-danger">Belum Bayar</span>';
                                                            break;
                                                        case 'menunggu_konfirmasi':
                                                            echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                                                            break;
                                                        case 'diterima':
                                                            echo '<span class="badge badge-success">Diterima</span>';
                                                            break;
                                                        case 'ditolak':
                                                            echo '<span class="badge badge-secondary">Ditolak</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="badge badge-info">Unknown</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= isset($item->tanggal_konfirmasi) && !empty($item->tanggal_konfirmasi) ?
                                                        tanggal_waktu_indo($item->tanggal_konfirmasi) : '-' ?>
                                                </td>
                                                <td><?= htmlspecialchars($item->nama_admin ?? '-', ENT_QUOTES, 'UTF-8') ?></td> <!-- PERBAIKAN DI SINI: konfirmasi_by_name -> nama_admin -->
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="<?= base_url('Pembayaran/detail/' . $item->id_pembayaran) ?>" 
                                                           class="btn btn-link btn-info btn-lg" 
                                                           data-bs-toggle="tooltip" 
                                                           title="Detail">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        
                                                        <?php if ($item->status === 'belum_bayar'): ?>
                                                            <a href="<?= base_url('Pembayaran/detail/' . $item->id_pembayaran) ?>" 
                                                               class="btn btn-link btn-primary btn-lg" 
                                                               data-bs-toggle="tooltip" 
                                                               title="Bayar">
                                                                <i class="fa fa-upload"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($item->status === 'ditolak'): ?>
                                                            <a href="<?= base_url('Pembayaran/detail/' . $item->id_pembayaran) ?>" 
                                                               class="btn btn-link btn-primary btn-lg" 
                                                               data-bs-toggle="tooltip" 
                                                               title="Upload Ulang">
                                                                <i class="fa fa-upload"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="11" class="text-center">Tidak ada data tagihan</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alur Pembayaran -->
<div class="modal fade" id="alurPembayaranModal" tabindex="-1" aria-labelledby="alurPembayaranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="alurPembayaranModalLabel">
                    <i class="fas fa-info-circle"></i> Alur Pembayaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h6 class="mb-3 text-info">Langkah-langkah Pembayaran:</h6>
                        
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary">
                                    <span class="text-white font-weight-bold">1</span>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Cek Tagihan</h6>
                                    <p class="timeline-text">
                                        Periksa daftar tagihan yang belum dibayar pada tabel di atas. 
                                        Perhatikan tanggal jatuh tempo untuk menghindari keterlambatan.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning">
                                    <span class="text-white font-weight-bold">2</span>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Klik Detail/Bayar</h6>
                                    <p class="timeline-text">
                                        Klik tombol <i class="fa fa-eye text-info"></i> untuk melihat detail tagihan atau 
                                        <i class="fa fa-upload text-primary"></i> untuk melakukan pembayaran.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success">
                                    <span class="text-white font-weight-bold">3</span>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Upload Bukti Pembayaran</h6>
                                    <p class="timeline-text">
                                        Lakukan transfer sesuai nominal yang tertera, kemudian upload bukti pembayaran 
                                        dalam format JPG, PNG, atau PDF (maksimal 2MB).
                                    </p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info">
                                    <span class="text-white font-weight-bold">4</span>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Menunggu Konfirmasi</h6>
                                    <p class="timeline-text">
                                        Status akan berubah menjadi <span class="badge badge-warning">Menunggu Konfirmasi</span>. 
                                        Admin akan memverifikasi pembayaran Anda dalam 1x24 jam.
                                    </p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success">
                                    <span class="text-white font-weight-bold">5</span>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Pembayaran Selesai</h6>
                                    <p class="timeline-text">
                                        Jika pembayaran valid, status akan berubah menjadi <span class="badge badge-success">Diterima</span>. 
                                        Jika ada masalah, status akan menjadi <span class="badge badge-secondary">Ditolak</span> 
                                        dan Anda perlu upload ulang bukti pembayaran.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Penting:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Pastikan nominal transfer sesuai dengan tagihan yang tertera</li>
                                <li>Simpan bukti pembayaran dalam format yang jelas dan mudah dibaca</li>
                                <li>Hubungi admin jika ada kendala dalam proses pembayaran</li>
                                <li>Perhatikan tanggal jatuh tempo untuk menghindari denda keterlambatan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Hapus konfigurasi DataTables yang lama

        // Initialize tooltips
        if ($.fn.tooltip) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
</script>

<style>
    /* Styling untuk highlight status */
    .bg-danger-light {
        background-color: rgba(255, 0, 0, 0.1);
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1);
    }

    .bg-secondary-light {
        background-color: rgba(108, 117, 125, 0.1);
    }

    /* Meningkatkan keterbacaan tabel */
    #pembayaran-table th {
        vertical-align: middle;
        font-weight: 600;
    }

    #pembayaran-table td {
        vertical-align: middle;
    }

    /* Styling untuk filter dropdown */
    #pembayaran-table_filter {
        margin-bottom: 15px;
    }

    .dataTables_filter {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    /* Timeline Styling */
    .timeline {
        position: relative;
        padding-left: 0;
        margin-left: 20px;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 30px;
        position: relative;
        align-items: flex-start;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 19px;
        top: 45px;
        height: calc(100% + 5px);
        width: 2px;
        background: linear-gradient(to bottom, #dee2e6, #f8f9fa);
        z-index: 1;
    }

    .timeline-marker {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        position: relative;
        z-index: 2;
        font-size: 14px;
        font-weight: bold;
        flex-shrink: 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border: 3px solid #fff;
    }

    .timeline-content {
        flex: 1;
        padding-top: 2px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #e9ecef;
        margin-top: 5px;
    }

    .timeline-title {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        font-size: 16px;
    }

    .timeline-text {
        color: #6c757d;
        margin: 0;
        line-height: 1.6;
        font-size: 14px;
    }

    /* Modal enhancements */
    .modal-header.bg-info {
        border-bottom: none;
        border-radius: 0.375rem 0.375rem 0 0;
    }

    .modal-body {
        padding: 2rem;
    }

    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    /* Alert dalam modal */
    .alert-info {
        border-left: 4px solid #17a2b8;
        background-color: rgba(23, 162, 184, 0.08);
        border-radius: 8px;
        border: none;
    }

    /* Styling untuk content dalam timeline */
    .timeline-content .badge {
        display: inline-block;
        margin: 0 2px;
    }

    .timeline-content i {
        margin: 0 2px;
    }

    /* Responsive timeline untuk mobile */
    @media (max-width: 768px) {
        .timeline {
            margin-left: 10px;
        }
        
        .timeline-marker {
            width: 35px;
            height: 35px;
            font-size: 12px;
            margin-right: 15px;
        }
        
        .timeline-content {
            padding: 12px;
        }
        
        .timeline-item:not(:last-child)::before {
            left: 17px;
        }
    }

    /* Badge styling improvements */
    .badge {
        font-size: 11px;
        padding: 4px 8px;
    }

    /* Button alur pembayaran */
    .card-tools .btn {
        border-radius: 20px;
        padding: 6px 15px;
        font-size: 13px;
        font-weight: 500;
    }

    .card-tools .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
</style>