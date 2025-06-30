<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Penerimaan;
use App\Models\admin\Produk;
use App\Models\admin\ProdukLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Pembelian Barang';
        $data['rs_data'] = Penerimaan::with('produk')->orderBy('created_at', 'DESC')->paginate(20);
        // dd($data);
        return view('admin.penerimaan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah Pembelian Barang';
        $data['rs_produk'] = Produk::orderBy('produk_nama', 'ASC')->get();
        // dd($data);
        return view('admin.penerimaan.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'stok_now' => 'required',
            'stok_hasil' => 'required',
            'penerimaan_suplier' => 'required',
            'penerimaan_harga' => 'required',
            'penerimaan_tgl' => 'required',
            'penerimaan_jumlah' => 'required',
        ]);
        $params = [
            'user_id' => Auth::user()->user_id,
            'produk_id' => $request->produk_id,
            'penerimaan_suplier' => $request->penerimaan_suplier,
            'penerimaan_harga' => $request->penerimaan_harga,
            'penerimaan_tgl' => $request->penerimaan_tgl,
            'penerimaan_jumlah' => $request->penerimaan_jumlah,
        ];

        if (Penerimaan::create($params)) {
            //
            // last ID Penerimaan
            $penerimaan_id = Penerimaan::latest('id')->value('id');
            // 
            $produk = Produk::findOrFail($request->produk_id);
            $awal = $produk->produk_stok;
            $penambahan = $request->penerimaan_jumlah;
            $result = $awal + $penambahan;
            //
            $produk->produk_stok = $result;
            if($produk->update()){
                ProdukLog::create([
                    'produk_id' => $produk->id,
                    'user_id' => Auth::user()->user_id,
                    'log_awal' => $awal,
                    'log_jumlah' => $penambahan,
                    'log_akhir' => $result,
                    'log_st' => 'masuk',
                    'log_id_ref' => $penerimaan_id,
                    'log_date' => date('Y-m-d'),
                ]);
            }
            return redirect()->route('addPenerimaanBarang')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('addPenerimaanBarang')->with('error', 'Data gagal disimpan');
        }
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
        $detail = Penerimaan::findOrFail($id);
        // dd($detail);
        if (empty($detail)) {
            return redirect()->route('penerimaanBarang')->with('error', 'data tidak ditemukan');
        }
        $data['title'] = 'Ubah Pembelian Barang';
        $data['rs_produk'] = Produk::orderBy('produk_nama', 'ASC')->get();
        $data['detail'] = $detail;
        // dd($data);
        return view('admin.penerimaan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'produk_id' => 'required',
            'stok_now' => 'required',
            'stok_hasil' => 'required',
            'penerimaan_suplier' => 'required',
            'penerimaan_harga' => 'required',
            'penerimaan_tgl' => 'required',
            'penerimaan_jumlah' => 'required',
        ]);

        $detail = Penerimaan::findOrFail($id);
        // dd($detail);
        if (empty($detail)) {
            return redirect()->route('penerimaanBarang')->with('error', 'data tidak ditemukan');
        }
        // $detail->produk_id = $request->produk_id;
        $detail->penerimaan_jumlah = $request->penerimaan_jumlah;
        $detail->penerimaan_tgl = $request->penerimaan_tgl;
        $detail->penerimaan_suplier = $request->penerimaan_suplier;
        $detail->penerimaan_harga = $request->penerimaan_harga;
        // 
        $logBarang = ProdukLog::where('log_id_ref', $id)->first();
        if ($detail->save()) {
            // update produk stok
            $produk = Produk::findOrFail($request->produk_id);
            $produk->produk_stok = $request->stok_hasil;
            $produk->update();
            // update produk log
            $logBarang->log_jumlah = $request->penerimaan_jumlah;
            $logBarang->log_akhir = $request->stok_hasil;
            // 
            if($logBarang->save()){
                return redirect()->route('updatePenerimaanBarang', $id)->with('success', 'data berhasil diupdate');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detail = Penerimaan::findOrFail($id);
        if (empty($detail)) {
            return redirect()->route('penerimaanBarang')->with('error', 'data tidak ditemukan');
        }
        $produk = Produk::findOrFail($detail->produk_id);
        $stokProduk = $produk->produk_stok;
        $penerimaan = $detail->penerimaan_jumlah;
        $result = $stokProduk - $penerimaan;
        if ($detail->delete()) {
            $produk->produk_stok = $result;
            $produk->update();
            // delete produk log
            ProdukLog::where('log_id_ref', $detail->id)->delete();
            //
            return redirect()->route('penerimaanBarang')->with('success', 'Data penerimaan berhasil dibapus, stok akan dikembalikan sesuai jumlah penerimaan');
        }
    }

    public function get_detail_produk(Request $request)
    {
        $detail = Produk::findOrFail($request->produk_id);
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
                'data' => $detail,
                'image' => asset('image/produk/' . $detail->produk_image)
            ]);
        }
    }
}
