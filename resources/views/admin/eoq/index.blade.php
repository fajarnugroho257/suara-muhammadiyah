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
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Nama Produk</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="form-control select2" id="produk_id" name="produk_id"
                                                style="width: 100%;">
                                                <option value=""></option>
                                                @foreach ($rs_produk as $produk)
                                                    <option value="{{ $produk->id }}">
                                                        {{ $produk->produk_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Permintaan tahunan (D)</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="permintaan_tahunan" name="permintaan_tahunan"
                                                class="form-control" placeholder="Permintaan tahunan (D)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Biaya pesan (S)</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="biaya_pesan" name="biaya_pesan" class="form-control"
                                                placeholder="Biaya pesan (S)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Biaya simpan (H)</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="biaya_simpan" name="biaya_simpan" class="form-control"
                                                placeholder="Biaya simpan (H)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Harga per unit (P)</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="harga_per_unit" name="harga_per_unit"
                                                class="form-control" placeholder="Harga per unit (P)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Hari kerja per tahun (W)</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="hari_per_tahun" name="hari_per_tahun"
                                                class="form-control" placeholder="Hari kerja per tahun (W)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Jangka waktu (LT)</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="jangka_waktu" name="jangka_waktu" class="form-control"
                                                placeholder="Jangka waktu (LT)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <a href="javascript:;" class="btn btn-success"><i class="fa fa-calculator"></i>
                                            Hitung</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>EOQ</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="res_eoq" name="res_eoq" class="form-control"
                                                placeholder="Permintaan tahunan (D)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Jumlah Pesanan / Tahun</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="res_pesanan_pertahun" name="res_pesanan_pertahun"
                                                class="form-control" placeholder="Permintaan tahunan (D)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Siklus Pemesanan</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="res_siklus" name="res_siklus" class="form-control"
                                                placeholder="Siklus Pemesanan">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>Total Biaya Tahunan</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="res_biaya_tahunan" name="res_biaya_tahunan"
                                                class="form-control" placeholder="Total Biaya Tahunan">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label>ROP (Reorder Point)</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="res_rop" name="res_rop" class="form-control"
                                                placeholder="ROP (Reorder Point)">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <a href="javascript:;" id="simpan" class="btn btn-primary"><i class="fa fa-save"></i>
                                            Simpan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">

                </div>
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
            $('#produk_id').on('change', function () {
                const produk_id = $(this).val();
                let data = {
                    _token: '{{ csrf_token() }}',
                    produk_id: $('#produk_id').val(),
                }
                // 
                $.ajax({
                    url: "{{ route('cariEoq') }}",
                    type: "POST",
                    data: data,
                    success: function(response) {
                        if (response.status == 'success') {
                            // hitung
                            // $('#produk_id').val(response.data.produk_id).change();
                            $('#permintaan_tahunan').val(response.data.hitung_tahunan);
                            $('#biaya_pesan').val(response.data.hitung_pesan);
                            $('#biaya_simpan').val(response.data.hitung_simpan);
                            $('#harga_per_unit').val(response.data.hitung_harga_unit);
                            $('#hari_per_tahun').val(response.data.hitung_hari_kerja);
                            $('#jangka_waktu').val(response.data.hitung_waktu);

                            // hasil
                            $('#res_eoq').val(response.data.eoq_nilai);
                            $('#res_pesanan_pertahun').val(response.data.eoq_pesanan);
                            $('#res_siklus').val(response.data.eoq_siklus);
                            $('#res_biaya_tahunan').val(response.data.eoq_biaya);
                            $('#res_rop').val(response.data.eoq_rop);
                        } else {
                            // $('#produk_id').val(null).change();
                            $('#permintaan_tahunan').val(null);
                            $('#biaya_pesan').val(null);
                            $('#biaya_simpan').val(null);
                            $('#harga_per_unit').val(null);
                            $('#hari_per_tahun').val(null);
                            $('#jangka_waktu').val(null);
                            // 
                            $('#res_eoq').val(null);
                            $('#res_pesanan_pertahun').val(null);
                            $('#res_siklus').val(null);
                            $('#res_biaya_tahunan').val(null);
                            $('#res_rop').val(null);
                        }
                        
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.error);
                        alert(xhr.responseJSON.error);
                    }
                });
            });
            // 
            $('.btn-success').on('click', function() {
                let data = {
                    _token: '{{ csrf_token() }}',
                    produk_id: $('#produk_id').val(),
                    permintaan_tahunan: $('#permintaan_tahunan').val(),
                    biaya_pesan: $('#biaya_pesan').val(),
                    biaya_simpan: $('#biaya_simpan').val(),
                    harga_per_unit: $('#harga_per_unit').val(),
                    hari_per_tahun: $('#hari_per_tahun').val(),
                    jangka_waktu: $('#jangka_waktu').val()
                };

                $.ajax({
                    url: "{{ route('hitungEoqProcess') }}",
                    type: "POST",
                    data: data,
                    success: function(response) {
                        $('#res_eoq').val(response.res_eoq);
                        $('#res_pesanan_pertahun').val(response.res_pesanan_pertahun);
                        $('#res_siklus').val(response.res_siklus);
                        $('#res_biaya_tahunan').val(response.res_biaya_tahunan);
                        $('#res_rop').val(response.res_rop);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.error);
                        alert(xhr.responseJSON.error);
                    }
                });
            });
            // simpan
            $('#simpan').on('click', function() {
                let data = {
                    _token: '{{ csrf_token() }}',
                    produk_id: $('#produk_id').val(),
                    permintaan_tahunan: $('#permintaan_tahunan').val(),
                    biaya_pesan: $('#biaya_pesan').val(),
                    biaya_simpan: $('#biaya_simpan').val(),
                    harga_per_unit: $('#harga_per_unit').val(),
                    hari_per_tahun: $('#hari_per_tahun').val(),
                    jangka_waktu: $('#jangka_waktu').val(),
                    // hasil
                    res_eoq : $('#res_eoq').val(),
                    res_pesanan_pertahun : $('#res_pesanan_pertahun').val(),
                    res_siklus : $('#res_siklus').val(),
                    res_biaya_tahunan : $('#res_biaya_tahunan').val(),
                    res_rop : $('#res_rop').val(),
                };

                $.ajax({
                    url: "{{ route('simpanEoqProcess') }}",
                    type: "POST",
                    data: data,
                    success: function(response) {
                        console.log(response);
                        alert(response.message);
                        // $('#res_eoq').val(response.res_eoq);
                        // $('#res_pesanan_pertahun').val(response.res_pesanan_pertahun);
                        // $('#res_siklus').val(response.res_siklus);
                        // $('#res_biaya_tahunan').val(response.res_biaya_tahunan);
                        // $('#res_rop').val(response.res_rop);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.error);
                        alert(xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
@endsection
