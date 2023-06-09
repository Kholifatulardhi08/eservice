<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Jasa;

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

    public function jasa(){
        return $this->hasMany(Jasa::class);
    }
}
