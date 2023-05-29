<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penyewa;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewa_id',
        'jasa_id',
        'deskripsi',
        'rating'
    ];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }
}
