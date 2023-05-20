<?php

namespace App\Http\Controllers\Kategori;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Subkategori;
use App\Models\Kategori;
use App\Http\Resources\SubkategoriResource;
use Illuminate\Support\Facades\DB;
use File;

class SubkategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Subkategori $subkategoris)
    {
        return DB::table('subkategoris')
             ->join('kategoris', 'subkategoris.kategori_id','=','kategoris.id')
             ->select('subkategoris.id', 'subkategoris.nama_subkategori',
                      'subkategoris.deskripsi', 'subkategoris.gambar',
                      'subkategoris.kategori_id')
             ->orderBy('subkategoris.id', 'desc')
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
            'nama_subkategori' => ['required'],
            'deskripsi' => ['required'],
            'gambar' => 'required|image|mimes:jpg,png,jpeg,webp,jfif',
            'kategori_id' => ['required']
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
        $subkategoris = Subkategori::create($input);

        return new SubkategoriResource($subkategoris);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $subkategoris = Subkategori::find($id);
        return response()->json([
            'data' => $subkategoris
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
        $subkategoris = Subkategori::find($id);
        $validator = Validator::make($request->all(), [
            'nama_subkategori' => ['required'],
            'deskripsi' => ['required'],
            // 'gambar' => 'required|image|mimes:jpg,png,jpeg,webp,jfif',
            'kategori_id' => ['required']
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            file::delete('uploads/' . $subkategoris->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        //save to database
        $subkategoris -> update($input);

        return new SubkategoriResource($subkategoris);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Subkategori::destroy($id);
    }
}
