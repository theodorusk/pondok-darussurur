
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        
        h1 {
            font-size: 18pt;
            text-align: center;
            margin-bottom: 20px;
        }
        
        h2 {
            font-size: 14pt;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 30px 0;
        }
        
        table, th, td {
            border: 1px solid #000;
        }
        
        th, td {
            padding: 5px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        .summary-table {
            width: 100%;
            border: none;
            margin-bottom: 30px;
        }
        
        .summary-table td {
            padding: 5px;
            border: none;
        }
        
        .summary-table .label {
            font-weight: bold;
            width: 150px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN KEUANGAN PONDOK DARUSSURUR</h1>
        <p>Periode: <?= tanggal_indo($laporan->periode_awal) ?> - <?= tanggal_indo($laporan->periode_akhir) ?></p>
        <p><?= htmlspecialchars($laporan->keterangan) ?></p>
    </div>
    
    <h2>Ringkasan Laporan</h2>
    <table class="summary-table" border="0">
        <tr>
            <td class="label">ID Laporan</td>
            <td>: LAP<?= sprintf('%03d', $laporan->id_laporan) ?></td>
        </tr>
        <tr>
            <td class="label">Total Pemasukan</td>
            <td>: Rp <?= number_format($laporan->total_pemasukan, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td class="label">Total Pengeluaran</td>
            <td>: Rp <?= number_format($laporan->total_pengeluaran, 0, ',', '.') ?></td>
        </tr>
        <!-- Baris saldo awal telah dihapus -->
        <tr>
            <td class="label">Saldo Akhir</td>
            <td>: Rp <?= number_format($laporan->saldo_akhir, 0, ',', '.') ?></td>
        </tr>
    </table>
    
    <h2>Detail Pemasukan</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Santri</th>
                <th>Tagihan</th>
                <th>Nominal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($pemasukan)): ?>
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data pemasukan</td>
            </tr>
            <?php else: ?>
                <?php foreach ($pemasukan as $row): ?>
                <tr>
                    <td><?= tanggal_indo($row->tanggal_pemasukan) ?></td>
                    <td><?= $row->nis ?></td>
                    <td><?= htmlspecialchars($row->nama_santri) ?></td>
                    <td><?= htmlspecialchars($row->nama_tagihan) ?></td>
                    <td class="text-right">Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row->keterangan) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <h2>Detail Pengeluaran</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Pengeluaran</th>
                <th>Nominal</th>
                <th>Keterangan</th>
                <th>Dibuat Oleh</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($pengeluaran)): ?>
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data pengeluaran</td>
            </tr>
            <?php else: ?>
                <?php foreach ($pengeluaran as $row): ?>
                <tr>
                    <td><?= tanggal_indo($row->tanggal_pengeluaran) ?></td>
                    <td><?= htmlspecialchars($row->nama_pengeluaran) ?></td>
                    <td class="text-right">Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row->keterangan) ?></td>
                    <td><?= htmlspecialchars($row->created_by_name) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: <?= tanggal_waktu_indo(date('Y-m-d H:i:s')) ?></p>
    </div>
</body>
</html>