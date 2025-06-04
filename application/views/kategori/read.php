
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
                    <span>Kategori Pembayaran</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Daftar Kategori Pembayaran</h4>
                            <a href="<?= base_url('kategori/create') ?>" class="btn btn-primary btn-round">
                                <i class="fa fa-plus"></i> Tambah Kategori
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
                            <table id="kategori-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Kategori</th>
                                        <th>Deskripsi</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($kategori)): ?>
                                        <?php foreach ($kategori as $index => $item): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($item->nama_kategori, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($item->deskripsi ?: '-', ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>
                                                    <a href="<?= base_url('kategori/edit/' . $item->id_kategori) ?>" 
                                                        class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger btn-confirm-delete" 
                                                        data-url="<?= base_url('kategori/delete/' . $item->id_kategori) ?>"
                                                        data-title="Hapus Kategori Pembayaran"
                                                        data-text="Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan."
                                                        data-toggle="tooltip" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data kategori</td>
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
        $('#kategori-table').DataTable({
            responsive: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>