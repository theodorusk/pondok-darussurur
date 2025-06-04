
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
                    <a href="<?= base_url('Tagihan') ?>">Manajemen Tagihan</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Detail Tagihan</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Informasi Tagihan</h4>
                            <a href="<?= base_url('Tagihan') ?>" class="btn btn-secondary btn-round">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Nama Tagihan</th>
                                        <td><?= htmlspecialchars($tagihan->nama_tagihan, ENT_QUOTES, 'UTF-8') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td><?= htmlspecialchars($tagihan->nama_kategori, ENT_QUOTES, 'UTF-8') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nominal</th>
                                        <td>Rp <?= number_format($tagihan->nominal, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Mulai</th>
                                        <td><?= tanggal_indo($tagihan->tanggal_mulai) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <td><?= tanggal_indo($tagihan->tanggal_jatuh_tempo) ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Rekening Pembayaran</th>
                                        <td><?= htmlspecialchars($tagihan->nama_bank . ' - ' . $tagihan->no_rekening, ENT_QUOTES, 'UTF-8') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Atas Nama</th>
                                        <td><?= htmlspecialchars($tagihan->atas_nama, ENT_QUOTES, 'UTF-8') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <?php
                                            $today = date('Y-m-d');
                                            if ($today > $tagihan->tanggal_jatuh_tempo) {
                                                echo '<span class="badge badge-danger">Jatuh Tempo</span>';
                                            } elseif ($today == $tagihan->tanggal_jatuh_tempo) {
                                                echo '<span class="badge badge-warning">Hari Ini</span>';
                                            } else {
                                                echo '<span class="badge badge-success">Aktif</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Oleh</th>
                                        <td><?= htmlspecialchars($tagihan->created_by_name, ENT_QUOTES, 'UTF-8') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Pada</th>
                                        <td><?= tanggal_waktu_indo($tagihan->created_at) ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <label for="deskripsi"><strong>Deskripsi Tagihan</strong></label>
                                    <div class="p-3 border rounded">
                                        <?= nl2br(htmlspecialchars($tagihan->deskripsi ?: 'Tidak ada deskripsi', ENT_QUOTES, 'UTF-8')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator-solid"></div>
                        
                        <h4 class="mt-4">Daftar Pembayaran Santri</h4>
                        <div class="table-responsive mt-3">
                            <table id="pembayaran-table" class="display table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Status</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Nominal Bayar</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pembayaran)): ?>
                                        <?php foreach ($pembayaran as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($item->nis, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($item->nama_user, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>
                                                    <?php 
                                                    switch($item->status) {
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
                                                    <?= $item->tanggal_bayar ? tanggal_waktu_indo($item->tanggal_bayar) : '-' ?>
                                                </td>
                                                <td>
                                                    <?= $item->nominal_bayar ? 'Rp ' . number_format($item->nominal_bayar, 0, ',', '.') : '-' ?>
                                                </td>
                                                <td>
                                                    <?php if ($item->status === 'menunggu_konfirmasi'): ?>
                                                        <a href="<?= base_url('Konfirmasi/detail/' . $item->id_pembayaran) ?>" class="btn btn-sm btn-primary">
                                                            <i class="fa fa-check-circle"></i> Konfirmasi
                                                        </a>
                                                    <?php elseif ($item->status === 'belum_bayar'): ?>
                                                        <span class="text-danger">Belum dibayar</span>
                                                    <?php else: ?>
                                                        <a href="<?= base_url('Konfirmasi/detail/' . $item->id_pembayaran) ?>" class="btn btn-sm btn-info">
                                                            <i class="fa fa-eye"></i> Detail
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data pembayaran</td>
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