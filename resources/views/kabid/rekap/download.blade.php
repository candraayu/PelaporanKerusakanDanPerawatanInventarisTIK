<!DOCTYPE html>
<html>
<head>
    <title>Rekap Laporan Kerusakan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Rekap Laporan Kerusakan TIK</h2>
        <p>Dinas Kependudukan dan Pencatatan Sipil - Kabupaten Pati</p>
        @if(request('tanggal_awal') || request('tanggal_akhir'))
            <p>Periode: {{ request('tanggal_awal') ?? '...' }} s/d {{ request('tanggal_akhir') ?? '...' }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Barang</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d/m/Y') }}</td>
                <td>{{ $item->user->nama ?? '-' }}</td>
                <td>{{ $item->inventaris->nama_barang }} ({{ $item->inventaris->kode_inventaris }})</td>
                <td>{{ $item->deskripsi_kerusakan }}</td>
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Pati, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><strong>Teguh Endratno, S.E., M.M.</strong></p>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
