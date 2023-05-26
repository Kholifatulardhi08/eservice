u<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jasa;
use App\Models\Pesanan;

class PesananDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'jasa_id',
        'total',
        'jumlah',
    ];

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function pesanan()
    {
        $this->belongsTo(Pesanan::class);
    }
}
