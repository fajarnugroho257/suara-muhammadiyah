<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Penjualan</title>
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
    <h2 style="text-align: center">LAPORAN FREKUENSI PENJUALAN</h2>
    <h4 style="text-align: center">{{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y ') }} -
        {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y ') }}</h4>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; width: 5%;">No</th>
                <th style="text-align: center; width: 55%;">Produk</th>
                <th style="text-align: center; width: 40%;">Penjualan</th>
            </tr>
        </thead>
        @php
            $no = 1;
        @endphp
        <tbody>
        @foreach ($rs_data as $key => $data)
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td>{{ $data->produk->produk_nama }}</td>
                    <td style="text-align: center;">{{ $data->jlh_terjual}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
