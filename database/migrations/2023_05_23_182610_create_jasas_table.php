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
        Schema::create('jasas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jasa');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('subkategori_id');
            // $table->unsignedBigInteger('penyewa_id');
            $table->integer('harga');
            $table->integer('diskon');
            $table->string('tags');
            $table->timestamps();

            // ADD foreign key
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('subkategori_id')->references('id')->on('subkategoris')->onDelete('cascade');
            // $table->foreign('penyewa_id')->references('id')->on('penyewas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasas');
    }
};
