
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><?= $title ?></h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="<?= base_url('pengeluaran') ?>">Data Pengeluaran</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <span>Detail Pengeluaran</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Detail Pengeluaran</h4>
                            <a href="<?= base_url('pengeluaran') ?>" class="btn btn-secondary btn-round">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="35%">Nama Pengeluaran</th>
                                            <td><?= htmlspecialchars($pengeluaran->nama_pengeluaran) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nominal</th>
                                            <td>Rp <?= number_format($pengeluaran->nominal, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td><?= date('d/m/Y H:i', strtotime($pengeluaran->tanggal_pengeluaran)) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td><?= nl2br(htmlspecialchars($pengeluaran->keterangan ?? '-')) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Dibuat Oleh</th>
                                            <td><?= htmlspecialchars($pengeluaran->nama_admin) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Input</th>
                                            <td><?= date('d/m/Y H:i', strtotime($pengeluaran->created_at)) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="card-title fw-bold">Bukti Pengeluaran</div>
                                        <?php if ($pengeluaran->bukti_pengeluaran): ?>
                                            <?php
                                            $ext = pathinfo($pengeluaran->bukti_pengeluaran, PATHINFO_EXTENSION);
                                            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])):
                                            ?>
                                                <div class="bukti-pengeluaran-gallery">
                                                    <div class="image-container text-center">
                                                        <img src="<?= base_url('uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran) ?>"
                                                             alt="Bukti Pengeluaran" class="img-fluid rounded">
                                                        <div class="image-overlay">
                                                            <div class="overlay-buttons">
                                                                <button type="button" class="btn btn-light" onclick="zoomImage()">
                                                                    <i class="fa fa-search-plus"></i>
                                                                </button>
                                                                <a href="<?= base_url('uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran) ?>"
                                                                   class="btn btn-light" download>
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center">
                                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                                    <p class="mt-2">File bukti pengeluaran (<?= strtoupper($ext) ?>)</p>
                                                    <div class="mt-3">
                                                        <a href="<?= base_url('uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran) ?>"
                                                           class="btn btn-primary btn-sm" target="_blank">
                                                            <i class="fa fa-eye"></i> Lihat Dokumen
                                                        </a>
                                                        <a href="<?= base_url('uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran) ?>"
                                                           class="btn btn-info btn-sm" download>
                                                            <i class="fa fa-download"></i> Download
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="alert alert-warning">
                                                Bukti pengeluaran tidak tersedia
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
    </div>
</div>

<!-- Modal Zoom Image -->
<div class="modal fade" id="imageZoomModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="image-zoom-container">
                    <img id="zoomed-image" src="" class="img-fluid" alt="Bukti Pengeluaran">
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-light" id="zoom-in">
                        <i class="fa fa-search-plus"></i> Perbesar
                    </button>
                    <button type="button" class="btn btn-light" id="zoom-out">
                        <i class="fa fa-search-minus"></i> Perkecil
                    </button>
                    <button type="button" class="btn btn-light" id="rotate-image">
                        <i class="fa fa-sync"></i> Putar
                    </button>
                    <button type="button" class="btn btn-light" id="reset-image">
                        <i class="fa fa-undo"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.image-container {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.image-container:hover .image-overlay {
    opacity: 1;
}

.overlay-buttons {
    display: flex;
    gap: 10px;
}

.image-zoom-container {
    position: relative;
    min-height: 400px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

#zoomed-image {
    max-height: 70vh;
    transition: transform 0.3s;
}
</style>

<script>
let currentZoom = 1;
let currentRotation = 0;

function zoomImage() {
    const imgSrc = document.querySelector('#bukti-image').src;
    document.querySelector('#zoomed-image').src = imgSrc;
    $('#imageZoomModal').modal('show');
}

$(document).ready(function() {
    $('#zoom-in').click(function() {
        currentZoom += 0.1;
        updateImageTransform();
    });

    $('#zoom-out').click(function() {
        if (currentZoom > 0.5) {
            currentZoom -= 0.1;
            updateImageTransform();
        }
    });

    $('#rotate-image').click(function() {
        currentRotation += 90;
        updateImageTransform();
    });

    $('#reset-image').click(function() {
        currentZoom = 1;
        currentRotation = 0;
        updateImageTransform();
    });

    $('#imageZoomModal').on('show.bs.modal', function() {
        currentZoom = 1;
        currentRotation = 0;
        updateImageTransform();
    });
});

function updateImageTransform() {
    const image = document.querySelector('#zoomed-image');
    image.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
}
</script>