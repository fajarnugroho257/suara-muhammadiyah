<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\PesananData;
use App\Models\admin\Produk;
use App\Models\admin\ProdukLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PersediaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Persediaan Barang';
        $start_ses = session()->get('start_log');
        $end_ses = session()->get('end_log');
        $produk_nama = session()->get('produk_nama');
        $start = empty($start_ses) ? date('Y-m-01') : $start_ses;
        $data['produk_nama'] = $produk_nama;
        $end = empty($end_ses) ? date('Y-m-d') : $end_ses;
        $produk_nama = empty($produk_nama) ? '%' : '%'.$produk_nama.'%';
        // echo $produk_nama;die;
        $data['start'] = $start;
        $data['end'] = $end;
        // 
        $data['rs_data'] = ProdukLog::with('produk.kategori')
                        ->whereRelation('produk', 'produk_nama', 'LIKE', $produk_nama)
                        ->whereBetween(DB::raw('DATE(log_date)'), [$start, $end])
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);
        $data['rs_penjualan'] = PesananData::select('produk_id', DB::raw('SUM(data_jlh) AS jlh_terjual'))
                                ->whereHas('pesanan', function ($query) use ($start, $end) {
                                    $query->whereBetween(DB::raw('DATE(pesanan_tgl)'), [$start, $end])
                                    ->where('pesanan_st', 'approve');
                                })
                                ->groupBy('produk_id')
                                ->orderByDesc(DB::raw('SUM(data_jlh)'))
                                ->get();
        // produk tidak bergerak selama 3 bulan terakhir
        $produkTidakBergerak = DB::table('produk as a')
                            ->whereNotIn('a.id', function ($query) {
                                $query->select('b.produk_id')
                                    ->from('pesanan_data as b')
                                    ->whereDate('b.created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 3 MONTH)'))
                                    ->groupBy('b.produk_id');
                            })
                            ->get();
        $data['rs_tdk_bergerak'] = $produkTidakBergerak;
        // dd($data);
        return view('admin.persediaan.index', $data);
    }

    public function search_log(Request $request)
    {
        // dd($request->all());
        if ($request->aksi == 'cari') {
            session([
                'produk_nama' => $request->produk_nama,
                'start_log' => $request->start,
                'end_log' => $request->end,
            ]);
        } else {
            session()->forget(['start_log', 'end_log', 'produk_nama']);
        }
        return redirect()->route('persediaanBarang');
    }

    public function download_log_barang()
    {
        $data['title'] = 'Download Laporan Pesanan';

        $start_ses = session()->get('start_log');
        $end_ses = session()->get('end_log');
        $produk_nama = session()->get('produk_nama');
        $start = empty($start_ses) ? date('Y-m-01') : $start_ses;
        $data['produk_nama'] = $produk_nama;
        $end = empty($end_ses) ? date('Y-m-d') : $end_ses;
        $produk_nama = empty($produk_nama) ? '%' : '%'.$produk_nama.'%';
        // echo $produk_nama;die;
        $data['start'] = $start;
        $data['end'] = $end;
        // 
        $rs_data = ProdukLog::with('produk.kategori')
                        ->whereRelation('produk', 'produk_nama', 'LIKE', $produk_nama)
                        ->whereBetween(DB::raw('DATE(log_date)'), [$start, $end])
                        ->orderBy('created_at', 'DESC')
                        ->get();
                        // dd($rs_data);
        // Render view ke dalam PDF
        $pdf = Pdf::loadView('admin.persediaan.download_log_barang', compact('rs_data', 'start', 'end'))->setPaper('a4', 'landscape');
        // Unduh PDF
        // return $pdf->stream();
        return $pdf->download('LAPORAN ARUS BARANG ' . $start . '-' . $end . '.pdf');
    }

    public function download_penjualan_barang()
    {
        $data['title'] = 'Download Laporan Penjualan';

        $start_ses = session()->get('start_log');
        $end_ses = session()->get('end_log');
        $produk_nama = session()->get('produk_nama');
        $start = empty($start_ses) ? date('Y-m-01') : $start_ses;
        $data['produk_nama'] = $produk_nama;
        $end = empty($end_ses) ? date('Y-m-d') : $end_ses;
        $produk_nama = empty($produk_nama) ? '%' : '%'.$produk_nama.'%';
        // 
        $rs_data = PesananData::select('produk_id', DB::raw('SUM(data_jlh) AS jlh_terjual'))
                                ->whereHas('pesanan', function ($query) use ($start, $end) {
                                    $query->whereBetween(DB::raw('DATE(pesanan_tgl)'), [$start, $end])
                                    ->where('pesanan_st', 'approve');
                                })
                                ->groupBy('produk_id')
                                ->orderByDesc(DB::raw('SUM(data_jlh)'))
                                ->get();
        // dd($rs_data);
        // Render view ke dalam PDF
        $pdf = Pdf::loadView('admin.persediaan.download_penjualan', compact('rs_data', 'start', 'end'))->setPaper('a4');
        // Unduh PDF
        // return $pdf->stream();
        return $pdf->download('LAPORAN FREKUENSI PENJUALAN ' . $start . '-' . $end . '.pdf');
    }
}
