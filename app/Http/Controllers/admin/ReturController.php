<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Pesanan;
use App\Models\admin\PesananData;
use App\Models\admin\Produk;
use App\Models\admin\Retur;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Data Retur Pembelian';
        $start_ses = session()->get('start_retur');
        $end_ses = session()->get('end_retur');
        $start = empty($start_ses) ? date('Y-m-01') : $start_ses;
        $end = empty($end_ses) ? date('Y-m-d') : $end_ses;
        $data['start'] = $start;
        $data['end'] = $end;
        //
        $data['rs_retur'] = Retur::with(['pesanan.pesanan_data.produk', 'pesanan.user.users_data'])
            ->whereBetween(DB::raw('DATE(retur_date)'), [$start, $end])
            ->orderBy('retur_date', 'DESC')->paginate('10');
        // dd($data);
        return view('admin.retur.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah Retur Pembelian';
        $data['rs_pesanan'] = Pesanan::where('pesanan_st', 'approve', )->whereNotIn('pesanan_id', function ($query) {
            $query->select('pesanan_id')->from('retur');
        })->get();
        return view('admin.retur.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'pesanan_id' => 'required',
            'retur_alasan' => 'nullable',
        ]);
        // dd($validated);
        $validated['retur_date'] = date('Y-m-d H:i:s');
        if (Retur::create($validated)) {
            // update stok
            $pesanan_data = PesananData::where('pesanan_id', $request->pesanan_id)->get();
            // dd($pesanan_data);
            foreach ($pesanan_data as $key => $value) {
                $produk = Produk::where('id', $value['produk_id'])->first();
                $stok = $produk->produk_stok;
                $sisa = $stok + $value['data_jlh'];
                // update produk
                $produk->produk_stok = $sisa;
                $produk->save();
            }
            return redirect()->route('addRetur')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('addRetur')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $pesanan_id = $request->pesanan_id;
        $detail = Pesanan::with(['user.users_data', 'pesanan_data.produk'])->where('pesanan_id', $pesanan_id)->first();
        // dd($detail);
        $html = '';
        $html .= '<div class="row">
                        <div class="col-2">No Pesanan</div>
                        <div class="col-1">:</div>
                        <div class="col-9">' . $detail->pesanan_id . '</div>
                    </div>
                    <div class="row">
                        <div class="col-2">Tanggal Pesanan</div>
                        <div class="col-1">:</div>
                        <div class="col-9">' . Carbon::parse($detail->pesanan_tgl)->translatedFormat('d F Y \\j\\a\\m H:i:s') . '</div>
                    </div>
                    <div class="row">
                        <div class="col-2">Nama</div>
                        <div class="col-1">:</div>
                        <div class="col-9">' . $detail->user->users_data->user_nama_lengkap . '</div>
                    </div>
                    <div class="row">
                        <div class="col-2">Telp/Wa</div>
                        <div class="col-1">:</div>
                        <div class="col-9">' . $detail->user->users_data->user_telp . '</div>
                    </div>';
        $html .= '<table class="table table-bordered mt-3">';
        $html .= '<thead>
                            <tr class="text-center">
                                <th style="width: 10px">No</th>
                                <th>Produk</th>
                                <th>Image</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>';
        // data
        $no = 1;
        $grandTotal = 0;
        foreach ($detail->pesanan_data as $value) {
            $total = $value->data_jlh * $value->produk->produk_harga;
            $grandTotal += $total;
            //
            $html .= '<tr>';
            $html .= '  <td class="text-center">';
            $html .= $no++;
            $html .= '  </td>';
            $html .= '  <td>';
            $html .= $value->produk->produk_nama;
            $html .= '  </td>';
            $html .= '<td class="text-center"> <img width="150" height="150" class=""
                                                src=' . asset('image/produk/' . $value->produk->produk_image) . '
                                                alt=""></td>';
            $html .= '  <td class="text-right">';
            $html .= 'Rp. ' . number_format($value->produk->produk_harga, 0, ',', '.');
            $html .= '  </td>';
            $html .= '  <td class="text-center">';
            $html .= $value->data_jlh;
            $html .= '  </td>';
            $html .= '  <td class="text-right">';
            $html .= 'Rp. ' . number_format($total, 0, ',', '.');
            $html .= '  </td>';
            $html .= '</tr>';
        }
        // data
        $html .= '  <td colspan="5" class="text-right">';
        $html .= 'Grand Total';
        $html .= '  </td>';
        $html .= '  <td class="text-right">';
        $html .= 'Rp. ' . number_format($grandTotal, 0, ',', '.');
        $html .= '  </td>';
        $html .= '</tr>';
        $html .= '</table>';
        if (empty($detail)) {
            // abort(404);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak tersedia!',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Oke..',
                'html' => $html,
                // 'detail' => $detail,
            ]);
        }
    }
    public function download_retur()
    {
        $data['title'] = 'Download Retur Pesanan';

        $start_ses = session()->get('start_retur');
        $end_ses = session()->get('end_retur');
        $start = empty($start_ses) ? date('Y-m-01') : $start_ses;
        $end = empty($end_ses) ? date('Y-m-d') : $end_ses;
        $data['start'] = $start;
        $data['end'] = $end;
        // dd($data);
        $rs_retur = Retur::with(['pesanan.pesanan_data.produk', 'pesanan.user.users_data'])
            ->whereBetween(DB::raw('DATE(retur_date)'), [$start, $end])
            ->orderBy('retur_date', 'DESC')->get();
        // Render view ke dalam PDF
        $pdf = Pdf::loadView('admin.retur.download', compact('rs_retur', 'start', 'end'))->setPaper('a4', 'landscape');
        // Unduh PDF
        // return $pdf->stream();
        return $pdf->download('Laporan Retur Pesanan ' . $start . '-' . $end . '.pdf');
    }
    public function search_retur(Request $request)
    {
        // dd($request->all());
        if ($request->aksi == 'cari') {
            session([
                'start_retur' => $request->start,
                'end_retur' => $request->end,
            ]);
        } else {
            session()->forget(['start_retur', 'end_retur']);
        }
        return redirect()->route('returPembelian');
    }
}
