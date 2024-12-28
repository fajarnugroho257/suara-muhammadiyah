<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\admin\Pesanan;
use App\Models\admin\UserData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;
    protected $fillable = [
        'name',
        'nik',
        'username',
        'password',
        'user_id',
        'role_id',
    ];
    protected $primaryKey = 'user_id';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function app_role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function users_data()
    {
        return $this->hasOne(UserData::class, 'user_id', 'user_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id', 'user_id');
    }
}
