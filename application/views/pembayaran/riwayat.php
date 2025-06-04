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
                    <a href="<?= base_url('pembayaran') ?>">Pembayaran</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Riwayat Pembayaran</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Riwayat Pembayaran</h4>
                            <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary btn-round">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
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
                            <table id="riwayat-table" class="display table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Tagihan</th>
                                        <th>Kategori</th>
                                        <th>Nominal Tagihan</th>
                                        <th>Nominal Bayar</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Status</th>
                                        <th>Tanggal Konfirmasi</th>
                                        <th>Oleh</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($riwayat)): ?>
                                        <?php foreach ($riwayat as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($item->nama_tagihan, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($item->nama_kategori, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>Rp <?= number_format($item->nominal, 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($item->nominal_bayar, 0, ',', '.') ?></td>
                                                <td><?= date('d M Y H:i', strtotime($item->tanggal_bayar)) ?></td>
                                                <td>
                                                    <?php 
                                                    switch($item->status) {
                                                        case 'menunggu_konfirmasi':
                                                            echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                                                            break;
                                                        case 'diterima':
                                                            echo '<span class="badge badge-success">Diterima</span>';
                                                            break;
                                                        case 'ditolak':
                                                            echo '<span class="badge badge-danger">Ditolak</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="badge badge-info">Unknown</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= ($item->tanggal_konfirmasi) ? date('d M Y H:i', strtotime($item->tanggal_konfirmasi)) : '-' ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($item->confirmed_by ?? '-', ENT_QUOTES, 'UTF-8') ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('Pembayaran/detail/' . $item->id_pembayaran) ?>" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <?php if ($item->status == 'ditolak'): ?>
                                                        <a href="<?= base_url('Pembayaran/detail/' . $item->id_pembayaran) ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Upload Ulang">
                                                            <i class="fa fa-upload"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">Tidak ada riwayat pembayaran</td>
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
        $('#riwayat-table').DataTable({
            responsive: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            order: [[5, 'desc']] // Sortir berdasarkan tanggal bayar (descending)
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>