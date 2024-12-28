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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px">No</th>
                                    <th>Nomor Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal dibuat</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Retur</th>
                                    <th>Total</th>
                                    <th style="width: 7%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rs_pesanan as $key => $pesanan)
                                    <tr>
                                        <td class="text-center">{{ $rs_pesanan->firstItem() + $key }}</td>
                                        <td>{{ $pesanan->pesanan_id }}</td>
                                        <td>{{ $pesanan->user->users_data->user_nama_lengkap }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($pesanan->pesanan_tgl)->translatedFormat('d F Y \\j\\a\\m H:i:s') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($pesanan->pesanan_st == 'waiting')
                                                <div class="btn btn-sm btn-warning">Menunggu</div>
                                            @endif
                                            @if ($pesanan->pesanan_st == 'approve')
                                                <div class="btn btn-sm btn-primary">Setujui</div>
                                            @endif
                                            @if ($pesanan->pesanan_st == 'reject')
                                                <div class="btn btn-sm btn-danger">Tolak</div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($pesanan->pesanan_bayar == 'yes')
                                                <div class="btn btn-sm btn-sm btn-success updt-pembayaran" data-status="yes"
                                                    data-pesanan_id="{{ $pesanan->pesanan_id }}">Sudah <i
                                                        class="fa fa-check"></i></div>
                                                <br />
                                                <small>{{ \Carbon\Carbon::parse($pesanan->pesanan_bayar_date)->translatedFormat('d F Y \\j\\a\\m H:i:s') }}</small>
                                            @endif
                                            @if ($pesanan->pesanan_bayar == 'no')
                                                <div class="btn btn-sm btn-sm btn-danger updt-pembayaran" data-status="no"
                                                    data-pesanan_id="{{ $pesanan->pesanan_id }}">Belum <i
                                                        class="fa
                                                    fa-times"></i>
                                                </div>
                                                <br />
                                                <small>{{ \Carbon\Carbon::parse($pesanan->pesanan_bayar_date)->translatedFormat('d F Y \\j\\a\\m H:i:s') }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($pesanan->retur->isEmpty())
                                                <div class="btn btn-sm btn-success">Tidak</div>
                                            @else
                                                <div class="btn btn-sm btn-danger">Ya</div>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            @php
                                                $ttl = 0;
                                            @endphp
                                            @foreach ($pesanan->pesanan_data as $psn_data)
                                                @php
                                                    $ttl += $psn_data->data_jlh * $psn_data->produk->produk_harga;
                                                @endphp
                                            @endforeach
                                            @if ($pesanan->retur->isEmpty())
                                                <div class="text-success"><b>Rp. {{ number_format($ttl, 0, ',', '.') }}</b>
                                                </div>
                                            @else
                                                <div class="text-danger"><b>Rp. {{ number_format($ttl, 0, ',', '.') }}</b>
                                                </div>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('detailPesanan', ['pesanan_id' => $pesanan->pesanan_id]) }}"
                                                class="btn btn-sm btn-info"><i class="fa fa-book"></i></a>
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
                        {{ $rs_pesanan->links() }}
                    </ul>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <div class="modal fade" id="modal-pembayaran">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ubah Status Pembayaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateStatusPembayaran') }}" method="POST"
                        onsubmit="return confirm('Apakah anda yakin akan merubah status pembayaran ..?')">
                        @method('POST')
                        @csrf
                        <input type="hidden" value="" name="pesanan_id" id="pesanan_id">
                        <button type="submit" value="" name="status" id="btn-update"
                            class="btn btn-primary">Simpan</button>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            $('.updt-pembayaran').on('click', function() {
                const status = $(this).data('status');
                const pesanan_id = $(this).data('pesanan_id');
                $('#pesanan_id').val(pesanan_id);
                let res_status = status === 'yes' ? 'no' : 'yes';
                let res_text_status = status === 'yes' ? 'Belum' : 'Sudah';
                let res_class = status === 'yes' ? 'btn-danger' : 'btn-success';
                $('#btn-update').val(res_status);
                $('#btn-update').html(res_text_status);
                $('#btn-update').addClass(res_class);
                $('#modal-pembayaran').modal('show');
            });
        });
    </script>
@endsection
