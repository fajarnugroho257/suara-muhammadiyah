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
                        <a href="{{ route('addPenerimaanBarang') }}" class="btn btn-block btn-success"><i
                                class="fa fa-plus"></i>
                            Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 10px">No</th>
                                <th>Nama Produk</th>
                                <th>Gambar</th>
                                <th>Stok Penerimaan</th>
                                <th>Harga Pembelian</th>
                                <th>Tanggal</th>
                                <th>Suplier</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rs_data as $key => $data)
                                <tr>
                                    <td class="text-center">{{ $rs_data->firstItem() + $key }}</td>
                                    <td>{{ $data->produk->produk_nama }}</td>
                                    <td class="text-center"><img class="img-fluid img-thumbnail" height="50"
                                            width="50" src="{{ asset('image/produk/' . $data->produk->produk_image) }}"
                                            alt=""></td>
                                    <td class="text-center">{{ $data->penerimaan_jumlah }}</td>
                                    <td class="text-center">Rp {{ number_format($data->penerimaan_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($data->penerimaan_tgl)->translatedFormat('d F Y') }}</td>
                                    <td class="text-center">{{ $data->penerimaan_suplier }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('updatePenerimaanBarang', [$data->id]) }}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                        <a href="{{ route('deletePenerimaan', [$data->id]) }}"
                                            onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')"
                                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        {{ $rs_data->links() }}
                    </ul>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
