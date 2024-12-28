<?php

namespace App\Http\Controllers;
use App\Models\admin\Pesanan;
use App\Models\admin\PesananData;
use App\Models\admin\Produk;
use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->role_id;
        $data['title'] = 'Dashboard';
        $now = date('Y-m-d');
        $rupiah = collect(DB::select(
            'SELECT SUM(total) AS grand_total, res.pesanan_bayar_date FROM (
                SELECT DATE(c.pesanan_bayar_date) AS pesanan_bayar_date, DATE(c.pesanan_tgl) AS tanggal, a.data_jlh, b.produk_harga, (a.data_jlh * b.produk_harga) AS total,
                c.pesanan_id
                FROM pesanan_data a
                INNER JOIN produk b ON a.produk_id = b.id
                INNER JOIN pesanan c ON a.pesanan_id = c.pesanan_id
                WHERE c.pesanan_st = "approve"
                AND c.pesanan_bayar = "yes"
                -- AND c.pesanan_id NOT IN(SELECT d.pesanan_id FROM retur d)
            ) res
            WHERE res.pesanan_bayar_date = ?
            GROUP BY res.pesanan_bayar_date',
            [$now]
        ))->first();
        $exist = collect(DB::select('SELECT pesanan_id FROM retur'));
        // dd($exist);
        $dataExist = [];
        foreach ($exist as $key => $value) {
            $dataExist[] = $value->pesanan_id;
        }
        // print_r($dataExist);
        // die;
        // die;
        $pesanan = PesananData::whereHas('pesanan', function ($query) use ($now) {
            $query->whereRaw('DATE(pesanan_bayar_date) = ?', [$now]);
        })
            ->join('pesanan AS a', 'a.pesanan_id', '=', 'pesanan_data.pesanan_id')
            // ->whereNotIn('a.pesanan_id', function ($query) {
            //     $query->select('pesanan_id')->from('retur');
            // })
            ->sum('data_jlh');
        $data['ttl_rupiah'] = $rupiah;
        $data['ttl_pesanan'] = $pesanan;
        // dd($data);
        return view('dashboard.dashboard', $data);
    }
}
