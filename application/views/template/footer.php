<!-- Footer Section -->
<footer class="footer">
    <div class="container-fluid d-flex justify-content-center">
        <div class="copyright">
            &copy; <?= date('Y') ?> Pondok Pesantren Darussurur. All rights reserved.
        </div>
    </div>
</footer>
</div> <!-- End wrapper -->

<!-- Define base_url for global use -->
<script>
    var base_url = "<?= base_url() ?>";
</script>

<!-- Essential jQuery Libraries -->
<script src="<?= base_url('assets/js/core/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<!-- Essential Plugins -->
<script src="<?= base_url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugin/select2/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugin/datatables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugin/chart.js/chart.min.js') ?>"></script>

<!-- Optional Plugins -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

<!-- Main Application JS -->
<script src="<?= base_url('assets/js/kaiadmin.min.js') ?>"></script>

<!-- Page Specific Scripts -->
<script>
    (function($) { // Pastikan $ adalah jQuery
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
            if (!$(tableId).length) {
                console.warn('Table ' + tableId + ' not found in DOM');
                return;
            }

            try {
                // Verifikasi struktur tabel
                var tableNode = $(tableId)[0];
                if (!tableNode || tableNode.nodeName !== 'TABLE') {
                    console.error('Element is not a table');
                    return;
                }

                // Pastikan kolom untuk sorting ada
                if (options.order) {
                    let hasHeaderRow = $(tableId + ' thead tr').length > 0;
                    let columnCount = hasHeaderRow ? $(tableId + ' thead th').length : 0;
                    // Periksa apakah indeks kolom yang akan diurutkan valid
                    if (options.order[0] && options.order[0][0] >= columnCount) {
                        console.warn('Sort column index out of bounds, resetting to first column');
                        options.order[0][0] = 0;
                    }
                }

                const defaultOptions = {
                    responsive: true,
                    processing: true,
                    language: {
                        emptyTable: "Tidak ada data yang tersedia",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                        infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                        lengthMenu: "Tampilkan _MENU_ entri",
                        loadingRecords: "Sedang memuat...",
                        processing: "Sedang memproses...",
                        search: "Cari:",
                        zeroRecords: "Tidak ditemukan data yang sesuai",
                        thousands: ".",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        },
                        aria: {
                            sortAscending: ": aktifkan untuk mengurutkan kolom ke atas",
                            sortDescending: ": aktifkan untuk mengurutkan kolom menurun"
                        }
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
                const finalOptions = $.extend(true, {}, defaultOptions, options);

                return $(tableId).DataTable(finalOptions);
            } catch (error) {
                console.error('DataTable initialization error:', error);

                // Fallback: tampilkan tabel biasa tanpa DataTables
                $(tableId).addClass('table-simple');
                return null;
            }
        };

        // Global handleTabChange function for DataTables in tabs
        window.handleTabChange = function() {
            // Perbaikan untuk handling tab click
            $('.nav-pills a').on('click', function(e) {
                e.preventDefault(); // Mencegah navigasi ke URL baru
                $(this).tab('show'); // Menampilkan tab yang diklik
            });

            // Handle tab change dengan benar
            $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                // Perbaiki layout DataTables saat tab aktif berubah
                if ($.fn.dataTable) {
                    try {
                        $.fn.dataTable.tables({
                            visible: true,
                            api: true
                        }).columns.adjust().responsive.recalc();
                    } catch (error) {
                        console.error('Error adjusting DataTables:', error);
                    }
                }
            });

            // Cek apakah ada hash di URL dan aktifkan tab yang sesuai
            var hash = window.location.hash;
            if (hash) {
                $('.nav-pills a[href="' + hash + '"]').tab('show');
            }
        };

        // Global initSelect2 function
        window.initSelect2 = function(selector, options = {}) {
            if (!$(selector).length) return;

            try {
                const defaultOptions = {
                    theme: 'bootstrap-5',
                    width: '100%'
                };

                const finalOptions = $.extend(true, {}, defaultOptions, options);
                $(selector).select2(finalOptions);
            } catch (error) {
                console.error('Error initializing Select2:', error);
            }
        };

        // Global confirmDelete function
        window.confirmDelete = function(url, title, text) {
            if (typeof Swal !== 'function') {
                console.error('SweetAlert2 not loaded');
                return;
            }

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
    })(jQuery); // Pass jQuery to IIFE

    jQuery(document).ready(function($) { // Ensure $ is jQuery in this scope
        try {
            // Initialize scrollbar
            if ($.fn.scrollbar && $('.scrollbar-inner').length) {
                $('.scrollbar-inner').scrollbar();
            }

            // Initialize icon select
            if ($.fn.select2 && $('#icon').length) {
                $('#icon').select2({
                    theme: "bootstrap"
                });
            }

            // Handle flash messages
            <?php if ($this->session->flashdata('success')): ?>
                if (typeof showNotification === 'function') {
                    showNotification('success', 'Sukses', '<?= $this->session->flashdata("success") ?>');
                }
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                if (typeof showNotification === 'function') {
                    showNotification('danger', 'Error', '<?= $this->session->flashdata("error") ?>');
                }
            <?php endif; ?>

            <?php if ($this->session->flashdata('warning')): ?>
                if (typeof showNotification === 'function') {
                    showNotification('warning', 'Peringatan', '<?= $this->session->flashdata("warning") ?>');
                }
            <?php endif; ?>

            <?php if ($this->session->flashdata('info')): ?>
                if (typeof showNotification === 'function') {
                    showNotification('info', 'Informasi', '<?= $this->session->flashdata("info") ?>');
                }
            <?php endif; ?>

            // Initialize Select2
            if (typeof initSelect2 === 'function' && $('.select2').length) {
                initSelect2('.select2');
            }

            // Initialize tooltips
            if ($.fn.tooltip) {
                $('[data-toggle="tooltip"], [data-bs-toggle="tooltip"]').tooltip();
            }

            // Konfirmasi untuk hapus data (global handler)
            if (typeof confirmDelete === 'function') {
                $(document).on('click', '.btn-confirm-delete', function() {
                    const url = $(this).data('url');
                    const title = $(this).data('title');
                    const text = $(this).data('text');
                    confirmDelete(url, title, text);
                });
            }

            // Initialize tab functionality if present
            if (typeof handleTabChange === 'function' && $('.nav-pills').length) {
                handleTabChange();
            }

            // Mendaftarkan event untuk bootstrap modal
            $(document).on('shown.bs.modal', function(e) {
                // Reinisialisasi Select2 dalam modal
                if ($.fn.select2) {
                    $(e.target).find('.select2').each(function() {
                        $(this).select2({
                            theme: 'bootstrap-5',
                            width: '100%',
                            dropdownParent: $(e.target)
                        });
                    });
                }
            });

            // ===== INITIALIZE DATATABLES =====
            // Inisialisasi dengan pengecekan DOM
            // ===== User Management Tables =====
            if ($('#allTable').length && typeof initializeDataTable === 'function') {
                initializeDataTable('#allTable', {
                    columnDefs: [{
                            orderable: false,
                            targets: [4]
                        },
                        {
                            searchable: false,
                            targets: [4]
                        }
                    ],
                    order: [
                        [0, 'asc']
                    ]
                });
            }
            if ($('#pemasukan-table').length && typeof initializeDataTable === 'function') {
                initializeDataTable('#pemasukan-table', {
                    order: [
                        [5, 'desc']
                    ], // Urutkan berdasarkan Tanggal (kolom ke-6)
                    columnDefs: [
                        {
                            orderable: false,
                            targets: [0]
                        }, // Kolom No tidak bisa diurutkan
                        {
                            searchable: false,
                            targets: [0]
                        } // Kolom No tidak bisa dicari
                    ]
                });
            }

            if ($('#santriTable').length && typeof initializeDataTable === 'function') {
                initializeDataTable('#santriTable', {
                    columnDefs: [{
                            orderable: false,
                            targets: [3]
                        },
                        {
                            searchable: false,
                            targets: [3]
                        }
                    ],
                    order: [
                        [0, 'asc']
                    ]
                });
            }

            if ($('#adminTable').length && typeof initializeDataTable === 'function') {
                initializeDataTable('#adminTable', {
                    columnDefs: [{
                            orderable: false,
                            targets: [2]
                        },
                        {
                            searchable: false,
                            targets: [2]
                        }
                    ],
                    order: [
                        [0, 'asc']
                    ]
                });
            }

            // Enable alert dismiss
            if ($.fn.alert && $('.alert').length) {
                $('.alert').alert();
            }

            // ===== INITIALIZE DATATABLES =====
            // Inisialisasi dengan pengecekan DOM
            // ===== Pembayaran Tables =====
            // TAMBAHKAN KODE INI untuk tabel pembayaran di bawah inisialisasi tabel lainnya
            if ($('#pembayaran-table').length && typeof initializeDataTable === 'function') {
                initializeDataTable('#pembayaran-table', {
                    order: [
                        [7, 'asc'],
                        [6, 'desc']
                    ], // Urutkan berdasarkan Status, lalu Tanggal Bayar
                    columnDefs: [{
                            orderable: false,
                            targets: [10]
                        }, // Kolom Aksi tidak bisa diurutkan
                        {
                            searchable: false,
                            targets: [0, 10]
                        }, // Kolom No dan Aksi tidak bisa dicari
                        {
                            // Warna berdasarkan status
                            targets: 7,
                            createdCell: function(td, cellData, rowData, row, col) {
                                if (cellData.includes('Belum Bayar')) {
                                    $(td).addClass('bg-danger-light');
                                } else if (cellData.includes('Menunggu Konfirmasi')) {
                                    $(td).addClass('bg-warning-light');
                                } else if (cellData.includes('Diterima')) {
                                    $(td).addClass('bg-success-light');
                                } else if (cellData.includes('Ditolak')) {
                                    $(td).addClass('bg-secondary-light');
                                }
                            }
                        }
                    ],
                    
                });
            }

        } catch (error) {
            console.error('Error in document ready handler:', error);
        }
    });
</script>

<!-- Fungsi untuk Format Nominal -->
<script>
    (function() {
        // Fungsi untuk format nominal dengan titik ribuan
        function formatNominal(input) {
            if (!input) return;
            let value = input.value.replace(/\D/g, ''); // Menghapus semua karakter non-digit
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Menambahkan titik ribuan
            input.value = value;
        }

        // Menambahkan event listener untuk memformat nominal saat input berubah
        document.addEventListener('DOMContentLoaded', function() {
            // Periksa dulu apakah elemen dengan ID 'nominal' ada
            const nominalInput = document.getElementById('nominal');
            if (nominalInput) {
                nominalInput.addEventListener('input', function() {
                    formatNominal(this);
                });
            }

            // Event delegation untuk elemen dengan class format-nominal
            document.addEventListener('input', function(e) {
                if (e.target && e.target.classList && e.target.classList.contains('format-nominal')) {
                    formatNominal(e.target);
                }
            });
        });
    })();
</script>

<!-- Handle DataTables CORS issues -->
<script>
    jQuery(document).ajaxError(function(event, jqxhr, settings, thrownError) {
        if (settings.url && settings.url.includes('datatables.net/plug-ins') &&
            (thrownError === 'Not Found' || jqxhr.status === 0)) {
            console.warn('DataTables language file failed to load. Using fallback.');
        }
    });
</script>

<!-- Debugging untuk Struktur Tabel -->
<script>
    jQuery(document).ready(function($) {
        // Log informasi tentang tabel di halaman
        console.log('Debugging Tables:');
        ['#all-table', '#unpaid-table', '#pending-table', '#history-table',
            '#allTable', '#santriTable', '#adminTable'
        ].forEach(function(tableId) {
            var table = $(tableId);
            if (table.length) {
                console.info(tableId + ' found in DOM');
                console.info('- Has thead: ' + (table.find('thead').length > 0));
                console.info('- Has tbody: ' + (table.find('tbody').length > 0));
                console.info('- Number of columns: ' + table.find('thead th').length);
            }
        });
    });
</script>
</body>

</html>