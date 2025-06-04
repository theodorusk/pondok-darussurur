
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
                    <a href="<?= base_url('rekening') ?>">Manajemen Rekening</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Tambah Rekening</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Form Tambah Rekening</h4>
                            <a href="<?= base_url('rekening') ?>" class="btn btn-secondary btn-round">
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

                        <form id="form-rekening" action="<?= base_url('rekening/store') ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_bank">Nama Bank <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_bank" name="nama_bank" 
                                            placeholder="Masukkan nama bank" maxlength="100" required>
                                        <small class="form-text text-muted">Contoh: BCA, BNI, BRI, Mandiri, dll.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_rekening">Nomor Rekening <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_rekening" name="no_rekening" 
                                            placeholder="Masukkan nomor rekening" maxlength="50" required>
                                        <small class="form-text text-muted">Masukkan nomor rekening tanpa spasi.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="atas_nama">Atas Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="atas_nama" name="atas_nama" 
                                            placeholder="Masukkan nama pemilik rekening" maxlength="100" required>
                                        <small class="form-text text-muted">Nama pemilik rekening sesuai buku tabungan.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="custom-control custom-switch mt-2">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                            <label class="custom-control-label" for="is_active">Aktif</label>
                                            <small class="form-text text-muted">Rekening aktif bisa dipilih untuk pembayaran.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-right">
                                <button type="reset" class="btn btn-light btn-round">Reset</button>
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="fa fa-save"></i> Simpan
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
        $('#form-rekening').validate({
            rules: {
                nama_bank: {
                    required: true,
                    maxlength: 100
                },
                no_rekening: {
                    required: true,
                    maxlength: 50
                },
                atas_nama: {
                    required: true,
                    maxlength: 100
                }
            },
            messages: {
                nama_bank: {
                    required: "Nama bank wajib diisi",
                    maxlength: "Nama bank maksimal 100 karakter"
                },
                no_rekening: {
                    required: "Nomor rekening wajib diisi",
                    maxlength: "Nomor rekening maksimal 50 karakter"
                },
                atas_nama: {
                    required: "Nama pemilik rekening wajib diisi",
                    maxlength: "Nama pemilik rekening maksimal 100 karakter"
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