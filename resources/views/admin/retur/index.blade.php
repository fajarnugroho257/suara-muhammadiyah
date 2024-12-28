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
                {{-- <div class="card-header ">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('addRetur') }}" class="btn btn-block btn-success"><i class="fa fa-plus"></i>
                            Tambah</a>
                    </div>
                </div> --}}
                <form action="{{ route('searchRetur') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="card-header row">
                        <div class="col">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                        <div class="col-md-4 d-flex" style="align-items: center">
                            <input type="date" name="start" value="{{ $start ?? '' }}" class="form-control">
                            <small class="mx-2">sampai</small>
                            <input type="date" name="end" value="{{ $end ?? '' }}" class="form-control">
                        </div>
                        <div class="d-flex" style="gap: 5px">
                            <button type="submit" name="aksi" value="cari" class="btn btn-primary">Cari</button>
                            <button type="submit" name="aksi" value="reset" class="btn btn-dark">Reset</button>
                            <a href="{{ route('addRetur') }}" class="btn btn-block btn-success"><i class="fa fa-plus"></i>
                                Tambah</a>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <div class="text-right">
                        <a href="{{ route('downloadRetur') }}" class="btn btn-success mb-3"><i class="fa fa-file-pdf"></i>
                            Download</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px">No</th>
                                    <th>Nomor Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>WhatsApp</th>
                                    <th>Tanggal Retur</th>
                                    <th>Alasan</th>
                                    <th>Items</th>
                                    <th>Total Pesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rs_retur as $key => $retur)
                                    <tr>
                                        <td class="text-center">{{ $rs_retur->firstItem() + $key }}</td>
                                        <td>{{ $retur->pesanan_id }}</td>
                                        <td>{{ $retur->pesanan->user->users_data->user_nama_lengkap }}</td>
                                        <td>{{ $retur->pesanan->user->users_data->user_telp }}</td>
                                        <td class="text-center">
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
                                            <p class="text-right mb-0 text-danger"><b>Rp.
                                                    {{ number_format($grand_total, 0, ',', '.') }}</b>
                                            </p>
                                        </td>
                                        <td class="text-right">
                                            <p class="mb-0 text-danger"><b>Rp.
                                                    {{ number_format($grand_total, 0, ',', '.') }}</b>
                                            </p>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        {{ $rs_retur->links() }}
                    </ul>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
