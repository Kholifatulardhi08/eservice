<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Http\Resources\PesananResource;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = Pesanan::all();

        return response()->json([
            'data' => $pesanan
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
            'penyewa_id' => ['required']
        ]);

         //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $input = $request->all();
        $pesanan = Pesanan::create($input);

        for ($i=0; $i < count($input['jasa_id']); $i++) {
            # code...
            PesananDetail::create([
                'pesanan_id' => $input['pesanan_id'],
                'jasa_id' => $input['jasa_id'][$i],
                'jumlah' => $input['jumlah'][$i],
                'total' => $input['total'][$i],
            ]);
        }

        return response()->json([
            'data' => $pesanan
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pesanan = Pesanan::find($id);
        return response()->json([
            'data' => $pesanan
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
        $pesanan = Pesanan::find($id);
        $validator = Validator::make($request->all(), [
            'penyewa_id' => ['required']
        ]);

         //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $input = $request->all();
        $pesanan -> update($input);
        PesananDetail::where('id', $id)->delete();

        for ($i=0; $i < count($input['jasa_id']); $i++) {
            # code...
            PesananDetail::create([
                'pesanan_id' => $input['pesanan_id'],
                'jasa_id' => $input['jasa_id'][$i],
                'jumlah' => $input['jumlah'][$i],
                'total' => $input['total'][$i],
            ]);
        }

        return response()->json([
            'message' => 'succsess',
            'data' => $pesanan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Pesanan $pesanan, $id)
    {
        $pesanan = Pesanan::find($id);
        $pesanan->delete();

        return response()->json([
            'message' => 'succsess',
        ]);
    }

    // ADD Status in controller Pesanan
    public function dikonfirmasi()
    {
        $pesanan = Pesanan::where('status', 'Dikonfirmasi')->get();

        return response()->json([
            'data' => $pesanan
        ]);
    }

    public function diproses()
    {
        $pesanan = Pesanan::where('status', 'Diproses')->get();

        return response()->json([
            'data' => $pesanan
        ]);
    }

    public function selesai()
    {
        $pesanan = Pesanan::where('status', 'Selesai')->get();

        return response()->json([
            'data' => $pesanan
        ]);
    }

    public function ubah_status(Request $request, Pesanan $pesanan)
    {
        $pesanan->update([
            'status' => $request->status
        ]);

        return response()->json([
            'data' => $pesanan
        ]);
    }

}
