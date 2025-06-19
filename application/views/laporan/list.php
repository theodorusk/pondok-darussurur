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
                    <span>Laporan Keuangan</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Generate Laporan Baru</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('laporan/generate') ?>" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Periode Awal</label>
                                        <input type="date" name="periode_awal" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Periode Akhir</label>
                                        <input type="date" name="periode_akhir" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <input type="text" name="keterangan" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Generate Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="laporan-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Laporan</th>
                                        <th>Periode</th>
                                        <th>Total Pemasukan</th>
                                        <th>Total Pengeluaran</th>
                                        <th>Saldo Akhir</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($laporan as $row): ?>
                                    <tr>
                                        <td>LAP<?= sprintf('%03d', $row->id_laporan) ?></td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($row->periode_awal)) ?> -
                                            <?= date('d/m/Y', strtotime($row->periode_akhir)) ?>
                                        </td>
                                        <td>Rp <?= number_format($row->total_pemasukan, 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($row->total_pengeluaran, 0, ',', '.') ?></td>
                                        <td>Rp <?= number_format($row->saldo_akhir, 0, ',', '.') ?></td>
                                        <td><?= htmlspecialchars($row->keterangan) ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="<?= base_url('laporan/detail/' . $row->id_laporan) ?>" 
                                                   class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('laporan/print/' . $row->id_laporan) ?>" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Cetak">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                <button type="button" data-bs-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger btn-lg btn-confirm-delete"
                                                    data-url="<?= base_url('laporan/delete/' . $row->id_laporan) ?>"
                                                    data-title="Hapus Laporan"
                                                    data-text="Apakah Anda yakin ingin menghapus laporan ini?">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
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
    $('#laporan-table').DataTable({
        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        order: [[0, 'desc']]
    });
});
</script>