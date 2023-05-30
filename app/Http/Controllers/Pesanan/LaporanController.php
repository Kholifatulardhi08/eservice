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
    public function index(Request $request)
    {
        $laporan = DB::table('pesanan_details')
        ->join('jasas', 'jasas.id','=','pesanan_details.jasa_id')
        ->select(DB::raw(
     'count(*) as jumlah_beli,
            nama_jasa,
            harga,
            SUM(total) as total,
            SUM(jumlah) as total_qty
            '))
            ->whereRaw("date(pesanan_details.created_at) >= '$request->dari'")
            ->whereRaw("date(pesanan_details.created_at) <= '$request->sampai'")
            ->groupby('jasa_id', 'nama_jasa', 'harga')
            ->get();
        return response()->json([
            'data' => $laporan
        ]);
    }
}
