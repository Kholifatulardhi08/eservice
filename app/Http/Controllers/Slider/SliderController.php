<?php

namespace App\Http\Controllers\Slider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Slider;
use App\Http\Resources\SliderResource;
use File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slider = Slider::all();
        return response()->json([
            'data' => $slider
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
            'nama_slider' => ['required'],
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
        $slider = Slider::create($input);

        return new SliderResource($slider);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $slider = Slider::find($id);
        return response()->json([
            'data' => $slider
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
        $slider = Slider::find($id);
        $validator = Validator::make($request->all(), [
            'nama_slider' => ['required'],
            'deskripsi' => ['required'],
            // 'gambar' => 'required|image|mimes:jpg,png,jpeg,webp,jfif'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            file::delete('uploads/' . $slider->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1,9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        //save to database
        $slider -> update($input);

        return new SliderResource($slider);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Slider::destroy($id);
    }
}
