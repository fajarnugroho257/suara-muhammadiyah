<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Produk extends Model
{
    use HasFactory, Sluggable;
    protected $table = 'produk';
    protected $fillable = ['kategori_id', 'slug', 'produk_nama', 'produk_rating', 'produk_deskripsi', 'produk_harga', 'produk_stok', 'produk_image'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'produk_nama',
                'onUpdate' => true,
            ]
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function produk_image()
    {
        return $this->hasMany(Produk_image::class, 'produk_id', 'id');
    }

    public function pesanan_data()
    {
        return $this->hasOne(PesananData::class, 'produk_id', 'id');
    }

    public function penerimaan()
    {
        return $this->hasMany(Penerimaan::class, 'produk_id', 'id');
    }

    public function hitung_eoq()
    {
        return $this->hasOne(HitungEoq::class, 'produk_id', 'id');
    }
}
