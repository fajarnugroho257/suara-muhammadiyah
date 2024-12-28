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

            <!-- Default box -->
            <div class="card">

                <div class="card-header ">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('dataProduk') }}" class="btn btn-block btn-success"><i
                                class="fa fa-arrow-left"></i>
                            Kembali</a>
                    </div>
                </div>
                <form action="{{ route('addProsesProduk') }}" method="POST" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label>Kategori</label>
                                    <select class="form-control select2" name="kategori_id" style="width: 100%;">
                                        <option value=""></option>
                                        @foreach ($rs_kategori as $kategori)
                                            <option value="{{ $kategori->kategori_id }}" @selected(old('kategori_id') == $kategori->kategori_id)>
                                                {{ $kategori->kategori_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Nama Produk</label>
                                        <input type="text" value="{{ old('produk_nama') }}" name="produk_nama"
                                            class="form-control" placeholder="Nama Produk">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Rating Produk</label>
                                        <input type="number" value="{{ old('produk_rating') }}" name="produk_rating"
                                            class="form-control" placeholder="Rating Produk">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input type="number" value="{{ old('produk_harga') }}" name="produk_harga"
                                            class="form-control" placeholder="Harga">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Stok</label>
                                        <input type="number" value="{{ old('produk_stok') }}" name="produk_stok"
                                            class="form-control" placeholder="Stok">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Gambar</label>
                                        <input type="file" value="" name="produk_image" class="form-control"
                                            placeholder="gambar">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control" name="produk_deskripsi" id="" cols="10" rows="4">{{ old('produk_deskripsi') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Gambar Lainnya</label>
                                        <input type="file" value="" name="data_image[]" multiple
                                            class="form-control" placeholder="Stok">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
