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
                    <a href="<?= base_url('konfirmasi') ?>">Konfirmasi Pembayaran</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Detail Konfirmasi</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Detail Pembayaran</h4>
                            <a href="<?= base_url('konfirmasi') ?>" class="btn btn-secondary btn-round">
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

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="card-title fw-bold">Informasi Santri</div>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="40%">NIS</th>
                                                <td><?= htmlspecialchars($pembayaran->nis, ENT_QUOTES, 'UTF-8') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama Santri</th>
                                                <td><?= htmlspecialchars($pembayaran->nama_santri, ENT_QUOTES, 'UTF-8') ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="card-title fw-bold">Status Pembayaran</div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4 class="mb-0">
                                                <?php
                                                switch ($pembayaran->status) {
                                                    case 'belum_bayar':
                                                        echo '<span class="badge badge-danger">Belum Bayar</span>';
                                                        break;
                                                    case 'menunggu_konfirmasi':
                                                        echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                                                        break;
                                                    case 'diterima':
                                                        echo '<span class="badge badge-success">Diterima</span>';
                                                        break;
                                                    case 'ditolak':
                                                        echo '<span class="badge badge-secondary">Ditolak</span>';
                                                        break;
                                                    default:
                                                        echo '<span class="badge badge-info">Unknown</span>';
                                                }
                                                ?>
                                            </h4>
                                            <?php if ($pembayaran->status === 'diterima' || $pembayaran->status === 'ditolak'): ?>
                                                <div>
                                                    <small class="text-muted">Dikonfirmasi oleh: <?= htmlspecialchars($pembayaran->nama_admin, ENT_QUOTES, 'UTF-8') ?></small><br>
                                                    <small class="text-muted">Tanggal: <?= tanggal_waktu_indo($pembayaran->tanggal_konfirmasi) ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="card-title fw-bold">Detail Tagihan</div>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="40%">Nama Tagihan</th>
                                                <td><?= htmlspecialchars($pembayaran->nama_tagihan, ENT_QUOTES, 'UTF-8') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kategori</th>
                                                <td><?= htmlspecialchars($pembayaran->nama_kategori, ENT_QUOTES, 'UTF-8') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nominal Tagihan</th>
                                                <td>Rp <?= number_format($pembayaran->nominal, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Jatuh Tempo</th>
                                                <td><?= tanggal_indo($pembayaran->tanggal_jatuh_tempo) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="card-title fw-bold">Informasi Pembayaran</div>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="40%">Nominal Dibayar</th>
                                                <td>Rp <?= number_format($pembayaran->nominal_bayar, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Bayar</th>
                                                <td><?= tanggal_waktu_indo($pembayaran->tanggal_bayar) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Rekening Tujuan</th>
                                                <td><?= htmlspecialchars($pembayaran->nama_bank . ' - ' . $pembayaran->no_rekening, ENT_QUOTES, 'UTF-8') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Catatan Santri</th>
                                                <td><?= nl2br(htmlspecialchars($pembayaran->catatan_santri ?? '-', ENT_QUOTES, 'UTF-8')) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="card-title fw-bold text-left mb-3">Bukti Pembayaran</div>
                                        <?php if ($pembayaran->bukti_pembayaran): ?>
                                            <?php
                                            $ext = pathinfo($pembayaran->bukti_pembayaran, PATHINFO_EXTENSION);
                                            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])):
                                            ?>
                                                <div class="bukti-pembayaran-gallery">
                                                    <!-- Thumbnail dengan efek hover -->
                                                    <div class="image-container text-center position-relative">
                                                        <img id="bukti-image" src="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                            alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm" style="max-height: 400px;">

                                                        <!-- Overlay dengan tombol aksi -->
                                                        <div class="image-overlay">
                                                            <div class="overlay-buttons">
                                                                <button type="button" class="btn btn-sm btn-light rounded-circle" onclick="zoomImage()">
                                                                    <i class="fas fa-search-plus"></i>
                                                                </button>
                                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                                    class="btn btn-sm btn-light rounded-circle" target="_blank">
                                                                    <i class="fas fa-external-link-alt"></i>
                                                                </a>
                                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                                    class="btn btn-sm btn-light rounded-circle" download>
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                                <!-- Modal untuk Zoom Image -->
                                                <div class="modal fade" id="imageZoomModal" tabindex="-1" role="dialog" aria-labelledby="imageZoomModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header d-flex align-items-center">
                                                                <h5 class="modal-title" id="imageZoomModalLabel">Bukti Pembayaran</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModalBtn">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-center p-0">
                                                                <div class="image-zoom-container">
                                                                    <img id="zoomed-image" src="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                                        class="img-fluid" alt="Bukti Pembayaran">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="btn-group w-100">
                                                                    <button type="button" class="btn btn-sm btn-light" id="zoom-in">
                                                                        <i class="fas fa-search-plus"></i> Perbesar
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-light" id="zoom-out">
                                                                        <i class="fas fa-search-minus"></i> Perkecil
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-light" id="rotate-image">
                                                                        <i class="fas fa-sync-alt"></i> Putar
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-light" id="reset-image">
                                                                        <i class="fas fa-undo"></i> Reset
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="mb-3 text-center">
                                                    <i class="fas fa-file-pdf fa-4x"></i>
                                                    <p class="mt-2">File bukti pembayaran (<?= strtoupper($ext) ?>)</p>
                                                </div>

                                                <div class="mt-3 text-center">
                                                    <a href="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                        class="btn btn-primary" target="_blank">
                                                        <i class="fa fa-eye"></i> Lihat Dokumen
                                                    </a>
                                                    <a href="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                        class="btn btn-info" download>
                                                        <i class="fa fa-download"></i> Download
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="alert alert-warning">
                                                Bukti pembayaran tidak tersedia
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($pembayaran->status === 'menunggu_konfirmasi'): ?>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0"><i class="fa fa-check-circle me-2"></i> Konfirmasi Pembayaran</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?= base_url('Konfirmasi/proses') ?>" method="POST">
                                                <input type="hidden" name="id_pembayaran" value="<?= $pembayaran->id_pembayaran ?>">

                                                <div class="form-group">
                                                    <label for="status">Status Konfirmasi <span class="text-danger">*</span></label>
                                                    <div class="d-flex">
                                                        <div class="custom-control custom-radio mr-4">
                                                            <input type="radio" id="status_diterima" name="status" value="diterima" class="custom-control-input" checked>
                                                            <label class="custom-control-label" for="status_diterima">Terima Pembayaran</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="status_ditolak" name="status" value="ditolak" class="custom-control-input">
                                                            <label class="custom-control-label" for="status_ditolak">Tolak Pembayaran</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="catatan_admin">Catatan Admin</label>
                                                    <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3" placeholder="Tambahkan catatan untuk santri (opsional)"></textarea>
                                                    <small class="form-text text-muted">
                                                        Tambahkan alasan jika menolak pembayaran atau informasi tambahan jika diperlukan.
                                                    </small>
                                                </div>

                                                <div class="mt-4 text-right">
                                                    <button type="submit" class="btn btn-success" id="btn-terima">
                                                        <i class="fas fa-check me-2"></i> Konfirmasi Pembayaran
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header rounded-top-3 <?= $pembayaran->status === 'diterima' ? 'bg-success text-white' : 'bg-danger text-white' ?>">
                                            <h5 class="card-title mb-0">
                                                <i class="fa <?= $pembayaran->status === 'diterima' ? 'fa-check-circle' : 'fa-times-circle' ?> me-2"></i>
                                                Hasil Konfirmasi
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <input type="text" class="form-control" value="<?= $pembayaran->status === 'diterima' ? 'Pembayaran Diterima' : 'Pembayaran Ditolak' ?>" disabled>
                                            </div>

                                            <div class="form-group">
                                                <label for="catatan_admin">Catatan Admin</label>
                                                <textarea class="form-control" rows="3" disabled><?= htmlspecialchars($pembayaran->catatan_admin ?? '-', ENT_QUOTES, 'UTF-8') ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($log)): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fa fa-history me-2"></i> Riwayat Perubahan Status</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th width="20%">Waktu</th>
                                                            <th width="30%">Perubahan Status</th>
                                                            <th width="30%">Catatan</th>
                                                            <th width="20%">Diubah Oleh</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($log as $item): ?>
                                                            <tr>
                                                                <td><?= tanggal_waktu_indo($item->created_at) ?></td>
                                                                <td>
                                                                    <?php
                                                                    // Array untuk status dengan nama yang lebih jelas
                                                                    $status_labels = [
                                                                        'belum_bayar' => 'Belum Bayar',
                                                                        'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                                                                        'diterima' => 'Pembayaran Diterima',
                                                                        'ditolak' => 'Pembayaran Ditolak'
                                                                    ];

                                                                    // Array untuk warna badge
                                                                    $badge_colors = [
                                                                        'belum_bayar' => 'danger',
                                                                        'menunggu_konfirmasi' => 'warning',
                                                                        'diterima' => 'success',
                                                                        'ditolak' => 'secondary'
                                                                    ];

                                                                    // Status lama
                                                                    $status_lama = $item->status_lama ?
                                                                        '<span class="badge badge-' . $badge_colors[$item->status_lama] . '">' . $status_labels[$item->status_lama] . '</span>' :
                                                                        '<span class="badge badge-info">-</span>';

                                                                    // Status baru
                                                                    $status_baru = $item->status_baru ?
                                                                        '<span class="badge badge-' . $badge_colors[$item->status_baru] . '">' . $status_labels[$item->status_baru] . '</span>' :
                                                                        '<span class="badge badge-info">-</span>';

                                                                    // Tampilkan perubahan status dengan keterangan yang jelas
                                                                    echo '<div class="mb-1">Dari: ' . $status_lama . '</div>';
                                                                    echo '<div>Menjadi: ' . $status_baru . '</div>';
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (!empty($item->catatan)): ?>
                                                                        <div class="text-wrap">
                                                                            <?= nl2br(htmlspecialchars($item->catatan, ENT_QUOTES, 'UTF-8')) ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <?= htmlspecialchars($item->created_by_name, ENT_QUOTES, 'UTF-8') ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
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

<!-- CSS untuk efek fancy pada gambar -->
<style>
    /* Container untuk bukti pembayaran */
    .bukti-pembayaran-gallery {
        position: relative;
    }

    /* Container untuk gambar bukti pembayaran */
    .image-container {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .image-container:hover img {
        filter: brightness(0.9);
    }

    /* Overlay dengan tombol aksi */
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .image-container:hover .image-overlay {
        opacity: 1;
    }

    /* Tombol di overlay */
    .overlay-buttons {
        display: flex;
        gap: 10px;
    }

    .overlay-buttons .btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease;
    }

    .overlay-buttons .btn:hover {
        transform: scale(1.1);
    }

    /* Modal zoom image styling */
    .image-zoom-container {
        position: relative;
        overflow: hidden;
        background-color: #f8f9fa;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 500px;
    }

    #zoomed-image {
        max-width: 100%;
        max-height: 70vh;
        transition: transform 0.3s ease;
    }

    /* Perbaiki CSS untuk tombol close */
    .modal-header {
        position: relative;
        z-index: 2000 !important;
        /* Z-index lebih tinggi */
        padding: 1rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header .close {
        position: static !important;
        /* Ubah dari absolute ke static */
        z-index: 2001 !important;
        opacity: 0.8;
        margin: -1rem -1rem -1rem auto;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        background-color: transparent;
        border: 0;
        padding: 1rem;
        cursor: pointer;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    /* Pastikan image container tidak menutupi header */
    .image-zoom-container {
        position: relative;
        z-index: 1040;
    }
</style>

<!-- JavaScript untuk fungsi fancy image -->
<script>
    // JS yang sudah ada
    $(document).ready(function() {
        // Change button text and class based on radio selection
        $('input[name="status"]').change(function() {
            if ($(this).val() === 'diterima') {
                $('#btn-terima').removeClass('btn-danger').addClass('btn-success');
                $('#btn-terima').html('<i class="fas fa-check me-2"></i> Terima Pembayaran');
            } else {
                $('#btn-terima').removeClass('btn-success').addClass('btn-danger');
                $('#btn-terima').html('<i class="fas fa-times me-2"></i> Tolak Pembayaran');
            }
        });

        // Inisialisasi fungsi zoom dan rotate
        let currentZoom = 1;
        let currentRotation = 0;

        // Zoom in
        $('#zoom-in').click(function() {
            currentZoom += 0.1;
            updateImageTransform();
        });

        // Zoom out
        $('#zoom-out').click(function() {
            if (currentZoom > 0.2) {
                currentZoom -= 0.1;
                updateImageTransform();
            }
        });

        // Rotate image
        $('#rotate-image').click(function() {
            currentRotation += 90;
            updateImageTransform();
        });

        // Reset zoom and rotation
        $('#reset-image').click(function() {
            currentZoom = 1;
            currentRotation = 0;
            updateImageTransform();
        });

        function updateImageTransform() {
            $('#zoomed-image').css('transform', `scale(${currentZoom}) rotate(${currentRotation}deg)`);
        }

        // Kode yang sudah ada...

        // Perbaikan untuk tombol close
        $('.modal').on('shown.bs.modal', function() {
            $('.modal-header .close').css('z-index', '2001');
        });

        // Gunakan event handler yang lebih spesifik untuk tombol close
        $(document).on('click', '#closeModalBtn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('#imageZoomModal').modal('hide');
        });


        // Reset zoom dan rotation saat modal dibuka
        $('#imageZoomModal').on('show.bs.modal', function() {
            currentZoom = 1;
            currentRotation = 0;
            updateImageTransform();
        });
    });

    // Fungsi untuk menampilkan modal zoom
    function zoomImage() {
        $('#imageZoomModal').modal('show');
    }
</script>