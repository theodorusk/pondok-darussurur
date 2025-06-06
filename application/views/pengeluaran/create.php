<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><?= $title ?></h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="<?= base_url('dashboard') ?>"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="<?= base_url('pengeluaran') ?>">Data Pengeluaran</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <span>Tambah Pengeluaran</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"><?= $title ?></div>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('error') ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <form id="form-pengeluaran" action="<?= base_url('pengeluaran/store') ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Pengeluaran <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_pengeluaran" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Nominal (Rp) <span class="text-danger">*</span></label>
                                        <input type="text" name="nominal" class="form-control nominal" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_pengeluaran" class="form-control" required value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Bukti Pengeluaran</label>
                                        <input type="file" name="bukti_pengeluaran" class="form-control" accept="image/*,.pdf">
                                        <small class="form-text text-muted">Format: JPG, JPEG, PNG, PDF (Max 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-action">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                <button type="reset" class="btn btn-warning"><i class="fa fa-undo"></i> Reset</button>
                                <a href="<?= base_url('pengeluaran') ?>" class="btn btn-danger"><i class="fa fa-times"></i> Batal</a>
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
    // Format nominal
    $('.nominal').on('keyup', function() {
        let val = $(this).val();
        val = val.replace(/[^\d]/g, '');
        val = val ? parseInt(val) : 0;
        $(this).val(formatRupiah(val));
    });
});

function formatRupiah(angka) {
    let reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return ribuan;
}
</script>