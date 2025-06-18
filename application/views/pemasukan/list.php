
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
    // const table = $('#pemasukan-table').DataTable({
    //     responsive: true,
    //     language: {
    //         url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
    //     },
    //     // Define columns explicitly to avoid the unknown parameter error
    //     columns: [
    //         { title: "No" },
    //         { title: "NIS" },
    //         { title: "Nama Santri" },
    //         { title: "Tagihan" },
    //         { title: "Nominal" },
    //         { title: "Tanggal" },
    //         { title: "Admin" }
    //     ]
    // });

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
                    // Clear the table first
                    table.clear();
                    
                    // Add each row from the response data
                    let counter = 1;
                    $.each(response.data, function(index, item) {
                        // Format the data
                        const formattedDate = formatDate(item.tanggal_pemasukan);
                        const formattedNominal = 'Rp ' + formatNumber(item.nominal);
                        
                        // Add the row
                        table.row.add([
                            counter++,
                            item.nis,
                            item.nama_santri,
                            item.nama_tagihan,
                            formattedNominal,
                            formattedDate,
                            item.nama_admin
                        ]);
                    });
                    
                    // Draw the table to show the updated data
                    table.draw();
                    
                    // Update total pemasukan if available
                    if (response.total_pemasukan !== undefined) {
                        $('.card-title:contains("Total Pemasukan")').text('Rp ' + formatNumber(response.total_pemasukan));
                    }
                } else {
                    // Handle no data response
                    table.clear().draw();
                    alert('Tidak ada data yang sesuai dengan filter');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses permintaan');
            }
        });
    });
});

function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

function formatDate(dateString) {
    if (!dateString) return '-';
    
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return dateString; // Return original if invalid
    
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}
</script>