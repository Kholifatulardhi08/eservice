<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PesananDetail;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use File;


class LaporanController extends Controller
{
    public function index()
    {
        $laporan = DB::table('pesanan_details')
            ->get();
        return response()->json([
            'data' => $laporan
        ]);
    }
}
