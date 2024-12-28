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
                <div class="card-header ">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('dataPesanan') }}" class="btn btn-block btn-success"><i
                                class="fa fa-arrow-left"></i>
                            Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        @if ($pesanan->pesanan_st != 'waiting')
                            <p>Pesanan sudah dilakukan perubahan status</p>
                        @endif
                        @if ($pesanan->pesanan_st == 'approve')
                            <div class="btn btn-primary"><i class="fa fa-check"></i> Pesanan disetujui</div>
                        @endif
                        @if ($pesanan->pesanan_st == 'reject')
                            <div class="btn btn-danger"><i class="fa fa-times"></i> Pesanan ditolak</div>
                        @endif
                    </div>
                    <h3 class="text-center">DETAIL PESANAN</h3>
                    <div class="row">
                        <div class="col-2">No Pesanan</div>
                        <div class="col-1">:</div>
                        <div class="col-9">{{ $pesanan->pesanan_id }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2">Tanggal Pesanan</div>
                        <div class="col-1">:</div>
                        <div class="col-9">
                            {{ \Carbon\Carbon::parse($pesanan->pesanan_tgl)->translatedFormat('d F Y \\j\\a\\m H:i:s') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">Nama</div>
                        <div class="col-1">:</div>
                        <div class="col-9">{{ $pesanan->user->users_data->user_nama_lengkap }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2">Telp/Wa</div>
                        <div class="col-1">:</div>
                        <div class="col-9">{{ $pesanan->user->users_data->user_telp }}</div>
                    </div>
                    <h3 class="text-center">DAFTAR ITEM PESANAN</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px">No</th>
                                    <th>Produk</th>
                                    <th class="text-center">Foto</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grand_total = 0;
                                @endphp
                                @foreach ($rs_pesanan as $key => $data)
                                    @php
                                        $total = $data->produk->produk_harga * $data->data_jlh;
                                        $grand_total += $total;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $rs_pesanan->firstItem() + $key }}</td>
                                        <td>{{ $data->produk->produk_nama }}</td>
                                        <td class="text-center"> <img width="150" height="150" class=""
                                                src="{{ asset('image/produk/' . $data->produk->produk_image) }}"
                                                alt=""></td>
                                        <td class="text-center">
                                            Rp. {{ number_format($data->produk->produk_harga, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $data->data_jlh }}</td>
                                        <td class="text-center">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right">Grand Total</td>
                                    <td class="text-center">Rp {{ number_format($grand_total, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    @if ($pesanan->pesanan_st == 'waiting')
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('stPesanan', ['pesanan_id' => $pesanan->pesanan_id, 'status' => 'reject']) }}"
                                type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah anda yakin akan menolak pesanan ini ..?')"><i
                                    class="fa fa-times"></i> Tolak Pesanan</a>
                            <a href="{{ route('stPesanan', ['pesanan_id' => $pesanan->pesanan_id, 'status' => 'approve']) }}"
                                type="submit" class="btn btn-primary"
                                onclick="return confirm('Apakah anda yakin akan menyetujui pesanan ini ..?')"><i
                                    class="fa fa-check"></i> Setujui
                                Pesanan</a>
                        </div>
                    @endif
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
