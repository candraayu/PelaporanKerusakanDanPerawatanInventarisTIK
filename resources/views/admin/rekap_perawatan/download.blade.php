<!DOCTYPE html>
<html>
<head>
    <title>Rekap Perawatan</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 12px; 
            color: #333; 
            line-height: 1.6; 
        }

        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 2px solid #444; 
            padding-bottom: 10px; 
        }

        .header h2 { 
            margin: 0; 
            text-transform: uppercase; 
            color: #000; 
        }

        .header p { 
            margin: 5px 0 0; 
            font-size: 14px; 
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }

        th { 
            background-color: #f2f2f2; 
            color: #333; 
            font-weight: bold; 
            border: 1px solid #ddd; 
            padding: 10px 5px; 
            text-align: center; 
        }

        td { 
            border: 1px solid #ddd; 
            padding: 8px 5px; 
            vertical-align: top; 
        }

        .text-center { 
            text-align: center; 
        }

        .footer { 
            margin-top: 50px; 
            text-align: right; 
        }

        .footer p { 
            margin-bottom: 60px; 
        }

        @page { 
            size: A4; 
            margin: 2cm; 
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <h2>Rekap Perawatan Barang TIK</h2>

        <p>
            Kecamatan: 
            {{ Auth::user()->kecamatan->nama_kecamatan ?? 'Seluruh Kecamatan' }}
        </p>

        <p style="font-size: 11px;">
            Periode:
            {{ request('tanggal_awal') 
                ? \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') 
                : 'Awal' 
            }}
            s/d
            {{ request('tanggal_akhir') 
                ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') 
                : 'Sekarang' 
            }}
        </p>
    </div>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th width="120">Kecamatan</th>
                <th width="150">Nama Barang / Kode</th>
                <th width="120">Jenis Perawatan</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>

                <td class="text-center">
                    {{ \Carbon\Carbon::parse($item->tanggal_perawatan)->format('d/m/Y') }}
                </td>
                <td>
                    {{ $item->inventaris->kecamatan->nama_kecamatan ?? '-' }}
                </td>
                <td>
                    <strong>{{ $item->inventaris?->nama_barang }}</strong><br>
                    <small>{{ $item->inventaris?->kode_inventaris }}</small>
                </td>

                <td class="text-center">
                    {{ $item->jenis_perawatan }}
                </td>

                <td>
                    {{ $item->keterangan ?? '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i') }}</p>

        <strong>( ............................................ )</strong>
    </div>

</body>
</html>