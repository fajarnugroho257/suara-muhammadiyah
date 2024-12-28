<?php

namespace App\Models\admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
    protected $table = 'users_data';
    protected $fillable = ['user_id', 'user_alamat', 'user_nama_lengkap', 'user_telp', 'user_tgl_lahir', 'user_jk', 'image'];

    public function users()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}
