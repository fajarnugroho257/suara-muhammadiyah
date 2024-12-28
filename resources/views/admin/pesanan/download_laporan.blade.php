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
    <h2 style="text-align: center">LAPORAN PENJUALAN</h2>
    <h4 style="text-align: center">{{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y ') }} -
        {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y ') }}</h4>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; width: 2%;">No</th>
                <th style="text-align: center; width: 10%;">Nomor Pesanan</th>
                <th style="text-align: center; width: 18%;">Nama</th>
                <th style="text-align: center; width: 5%;">Status</th>
                <th style="text-align: center; width: 15%;">Tanggal dibuat</th>
                <th style="text-align: center; width: 30%;">Items</th>
                <th style="text-align: center; width: 15%;">Total Pesanan</th>
            </tr>
        </thead>
        @php
            $no = 1;
            $all_grand_total = 0;
        @endphp
        <tbody>
            @foreach ($rs_pesanan as $key => $data)
                @php
                    $grand_total = 0;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td>{{ $data->pesanan_id }}</td>
                    <td>{{ $data->user->users_data->user_nama_lengkap }}</td>
                    <td style="text-align: center;">
                        @if ($data->pesanan_st == 'waiting')
                            <div class="btn btn-warning">Menunggu</div>
                        @endif
                        @if ($data->pesanan_st == 'approve')
                            <div class="btn btn-primary">Setujui</div>
                        @endif
                        @if ($data->pesanan_st == 'reject')
                            <div class="btn btn-danger">Tolak</div>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        {{ \Carbon\Carbon::parse($data->pesanan_tgl)->translatedFormat('d F Y ') }}
                        <br />
                        Jam
                        {{ \Carbon\Carbon::parse($data->pesanan_tgl)->translatedFormat('H:i:s') }}
                    </td>
                    <td>
                        @php
                            $no_data = 1;
                        @endphp
                        @foreach ($data->pesanan_data as $psn_data)
                            @php
                                $total = $psn_data->data_jlh * $psn_data->produk->produk_harga;
                                $grand_total += $total;
                            @endphp
                            <div class="">
                                <p class="mb-0">{{ $no_data++ }}.
                                    {{ $psn_data->produk->produk_nama }}
                                </p>
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
                    </td>
                    <td style="text-align: right;">
                        <p class="text-right mb-0 text-danger"><b>Rp.
                                {{ number_format($grand_total, 0, ',', '.') }}</b>
                        </p>
                    </td>
                </tr>
                @php
                    $all_grand_total += $grand_total;
                @endphp
            @endforeach
            <tr>
                <td style="text-align: right;" colspan="6"><b>Grand Total</b></td>
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
