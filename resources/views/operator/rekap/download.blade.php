<!DOCTYPE html>
<html>
<head>
    <title>Rekap Laporan Kerusakan</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #000; }
        .header p { margin: 5px 0 0; font-size: 14px; }

        .info { margin-bottom: 20px; }
        .info table { border: none; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f2f2f2; color: #333; font-weight: bold; border: 1px solid #ddd; padding: 10px 5px; text-align: center; }
        td { border: 1px solid #ddd; padding: 8px 5px; vertical-align: top; }

        .status { text-transform: capitalize; font-weight: bold; }
        .footer { margin-top: 50px; text-align: right; }
        .footer p { margin-bottom: 60px; }

        @page { size: A4; margin: 2cm; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Rekap Laporan Kerusakan TIK</h2>
        <p>Kecamatan: {{ Auth::user()->kecamatan->nama_kecamatan ?? 'Seluruh Kecamatan' }}</p>
        <p style="font-size: 11px;">Periode:
            {{ request('tanggal_awal') ? \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') : 'Awal' }}
            s/d
            {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') : 'Sekarang' }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th width="150">Nama Barang / Kode</th>
                <th>Deskripsi Kerusakan</th>
                <th width="80">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $item->inventaris?->nama_barang }}</strong><br>
                    <small>{{ $item->inventaris?->kode_inventaris }}</small>
                </td>
                <td>{{ $item->deskripsi_kerusakan }}</td>
                <td style="text-align: center;" class="status">{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>
        <strong>( ............................................ )</strong>
    </div>
</body>
</html>
