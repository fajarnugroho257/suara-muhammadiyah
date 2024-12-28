<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pref extends Model
{
    use HasFactory;
    protected $table = 'preference';
    protected $fillable = ['pref_nama', 'pref_value'];
}
