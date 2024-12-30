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
                        <a href="{{ route('akunPelanggan') }}" class="btn btn-block btn-success"><i
                                class="fa fa-arrow-left"></i>
                            Kembali</a>
                    </div>
                </div>
                <form action="{{ route('addProsesAkunPelanggan') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Nama lengkap</label>
                                    <input type="text" value="{{ old('user_nama_lengkap') }}" name="user_nama_lengkap"
                                        class="form-control" placeholder="Nama Lengkap">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" value="{{ old('nik') }}" name="nik" class="form-control"
                                        placeholder="NIK">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" value="{{ old('user_alamat') }}" name="user_alamat"
                                        class="form-control" placeholder="Alamat">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Telp / WA</label>
                                    <input type="text" value="{{ old('user_telp') }}" name="user_telp"
                                        class="form-control" placeholder="Telp / WA">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Foto Profil</label>
                                    <input type="file" value="{{ old('image') }}" name="image" class="form-control"
                                        placeholder="Foto Profil">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" value="{{ old('user_tgl_lahir') }}" name="user_tgl_lahir"
                                        class="form-control" placeholder="Alamat">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="user_jk" id="" class="form-control">
                                        <option value="">Pilih Gender</option>
                                        <option value="L" @selected(old('user_jk') == 'L')>LAKI - LAKI</option>
                                        <option value="P" @selected(old('user_jk') == 'P')>PEREMPUAN</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" value="{{ old('username') }}" name="username"
                                        class="form-control" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" value="{{ old('password') }}" name="password"
                                        class="form-control" placeholder="Password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
