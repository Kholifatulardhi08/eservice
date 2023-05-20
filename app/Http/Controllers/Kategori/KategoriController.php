<?php

namespace App\Http\Controllers\Kategori;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Kategori;
use App\Http\Resources\KategoriResource;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return response()->json([
            'data' => $kategoris
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => ['required'],
            'deskripsi' => ['required'],
            'gambar' => ['required']
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $kategoris = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'gambar' => $request->gambar
        ]);

        return new KategoriResource($kategoris);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategoris = Kategori::find($id);
        return response()->json([
            'data' => $kategoris
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategoris = Kategori::find($id);
        $validator = Validator::make($request->all(), [
            'nama_kategori' => ['required'],
            'deskripsi' => ['required'],
            'gambar' => ['required']
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $kategoris -> update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'gambar' => $request->gambar
        ]);

        return new KategoriResource($kategoris);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Kategori::destroy($id);

    }
}
