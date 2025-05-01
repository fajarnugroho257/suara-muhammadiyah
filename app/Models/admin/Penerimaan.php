<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;
    protected $table = 'penerimaan';
    protected $fillable = ['user_id', 'produk_id', 'penerimaan_jumlah', 'penerimaan_tgl', 'penerimaan_suplier', 'penerimaan_harga'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
