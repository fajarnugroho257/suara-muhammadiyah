<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\HitungEoq;
use App\Models\admin\Produk;
use Illuminate\Http\Request;

class HitungEoqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Hitung EOQ';
        $data['rs_produk'] = Produk::orderBy('produk_nama', 'ASC')->get();
        // dd($data);
        return view('admin.eoq.index', $data);
    }

    public function hitungEOQ(Request $request)
    {
        $permintaan_tahunan = $request->input('permintaan_tahunan');
        $biaya_pesan = $request->input('biaya_pesan');
        $biaya_simpan = $request->input('biaya_simpan');
        $harga_per_unit = $request->input('harga_per_unit');
        $hari_per_tahun = $request->input('hari_per_tahun');
        $jangka_waktu = $request->input('jangka_waktu');

        if ($permintaan_tahunan > 0 && $biaya_pesan > 0 && $biaya_simpan > 0 && $hari_per_tahun > 0 && $jangka_waktu > 0) {

            // Hitung EOQ
            $EOQ = sqrt((2 * $permintaan_tahunan * $biaya_pesan) / $biaya_simpan);

            // Hitung Jumlah Pesanan per Tahun
            $jumlah_pesanan_pertahun = $permintaan_tahunan / $EOQ;
            $jumlah_pesanan_pertahun = ceil($jumlah_pesanan_pertahun); // Dibulatkan ke atas

            // Hitung Siklus Pemesanan
            $siklus_pemesanan = $hari_per_tahun / $jumlah_pesanan_pertahun;

            // Hitung Total Biaya Tahunan
            $total_biaya_tahunan = ($permintaan_tahunan * $harga_per_unit) +
                (($permintaan_tahunan / $EOQ) * $biaya_pesan) +
                (($EOQ / 2) * $biaya_simpan);

            // Hitung ROP
            $ROP = ($permintaan_tahunan / $hari_per_tahun) * $jangka_waktu;

            return response()->json([
                'res_eoq' => round($EOQ, 2),
                'res_pesanan_pertahun' => $jumlah_pesanan_pertahun,
                'res_siklus' => round($siklus_pemesanan, 2),
                'res_biaya_tahunan' => round($total_biaya_tahunan, 2),
                'res_rop' => round($ROP, 2)
            ]);
        } else {
            return response()->json([
                'error' => 'Input tidak boleh kosong atau bernilai 0.'
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data (opsional)
        $request->validate([
            'produk_id' => 'required',
            'permintaan_tahunan' => 'required',
            'biaya_pesan' => 'required',
            'biaya_simpan' => 'required',
            'harga_per_unit' => 'required',
            'hari_per_tahun' => 'required',
            'jangka_waktu' => 'required',
            'res_eoq' => 'required',
            'res_pesanan_pertahun' => 'required',
            'res_siklus' => 'required',
            'res_biaya_tahunan' => 'required',
            'res_rop' => 'required',
        ]);
        $detail = HitungEoq::where('produk_id', $request->produk_id)->first();
        if (empty($detail)) {
            // Simpan ke database
            $data = HitungEoq::create([
                'produk_id' => $request->produk_id,
                'hitung_tahunan' => $request->permintaan_tahunan,
                'hitung_pesan' => $request->biaya_pesan,
                'hitung_simpan' => $request->biaya_simpan,
                'hitung_harga_unit' => $request->harga_per_unit,
                'hitung_hari_kerja' => $request->hari_per_tahun,
                'hitung_waktu' => $request->jangka_waktu,
                'eoq_nilai' => $request->res_eoq,
                'eoq_pesanan' => $request->res_pesanan_pertahun,
                'eoq_siklus' => $request->res_siklus,
                'eoq_biaya' => $request->res_biaya_tahunan,
                'eoq_rop' => $request->res_rop,
            ]);
            // 
            $status = 'Simpan';
        } else {
            // update
            $detail->hitung_tahunan = $request->permintaan_tahunan;
            $detail->hitung_pesan = $request->biaya_pesan;
            $detail->hitung_simpan = $request->biaya_simpan;
            $detail->hitung_harga_unit = $request->harga_per_unit;
            $detail->hitung_hari_kerja = $request->hari_per_tahun;
            $detail->hitung_waktu = $request->jangka_waktu;
            $detail->eoq_nilai = $request->res_eoq;
            $detail->eoq_pesanan = $request->res_pesanan_pertahun;
            $detail->eoq_siklus = $request->res_siklus;
            $detail->eoq_biaya = $request->res_biaya_tahunan;
            $detail->eoq_rop = $request->res_rop;
            // 
            $detail->save();
            // 
            $status = 'Update';
            // 
            $data = $detail;
        }
        // return
        return response()->json([
            'status' => 'success',
            'aksi' => $status,
            'message' => 'Data berhasil disimpan',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cari_eoq(Request $request)
    {
        // Validasi data (opsional)
        $request->validate([
            'produk_id' => 'required',
        ]);

        // Ambil data
        $produk_id = $request->input('produk_id');
        // cari
        $detail = HitungEoq::where('produk_id', $produk_id)->first();
        // return
        if (!empty($detail)) {
            return response()->json([
                'status' => 'success',
                'data' => $detail,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => null,
            ]);
        }
        
    }
}
