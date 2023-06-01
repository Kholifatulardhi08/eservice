<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Penyewa;
use App\Http\Resources\PenyewaResource;
use File;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewa = Penyewa::all();
        return response()->json([
            'data' => $penyewa
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
            'nama_penyewa' => ['required'],
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

        //save to database
        $penyewa = Penyewa::create($input);

        return new PenyewaResource($penyewa);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penyewa = Penyewa::find($id);
        return response()->json([
            'data' => $penyewa
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
        $penyewa = Penyewa::find($id);
        $validator = Validator::make($request->all(), [
            'nama_penyewa' => ['required'],
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

        //save to database
        $penyewa->update($input);

        return new PenyewaResource($penyewa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Penyewa::destroy($id);
    }
}
