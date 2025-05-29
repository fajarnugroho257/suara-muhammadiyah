<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Pesanan;
use App\Models\admin\PesananData;
use App\Models\admin\Produk;
use App\Models\admin\ProdukLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $data['title'] = 'Data Pesanan';
        $data['rs_pesanan'] = Pesanan::with(['retur', 'user', 'pesanan_data.produk'])->orderBy('pesanan_tgl', 'DESC')->paginate(10);
        // dd($data);
        return view('admin.pesanan.index', $data);
    }

    public function show($pesanan_id)
    {
        $data['title'] = 'Detail Pesanan';
        $pesanan = Pesanan::with('user')->where('pesanan_id', $pesanan_id)->first();
        if (empty($pesanan)) {
            return redirect()->route('dataPesanan')->with('error', 'Data tidak ditemukan');
        }
        $rs_pesanan = PesananData::with('produk')->where('pesanan_id', $pesanan->pesanan_id)->paginate(10);
        $data['rs_pesanan'] = $rs_pesanan;
        $data['pesanan'] = $pesanan;
        // dd($data);
        return view('admin.pesanan.detail', $data);
    }

    public function update_pesanan($pesanan_id, $status)
    {
        $pesanan = Pesanan::with('user')->where('pesanan_id', $pesanan_id)->first();
        if (empty($pesanan)) {
            return redirect()->route('dataPesanan')->with('error', 'Data tidak ditemukan');
        }
        $pesanan_data = PesananData::where('pesanan_id', $pesanan->pesanan_id)->get();
        // dd($pesanan->user_id);
        foreach ($pesanan_data as $key => $value) {
            $produk = Produk::where('id', $value['produk_id'])->first();
            $stok = $produk->produk_stok;
            $sisa = $stok - $value['data_jlh'];
            // update produk
            $produk->produk_stok = $sisa;
            if($produk->save()){
                // insert log
                $awal = $stok;
                $keluar = $value['data_jlh'];
                $akhir = $sisa;
                // 
                ProdukLog::create([
                    'produk_id' => $produk->id,
                    'user_id' => $pesanan->user_id,
                    'log_awal' => $awal,
                    'log_jumlah' => $keluar,
                    'log_akhir' => $akhir,
                    'log_st' => 'keluar',
                    'log_date' => date('Y-m-d'),
                ]);
            }
        }
        // die;
        $pesanan->pesanan_st = $status;
        if ($pesanan->save()) {
            return redirect()->back()->with('success', 'Behasil merubah status pesanan');
        }
    }

    public function laporan()
    {
        $data['title'] = 'Laporan Pesanan';

        $start_ses = session()->get('start');
        $end_ses = session()->get('end');
        $start = empty($start_ses) ? date('Y-m-01') : $start_ses;
        $end = empty($end_ses) ? date('Y-m-d') : $end_ses;
        $data['start'] = $start;
        $data['end'] = $end;
        // dd($data);
        $data['rs_pesanan'] = Pesanan::with('user')
            ->whereBetween(DB::raw('DATE(pesanan_tgl)'), [$start, $end])
            ->orderBy('pesanan_tgl', 'DESC')->get();
        return view('admin.pesanan.laporan', $data);
    }

    public function download_laporan()
    {
        $data['title'] = 'Download Laporan Pesanan';

        $start_ses = session()->get('start');
        $end_ses = session()->get('end');
        $start = empty($start_ses) ? date('Y-m-01') : $start_ses;
        $end = empty($end_ses) ? date('Y-m-d') : $end_ses;
        $data['start'] = $start;
        $data['end'] = $end;
        // dd($data);
        $rs_pesanan = Pesanan::with('user')
            ->whereBetween(DB::raw('DATE(pesanan_tgl)'), [$start, $end])
            ->orderBy('pesanan_tgl', 'DESC')->get();
        // Render view ke dalam PDF
        $pdf = Pdf::loadView('admin.pesanan.download_laporan', compact('rs_pesanan', 'start', 'end'))->setPaper('a4', 'landscape');
        // Unduh PDF
        // return $pdf->stream();
        return $pdf->download('Laporan Penjualan ' . $start . '-' . $end . '.pdf');
    }

    public function search_laporan(Request $request)
    {
        // dd($request->all());
        if ($request->aksi == 'cari') {
            session([
                'start' => $request->start,
                'end' => $request->end,
            ]);
        } else {
            session()->forget(['start', 'end']);
        }
        return redirect()->route('laporanPesanan');
    }

    public function update_pembayaran(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required',
            'pesanan_id' => 'required',
        ]);
        // detail
        $pesanan = Pesanan::where('pesanan_id', $request->pesanan_id)->first();
        if (empty($pesanan)) {
            return redirect()->route('dataPesanan')->with('error', 'Data tidak ditemukan');
        }
        // update
        $pesanan->pesanan_bayar = $request->status;
        $pesanan->pesanan_bayar_date = date('Y-m-d H:i:s');
        if ($pesanan->save()) {
            return redirect()->route('dataPesanan')->with('success', 'Pembayaran berhasil diupdate');
        } else {
            return redirect()->route('dataPesanan')->with('error', 'Data tidak ditemukan');
        }
    }
}
