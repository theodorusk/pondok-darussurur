
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
                    <span>Profil Saya</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Edit Profil Saya</h4>
                            <a href="<?= base_url('profil/password') ?>" class="btn btn-primary btn-round">
                                <i class="fa fa-key"></i> Ubah Password
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
                                <h5 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Error!</h5>
                                <hr>
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form id="formProfil" action="<?= base_url('profil/update') ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Kolom Utama -->
                                <div class="col-md-6 border-right">
                                    <h5 class="section-title mb-4">
                                        <i class="fas fa-id-card mr-2"></i>
                                        <span>Informasi Utama</span>
                                    </h5>

                                    <div class="form-group">
                                        <label for="nama_user">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_user" name="nama_user" 
                                            value="<?= set_value('nama_user', $pengguna->nama_user) ?>" required>
                                        <small class="form-text text-muted">Nama lengkap Anda</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                            value="<?= set_value('email', $pengguna->email) ?>" required>
                                        <small class="form-text text-muted">Email aktif Anda</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jenis_kelamin_l" name="jenis_kelamin" 
                                                    value="L" <?= set_radio('jenis_kelamin', 'L', $pengguna->jenis_kelamin == 'L') ?> required>
                                                <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jenis_kelamin_p" name="jenis_kelamin" 
                                                    value="P" <?= set_radio('jenis_kelamin', 'P', $pengguna->jenis_kelamin == 'P') ?> required>
                                                <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($pengguna->id_role == 2 && isset($santri)): // Santri fields ?>
                                        <hr>
                                        <h5 class="section-title mb-4">
                                            <i class="fas fa-user-graduate mr-2"></i>
                                            <span>Data Santri</span>
                                        </h5>
                                        
                                        <div class="form-group">
                                            <label>NIS</label>
                                            <input type="text" class="form-control" value="<?= htmlspecialchars($santri->nis, ENT_QUOTES, 'UTF-8') ?>" readonly>
                                            <small class="form-text text-muted">NIS tidak dapat diubah</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required><?= set_value('alamat', $santri->alamat ?? '') ?></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="no_wa">No. WhatsApp <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="height: 100%; text-align: center;">+62</span>
                                                </div>
                                                <input type="text" class="form-control" id="no_wa" name="no_wa" 
                                                    value="<?= set_value('no_wa', $santri->no_wa ?? '') ?>" placeholder="81234567890" required>
                                            </div>
                                            <small class="form-text text-muted">Masukkan nomor tanpa angka 0 di depan</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" 
                                                value="<?= set_value('tanggal_lahir', $santri->tanggal_lahir ?? '') ?>" required>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Kolom Foto -->
                                <div class="col-md-6">
                                    <h5 class="section-title mb-4">
                                        <i class="fas fa-image mr-2"></i>
                                        <span>Foto Profil</span>
                                    </h5>

                                    <div class="form-group text-center mb-4">
                                        <?php if ($pengguna->foto_user): ?>
                                            <img src="<?= base_url('uploads/profil/' . $pengguna->foto_user) ?>" 
                                                class="img-thumbnail rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                                style="width: 200px; height: 200px; background-color: #f0f0f0;">
                                                <i class="fas fa-user fa-5x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="foto_user">Ganti Foto Profil</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_user" name="foto_user" accept="image/*">
                                            <label class="custom-file-label" for="foto_user">Pilih file...</label>
                                        </div>
                                        <small class="form-text text-muted">Format: JPG/PNG (maks. 2MB)</small>
                                        
                                        <?php if ($pengguna->foto_user): ?>
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" id="remove_foto" name="remove_foto">
                                                <label class="form-check-label text-danger" for="remove_foto">
                                                    Hapus foto saat ini
                                                </label>
                                            </div>
                                        <?php else: ?>
                                            <div class="preview mt-3" id="fotoPreview"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-action mt-4 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="fa fa-save mr-2"></i> Simpan Perubahan
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
        // File input preview
        $('#foto_user').change(function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#fotoPreview').html(`
                        <div class="alert alert-light">
                            <img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">
                            <p class="mt-2 mb-0">${file.name} (${(file.size/1024).toFixed(2)} KB)</p>
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            } else {
                $('#fotoPreview').html('');
            }
        });

        // Update custom file input label
        $('.custom-file-input').change(function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName || 'Pilih file...');
        });

        // Form validation
        $('#formProfil').validate({
            rules: {
                nama_user: {
                    required: true,
                    maxlength: 100
                },
                email: {
                    required: true,
                    email: true
                },
                jenis_kelamin: {
                    required: true
                },
                alamat: {
                    required: <?= $pengguna->id_role == 2 ? 'true' : 'false' ?>
                },
                no_wa: {
                    required: <?= $pengguna->id_role == 2 ? 'true' : 'false' ?>,
                    digits: true
                },
                tanggal_lahir: {
                    required: <?= $pengguna->id_role == 2 ? 'true' : 'false' ?>
                }
            },
            messages: {
                nama_user: {
                    required: "Nama lengkap wajib diisi",
                    maxlength: "Nama maksimal 100 karakter"
                },
                email: {
                    required: "Email wajib diisi",
                    email: "Format email tidak valid"
                },
                jenis_kelamin: {
                    required: "Jenis kelamin wajib dipilih"
                },
                alamat: {
                    required: "Alamat wajib diisi untuk santri"
                },
                no_wa: {
                    required: "No. WhatsApp wajib diisi untuk santri",
                    digits: "Hanya boleh berisi angka"
                },
                tanggal_lahir: {
                    required: "Tanggal lahir wajib diisi untuk santri"
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

<style>
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
        margin-bottom: 1.5rem;
    }

    .border-right {
        border-right: 1px solid #eee;
    }

    @media (max-width: 767px) {
        .border-right {
            border-right: none;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
    }

    .custom-file-label::after {
        content: "Browse";
    }
</style>