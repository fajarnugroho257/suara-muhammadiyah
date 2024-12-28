<?php

namespace App\Providers;

use App\Models\admin\PesananData;
use App\Models\admin\Pref;
use Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        //
        View::composer('*', function ($view) {
            // total pembelian
            $keranjang = array();
            if (Auth::check()) {
                $keranjang = PesananData::with('pesanan')
                    ->whereRelation('pesanan', 'pesanan_st', 'waiting')
                    ->whereRelation('pesanan', 'user_id', Auth::user()->user_id)
                    ->count();
            }
            // $headerData = Header::all(); // atau sesuaikan dengan query header yang diinginkan
            $keyword = session()->get('keyword');
            //
            $data['keranjang'] = $keranjang;
            $data['keyword'] = $keyword;
            $pref = Pref::where('pref_nama', 'no_wa')->first();
            $data['nomor_wa'] = $pref->pref_value;
            // dd($data);
            $view->with('headerData', $data);
        });
    }
}
