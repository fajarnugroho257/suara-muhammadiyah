@extends('template.base.base')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            @session('success')
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endsession
            @session('error')
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endsession
            <!-- Default box -->
            <div class="card">
                <form action="{{ route('searchLaporan') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="card-header row">
                        <div class="col">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>

                        <div class="col-4 d-flex" style="align-items: center">
                            <input type="date" name="start" value="{{ $start ?? '' }}" class="form-control">
                            <small class="mx-2">sampai</small>
                            <input type="date" name="end" value="{{ $end ?? '' }}" class="form-control">
                        </div>
                        <div>
                            <button type="submit" name="aksi" value="cari" class="btn btn-primary">Cari</button>
                            <button type="submit" name="aksi" value="reset" class="btn btn-dark">Reset</button>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <div class="text-right">
                        <a href="{{ route('downloadLaporanPesanan') }}" class="btn btn-success mb-3"><i
                                class="fa fa-file-pdf"></i> Download</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px">No</th>
                                    <th>Nomor Pesanan</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Tanggal dibuat</th>
                                    <th width="30%">Items</th>
                                    <th width="12%">Total Pesanan</th>
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
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $data->pesanan_id }}</td>
                                        <td>{{ $data->user->users_data->user_nama_lengkap }}</td>
                                        <td class="text-center">
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
                                        <td class="text-center">
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
                                            <p class="text-right mb-0 text-danger"><b>Rp.
                                                    {{ number_format($grand_total, 0, ',', '.') }}</b>
                                            </p>
                                        </td>
                                        <td>
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
                                    <td class="text-right" colspan="6"><b>Grand Total</b></td>
                                    <td>
                                        <p class="text-right mb-0 text-danger"><b>Rp.
                                                {{ number_format($all_grand_total, 0, ',', '.') }}</b>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                    </ul>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
