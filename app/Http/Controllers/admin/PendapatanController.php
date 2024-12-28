<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Pesanan;
use DB;
use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Laporan Pendapatan';

        $start_ses = session()->get('start_pendapatan');
        $end_ses = session()->get('end_pendapatan');
        $start = empty($start_ses) ? date('Y-m-01') : $start_ses;
        $end = empty($end_ses) ? date('Y-m-d') : $end_ses;
        $data['start'] = $start;
        $data['end'] = $end;
        $pendapatan = collect(DB::select("SELECT res.pesanan_bayar_date, SUM(res.total) AS pendapatan
                            FROM(
                            SELECT DATE(pesanan_bayar_date) AS pesanan_bayar_date, b.`data_jlh`, c.`produk_nama`, c.`produk_harga`,
                            (b.`data_jlh` * c.`produk_harga`) AS total
                            FROM `pesanan` a
                            INNER JOIN `pesanan_data` b ON a.`pesanan_id` = b.`pesanan_id`
                            INNER JOIN `produk` c ON b.`produk_id` = c.`id`
                            WHERE DATE(pesanan_bayar_date) >= ?
                            AND DATE(pesanan_bayar_date) <= ?
                            )res
                            GROUP BY res.pesanan_bayar_date", [$start, $end]));
        // dd($pendapatan);
        $data['rs_pendapatan'] = $pendapatan;
        return view('admin.pendapatan.index', $data);
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
