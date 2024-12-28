<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk_image extends Model
{
    use HasFactory;
    protected $table = 'produk_image';
    protected $fillable = ['produk_id', 'data_image'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

}
