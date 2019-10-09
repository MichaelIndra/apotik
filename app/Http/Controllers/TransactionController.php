<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transaction.transaction');
    }

    public function getData(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            // $query = DB::table('obats')->select('obat_id','nama_obat')->where('nama_obat','LIKE','%$nama%')->get();
            // $query = DB::select('SELECT obat_id, nama_obat FROM obats WHERE nama_obat LIKE ?', [$nama]);
            $query = DB::table('obats')
                ->where('nama_obat', 'LIKE', "%{$nama}%")
                ->where('status', '1')
                ->get(); 
            return response()->json($query);        

        }
    }

    public function getStok(Request $request){
        $now = Carbon::now()->toDateString();
        
        if ($request->has('q')){
            $obt_id = $request->q;
            // $query = DB::table('obats')->select('obat_id','nama_obat')->where('nama_obat','LIKE','%$nama%')->get();
            // $query = DB::select('SELECT obat_id, nama_obat FROM obats WHERE nama_obat LIKE ?', [$nama]);
            //$query = DB::table('stoks')->where('obat_id', 'LIKE', "%{$obt_id}%")->get(); 
            $query = DB::table('stoks')
                ->join('harga_obats', 'stoks.obat_id', '=', 'harga_obats.obat_id')
                ->where('stoks.obat_id',$obt_id)
                ->where('harga_obats.tgl_awal', '<', $now)
                ->select('stoks.*', 'harga_obats.harga')
                ->get();
            return response()->json($query);        

        }
    }

}