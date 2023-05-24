<?php

namespace App\Http\Controllers\Jasa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Subkategori;
use App\Models\Kategori;
use App\Models\Jasa;
use App\Http\Resources\JasaResource;
use Illuminate\Support\Facades\DB;
use File;

class JasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Jasa $jasa)
    {
        return DB::table('jasas')
             ->join('kategoris', 'jasas.kategori_id','=','kategoris.id')
             ->join('subkategoris', 'jasas.subkategori_id','=','subkategoris.id')
             ->select('jasas.id', 'jasas.nama_jasa',
                      'jasas.deskripsi', 'jasas.gambar',
                      'jasas.harga', 'jasas.harga', 'jasas.tags',
                      'jasas.kategori_id', 'jasas.subkategori_id')
             ->orderBy('jasas.id', 'desc')
             ->get();
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
            'nama_jasa' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,webp,jfif',
            'harga' => 'required',
            'diskon' => 'required',
            'tags' => 'required',
            'kategori_id' => 'required',
            'subkategori_id' => 'required',
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
        $jasa = Jasa::create($input);

        return new JasaResource($jasa);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jasa = Jasa::find($id);
        return response()->json([
            'data' => $jasa
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
        $jasa = Jasa::find($id);
        $validator = Validator::make($request->all(), [
            'nama_jasa' => 'required',
            'deskripsi' => 'required',
            // 'gambar' => 'required|image|mimes:jpg,png,jpeg,webp,jfif',
            'harga' => 'required',
            'diskon' => 'required',
            'tags' => 'required',
            'kategori_id' => 'required',
            'subkategori_id' => 'required',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();
        if ($request->has('gambar')) {
            file::delete('uploads/' . $jasa->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        //save to database
        $jasa->update($input);

        return new JasaResource($jasa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Jasa::destroy($id);
    }
}
