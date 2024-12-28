<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananData extends Model
{
    use HasFactory;
    protected $table = 'pesanan_data';
    protected $primaryKey = 'data_id';

    public $incrementing = false;
    // Menentukan tipe primary key
    // protected $keyType = 'string';
    protected $fillable = ['data_id', 'pesanan_id', 'produk_id', 'data_jlh'];
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'pesanan_id');
    }
    public function produk()
    {
        return $this->hasOne(Produk::class, 'id', 'produk_id');
    }
    // Boot method untuk membuat pesanan_id otomatis
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         if (!$model->pesanan_id) {
    //             $model->pesanan_id = self::generatePesananId();
    //         }
    //     });
    // }

    // // Fungsi untuk generate pesanan_id dengan format pesanan_id-0001
    // public static function generatePesananId()
    // {
    //     // Ambil pesanan_id terakhir dan ambil angka increment terakhir
    //     $lastPesanan = self::latest('pesanan_id')->first();
    //     $lastNumber = $lastPesanan ? (int) substr($lastPesanan->pesanan_id, -4) : 0; // Ambil 4 digit terakhir
    //     $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan pastikan 4 digit

    //     // Format pesanan_id
    //     return 'PESANAN-' . $newNumber;
    // }

}
