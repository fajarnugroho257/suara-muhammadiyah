<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Kategori extends Model
{
    use HasFactory, Sluggable;
    public $incrementing = false;
    protected $table = 'kategori';
    protected $primaryKey = 'kategori_id';
    protected $keyType = 'string';
    protected $fillable = ['kategori_id', 'kategori_nama', 'status', 'slug'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'kategori_nama',
                'onUpdate' => true,
            ]
        ];
    }

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id', 'kategori_id');
    }
}
