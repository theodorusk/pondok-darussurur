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
                    <span>Detail Pengguna</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title d-flex align-items-center" style="gap: 10px;">
                                <span>Detail Pengguna - <?= htmlspecialchars($pengguna->nama_user, ENT_QUOTES, 'UTF-8') ?></span>
                                <?php if ($pengguna->id_user == $this->session->userdata('id_user')): ?>
                                    <span class="badge badge-info">Akun Anda</span>
                                <?php endif; ?>
                            </h4>
                            <a href="<?= base_url('Pengguna') ?>" class="btn btn-secondary btn-round">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Kolom Foto Profil -->
                            <div class="col-md-3 text-center">
                                <div class="profile-image mb-4">
                                    <?php if ($pengguna->foto_user): ?>
                                        <img src="<?= base_url('uploads/profil/' . $pengguna->foto_user) ?>"
                                            class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                            style="width: 150px; height: 150px; background-color: #f0f0f0;">
                                            <i class="fas fa-user fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h4 class="mb-1"><?= htmlspecialchars($pengguna->nama_user, ENT_QUOTES, 'UTF-8') ?></h4>
                                <span class="badge badge-primary mb-3"><?= htmlspecialchars($pengguna->nama_role, ENT_QUOTES, 'UTF-8') ?></span>
                                
                                <div class="action-buttons mt-3 d-flex justify-content-center" style="gap: 10px;">
                                    <a href="<?= base_url('Pengguna/edit/' . $pengguna->id_user) ?>" class="btn btn-primary">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </a>
                                    <?php if ($pengguna->id_user != $this->session->userdata('id_user')): ?>
                                        <button type="button" class="btn btn-danger btn-confirm-delete"
                                            data-url="<?= base_url('Pengguna/delete/' . $pengguna->id_user) ?>"
                                            data-title="Hapus Pengguna"
                                            data-text="Apakah Anda yakin ingin menghapus pengguna <?= htmlspecialchars($pengguna->nama_user, ENT_QUOTES, 'UTF-8') ?>?">
                                            <i class="fas fa-trash mr-2"></i> Hapus
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Kolom Informasi Utama -->
                            <div class="col-md-5">
                                <div class="profile-details">
                                    <h5 class="section-title mb-3">
                                        <i class="fas fa-id-card mr-2"></i>
                                        <span>Informasi Utama</span>
                                    </h5>

                                    <div class="detail-item">
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Nama Lengkap</div>
                                            <div class="col-sm-8"><?= htmlspecialchars($pengguna->nama_user, ENT_QUOTES, 'UTF-8') ?></div>
                                        </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Email</div>
                                            <div class="col-sm-8">
                                                <a href="mailto:<?= htmlspecialchars($pengguna->email, ENT_QUOTES, 'UTF-8') ?>">
                                                    <?= htmlspecialchars($pengguna->email, ENT_QUOTES, 'UTF-8') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Jenis Kelamin</div>
                                            <div class="col-sm-8">
                                                <?= $pengguna->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="row mb-3">
                                            <div class="col-sm-4 font-weight-bold">Role</div>
                                            <div class="col-sm-8"><?= htmlspecialchars($pengguna->nama_role, ENT_QUOTES, 'UTF-8') ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Data Santri -->
                            <div class="col-md-4">
                                <?php if ($pengguna->id_role == 2 && isset($santri)): ?>
                                    <div class="profile-details">
                                        <h5 class="section-title mb-3">
                                            <i class="fas fa-user-graduate mr-2"></i>
                                            <span>Data Santri</span>
                                        </h5>

                                        <div class="detail-item">
                                            <div class="row mb-3">
                                                <div class="col-sm-5 font-weight-bold">NIS</div>
                                                <div class="col-sm-7"><?= htmlspecialchars($santri->nis, ENT_QUOTES, 'UTF-8') ?></div>
                                            </div>
                                        </div>

                                        <div class="detail-item">
                                            <div class="row mb-3">
                                                <div class="col-sm-5 font-weight-bold">Alamat</div>
                                                <div class="col-sm-7"><?= htmlspecialchars($santri->alamat, ENT_QUOTES, 'UTF-8') ?></div>
                                            </div>
                                        </div>

                                        <div class="detail-item">
                                            <div class="row mb-3">
                                                <div class="col-sm-5 font-weight-bold">No. WhatsApp</div>
                                                <div class="col-sm-7">
                                                    <a href="https://wa.me/<?= preg_replace('/\D/', '', $santri->no_wa) ?>" target="_blank">
                                                        <?= htmlspecialchars($santri->no_wa, ENT_QUOTES, 'UTF-8') ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="detail-item">
                                            <div class="row mb-3">
                                                <div class="col-sm-5 font-weight-bold">Tanggal Lahir</div>
                                                <div class="col-sm-7">
                                                    <?= date('d F Y', strtotime($santri->tanggal_lahir)) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Konfirmasi hapus data
        $('.btn-confirm-delete').click(function() {
            const url = $(this).data('url');
            const title = $(this).data('title');
            const text = $(this).data('text');

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
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

    .profile-image img {
        border: 3px solid #dee2e6;
    }

    .avatar-placeholder {
        border: 3px solid #dee2e6;
    }

    .detail-item {
        margin-bottom: 0.5rem;
    }

    .action-buttons {
        padding-top: 1rem;
    }

    .card-header {
        background: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, .125);
    }

    @media (max-width: 768px) {
        .profile-image {
            margin-bottom: 1.5rem;
        }
        
        .action-buttons {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }
    }
</style>