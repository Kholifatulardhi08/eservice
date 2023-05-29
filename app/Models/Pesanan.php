<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penyewa;
use App\Models\PesananDetail;

class Pesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }

    public function pesanan_detail()
    {
        return $this->hasOne(PesananDetail::class);
    }

}
