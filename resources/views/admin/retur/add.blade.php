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
                        <a href="{{ route('returPembelian') }}" class="btn btn-block btn-success"><i
                                class="fa fa-arrow-left"></i>
                            Kembali</a>
                    </div>
                </div>
                <form action="{{ route('addProsesRetur') }}" method="POST"
                    onsubmit="return(confirm('Apakah anda yakin akan meretur pesanan ini.. ?'))">
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
                                    <label>Nomor Pesanan</label>
                                    <select class="form-control select2" name="pesanan_id" id="pesanan_id" required
                                        style="width: 100%;">
                                        <option value=""></option>
                                        @foreach ($rs_pesanan as $pesanan)
                                            <option value="{{ $pesanan->pesanan_id }}" @selected(old('pesanan_id') == $pesanan->pesanan_id)>
                                                {{ $pesanan->pesanan_id }} || {{ $pesanan->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <label>Detail Pesanan</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="res-data-pesanan"></div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Alasan</label>
                                        <textarea class="form-control" name="retur_alasan" id="" cols="10" rows="4">{{ old('retur_alasan') }}</textarea>
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
@section('javascript')
    <script>
        $(document).ready(function() {
            $('#pesanan_id').on('change', function() {
                const pesanan_id = $(this).val();
                // ajax request
                $.ajax({
                    url: "{{ route('ajaxDetailPesanan') }}",
                    type: 'POST', // Atur metode HTTP sesuai kebutuhan (POST, GET, dll.)
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF Token untuk keamanan
                        pesanan_id: pesanan_id, // Kirim data yang ingin dikirim ke server
                    },
                    success: function(response) {
                        if (response.success) {
                            // Tindakan jika permintaan berhasil
                            console.log(response.message);
                            // console.log($this);
                            $('#res-data-pesanan').html(response.html);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tindakan jika permintaan gagal
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
