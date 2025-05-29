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
            <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">Arus Barang</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="true">Frekuensi Barang</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Barang Tidak Bergerak</a>
                  </li>
                </ul>
              </div>
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <div class="card-body">
                        <h5>Penjualan Produk</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px">No</th>
                                    <th>Produk</th>
                                    <th>Status</th>
                                    <th>Masuk</th>
                                    <th>Jumlah</th>
                                    <th>Akhir</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
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
                                        <td class="text-center">{{ $rs_data->firstItem() + $key }}</td>
                                        <td><img class="img-fluid img-thumbnail" height="50" width="50" src="{{ asset('image/produk/' . $data->produk->produk_image) }}"alt=""> {{ $data->produk->produk_nama }}</td>
                                        <td class="text-center">{!! $log_st !!}</td>
                                        <td class="text-center">{{ $data->log_awal }}</td>
                                        <td class="text-center {{ $text }}"><b>{{ $data->log_jumlah }}</b></td>
                                        <td class="text-center">{{ $data->log_akhir }} {!! $log_akhir !!}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y : H:m:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            {{ $rs_data->links() }}
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                    <div class="card-body">
                        <h5>Frekuensi penjualan</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px">No</th>
                                    <th>Produk</th>
                                    <th>Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($rs_penjualan as $key => $penjualan)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td><img class="img-fluid img-thumbnail" height="50" width="50" src="{{ asset('image/produk/' . $penjualan->produk->produk_image) }}"alt=""> {{ $penjualan->produk->produk_nama }}</td>
                                        <td class="text-center">{{ $penjualan->jlh_terjual }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                    <div class="card-body">
                        <h5>Produk tidak bergerak selama 3 bulan terakhir</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px">No</th>
                                    <th>Produk</th>
                                    <th>Stok</th>
                                    <th>Terkahir Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($rs_tdk_bergerak as $key => $tdk_bergerak)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td><img class="img-fluid img-thumbnail" height="50" width="50" src="{{ asset('image/produk/' . $tdk_bergerak->produk_image) }}"alt=""> {{ $tdk_bergerak->produk_nama }}</td>
                                        <td class="text-center">{{ $tdk_bergerak->produk_stok }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($tdk_bergerak->created_at)->translatedFormat('d F Y : H:m:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
              <!-- /.card -->
            </div>
            <div class="card">
                
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
