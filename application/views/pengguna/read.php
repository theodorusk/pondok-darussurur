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
                    <span>Manajemen Pengguna</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-0">
                        <div class="row row-nav-line align-items-center p-3">
                            <div class="col-md-8">
                                <div class="btn-group gap-3" role="group">
                                    <a href="#" class="btn btn-outline-primary btn-round filter-pengguna active" data-target="all">
                                        <i class="fa fa-users me-2"></i> 
                                        Semua Pengguna
                                        <span class="badge bg-primary ms-2" id="total-count">0</span>
                                    </a>
                                    <a href="#" class="btn btn-outline-success btn-round filter-pengguna" data-target="santri">
                                        <i class="fa fa-user-graduate me-2"></i> 
                                        Santri
                                        <span class="badge bg-success ms-2" id="santri-count">0</span>
                                    </a>
                                    <a href="#" class="btn btn-outline-info btn-round filter-pengguna" data-target="admin">
                                        <i class="fa fa-user-shield me-2"></i> 
                                        Admin
                                        <span class="badge bg-info ms-2" id="admin-count">0</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end">
                                <a href="<?= base_url('Pengguna/create') ?>" class="btn btn-primary btn-round">
                                    <i class="fa fa-plus me-2"></i>
                                    Tambah Pengguna
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="tab-content mt-3">
                            <!-- All Users Tab -->
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="allTable" class="display table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th width="20%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($pengguna)): ?>
                                                <?php foreach ($pengguna as $index => $user): ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td>
                                                            <?= htmlspecialchars($user->nama_user, ENT_QUOTES, 'UTF-8') ?>
                                                            <?php if ($user->id_user == $this->session->userdata('id_user')): ?>
                                                                <span class="badge badge-info">Anda</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td><?= htmlspecialchars($user->nama_role, ENT_QUOTES, 'UTF-8') ?></td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <a href="<?= base_url('Pengguna/detail/' . $user->id_user) ?>" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                <a href="<?= base_url('Pengguna/edit/' . $user->id_user) ?>" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <?php if ($user->id_user != $this->session->userdata('id_user')): ?>
                                                                    <button type="button" data-bs-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger btn-lg btn-confirm-delete"
                                                                        data-url="<?= base_url('Pengguna/delete/' . $user->id_user) ?>"
                                                                        data-title="Hapus Pengguna"
                                                                        data-text="Apakah Anda yakin ingin menghapus pengguna <?= htmlspecialchars($user->nama_user, ENT_QUOTES, 'UTF-8') ?>?">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data pengguna</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Santri Tab -->
                            <div class="tab-pane fade" id="santri" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="santriTable" class="display table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>NIS</th>
                                                <th width="20%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $santriCount = 0;
                                            if (!empty($pengguna)):
                                                foreach ($pengguna as $user):
                                                    if ($user->id_role == 2): // Filter for santri role
                                                        $santriCount++;
                                                        $santriData = $this->M_santri->get_by_user($user->id_user);
                                            ?>
                                                        <tr>
                                                            <td><?= $santriCount ?></td>
                                                            <td><?= htmlspecialchars($user->nama_user, ENT_QUOTES, 'UTF-8') ?></td>
                                                            <td><?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8') ?></td>
                                                            <td><?= isset($santriData->nis) ? htmlspecialchars($santriData->nis, ENT_QUOTES, 'UTF-8') : '-' ?></td>
                                                            <td>
                                                                <div class="form-button-action">
                                                                    <a href="<?= base_url('Pengguna/detail/' . $user->id_user) ?>" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Detail">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('Pengguna/edit/' . $user->id_user) ?>" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <button type="button" data-bs-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger btn-lg btn-confirm-delete"
                                                                        data-url="<?= base_url('Pengguna/delete/' . $user->id_user) ?>"
                                                                        data-title="Hapus Pengguna"
                                                                        data-text="Apakah Anda yakin ingin menghapus pengguna <?= htmlspecialchars($user->nama_user, ENT_QUOTES, 'UTF-8') ?>?">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    endif;
                                                endforeach;
                                            endif;

                                            if ($santriCount == 0): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data santri</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Admin & Pengajar Tab -->
                            <div class="tab-pane fade" id="admin" role="tabpanel">
                                <div class="table-responsive">
                                    <table id="adminTable" class="display table table-striped table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th width="20%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $adminCount = 0;
                                            if (!empty($pengguna)):
                                                foreach ($pengguna as $user):
                                                    if ($user->id_role != 2): // Filter for non-santri roles
                                                        $adminCount++;
                                            ?>
                                                        <tr>
                                                            <td><?= $adminCount ?></td>
                                                            <td>
                                                                <?= htmlspecialchars($user->nama_user, ENT_QUOTES, 'UTF-8') ?>
                                                                <?php if ($user->id_user == $this->session->userdata('id_user')): ?>
                                                                    <span class="badge badge-info">Anda</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8') ?></td>
                                                            <td><?= htmlspecialchars($user->nama_role, ENT_QUOTES, 'UTF-8') ?></td>
                                                            <td>
                                                                <div class="form-button-action">
                                                                    <a href="<?= base_url('Pengguna/detail/' . $user->id_user) ?>" class="btn btn-link btn-info btn-lg" data-bs-toggle="tooltip" title="Detail">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('Pengguna/edit/' . $user->id_user) ?>" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <?php if ($user->id_user != $this->session->userdata('id_user')): ?>
                                                                        <button type="button" data-bs-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger btn-lg btn-confirm-delete"
                                                                            data-url="<?= base_url('Pengguna/delete/' . $user->id_user) ?>"
                                                                            data-title="Hapus Pengguna"
                                                                            data-text="Apakah Anda yakin ingin menghapus pengguna <?= htmlspecialchars($user->nama_user, ENT_QUOTES, 'UTF-8') ?>?">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    endif;
                                                endforeach;
                                            endif;

                                            if ($adminCount == 0): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data admin</td>
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
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi tooltip dengan Bootstrap 5
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Event handler untuk tombol hapus
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
                    Swal.fire({
                        title: 'Sedang memproses...',
                        html: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Tambahkan header untuk memastikan server tahu ini request AJAX
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            // Close loading dialog
                            Swal.close();
                            
                            if (response.status === true) {
                                // Animasi penghapusan baris
                                row.fadeOut(400, function() {
                                    $(this).remove();
                                    // Update counters setelah penghapusan
                                    updateCounters();
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

                                // Tampilkan notifikasi error dengan detail pesan
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Terjadi kesalahan saat menghapus data'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Close loading dialog
                            Swal.close();
                            
                            row.css('opacity', '1');
                            console.error("AJAX Error:", xhr.responseText);
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghubungi server. Silakan coba lagi.'
                            });
                        }
                    });
                }
            });
        });
        // Fungsi untuk update counters
        function updateCounters() {
            // Hitung total pengguna (dari tabel all)
            const totalUsers = $('#allTable tbody tr:not(.no-data)').length;
            $('#total-count').text(totalUsers);

            // Hitung jumlah santri
            const totalSantri = $('#santriTable tbody tr:not(.no-data)').length;
            $('#santri-count').text(totalSantri);

            // Hitung jumlah admin
            const totalAdmin = $('#adminTable tbody tr:not(.no-data)').length;
            $('#admin-count').text(totalAdmin);
        }

        // Filter pengguna berdasarkan tab
        $('.filter-pengguna').on('click', function(e) {
            e.preventDefault();
            $('.filter-pengguna').removeClass('active');
            $(this).addClass('active');
            
            const target = $(this).data('target');
            $('.tab-pane').removeClass('show active');
            $(`#${target}`).addClass('show active');
        });

        // Update counters saat halaman dimuat
        updateCounters();

        // Update counters setelah DataTable selesai dimuat
        allTable.on('draw', updateCounters);
        santriTable.on('draw', updateCounters);
        adminTable.on('draw', updateCounters);

        // Update counters setelah penghapusan
        $(document).on('click', '.btn-confirm-delete', function() {
            const row = $(this).closest('tr');
            row.on('remove', function() {
                updateCounters();
            });
        });
    });
</script>

<style>
.btn-round {
    padding: 8px 16px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-round .badge {
    margin-left: 8px;
    font-size: 0.75em;
    padding: 0.4em 0.6em;
    border-radius: 10px;
}

.filter-pengguna {
    margin-right: 10px;
}

.filter-pengguna.active {
    font-weight: 600;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Badge colors */
.badge.bg-primary {
    background-color: #1572E8 !important;
}

.badge.bg-success {
    background-color: #31CE36 !important;
}

.badge.bg-info {
    background-color: #48ABF7 !important;
}
</style>