<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rekap Laporan Kerusakan</title>
    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #000; padding: 8px; text-align: left; }
        table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .status { text-transform: capitalize; font-weight: bold; }
        .footer { margin-top: 30px; float: right; width: 200px; text-align: center; }
        .footer p { margin-bottom: 60px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Sekarang</button>
    </div>

    <div class="header">
        <h2>Rekap Laporan Kerusakan Barang</h2>
        <p>Periode: {{ request('tgl_mulai') ?? 'Semua' }} s/d {{ request('tgl_selesai') ?? 'Sekarang' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Pelapor</th>
                <th width="25%">Barang / Kode</th>
                <th width="25%">Deskripsi Kerusakan</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->user->nama }}</td>
                <td>
                    {{ $item->inventaris->nama_barang }}<br>
                    <small>({{ $item->inventaris->kode_inventaris }})</small>
                </td>
                <td>{{ $item->deskripsi_kerusakan }}</td>
                <td class="text-center status">{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y') }}</p>
        <br>
        <strong>Teguh Endratno, S.E., M.M.</strong>
    </div>

    <script>
        window.onload = function() {
        }
    </script>
</body>
</html>
