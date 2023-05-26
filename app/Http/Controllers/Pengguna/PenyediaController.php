<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Penyedia;
use App\Http\Resources\PenyediaResource;
use File;


class PenyediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyedia = Penyedia::all();
        return response()->json([
            'data' => $penyedia
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
            'nama_penyedia' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'provinsi' => ['required'],
            'kabupaten' => ['required'],
            'kecamatan' => ['required'],
            'detail_alamat' => ['required'],
            'no_hp' => ['required']
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
        $penyedia = Penyedia::create($input);

        return new PenyediaResource($penyedia);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penyedia = Penyedia::find($id);
        return response()->json([
            'data' => $penyedia
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
        $penyedia = Penyedia::find($id);
        $validator = Validator::make($request->all(), [
            'nama_penyedia' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'provinsi' => ['required'],
            'kabupaten' => ['required'],
            'kecamatan' => ['required'],
            'detail_alamat' => ['required'],
            'no_hp' => ['required'],
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            file::delete('uploads/' . $penyedia->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        //save to database
        $penyedia -> update($input);

        return new PenyediaResource($penyedia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Penyedia::destroy($id);
    }
}
