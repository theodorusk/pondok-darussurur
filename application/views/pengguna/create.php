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
                    <a href="<?= base_url('Pengguna') ?>">Manajemen Pengguna</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Tambah Pengguna</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title d-flex align-items-center" style="gap: 10px;">
                                <span>Tambah Pengguna</span>
                            </h4>
                            <a href="<?= base_url('Pengguna') ?>" class="btn btn-secondary btn-round">
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
                                <h5 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Error!</h5>
                                <hr>
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Perbaiki input berikut:</h5>
                                <hr>
                                <?= validation_errors() ?>
                            </div>
                        <?php endif; ?>

                        <form id="formPengguna" action="<?= base_url('Pengguna/store') ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Kolom Utama -->
                                <div class="col-md-6 border-right">
                                    <h5 class="section-title mb-4 d-flex align-items-center justify-content-between" style="gap: 10px;">
                                        <div>
                                            <i class="fas fa-exclamation-circle text-danger"></i>
                                            <span>Informasi Utama</span>
                                        </div>
                                        <span class="badge badge-light text-danger border border-danger">
                                            <i class="fas fa-asterisk mr-1"></i> Wajib diisi
                                        </span>
                                    </h5>

                                    <div class="form-group">
                                        <label for="nama_user">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_user" name="nama_user" 
                                            value="<?= set_value('nama_user') ?>" required>
                                        <small class="form-text text-muted">Nama lengkap pengguna</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                            value="<?= set_value('email') ?>" required>
                                        <small class="form-text text-muted">Email aktif yang belum terdaftar</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Minimal 6 karakter</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="id_role">Role <span class="text-danger">*</span></label>
                                        <select class="form-control select" id="id_role" name="id_role" required style="width: 100%">
                                            <option value="">-- Pilih Role --</option>
                                            <?php foreach ($roles as $role): ?>
                                                <option value="<?= $role->id_role ?>" <?= set_select('id_role', $role->id_role) ?>>
                                                    <?= htmlspecialchars($role->nama_role, ENT_QUOTES, 'UTF-8') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="form-text text-muted">Hak akses pengguna</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jenis_kelamin_l" name="jenis_kelamin" 
                                                    value="L" <?= set_radio('jenis_kelamin', 'L') ?> required>
                                                <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="jenis_kelamin_p" name="jenis_kelamin" 
                                                    value="P" <?= set_radio('jenis_kelamin', 'P') ?> required>
                                                <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Santri Specific Fields -->
                                    <div id="santriFields" style="display: none;">
                                        <hr>
                                        <h5 class="section-title mb-4">
                                            <i class="fas fa-user-graduate mr-2"></i>
                                            <span>Data Santri</span>
                                        </h5>
                                        
                                        <div class="form-group">
                                            <label for="nis">NIS <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nis" name="nis" 
                                                value="<?= set_value('nis') ?>">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= set_value('alamat') ?></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="no_wa">No. WhatsApp <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="height: 100%; text-align: center;">+62</span>
                                                </div>
                                                <input type="text" class="form-control" id="no_wa" name="no_wa" 
                                                    value="<?= set_value('no_wa') ?>" placeholder="81234567890">
                                            </div>
                                            <small class="form-text text-muted">Masukkan nomor tanpa angka 0 di depan</small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" 
                                                value="<?= set_value('tanggal_lahir') ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Kolom Tambahan -->
                                <div class="col-md-6">
                                    <h5 class="section-title mb-4 d-flex align-items-center" style="gap: 10px;">
                                        <i class="fas fa-info-circle text-primary"></i>
                                        <span>Informasi Tambahan</span>
                                    </h5>

                                    <div class="form-group">
                                        <label for="foto_user">Foto Profil</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto_user" name="foto_user" accept="image/*">
                                            <label class="custom-file-label" for="foto_user">Pilih file...</label>
                                        </div>
                                        <small class="form-text text-muted">Format: JPG/PNG (maks. 2MB)</small>
                                        <div class="preview mt-2" id="userPreview"></div>
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

        // Show/hide santri fields based on role selection
        $('#id_role').change(function() {
            if ($(this).val() == '2') { // ID for santri role
                $('#santriFields').show();
                $('#santriFields').find('input, textarea, select').prop('required', true);
            } else {
                $('#santriFields').hide();
                $('#santriFields').find('input, textarea, select').prop('required', false);
            }
        });

        // Trigger change event on page load if santri role is selected
        <?php if (set_value('id_role') == 2): ?>
            $('#id_role').trigger('change');
        <?php endif; ?>

        // Toggle password visibility
        $('.toggle-password').click(function() {
            const passwordField = $(this).closest('.input-group').find('input');
            const icon = $(this).find('i');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // File input preview
        $('#foto_user').change(function() {
            const previewId = $(this).attr('id') + 'Preview';
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).html(`
                        <div class="alert alert-light">
                            <img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">
                            <p class="mt-2 mb-0">${file.name} (${(file.size/1024).toFixed(2)} KB)</p>
                        </div>
                    `);
                }
                reader.readAsDataURL(file);
            } else {
                $('#' + previewId).html('');
            }
        });

        // Update custom file input label
        $('.custom-file-input').change(function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName || 'Pilih file...');
        });

        // Form validation
        $('#formPengguna').validate({
            rules: {
                nama_user: {
                    required: true,
                    maxlength: 100
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                id_role: {
                    required: true
                },
                jenis_kelamin: {
                    required: true
                },
                nis: {
                    required: function() {
                        return $('#id_role').val() == '2';
                    },
                    maxlength: 20
                },
                alamat: {
                    required: function() {
                        return $('#id_role').val() == '2';
                    }
                },
                no_wa: {
                    required: function() {
                        return $('#id_role').val() == '2';
                    },
                    digits: true
                },
                tanggal_lahir: {
                    required: function() {
                        return $('#id_role').val() == '2';
                    }
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
                password: {
                    required: "Password wajib diisi",
                    minlength: "Password minimal 6 karakter"
                },
                id_role: {
                    required: "Role wajib dipilih"
                },
                jenis_kelamin: {
                    required: "Jenis kelamin wajib dipilih"
                },
                nis: {
                    required: "NIS wajib diisi untuk santri",
                    maxlength: "NIS maksimal 20 karakter"
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

    .custom-file-label::after {
        content: "Browse";
    }

    .card-header {
        background: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, .125);
    }

    .preview img {
        max-width: 100%;
        height: auto;
    }
</style>