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
            </button>        </div>
        <!-- End Logo Header -->
    </div>
    
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <!-- User Info Section -->
            <div class="user">
                <div class="avatar-sm float-start me-2">
                    <img src="<?php echo base_url('uploads/profil/') . ($this->session->userdata('foto') ? $this->session->userdata('foto') : 'default.jpg'); ?>" alt="User Avatar" class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
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
                                <a href="javascript:void(0)" class="btn-logout">
                                    <span class="link-collapse">Keluar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>            <!-- Navigation Menu -->
            <ul class="nav nav-info">
                <?php if ($this->session->userdata('id_role') == 1): // Admin ?>
                    <!-- Dashboard -->
                    <li class="nav-item <?php echo ($this->uri->segment(1) == 'dashboard' && !$this->uri->segment(2)) ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('dashboard'); ?>">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Kelola Keuangan -->
                    <li class="nav-item <?php echo (in_array($this->uri->segment(1), ['Tagihan', 'Konfirmasi', 'pemasukan', 'pengeluaran', 'laporan'])) ? 'active submenu' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#keuangan" role="button" aria-expanded="<?php echo (in_array($this->uri->segment(1), ['Tagihan', 'Konfirmasi', 'pemasukan', 'pengeluaran', 'laporan'])) ? 'true' : 'false'; ?>" aria-controls="keuangan">
                            <i class="fas fa-wallet"></i>
                            <p>Kelola Keuangan</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo (in_array($this->uri->segment(1), ['Tagihan', 'Konfirmasi', 'pemasukan', 'pengeluaran', 'laporan'])) ? 'show' : ''; ?>" id="keuangan">
                            <ul class="nav nav-collapse">
                                <li class="<?php echo ($this->uri->segment(1) == 'Tagihan') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('Tagihan'); ?>">
                                        <span class="sub-item">Manajemen Tagihan</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'Konfirmasi') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('Konfirmasi'); ?>">
                                        <span class="sub-item">Konfirmasi Pembayaran</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'pemasukan') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('pemasukan'); ?>">
                                        <span class="sub-item">Pemasukan</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'pengeluaran') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('pengeluaran'); ?>">
                                        <span class="sub-item">Pengeluaran</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'laporan') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('laporan'); ?>">
                                        <span class="sub-item">Laporan Keuangan</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Master Data -->
                    <li class="nav-item <?php echo (in_array($this->uri->segment(1), ['Kategori', 'Rekening'])) ? 'active submenu' : ''; ?>">
                        <a data-bs-toggle="collapse" href="#masterdata" role="button" aria-expanded="<?php echo (in_array($this->uri->segment(1), ['Kategori', 'Rekening'])) ? 'true' : 'false'; ?>" aria-controls="masterdata">
                            <i class="fas fa-archive"></i>
                            <p>Master Data</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse <?php echo (in_array($this->uri->segment(1), ['Kategori', 'Rekening'])) ? 'show' : ''; ?>" id="masterdata">
                            <ul class="nav nav-collapse">
                                <li class="<?php echo ($this->uri->segment(1) == 'Kategori') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('Kategori'); ?>">
                                        <span class="sub-item">Manajemen Kategori</span>
                                    </a>
                                </li>
                                <li class="<?php echo ($this->uri->segment(1) == 'Rekening') ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('Rekening'); ?>">
                                        <span class="sub-item">Manajemen Rekening</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Kelola Pengguna -->
                    <li class="nav-item <?php echo ($this->uri->segment(1) == 'Pengguna') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('Pengguna'); ?>">
                            <i class="fas fa-users-cog"></i>
                            <p>Kelola Pengguna</p>
                        </a>
                    </li>

                    <!-- Logout Button -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($this->session->userdata('id_role') == 2): // Santri ?>
                    <!-- Dashboard Santri -->
                    <li class="nav-item <?php echo ($this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == 'santri') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('dashboard/santri'); ?>">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Informasi Pembayaran -->
                    <li class="nav-item <?php echo ($this->uri->segment(1) == 'Pembayaran') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('Pembayaran'); ?>">
                            <i class="fas fa-money-check-alt"></i>
                            <p>Informasi Pembayaran</p>
                        </a>
                    </li>

                    <!-- Logout Button -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->

<!-- Logout Confirmation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle all logout buttons
        const logoutButtons = document.querySelectorAll('.btn-logout');
        
        logoutButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
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

        // Ensure navigation links work properly
        const navLinks = document.querySelectorAll('.nav-item a:not(.btn-logout)');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // If it's a Bootstrap collapse toggle, let it work
                if (this.hasAttribute('data-bs-toggle')) {
                    return;
                }
                
                // If it's a regular link and not javascript:void(0), navigate
                if (href && href !== 'javascript:void(0)' && href !== '#') {
                    window.location.href = href;
                }
            });
        });

        // Handle sidebar collapse functionality
        const collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
        collapseToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.classList.toggle('show');
                    
                    // Update aria-expanded
                    const isExpanded = target.classList.contains('show');
                    this.setAttribute('aria-expanded', isExpanded);
                    
                    // Toggle parent nav-item class
                    const parentNavItem = this.closest('.nav-item');
                    if (parentNavItem) {
                        if (isExpanded) {
                            parentNavItem.classList.add('submenu');
                        } else {
                            parentNavItem.classList.remove('submenu');
                        }
                    }
                }
            });
        });
    });
</script>