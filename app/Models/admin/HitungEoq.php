<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HitungEoq extends Model
{
    use HasFactory;
    protected $table = 'hitung_eoq';
    protected $fillable = [
        'produk_id',
        'hitung_waktu',
        'hitung_hari_kerja',
        'hitung_harga_unit',
        'hitung_simpan',
        'hitung_pesan',
        'hitung_tahunan',
        'eoq_nilai',
        'eoq_pesanan',
        'eoq_siklus',
        'eoq_biaya',
        'eoq_rop'
    ];
}
