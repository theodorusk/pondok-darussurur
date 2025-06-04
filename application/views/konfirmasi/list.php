<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Konfirmasi Pembayaran</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Daftar Pembayaran</h4>
                            <a href="<?= base_url('Konfirmasi/laporan') ?>" class="btn btn-info btn-round">
                                <i class="fa fa-file-alt me-2"></i>
                                Laporan Pembayaran
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

                        <ul class="nav nav-pills nav-secondary mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-pending-tab" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected="true">
                                    Menunggu Konfirmasi
                                    <?php if (count($menunggu) > 0): ?>
                                        <span class="badge badge-warning"><?= count($menunggu) ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-approved-tab" data-toggle="pill" href="#pills-approved" role="tab" aria-controls="pills-approved" aria-selected="false">
                                    Diterima
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-rejected-tab" data-toggle="pill" href="#pills-rejected" role="tab" aria-controls="pills-rejected" aria-selected="false">
                                    Ditolak
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Menunggu Konfirmasi Tab -->
                            <div class="tab-pane fade show active" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                                <div class="table-responsive">
                                    <table id="pending-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>NIS</th>
                                                <th>Nama Santri</th>
                                                <th>Tagihan</th>
                                                <th>Kategori</th>
                                                <th>Nominal Tagihan</th>
                                                <th>Nominal Bayar</th>
                                                <th>Tanggal Bayar</th>
                                                <th width="15%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <!-- Tab Menunggu Konfirmasi -->
                                        <tbody>
                                            <?php if (!empty($menunggu)): ?>
                                                <?php foreach ($menunggu as $index => $item): ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= htmlspecialchars($item->nis, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_user, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_tagihan, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_kategori, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td>Rp <?= number_format($item->nominal, 0, ',', '.') ?></td>
                                                        <td>Rp <?= number_format($item->nominal_bayar, 0, ',', '.') ?></td>
                                                        <td><?= tanggal_waktu_indo($item->tanggal_bayar) ?></td>
                                                        <td>
                                                            <a href="<?= base_url('Konfirmasi/detail/' . $item->id_pembayaran) ?>" class="btn btn-primary btn-sm">
                                                                <i class="fa fa-check-circle"></i> Konfirmasi
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada pembayaran yang menunggu konfirmasi</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Diterima Tab -->
                            <div class="tab-pane fade" id="pills-approved" role="tabpanel" aria-labelledby="pills-approved-tab">
                                <div class="table-responsive">
                                    <table id="approved-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>NIS</th>
                                                <th>Nama Santri</th>
                                                <th>Tagihan</th>
                                                <th>Kategori</th>
                                                <th>Nominal Bayar</th>
                                                <th>Tanggal Bayar</th>
                                                <th>Tanggal Konfirmasi</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <!-- Tab Diterima -->
                                        <tbody>
                                            <?php if (!empty($diterima)): ?>
                                                <?php foreach ($diterima as $index => $item): ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= htmlspecialchars($item->nis, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_user, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_tagihan, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_kategori, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td>Rp <?= number_format($item->nominal_bayar, 0, ',', '.') ?></td>
                                                        <td><?= tanggal_waktu_indo($item->tanggal_bayar) ?></td>
                                                        <td><?= tanggal_waktu_indo($item->tanggal_konfirmasi) ?></td>
                                                        <td>
                                                            <a href="<?= base_url('Konfirmasi/detail/' . $item->id_pembayaran) ?>" class="btn btn-info btn-sm">
                                                                <i class="fa fa-eye"></i> Detail
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada pembayaran yang diterima</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Ditolak Tab -->
                            <div class="tab-pane fade" id="pills-rejected" role="tabpanel" aria-labelledby="pills-rejected-tab">
                                <div class="table-responsive">
                                    <table id="rejected-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>NIS</th>
                                                <th>Nama Santri</th>
                                                <th>Tagihan</th>
                                                <th>Kategori</th>
                                                <th>Nominal Bayar</th>
                                                <th>Tanggal Bayar</th>
                                                <th>Tanggal Konfirmasi</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <!-- Tab Ditolak -->
                                        <tbody>
                                            <?php if (!empty($ditolak)): ?>
                                                <?php foreach ($ditolak as $index => $item): ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= htmlspecialchars($item->nis, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_user, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_tagihan, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($item->nama_kategori, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td>Rp <?= number_format($item->nominal_bayar, 0, ',', '.') ?></td>
                                                        <td><?= tanggal_waktu_indo($item->tanggal_bayar) ?></td>
                                                        <td><?= tanggal_waktu_indo($item->tanggal_konfirmasi) ?></td>
                                                        <td>
                                                            <a href="<?= base_url('Konfirmasi/detail/' . $item->id_pembayaran) ?>" class="btn btn-info btn-sm">
                                                                <i class="fa fa-eye"></i> Detail
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada pembayaran yang ditolak</td>
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
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#pending-table, #approved-table, #rejected-table').DataTable({
            responsive: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });

        // Handle tab change - reinitialize tables to fix layout issues
        $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        });
    });
</script>