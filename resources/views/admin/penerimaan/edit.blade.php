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
                        <a href="{{ route('penerimaanBarang') }}" class="btn btn-block btn-success"><i
                                class="fa fa-arrow-left"></i>
                            Kembali</a>
                    </div>
                </div>
                <form action="{{ route('editProcessPenerimaanBarang', $detail->id) }}" method="POST">
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
                            <div class="row mb-5">
                                <div class="col-6">
                                    <label>Produk</label>
                                    <select class="form-control select2" required name="produk_id" id="produk_id" required
                                        style="width: 100%;">
                                        <option value=""></option>
                                        @foreach ($rs_produk as $produk)
                                            <option value="{{ $produk->id }}" @selected($detail->produk_id == $produk->id)>{{ $produk->produk_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label>Image</label>
                                    <img src="{{ asset('image/produk/images.png') }}" id="produk_image" alt=""
                                        width="150" height="150">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Penerimaan Stok</label>
                                        <input type="text" required onkeyup="hitunPenambahan()" id="penerimaan_jumlah" value="{{ old('penerimaan_jumlah', $detail->penerimaan_jumlah) }}"
                                            name="penerimaan_jumlah" class="form-control" placeholder="Penerimaan Stok">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Stok Saat Ini</label>
                                        <input type="text" required onkeyup="hitunPenambahan()" id="stok_now" readonly
                                            name="stok_now" class="form-control" placeholder="Stok Saat Ini">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Hasil Stok Penambahan</label>
                                        <input type="text" required readonly id="stok_hasil" readonly name="stok_hasil"
                                            class="form-control" placeholder=""
                                            style="background-color: rgba(230, 73, 73, 0.526); color: black;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Suplier</label>
                                        <input type="text" required name="penerimaan_suplier" class="form-control" placeholder="Suplier" value="{{ old('penerimaan_jumlah', $detail->penerimaan_suplier) }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Harga Pemerimaan</label>
                                        <input type="number" required name="penerimaan_harga" class="form-control" placeholder="Harga Pemerimaan" value="{{ old('penerimaan_jumlah', $detail->penerimaan_harga) }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Tanggal Pemerimaan</label>
                                        <input type="date" value="{{ now()->format('Y-m-d') }}" required
                                            name="penerimaan_tgl" class="form-control" placeholder="Tanggal Pemerimaan" value="{{ old('penerimaan_jumlah', $detail->penerimaan_tgl) }}">
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
            $('#produk_id').on('change', function() {
                const produk_id = $(this).val();
                // ajax request
                $.ajax({
                    url: "{{ route('ajaxDetailProduk') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF Token untuk keamanan
                        produk_id: produk_id, // Kirim data yang ingin dikirim ke server
                    },
                    success: function(response) {
                        if (response.success) {
                            // Tindakan jika permintaan berhasil
                            console.log(response.message);
                            console.log(response.image);
                            $('#produk_image').attr('src', response.image);
                            //
                            const penerimaanStok = $('#penerimaan_jumlah').val();
                            const nowStok = response.data.produk_stok;
                            const hasilPenambahan = parseInt(penerimaanStok) + parseInt(
                                nowStok);
                            $('#stok_hasil').val(hasilPenambahan);
                            // console.log($this);
                            $('#stok_now').val(response.data.produk_stok);
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
            $('#produk_id').trigger('change');
        });
        // hitung
        function hitunPenambahan() {
            const penerimaanStok = $('#penerimaan_jumlah').val();
            const nowStok = $('#stok_now').val();
            const hasilPenambahan = parseInt(penerimaanStok) + parseInt(nowStok);
            //
            $('#stok_hasil').val(hasilPenambahan);
        }
    </script>
@endsection
