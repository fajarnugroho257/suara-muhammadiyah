<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $primaryKey = 'pesanan_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['pesanan_id', 'user_id', 'pesanan_tgl', 'pesanan_st', 'pesanan_bayar', 'pesanan_bayar'];
    public function pesanan_data()
    {
        return $this->hasMany(PesananData::class, 'pesanan_id', 'pesanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    protected static function boot()
    {
        parent::boot();

        // Membuat pesanan_id secara otomatis saat data dibuat
        static::creating(function ($model) {
            if (!$model->pesanan_id) {
                $model->pesanan_id = self::generatePesananId(); // Panggil metode untuk menghasilkan pesanan_id
            }
        });
    }
    public static function generatePesananId()
    {
        $year = now()->year;  // Ambil tahun sekarang (misalnya 2024)
        $yearSuffix = substr($year, 2, 2); // Ambil dua digit terakhir dari tahun (misalnya 24)

        // Ambil pesanan_id terakhir dan ambil angka increment terakhir
        $lastPesanan = self::latest('pesanan_id')->first();
        $lastNumber = $lastPesanan ? (int) substr($lastPesanan->pesanan_id, -3) : 0; // Ambil 6 digit terakhir
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Tambahkan 1 dan pastikan 6 digit

        // Format: P24 + nomor urut (misalnya P240000001)
        return 'P' . $yearSuffix . $newNumber;
    }
    public function retur()
    {
        return $this->hasMany(Retur::class, 'pesanan_id', 'pesanan_id');
    }
}
