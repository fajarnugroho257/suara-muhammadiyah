<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukLog extends Model
{
    use HasFactory;
    protected $table = 'produk_log';
    protected $fillable = ['produk_id', 'log_awal', 'log_akhir', 'user_id', 'log_st', 'log_id_ref', 'log_jumlah', 'log_date'];
    // 
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
