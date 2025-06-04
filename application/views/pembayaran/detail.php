<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="<?= base_url('dashboard/santri') ?>">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('pembayaran') ?>">Pembayaran</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Detail Pembayaran</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Detail Tagihan</h4>
                            <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary btn-round">
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
                                <div class="card card-stats card-round" style="margin-bottom: 0;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card-title fw-bold">Informasi Tagihan</div>
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
                                                        <th>Nominal</th>
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
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-stats card-round" style="margin-bottom: 0;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card-title fw-bold">Informasi Rekening Pembayaran</div>
                                                <div class="alert alert-info" role="alert">
                                                    <h5 class="alert-heading mb-2"><i class="fas fa-info-circle me-2"></i> Rekening Tujuan</h5>
                                                    <p class="mb-0 fw-bold"><?= htmlspecialchars($pembayaran->nama_bank, ENT_QUOTES, 'UTF-8') ?></p>
                                                    <p class="mb-0">No. Rekening: <?= htmlspecialchars($pembayaran->no_rekening, ENT_QUOTES, 'UTF-8') ?></p>
                                                    <p class="mb-0">A/n: <?= htmlspecialchars($pembayaran->atas_nama, ENT_QUOTES, 'UTF-8') ?></p>
                                                </div>
                                                <p class="text-muted small mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>
                                                    Harap transfer sesuai dengan nominal dan mencantumkan nama santri pada keterangan transfer.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator-solid"></div>

                        <!-- Deskripsi Tagihan -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="fw-bold">Deskripsi Tagihan</h5>
                                <p><?= nl2br(htmlspecialchars($pembayaran->deskripsi_tagihan ?? 'Tidak ada deskripsi', ENT_QUOTES, 'UTF-8')) ?></p>
                            </div>
                        </div>

                        <div class="separator-solid"></div>

                        <!-- Status Pembayaran -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold m-0">Status Pembayaran</h5>
                                    <div>
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
                                    </div>
                                </div>

                                <?php if ($pembayaran->status != 'belum_bayar'): ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">Nominal Dibayar</th>
                                                        <td>Rp <?= number_format($pembayaran->nominal_bayar, 0, ',', '.') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Pembayaran</th>
                                                        <td><?= tanggal_waktu_indo($pembayaran->tanggal_bayar) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Catatan Santri</th>
                                                        <td><?= nl2br(htmlspecialchars($pembayaran->catatan_santri ?? '-', ENT_QUOTES, 'UTF-8')) ?></td>
                                                    </tr>
                                                    <?php if ($pembayaran->status == 'diterima' || $pembayaran->status == 'ditolak'): ?>
                                                        <tr>
                                                            <th>Tanggal Konfirmasi</th>
                                                            <td><?= tanggal_waktu_indo($pembayaran->tanggal_konfirmasi) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Catatan Admin</th>
                                                            <td><?= nl2br(htmlspecialchars($pembayaran->catatan_admin ?? '-', ENT_QUOTES, 'UTF-8')) ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card card-stats card-round">
                                                <div class="card-body">
                                                    <div class="card-title fw-bold">Bukti Pembayaran</div>
                                                    <?php if ($pembayaran->bukti_pembayaran): ?>
                                                        <?php
                                                        $ext = pathinfo($pembayaran->bukti_pembayaran, PATHINFO_EXTENSION);
                                                        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])):
                                                        ?>
                                                            <div class="bukti-pembayaran-gallery">
                                                                <!-- Thumbnail dengan efek hover -->
                                                                <div class="image-container text-center position-relative">
                                                                    <img id="bukti-image" src="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                                        alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm" style="max-height: 300px;">

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
                                                        <?php else: ?>
                                                            <div class="mb-3 text-center">
                                                                <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                                                <p class="mt-2">File bukti pembayaran (<?= strtoupper($ext) ?>)</p>
                                                            </div>

                                                            <div class="text-center">
                                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                                    class="btn btn-primary btn-sm" target="_blank">
                                                                    <i class="fa fa-eye"></i> Lihat Dokumen
                                                                </a>
                                                                <a href="<?= base_url('uploads/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) ?>"
                                                                    class="btn btn-info btn-sm" download>
                                                                    <i class="fa fa-download"></i> Download
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <div class="alert alert-warning text-center">
                                                            Bukti pembayaran belum diunggah
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($pembayaran->status == 'ditolak'): ?>
                                        <div class="separator-solid my-4"></div>

                                        <!-- Form Upload Ulang Bukti Pembayaran untuk pembayaran yang ditolak -->
                                        <div class="card shadow-sm mt-4">
                                            <div class="card-header bg-danger text-white">
                                                <h5 class="card-title mb-0"><i class="fa fa-exclamation-triangle me-2"></i> Pembayaran Ditolak</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-3">Pembayaran Anda ditolak dengan alasan: <strong><?= htmlspecialchars($pembayaran->catatan_admin ?: 'Tidak ada alasan yang diberikan', ENT_QUOTES, 'UTF-8') ?></strong></p>
                                                <p class="mb-4">Silakan upload ulang bukti pembayaran yang benar:</p>

                                                <form action="<?= base_url('Pembayaran/upload/' . $pembayaran->id_pembayaran) ?>" method="POST" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="nominal_bayar">Nominal Pembayaran <span class="text-danger">*</span></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" id="nominal_bayar" name="nominal_bayar"
                                                                        value="<?= number_format($pembayaran->nominal_bayar ?: $pembayaran->nominal, 0, ',', '.') ?>" required>
                                                                </div>
                                                                <small class="form-text text-muted">Masukkan sesuai nominal yang ditransfer</small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="catatan_santri">Catatan (Opsional)</label>
                                                                <textarea class="form-control" id="catatan_santri" name="catatan_santri" rows="3"><?= htmlspecialchars($pembayaran->catatan_santri ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                                                <small class="form-text text-muted">Tambahkan catatan jika diperlukan</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="bukti_pembayaran">Bukti Pembayaran Baru <span class="text-danger">*</span></label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,.pdf" required>
                                                                    <label class="custom-file-label" for="bukti_pembayaran">Pilih file...</label>
                                                                </div>
                                                                <small class="form-text text-muted">Format: JPG, PNG, atau PDF. Maks 2MB</small>
                                                            </div>
                                                            <div id="preview" class="mt-3 text-center">
                                                                <!-- Preview akan ditampilkan di sini -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-paper-plane me-2"></i> Kirim Ulang Bukti Pembayaran
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <!-- Form Upload Bukti Pembayaran untuk yang belum bayar -->
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0"><i class="fa fa-upload me-2"></i> Upload Bukti Pembayaran</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?= base_url('Pembayaran/upload/' . $pembayaran->id_pembayaran) ?>" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nominal_bayar">Nominal Pembayaran <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Rp</span>
                                                                </div>
                                                                <input type="text" class="form-control" id="nominal_bayar" name="nominal_bayar"
                                                                    value="<?= number_format($pembayaran->nominal, 0, ',', '.') ?>" required>
                                                            </div>
                                                            <small class="form-text text-muted">Masukkan sesuai nominal yang ditransfer</small>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="catatan_santri">Catatan (Opsional)</label>
                                                            <textarea class="form-control" id="catatan_santri" name="catatan_santri" rows="3"></textarea>
                                                            <small class="form-text text-muted">Tambahkan catatan jika diperlukan</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="bukti_pembayaran">Bukti Pembayaran <span class="text-danger">*</span></label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,.pdf" required>
                                                                <label class="custom-file-label" for="bukti_pembayaran">Pilih file...</label>
                                                            </div>
                                                            <small class="form-text text-muted">Format: JPG, PNG, atau PDF. Maks 2MB</small>
                                                        </div>
                                                        <div id="preview" class="mt-3 text-center">
                                                            <!-- Preview akan ditampilkan di sini -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-paper-plane me-2"></i> Kirim Bukti Pembayaran
                                                    </button>
                                                </div>
                                            </form>
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

<!-- Modal untuk Zoom Image - tambahkan di dekat penutup </div> terakhir sebelum tag </body> -->
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
                    <img id="zoomed-image" src="<?= base_url('uploads/bukti_pembayaran/' . ($pembayaran->bukti_pembayaran ?? '')) ?>"
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

<!-- CSS untuk efek fancy pada gambar - tambahkan sebelum penutup </head> -->
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

<!-- JavaScript untuk fungsi fancy image - tambahkan di dekat penutup </body> -->
<script>
    $(document).ready(function() {
        // Format nominal dengan titik ribuan
        $('#nominal_bayar').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
        });

        // Preview bukti pembayaran
        $('#bukti_pembayaran').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const fileType = file.type.split('/')[0];
                    if (fileType === 'image') {
                        $('#preview').html(`
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <img src="${e.target.result}" class="img-fluid" style="max-height: 200px;">
                                    <p class="mt-2 mb-0">${file.name} (${(file.size/1024).toFixed(2)} KB)</p>
                                </div>
                            </div>
                        `);
                    } else {
                        $('#preview').html(`
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                    <p class="mt-2 mb-0">${file.name} (${(file.size/1024).toFixed(2)} KB)</p>
                                </div>
                            </div>
                        `);
                    }
                }
                reader.readAsDataURL(file);
            } else {
                $('#preview').html('');
            }
        });

        // Update custom file input label
        $('.custom-file-input').change(function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName || 'Pilih file...');
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