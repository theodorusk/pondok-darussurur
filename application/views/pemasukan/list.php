
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
                    <span>Data Pemasukan</span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-stats card-success card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="icon-big text-center">
                                    <i class="fas fa-money-bill-wave text-success"></i>
                                </div>
                            </div>
                            <div class="col-9 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Total Pemasukan</p>
                                    <h4 class="card-title">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Filter Data</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="formFilter" class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-filter mr-2"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pemasukan-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Santri</th>
                                        <th>Tagihan</th>
                                        <th>Nominal</th>
                                        <th>Tanggal</th>
                                        <th>Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pemasukan as $index => $item): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $item->nis ?></td>
                                            <td><?= htmlspecialchars($item->nama_santri, ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($item->nama_tagihan, ENT_QUOTES, 'UTF-8') ?></td>
                                            <td>Rp <?= number_format($item->nominal, 0, ',', '.') ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($item->tanggal_pemasukan)) ?></td>
                                            <td><?= htmlspecialchars($item->nama_admin, ENT_QUOTES, 'UTF-8') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#pemasukan-table').DataTable({
        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        }
    });

    // Handle filter form
    $('#formFilter').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?= base_url('pemasukan/filter') ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    table.clear().draw();
                    response.data.forEach((item, index) => {
                        table.row.add([
                            index + 1,
                            item.nis,
                            item.nama_santri,
                            item.nama_tagihan,
                            `Rp ${formatNumber(item.nominal)}`,
                            formatDate(item.tanggal_pemasukan),
                            item.nama_admin
                        ]).draw(false);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});

function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}
</script>