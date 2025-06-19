<!-- Sidebar -->
<div class="sidebar sidebar-style-2" data-background-color="white">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="light-blue2">
            <a href="<?php echo base_url(); ?>" class="logo">
                <img src="<?php echo base_url('assets/img/logo/logo3.png'); ?>" alt="navbar brand" class="navbar-brand" style="height: auto; width: 170px;" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-start me-2">
                    <img src="<?php echo base_url('uploads/profil/') . ($this->session->userdata('foto') ? $this->session->userdata('foto') : 'default.jpg'); ?>" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-bs-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?php echo $this->session->userdata('nama_user'); ?>
                            <span class="user-level">
                                <?php
                                $role = $this->session->userdata('id_role');
                                if ($role == 1) {
                                    echo 'Admin';
                                } elseif ($role == 2) {
                                    echo 'Santri';
                                } else {
                                    echo 'Pengguna';
                                }
                                ?>
                            </span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="<?php echo base_url('profil'); ?>">
                                    <span class="link-collapse">Profil Saya</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" id="btn-logout">
                                    <span class="link-collapse">Keluar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-info">
                <?php if ($this->session->userdata('id_role') == 1): // Admin 
                ?>
                    <li class="nav-item <?php echo ($this->uri->segment(1) == 'dashboard' && !$this->uri->segment(2)) ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('dashboard'); ?>">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item <?php echo (in_array($this->uri->segment(1), ['Tagihan', 'Konfirmasi'])) ? 'active submenu' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#keuangan">
                            <i class="fas fa-wallet"></i>
                            <p>Kelola Keuangan</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo (in_array($this->uri->segment(1), ['Tagihan', 'Konfirmasi'])) ? 'show' : ''; ?>" id="keuangan">
                            <ul class="nav nav-collapse">
                                <li class="<?php echo ($this->uri->segment(1) == 'Tagihan') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('Tagihan'); ?>">
                                        <span class="sub-item">Manajemen Tagihan</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'Konfirmasi' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'detail')) ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('Konfirmasi'); ?>">
                                        <span class="sub-item">Konfirmasi Pembayaran</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'pemasukan' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'detail')) ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('pemasukan'); ?>">
                                        <span class="sub-item">Pemasukan</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'pengeluaran' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'detail')) ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('pengeluaran'); ?>">
                                        <span class="sub-item">Pengeluaran</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'laporan' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'detail')) ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('laporan'); ?>">
                                        <span class="sub-item">Laporan Keuangan</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item <?php echo (in_array($this->uri->segment(1), ['Kategori', 'Rekening'])) ? 'active submenu' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#masterdata">
                            <i class="fas fa-archive"></i>
                            <p>Master Data</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo (in_array($this->uri->segment(1), ['Kategori', 'Rekening'])) ? 'show' : ''; ?>" id="masterdata">
                            <ul class="nav nav-collapse">
                                <li class="<?php echo ($this->uri->segment(1) == 'Kategori') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('Kategori'); // Akan dibuat nanti 
                                                ?>">
                                        <span class="sub-item">Manajemen Kategori</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'Rekening') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('Rekening'); // Akan dibuat nanti 
                                                ?>">
                                        <span class="sub-item">Manajemen Rekening</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item <?php echo ($this->uri->segment(1) == 'Pengguna') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('Pengguna'); ?>">
                            <i class="fas fa-users-cog"></i>
                            <p>Kelola Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" id="btn-logout-sidebar">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                        </a>
                    </li>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var btnLogoutSidebar = document.getElementById('btn-logout-sidebar');
                            if (btnLogoutSidebar) {
                                btnLogoutSidebar.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    Swal.fire({
                                        title: 'Konfirmasi Keluar',
                                        text: "Apakah Anda yakin ingin keluar dari sistem?",
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, Keluar!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "<?php echo base_url('auth/logout'); ?>";
                                        }
                                    });
                                });
                            }
                        });
                    </script>
                <?php endif; ?>

                <?php if ($this->session->userdata('id_role') == 2): // Santri 
                ?>
                    <li class="nav-item <?php echo ($this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'santri') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('dashboard/santri'); ?>">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($this->uri->segment(1) == 'Pembayaran') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('Pembayaran'); ?>">
                            <i class="fas fa-money-check-alt"></i>
                            <p>Informasi Pembayaran</p>
                        </a>
                    </li>
                      <li class="nav-item">
                        <a href="javascript:void(0)" id="btn-logout-sidebar">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                        </a>
                    </li>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var btnLogoutSidebar = document.getElementById('btn-logout-sidebar');
                            if (btnLogoutSidebar) {
                                btnLogoutSidebar.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    Swal.fire({
                                        title: 'Konfirmasi Keluar',
                                        text: "Apakah Anda yakin ingin keluar dari sistem?",
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Ya, Keluar!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "<?php echo base_url('auth/logout'); ?>";
                                        }
                                    });
                                });
                            }
                        });
                    </script>
                    <!-- Menu Riwayat Pembayaran dihapus karena sudah digabung -->
                <?php endif; ?>
        </div>
    </div>
</div>
<!-- End Sidebar -->

<!-- Add logout confirmation script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btn-logout').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Keluar',
                text: "Apakah Anda yakin ingin keluar dari sistem?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo base_url('auth/logout'); ?>";
                }
            });
        });
    });
</script>