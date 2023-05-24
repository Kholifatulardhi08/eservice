<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subkategori;
use App\Models\Jasa;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori', 'deskripsi', 'gambar'
    ];

    public function subkategori()
    {
        return $this->hasMany(Subkategori::class);
    }

    public function jasa()
    {
        return $this->hasMany(Jasa::class);
    }

}
