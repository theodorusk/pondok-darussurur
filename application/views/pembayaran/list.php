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
</style>