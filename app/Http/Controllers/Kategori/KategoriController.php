<?php

namespace App\Http\Controllers\Kategori;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Kategori;
use App\Http\Resources\KategoriResource;
use File;

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
            'gambar' => 'required|image|mimes:jpg,png,jpeg,webp,jfif'
        ]);

         //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();
        if ($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }

        //save to database
        $kategoris = Kategori::create($input);

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
            // 'gambar' => 'required|image|mimes:jpg,png,jpeg,webp,jfif'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            file::delete('uploads/' . $kategoris->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        //save to database
        $kategoris -> update($input);

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
