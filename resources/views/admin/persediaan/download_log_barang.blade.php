<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Arus Barang</title>
    <style>
        body {
            font-size: 12px;
            /* Atur ukuran font global */
            font-family: Arial, sans-serif;
        }

        h1 {
            font-size: 18px;
            /* Atur ukuran font judul */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            /* Ukuran font untuk tabel */
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            font-size: 12px;
            /* Ukuran font untuk header tabel */
        }
    </style>
</head>

<body>
    <h2 style="text-align: center">LAPORAN ARUS BARANG</h2>
    <h4 style="text-align: center">{{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y ') }} -
        {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y ') }}</h4>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; width: 5%;">No</th>
                <th style="text-align: center; width: 7%;">Kode Barang</th>
                <th style="text-align: center; width: 20%;">Barang</th>
                <th style="text-align: center; width: 22%;">Kategori</th>
                <th style="text-align: center; width: 10%;">Status</th>
                <th style="text-align: center; width: 7%;">Awal</th>
                <th style="text-align: center; width: 7%;">Jumlah</th>
                <th style="text-align: center; width: 7%;">Akhir</th>
                <th style="text-align: center; width: 15%;">Tanggal</th>
            </tr>
        </thead>
        @php
            $no = 1;
        @endphp
        <tbody>
        @foreach ($rs_data as $key => $data)
            @php
                if ($data->log_st == 'masuk') {
                    $log_st = '<span class="btn btn-sm btn-success">Masuk</span>';
                    $log_akhir = '<i class="fa fa-arrow-up text-success"></i>';
                    $text = 'text-success';
                } elseif ($data->log_st == 'keluar') {
                    $log_st = '<span class="btn btn-sm btn-danger">Keluar</span>';
                    $log_akhir = '<i class="fa fa-arrow-down text-danger"></i>';
                    $text = 'text-danger';
                }
            @endphp
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td style="text-align: center;">BRG{{ str_pad($data->produk->id, 3, '0', STR_PAD_LEFT) }} </td>
                    <td>{{ $data->produk->produk_nama }}</td>
                    <td>{{ $data->produk->kategori->kategori_nama }}</td>
                    <td style="text-align: center;">{!! $log_st !!}</td>
                    <td style="text-align: center;">{{ $data->log_awal }}</td>
                    <td style="text-align: center;"><b>{{ $data->log_jumlah }}</b></td>
                    <td style="text-align: center;">{{ $data->log_akhir }} {!! $log_akhir !!}</td>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y : H:m:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
