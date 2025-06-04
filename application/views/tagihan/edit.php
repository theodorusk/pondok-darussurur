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
                    <a href="<?= base_url('Tagihan') ?>">Manajemen Tagihan</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Edit Tagihan</span>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Edit Tagihan</h4>
                            <a href="<?= base_url('Tagihan') ?>" class="btn btn-secondary btn-round">
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
                                <h5 class="alert-heading"><i class="fas fa-exclamation-circle mr-2"></i>Error!</h5>
                                <hr>
                                <?= $this->session->flashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form id="formTagihan" action="<?= base_url('Tagihan/update/' . $tagihan->id_tagihan) ?>" method="POST">
                            <input type="hidden" name="id_tagihan" value="<?= $tagihan->id_tagihan ?>">

                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_tagihan">Nama Tagihan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_tagihan" name="nama_tagihan"
                                            value="<?= set_value('nama_tagihan', $tagihan->nama_tagihan) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="id_kategori" name="id_kategori" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach ($kategori as $kat): ?>
                                                <option value="<?= $kat->id_kategori ?>" <?= $tagihan->id_kategori == $kat->id_kategori ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($kat->nama_kategori, ENT_QUOTES, 'UTF-8') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="nominal">Nominal (Rp) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nominal" name="nominal"
                                            value="<?= set_value('nominal', number_format($tagihan->nominal, 0, '', '.')) ?>" required>
                                        <small class="form-text text-muted">Format: Angka tanpa titik/koma</small>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                            value="<?= set_value('tanggal_mulai', date('Y-m-d', strtotime($tagihan->tanggal_mulai))) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo"
                                            value="<?= set_value('tanggal_jatuh_tempo', date('Y-m-d', strtotime($tagihan->tanggal_jatuh_tempo))) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="id_rekening">Rekening Pembayaran <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="id_rekening" name="id_rekening" required>
                                            <option value="">-- Pilih Rekening --</option>
                                            <?php foreach ($rekening as $rek): ?>
                                                <option value="<?= $rek->id_rekening ?>" <?= $tagihan->id_rekening == $rek->id_rekening ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($rek->nama_bank . ' - ' . $rek->no_rekening . ' - ' . $rek->atas_nama, ENT_QUOTES, 'UTF-8') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi Tagihan</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= set_value('deskripsi', $tagihan->deskripsi) ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-right">
                                <button type="reset" class="btn btn-light btn-round">Reset</button>
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
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
        // Format nominal dengan titik ribuan
        $('#nominal').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
        });

        // Form validation
        $('#formTagihan').validate({
            rules: {
                nama_tagihan: {
                    required: true,
                    maxlength: 100
                },
                id_kategori: {
                    required: true
                },
                nominal: {
                    required: true
                },
                tanggal_mulai: {
                    required: true
                },
                tanggal_jatuh_tempo: {
                    required: true
                },
                id_rekening: {
                    required: true
                }
            },
            messages: {
                nama_tagihan: {
                    required: "Nama tagihan wajib diisi",
                    maxlength: "Nama tagihan maksimal 100 karakter"
                },
                id_kategori: {
                    required: "Kategori wajib dipilih"
                },
                nominal: {
                    required: "Nominal tagihan wajib diisi"
                },
                tanggal_mulai: {
                    required: "Tanggal mulai wajib diisi"
                },
                tanggal_jatuh_tempo: {
                    required: "Tanggal jatuh tempo wajib diisi"
                },
                id_rekening: {
                    required: "Rekening pembayaran wajib dipilih"
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
            },
            submitHandler: function(form) {
                // Remove formatting from nominal before submit
                const nominalInput = $('#nominal');
                nominalInput.val(nominalInput.val().replace(/\./g, ''));

                form.submit();
            }
        });

        // Date validation - jatuh tempo harus > tanggal mulai
        $('#tanggal_jatuh_tempo').change(function() {
            const mulai = $('#tanggal_mulai').val();
            const jatuhTempo = $(this).val();

            if (mulai && jatuhTempo && new Date(jatuhTempo) <= new Date(mulai)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Tanggal jatuh tempo harus lebih besar dari tanggal mulai'
                });
                $(this).val('');
            }
        });

        $('#tanggal_mulai').change(function() {
            const mulai = $(this).val();
            const jatuhTempo = $('#tanggal_jatuh_tempo').val();

            if (mulai && jatuhTempo && new Date(jatuhTempo) <= new Date(mulai)) {
                $('#tanggal_jatuh_tempo').val('');
            }
        });
    });
</script>