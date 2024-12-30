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
                        <a href="{{ route('addAkunPelanggan') }}" class="btn btn-block btn-success"><i
                                class="fa fa-plus"></i>
                            Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 10px">No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Profil</th>
                                <th>Username</th>
                                <th>Alamat</th>
                                <th>No Whatsapp</th>
                                <th>Gender</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rs_pelanggan as $key => $pelanggan)
                                <tr>
                                    <td class="text-center">{{ $rs_pelanggan->firstItem() + $key }}</td>
                                    <td>{{ $pelanggan->nik }}</td>
                                    <td>{{ $pelanggan->users_data->user_nama_lengkap }}</td>
                                    <td><img class="img-fluid img-thumbnail" height="150" width="150"
                                            src="{{ asset('image/profil/' . $pelanggan->users_data->image) }}"
                                            alt="">
                                    </td>
                                    <td>{{ $pelanggan->username }}</td>
                                    <td>{{ $pelanggan->users_data->user_alamat }}</td>
                                    <td class="text-center">{{ $pelanggan->users_data->user_telp }}</td>
                                    <td class="text-center">{{ $pelanggan->users_data->user_jk }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('editAkunPelanggan', [$pelanggan->user_id]) }}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                        <a href="{{ route('deleteAkunPelanggan', [$pelanggan->user_id]) }}"
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
                        {{ $rs_pelanggan->links() }}
                    </ul>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
