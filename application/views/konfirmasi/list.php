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
                            <!-- <a href="<?= base_url('Konfirmasi/laporan') ?>" class="btn btn-info btn-round">
                                <i class="fa fa-file-alt me-2"></i>
                                Laporan Pembayaran
                            </a> -->
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

                        <div class="col-md-12">
                            <div class="btn-group gap-3" role="group" id="pills-tab">
                                <a href="#pills-pending" class="btn btn-outline-warning btn-round filter-konfirmasi active" data-toggle="pill" role="tab" aria-controls="pills-pending" aria-selected="true">
                                    <i class="fa fa-clock me-2"></i>
                                    Menunggu Konfirmasi
                                    <?php if (!empty($menunggu)): ?>
                                        <span class="badge bg-warning ms-2"><?= count($menunggu) ?></span>
                                    <?php endif; ?>
                                </a>
                                <a href="#pills-approved" class="btn btn-outline-success btn-round filter-konfirmasi" data-toggle="pill" role="tab" aria-controls="pills-approved" aria-selected="false">
                                    <i class="fa fa-check-circle me-2"></i>
                                    Diterima
                                    <?php if (!empty($diterima)): ?>
                                        <span class="badge bg-success ms-2"><?= count($diterima) ?></span>
                                    <?php endif; ?>
                                </a>
                                <a href="#pills-rejected" class="btn btn-outline-danger btn-round filter-konfirmasi" data-toggle="pill" role="tab" aria-controls="pills-rejected" aria-selected="false">
                                    <i class="fa fa-times-circle me-2"></i>
                                    Ditolak
                                    <?php if (!empty($ditolak)): ?>
                                        <span class="badge bg-danger ms-2"><?= count($ditolak) ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>

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
                                                            <div class="form-button-action">
                                                                <a href="<?= base_url('Konfirmasi/detail/' . $item->id_pembayaran) ?>" 
                                                                    class="btn btn-link btn-info btn-lg" 
                                                                    data-bs-toggle="tooltip" 
                                                                    title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </div>
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
                                                            <div class="form-button-action">
                                                                <a href="<?= base_url('Konfirmasi/detail/' . $item->id_pembayaran) ?>" 
                                                                    class="btn btn-link btn-info btn-lg" 
                                                                    data-bs-toggle="tooltip" 
                                                                    title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </div>
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
                                                            <div class="form-button-action">
                                                                <a href="<?= base_url('Konfirmasi/detail/' . $item->id_pembayaran) ?>" 
                                                                    class="btn btn-link btn-info btn-lg" 
                                                                    data-bs-toggle="tooltip" 
                                                                    title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </div>
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

<style>
.btn-round {
    padding: 8px 16px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-round .badge {
    margin-left: 8px;
    font-size: 0.75em;
    padding: 0.4em 0.6em;
    border-radius: 10px;
}

.filter-konfirmasi {
    margin-right: 10px;
}

.filter-konfirmasi.active {
    font-weight: 600;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Badge colors */
.badge.bg-warning {
    background-color: #FFAD46 !important;
}

.badge.bg-success {
    background-color: #31CE36 !important;
}

.badge.bg-danger {
    background-color: #F25961 !important;
}
</style>

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

    $(document).ready(function() {
        // Initialize tooltip with Bootstrap 5
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Filter konfirmasi based on tab
        $('.filter-konfirmasi').on('click', function(e) {
            e.preventDefault();
            $('.filter-konfirmasi').removeClass('active');
            $(this).addClass('active');
            
            const target = $(this).attr('href');
            $('.tab-pane').removeClass('show active');
            $(target).addClass('show active');

            // Reinitialize DataTables
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
        });
    });
</script>