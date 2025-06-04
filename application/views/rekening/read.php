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
                    <span>Master Data</span>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Manajemen Rekening</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Daftar Rekening</h4>
                            <a href="<?= base_url('rekening/create') ?>" class="btn btn-primary btn-round">
                                <i class="fa fa-plus"></i> Tambah Rekening
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
                            <table id="rekening-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Bank</th>
                                        <th>Nomor Rekening</th>
                                        <th>Atas Nama</th>
                                        <th>Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rekening)): ?>
                                        <?php foreach ($rekening as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($item->nama_bank, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($item->no_rekening, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($item->atas_nama, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-toggle-status <?= $item->is_active ? 'btn-success' : 'btn-secondary' ?>" 
                                                        data-id="<?= $item->id_rekening ?>" 
                                                        data-status="<?= $item->is_active ?>" 
                                                        data-toggle="tooltip" 
                                                        title="<?= $item->is_active ? 'Aktif (klik untuk nonaktifkan)' : 'Nonaktif (klik untuk aktifkan)' ?>">
                                                        <i class="fas <?= $item->is_active ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                                                        <span><?= $item->is_active ? 'Aktif' : 'Nonaktif' ?></span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('rekening/edit/' . $item->id_rekening) ?>" 
                                                        class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger btn-confirm-delete" 
                                                        data-url="<?= base_url('rekening/delete/' . $item->id_rekening) ?>"
                                                        data-title="Hapus Rekening"
                                                        data-text="Apakah Anda yakin ingin menghapus rekening ini? Tindakan ini tidak dapat dibatalkan."
                                                        data-toggle="tooltip" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data rekening</td>
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
        // Initialize DataTable
        $('#rekening-table').DataTable({
            responsive: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Toggle active/inactive status
        $('.btn-toggle-status').on('click', function() {
            const id = $(this).data('id');
            const currentStatus = $(this).data('status');
            const button = $(this);
            
            $.ajax({
                url: '<?= base_url('rekening/toggle/') ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        // Update button appearance
                        if (response.is_active) {
                            button.removeClass('btn-secondary').addClass('btn-success');
                            button.find('i').removeClass('fa-times-circle').addClass('fa-check-circle');
                            button.find('span').text('Aktif');
                            button.attr('title', 'Aktif (klik untuk nonaktifkan)');
                            button.data('status', 1);
                        } else {
                            button.removeClass('btn-success').addClass('btn-secondary');
                            button.find('i').removeClass('fa-check-circle').addClass('fa-times-circle');
                            button.find('span').text('Nonaktif');
                            button.attr('title', 'Nonaktif (klik untuk aktifkan)');
                            button.data('status', 0);
                        }
                        
                        // Reinitialize tooltip
                        button.tooltip('dispose').tooltip();
                        
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message || 'Terjadi kesalahan saat mengubah status'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan pada server'
                    });
                }
            });
        });
    });
</script>