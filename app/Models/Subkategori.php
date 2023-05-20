<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;

class Subkategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_subkategori', 'deskripsi', 'gambar', 'kategori_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

}
