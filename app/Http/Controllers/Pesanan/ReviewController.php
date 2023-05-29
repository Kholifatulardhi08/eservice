<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\DB;
use File;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DB::table('reviews')
             ->join('jasas', 'reviews.jasa_id','=','jasas.id')
             ->join('penyewas', 'reviews.penyewa_id','=','penyewas.id')
             ->select('reviews.id', 'reviews.penyewa_id',
                      'reviews.jasa_id', 'reviews.deskripsi',
                      'reviews.rating')
             ->orderBy('reviews.id', 'desc')
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
            'penyewa_id' => ['required'],
            'jasa_id' => ['required'],
            'deskripsi' => ['required'],
            'rating' => ['required']
        ]);

         //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $input = $request->all();
        //save to database
        $review = Review::create($input);

        return new ReviewResource($review);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $review = Review::find($id);
        return response()->json([
            'data' => $review
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
