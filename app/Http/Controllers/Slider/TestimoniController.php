<?php

namespace App\Http\Controllers\Slider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Testimoni;
use App\Http\Resources\TestimoniResource;
use File;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimoni = Testimoni::all();
        return response()->json([
            'data' => $testimoni
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
            'nama_testimoni' => ['required'],
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
        $testimoni = Testimoni::create($input);

        return new TestimoniResource($testimoni);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testimoni = Testimoni::find($id);
        return response()->json([
            'data' => $testimoni
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
        $testimoni = Testimoni::find($id);
        $validator = Validator::make($request->all(), [
            'nama_testimoni' => ['required'],
            'deskripsi' => ['required'],
            // 'gambar' => 'required|image|mimes:jpg,png,jpeg,webp,jfif'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            file::delete('uploads/' . $testimoni->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        //save to database
        $testimoni -> update($input);

        return new TestimoniResource($testimoni);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Testimoni::destroy($id);
    }
}
