
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
                    <a href="<?= base_url('kategori') ?>">Kategori Pembayaran</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Edit Kategori</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Form Edit Kategori Pembayaran</h4>
                            <a href="<?= base_url('kategori') ?>" class="btn btn-secondary btn-round">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form id="form-kategori" action="<?= base_url('kategori/update/' . $kategori->id_kategori) ?>" method="POST">
                            <input type="hidden" name="id_kategori" value="<?= $kategori->id_kategori ?>">
                            
                            <div class="form-group">
                                <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" 
                                    placeholder="Masukkan nama kategori" value="<?= htmlspecialchars($kategori->nama_kategori, ENT_QUOTES, 'UTF-8') ?>" 
                                    maxlength="100" required>
                                <small class="form-text text-muted">Contoh: SPP, Uang Gedung, Pengembangan, dll.</small>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" 
                                    rows="3" placeholder="Masukkan deskripsi (opsional)"><?= htmlspecialchars($kategori->deskripsi ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                <small class="form-text text-muted">Deskripsi singkat tentang kategori pembayaran ini.</small>
                            </div>

                            <div class="mt-4 text-right">
                                <button type="reset" class="btn btn-light btn-round">Reset</button>
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="fa fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Form validation
        $('#form-kategori').validate({
            rules: {
                nama_kategori: {
                    required: true,
                    maxlength: 100
                }
            },
            messages: {
                nama_kategori: {
                    required: "Nama kategori wajib diisi",
                    maxlength: "Nama kategori maksimal 100 karakter"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>