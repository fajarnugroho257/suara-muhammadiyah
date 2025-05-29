<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\PesananData;
use App\Models\admin\Produk;
use App\Models\admin\ProdukLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersediaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Persediaan Barang';
        $data['rs_data'] = ProdukLog::with('produk')->orderBy('created_at', 'DESC')->paginate(20);
        $data['rs_penjualan'] = PesananData::select('produk_id', DB::raw('SUM(data_jlh) AS jlh_terjual'))
                                ->with('produk')->whereRelation('pesanan', 'pesanan_st', 'approve')
                                ->groupBy('produk_id')
                                ->orderByDesc(DB::raw('SUM(data_jlh)'))
                                ->get();
        // produk tidak bergerak selama 3 bulan terakhir
        $threeMonthsAgo = Carbon::now()->subMonths(3);
        $produkTidakBergerak = Produk::whereNotIn('id', function ($query) use ($threeMonthsAgo) {
                                $query->select('produk_id')
                                    ->from('pesanan_data as a')
                                    ->join('pesanan as b', 'a.pesanan_id', '=', 'b.pesanan_id')
                                    ->where('b.pesanan_st', 'approve')
                                    ->where('b.created_at', '>=', $threeMonthsAgo);
                            })->leftJoin('pesanan_data as pd', 'id', '=', 'pd.produk_id')
                            ->select('pd.data_id', 'pd.created_at', 'produk.produk_nama', 'produk.produk_image', 'produk.produk_stok')
                            ->orderByDesc('pd.created_at')
                            ->get();
        $data['rs_tdk_bergerak'] = $produkTidakBergerak;
        // dd($data);
        return view('admin.persediaan.index', $data);
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
        //
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
}
