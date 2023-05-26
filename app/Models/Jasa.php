<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Subkategori;
use App\Model\PesananDetail;

class Jasa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jasa',
        'deskripsi',
        'gambar',
        'kategori_id',
        'subkategori_id',
        'harga',
        'diskon',
        'tags'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class);
    }

    public function pesanan_detail()
    {
        return $this->belongsTo(PesananDetail::class);
    }
}
