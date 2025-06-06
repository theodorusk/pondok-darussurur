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
                    <span>Data Pengeluaran</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Daftar Pengeluaran</h4>
                            <a href="<?= base_url('pengeluaran/create') ?>" class="btn btn-primary btn-round">
                                <i class="fa fa-plus"></i> Tambah Pengeluaran
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pengeluaran-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengeluaran</th>
                                        <th>Nominal</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Bukti</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pengeluaran as $index => $row): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars($row->nama_pengeluaran) ?></td>
                                        <td>Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($row->tanggal_pengeluaran)) ?></td>
                                        <td><?= $row->keterangan ? htmlspecialchars($row->keterangan) : '-' ?></td>
                                        <td>
                                            <?php if ($row->bukti_pengeluaran): ?>
                                                <a href="<?= base_url('uploads/bukti_pengeluaran/' . $row->bukti_pengeluaran) ?>" 
                                                   target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fa fa-file"></i> Lihat
                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row->nama_admin) ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="<?= base_url('pengeluaran/detail/' . $row->id_pengeluaran) ?>" data-bs-toggle="tooltip" title="Detail" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('pengeluaran/edit/' . $row->id_pengeluaran) ?>" data-bs-toggle="tooltip" title="Edit" class="btn btn-link btn-warning btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" data-bs-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger btn-lg btn-confirm-delete"
                                                    data-url="<?= base_url('pengeluaran/delete/' . $row->id_pengeluaran) ?>"
                                                    data-title="Hapus Pengeluaran"
                                                    data-text="Apakah Anda yakin ingin menghapus pengeluaran <?= htmlspecialchars($row->nama_pengeluaran, ENT_QUOTES, 'UTF-8') ?>?">
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
    // Inisialisasi DataTable
    $('#pengeluaran-table').DataTable({
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Handle delete button
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        const row = $(this).closest('tr');

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            // Animasi fade out row
                            row.fadeOut(400, function() {
                                $(this).remove();
                            });

                            // Tampilkan pesan sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            // Tampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server'
                        });
                    }
                });
            }
        });
    });
});
</script>