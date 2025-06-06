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
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('pengeluaran') ?>">Data Pengeluaran</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Edit Pengeluaran</span>
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
                        <form id="form-pengeluaran" action="<?= base_url('pengeluaran/update/' . $pengeluaran->id_pengeluaran) ?>" 
                              method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_pengeluaran">Nama Pengeluaran <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_pengeluaran" name="nama_pengeluaran" 
                                               value="<?= htmlspecialchars($pengeluaran->nama_pengeluaran) ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nominal">Nominal (Rp) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control nominal" id="nominal" name="nominal" 
                                               value="<?= number_format($pengeluaran->nominal, 0, ',', '.') ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_pengeluaran">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tanggal_pengeluaran" name="tanggal_pengeluaran" 
                                               value="<?= date('Y-m-d', strtotime($pengeluaran->tanggal_pengeluaran)) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" 
                                                  rows="3"><?= htmlspecialchars($pengeluaran->keterangan) ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="bukti_pengeluaran">Bukti Pengeluaran</label>
                                        <?php if ($pengeluaran->bukti_pengeluaran): ?>
                                            <div class="mb-2">
                                                <a href="<?= base_url('uploads/bukti_pengeluaran/' . $pengeluaran->bukti_pengeluaran) ?>" 
                                                   target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fa fa-file"></i> Lihat Bukti
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" id="bukti_pengeluaran" name="bukti_pengeluaran" 
                                               accept="image/*,.pdf">
                                        <small class="form-text text-muted">
                                            Format: JPG, JPEG, PNG, PDF. Maksimal 2MB
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-action">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
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
    // Initialize form validation
    $('#form-pengeluaran').validate({
        rules: {
            nama_pengeluaran: {
                required: true
            },
            nominal: {
                required: true
            },
            tanggal_pengeluaran: {
                required: true
            }
        },
        messages: {
            nama_pengeluaran: {
                required: "Nama pengeluaran wajib diisi"
            },
            nominal: {
                required: "Nominal wajib diisi"
            },
            tanggal_pengeluaran: {
                required: "Tanggal pengeluaran wajib diisi"
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    // Initialize number format
    $('.nominal').on('keyup', function() {
        let value = $(this).val();
        value = value.replace(/[^\d]/g, '');
        value = value ? parseInt(value) : 0;
        $(this).val(formatRupiah(value));
    });
});

function formatRupiah(angka) {
    let reverse = angka.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return ribuan;
}
</script>