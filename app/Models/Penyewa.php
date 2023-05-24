<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_penyewa',
        'email',
        'password',
        'provinsi',
        'kecamatan',
        'kabupaten',
        'detail_alamat',
        'no_hp'
    ];

}
