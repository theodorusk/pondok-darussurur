
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><?= $title ?></h4>
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
                    <a href="<?= base_url('laporan') ?>">Laporan Keuangan</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Detail</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Ringkasan Laporan</h4>
                            <a href="<?= base_url('laporan/print/'.$laporan->id_laporan) ?>" class="btn btn-primary btn-round">
                                <i class="fa fa-print"></i> Cetak Laporan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>ID Laporan</th>
                                        <td>: LAP<?= sprintf('%03d', $laporan->id_laporan) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Periode</th>
                                        <td>: <?= date('d/m/Y', strtotime($laporan->periode_awal)) ?> - 
                                            <?= date('d/m/Y', strtotime($laporan->periode_akhir)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>: <?= htmlspecialchars($laporan->keterangan) ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Total Pemasukan</th>
                                        <td>: Rp <?= number_format($laporan->total_pemasukan, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Pengeluaran</th>
                                        <td>: Rp <?= number_format($laporan->total_pengeluaran, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Saldo Awal</th>
                                        <td>: Rp <?= number_format($laporan->saldo_awal, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Saldo Akhir</th>
                                        <td>: Rp <?= number_format($laporan->saldo_akhir, 0, ',', '.') ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Pemasukan -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Pemasukan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pemasukan-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Tagihan</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pemasukan as $row): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($row->tanggal_pemasukan)) ?></td>
                                        <td><?= $row->nis ?></td>
                                        <td><?= htmlspecialchars($row->nama_santri) ?></td>
                                        <td><?= htmlspecialchars($row->nama_tagihan) ?></td>
                                        <td>Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row->keterangan) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Detail Pengeluaran -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Pengeluaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pengeluaran-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Pengeluaran</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                        <th>Dibuat Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pengeluaran as $row): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($row->tanggal_pengeluaran)) ?></td>
                                        <td><?= htmlspecialchars($row->nama_pengeluaran) ?></td>
                                        <td>Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row->keterangan) ?></td>
                                        <td><?= htmlspecialchars($row->created_by_name) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
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
    $('#pemasukan-table, #pengeluaran-table').DataTable({
        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        }
    });
});
</script>