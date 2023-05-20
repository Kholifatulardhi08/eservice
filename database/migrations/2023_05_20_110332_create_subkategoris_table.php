<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subkategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_subkategori');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->unsignedBigInteger('kategori_id');
            $table->timestamps();

            // ADD foreign key
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subkategoris');
    }
};