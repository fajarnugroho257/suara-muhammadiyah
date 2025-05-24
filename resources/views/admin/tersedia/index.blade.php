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
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 10px">No</th>
                                <th>Kategori</th>
                                <th>Nama Produk</th>
                                <th>Rating Produk</th>
                                <th>Harga</th>
                                <th>Reorder Point</th>
                                <th>Stok</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rs_produk as $key => $produk)
                                @php $stColor = $produk->produk_stok <= 0 ? "table-danger" : "" @endphp
                                <tr class="{{ $stColor }}">
                                    <td class="text-center">{{ $rs_produk->firstItem() + $key }}</td>
                                    <td>{{ $produk->kategori->kategori_nama }}</td>
                                    <td>{{ $produk->produk_nama }}</td>
                                    <td class="text-center">
                                        @for ($i = 0; $i < $produk->produk_rating; $i++)
                                            <i class="fa fa-star" style="color: yellow"></i>
                                        @endfor
                                    </td>
                                    <td class="text-center">Rp {{ number_format($produk->produk_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">{{ $produk->hitung_eoq ? $produk->hitung_eoq->eoq_rop : 'Belum dihitung' }}</td>
                                    <td class="text-center">{{ $produk->produk_stok }}</td>
                                    <td class="text-center"><img class="img-fluid img-thumbnail" height="50"
                                            width="50" src="{{ asset('image/produk/' . $produk->produk_image) }}"
                                            alt=""></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        {{ $rs_produk->links() }}
                    </ul>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
