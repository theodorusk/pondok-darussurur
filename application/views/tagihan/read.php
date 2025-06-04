<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <span>Manajemen Tagihan</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Daftar Tagihan</h4>
                            <a href="<?= base_url('Tagihan/create') ?>" class="btn btn-primary btn-round">
                                <i class="fa fa-plus me-2"></i>
                                Buat Tagihan Baru
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
                            <table id="tagihan-table" class="display table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Tagihan</th>
                                        <th>Kategori</th>
                                        <th>Nominal</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Rekening</th>
                                        <th>Status</th>
                                        <th width="20%">Aksi</th>
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
                                                <td><?= date('d M Y', strtotime($item->tanggal_jatuh_tempo)) ?></td>
                                                <td><?= htmlspecialchars($item->nama_bank . ' - ' . $item->no_rekening, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>
                                                    <?php
                                                    $today = date('Y-m-d');
                                                    if ($today > $item->tanggal_jatuh_tempo) {
                                                        echo '<span class="badge badge-danger">Jatuh Tempo</span>';
                                                    } elseif ($today == $item->tanggal_jatuh_tempo) {
                                                        echo '<span class="badge badge-warning">Hari Ini</span>';
                                                    } else {
                                                        echo '<span class="badge badge-success">Aktif</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <a href="<?= base_url('Tagihan/detail/' . $item->id_tagihan) ?>" data-bs-toggle="tooltip" title="Detail" class="btn btn-link btn-primary btn-lg">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('Tagihan/edit/' . $item->id_tagihan) ?>" data-bs-toggle="tooltip" title="Edit" class="btn btn-link btn-warning btn-lg">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button type="button" data-bs-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger btn-lg btn-confirm-delete"
                                                            data-url="<?= base_url('Tagihan/delete/' . $item->id_tagihan) ?>"
                                                            data-title="Hapus Tagihan"
                                                            data-text="Apakah Anda yakin ingin menghapus tagihan <?= htmlspecialchars($item->nama_tagihan, ENT_QUOTES, 'UTF-8') ?>?">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data tagihan</td>
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
        // Inisialisasi DataTables
        $('#tagihan-table').DataTable({
            responsive: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });

        // Konfirmasi hapus data
        $(document).on('click', '.btn-confirm-delete', function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            const title = $(this).data('title');
            const text = $(this).data('text');
            const row = $(this).closest('tr');

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    row.css('opacity', '0.5');

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                // Animasi penghapusan baris
                                row.fadeOut(400, function() {
                                    $(this).remove();
                                });

                                // Tampilkan notifikasi sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                // Kembalikan opacity jika gagal
                                row.css('opacity', '1');

                                // Tampilkan notifikasi error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Terjadi kesalahan saat menghapus data'
                                });
                            }
                        },
                        error: function(xhr) {
                            row.css('opacity', '1');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghubungi server'
                            });
                        }
                    });
                }
            });
        });
    });
</script>