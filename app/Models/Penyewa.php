<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\Pesanan;


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

    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function pesanan()
    {
        return $this->hasOne(Pesanan::class);
    }
}
