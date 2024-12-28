<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Retur Pemesanan</title>
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
    <h2 style="text-align: center">LAPORAN RETUR PESANAN</h2>
    <h4 style="text-align: center">{{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y ') }} -
        {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y ') }}</h4>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; width: 2%;">No</th>
                <th style="text-align: center; width: 10%;">Nomor Pesanan</th>
                <th style="text-align: center; width: 15%;">Nama</th>
                <th style="text-align: center; width: 5%;">Whatsapp</th>
                <th style="text-align: center; width: 15%;">Tanggal Retur</th>
                <th style="text-align: center; width: 13%;">Alasan</th>
                <th style="text-align: center; width: 17%;">Items</th>
                <th style="text-align: center; width: 13%;">Total Pesanan</th>
            </tr>
        </thead>
        @php
            $no = 1;
            $all_grand_total = 0;
        @endphp
        <tbody>
            @foreach ($rs_retur as $key => $retur)
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td>{{ $retur->pesanan_id }}</td>
                    <td>{{ $retur->pesanan->user->users_data->user_nama_lengkap }}</td>
                    <td>{{ $retur->pesanan->user->users_data->user_telp }}</td>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($retur->retur_date)->translatedFormat('d F Y \\j\\a\\m H:i:s') }}
                    </td>
                    <td>{{ $retur->retur_alasan }}</td>
                    <td>
                        @php
                            $no_data = 1;
                            $grand_total = 0;
                        @endphp
                        @foreach ($retur->pesanan->pesanan_data as $psn_data)
                            @php
                                $total = $psn_data->data_jlh * $psn_data->produk->produk_harga;
                                $grand_total += $total;
                            @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <p class="mb-0">{{ $no_data++ }}.
                                    {{ $psn_data->produk->produk_nama }}</p>
                                <div>
                                    <p class="mb-0"><b><span
                                                class="text-danger">({{ $psn_data->data_jlh }})</span></b>
                                        <b>X
                                            Rp.
                                            {{ number_format($psn_data->produk->produk_harga, 0, ',', '.') }}
                                            =
                                            Rp.
                                            {{ number_format($total, 0, ',', '.') }}
                                        </b>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <hr / class="mt-0 mb-0">
                        <p style="text-align: right;"><b>Rp.
                                {{ number_format($grand_total, 0, ',', '.') }}</b>
                        </p>
                    </td>
                    <td class="text-right">
                        <p style="text-align: right;"><b>Rp.
                                {{ number_format($grand_total, 0, ',', '.') }}</b>
                        </p>
                    </td>
                </tr>
                @php
                    $all_grand_total += $grand_total;
                @endphp
            @endforeach
            <tr>
                <td style="text-align: right;" colspan="7"><b>Grand Total</b></td>
                <td style="text-align: right;">
                    <p><b>Rp.
                            {{ number_format($all_grand_total, 0, ',', '.') }}</b>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
