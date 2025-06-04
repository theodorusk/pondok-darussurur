<!-- Footer Section -->
<footer class="footer">
    <div class="container-fluid d-flex justify-content-center">
        <div class="copyright">
            &copy; <?= date('Y') ?> Kost Bima. All rights reserved.
        </div>
    </div>
</footer>
</div> <!-- End wrapper -->

<!-- Define base_url for global use -->
<script>
    var base_url = "<?= base_url() ?>";
</script>

<!-- Essential Plugins -->
<script src="<?= base_url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="<?= base_url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugin/select2/select2.full.min.js') ?>"></script>

<!-- Optional Plugins -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="<?= base_url('assets/js/plugin/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugin/chart.js/chart.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/js/plugin/select2/select2.full.min.js') ?>"></script>

<!-- Ekko Lightbox -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<!-- FancyBox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<!-- FancyBox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<!-- Main Application JS -->
<script src="<?= base_url('assets/js/kaiadmin.min.js') ?>"></script>

<!-- Page Specific Scripts -->
<script>
    (function() {
        // Make key functions global

        // Global showNotification function
        window.showNotification = function(type, title, message) {
            $.notify({
                title: title,
                message: message,
                icon: type === 'success' ? 'fa fa-check' : type === 'error' || type === 'danger' ? 'fa fa-exclamation-circle' : type === 'warning' ? 'fa fa-exclamation-triangle' : 'fa fa-info-circle'
            }, {
                type: type,
                placement: {
                    from: "bottom",
                    align: "right"
                },
                delay: type === 'success' ? 3000 : 5000,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                }
            });
        };

        // Global initializeDataTable function
        window.initializeDataTable = function(tableId, options = {}) {
            const defaultOptions = {
                responsive: true,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                initComplete: function() {
                    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Cari...');
                    $('.dataTables_length select').addClass('form-control');
                }
            };

            // Gabungkan default options dengan custom options
            const finalOptions = {
                ...defaultOptions,
                ...options
            };

            $(tableId).DataTable(finalOptions);
        };

        // Global initSelect2 function
        window.initSelect2 = function(selector, options = {}) {
            const defaultOptions = {
                theme: 'bootstrap-5',
                width: '100%'
            };

            const finalOptions = Object.assign({}, defaultOptions, options);

            $(selector).select2(finalOptions);
        };

        // Inisialisasi Select2 pada elemen dengan class .select2 jika ada di halaman
        $(function() {
            if ($('.select2').length) {
                window.initSelect2('.select2');
            }
        });

        // Global confirmDelete function
        window.confirmDelete = function(url, title, text) {
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
                    // AJAX untuk hapus data
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            if (response && response.status) {
                                window.showNotification('success', 'Sukses', response.message || 'Data berhasil dihapus');
                                setTimeout(() => {
                                    location.reload(true);
                                }, 1000);
                            } else {
                                const errorMsg = response && response.message ? response.message : 'Gagal menghapus data';
                                window.showNotification('danger', 'Error', errorMsg);
                            }
                        },
                        error: function(xhr, status, error) {
                            let errorMsg = 'Terjadi kesalahan saat menghapus data';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            window.showNotification('danger', 'Error', errorMsg);
                        }
                    });
                }
            });
        };
    })();

    $(document).ready(function() {

        // Handle flash messages
        <?php if ($this->session->flashdata('success')): ?>
            showNotification('success', 'Sukses', '<?= $this->session->flashdata("success") ?>');
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            showNotification('danger', 'Error', '<?= $this->session->flashdata("error") ?>');
        <?php endif; ?>

        <?php if ($this->session->flashdata('warning')): ?>
            showNotification('warning', 'Peringatan', '<?= $this->session->flashdata("warning") ?>');
        <?php endif; ?>

        <?php if ($this->session->flashdata('info')): ?>
            showNotification('info', 'Informasi', '<?= $this->session->flashdata("info") ?>');
        <?php endif; ?>



        // Inisialisasi tooltip dengan Bootstrap 5
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Konfirmasi untuk hapus data (global handler)
        $(document).on('click', '.btn-confirm-delete', function() {
            const url = $(this).data('url');
            const title = $(this).data('title');
            const text = $(this).data('text');
            confirmDelete(url, title, text);
        });

        // Mendaftarkan event untuk bootstrap modal
        $(document).on('shown.bs.modal', function(e) {
            // Reinisialisasi Select2 dalam modal
            $(e.target).find('.select2').each(function() {
                $(this).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: $(e.target)
                });
            });
        });

        // Inisialisasi semua DataTable di halaman
        if ($('#userTable').length) {
            initializeDataTable('#userTable', {
                columnDefs: [{
                        orderable: false,
                        targets: [5]
                    },
                    {
                        searchable: false,
                        targets: [5]
                    }
                ],
                order: [
                    [0, 'asc'] // Urutan default berdasarkan kolom pertama
                ]
            });
        }
        if ($('#lokasiTable').length) {
            initializeDataTable('#lokasiTable', {
                columnDefs: [{
                        orderable: false,
                        targets: [3] // Kolom aksi (indeks 3) tidak bisa di-sort
                    },
                    {
                        searchable: false,
                        targets: [3] // Kolom aksi (indeks 3) tidak bisa di-search
                    }
                ],
                order: [
                    [0, 'asc'] // Default sorting by Nama Lokasi (kolom indeks 1)
                ]
            });
        }
        if ($('#fasilitasTable').length) {
            initializeDataTable('#fasilitasTable', {
                columnDefs: [{
                        orderable: false,
                        targets: [1, 4] // Kolom 2 dan 4 tidak bisa di-sort
                    },
                    {
                        searchable: false,
                        targets: [1, 4] // Kolom 2 dan 4 tidak bisa di-search
                    }
                ],
                order: [
                    [0, 'asc'] // Urutan default berdasarkan kolom pertama
                ]
            });
        }
        if ($('#kamarTable').length) {
            initializeDataTable('#kamarTable', {
                columnDefs: [{
                        orderable: false,
                        targets: [6] // Kolom 6 tidak bisa di-sort
                    },
                    {
                        searchable: false,
                        targets: [6] // Kolom 6 tidak bisa di-search
                    }
                ],
                order: [
                    [0, 'asc'] // Urutan default berdasarkan kolom pertama
                ]
            });
        }
        if ($('#rekeningTable').length) {
            initializeDataTable('#rekeningTable', {
                columnDefs: [{
                        orderable: false,
                        targets: [5] // Kolom 6 (indeks 5) tidak bisa di-sort
                    },
                    {
                        searchable: false,
                        targets: [5] // Kolom 6 (indeks 5) tidak bisa di-search
                    }
                ],
                order: [
                    [0, 'asc'] // Urutan default berdasarkan kolom pertama
                ]
            });
        }
        // Anda bisa menambahkan inisialisasi untuk tabel lainnya di sini
        if ($('#keluhanTable').length) {
            initializeDataTable('#keluhanTable', {
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                columnDefs: [{
                        orderable: false,
                        targets: [7]
                    },
                    {
                        searchable: false,
                        targets: [0, 7]
                    }
                ],
                order: [
                    [4, "desc"]
                ]
            });
        }
        if ($('#kelolaTable').length) {
            initializeDataTable('#kelolaTable', {
                columnDefs: [{
                        orderable: false,
                        targets: [8] // Kolom 6 (indeks 5) tidak bisa di-sort
                    },
                    {
                        searchable: false,
                        targets: [8] // Kolom 6 (indeks 5) tidak bisa di-search
                    }
                ],
                order: [
                    [0, 'asc'] // Urutan default berdasarkan kolom pertama
                ]
            });
        }


        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Enable alert dismiss
        $('.alert').alert();
    });
</script>
</body>

</html>