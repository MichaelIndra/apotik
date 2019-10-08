<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
            $query = DB::select('SELECT obat_id, nama_obat FROM obats WHERE nama_obat LIKE ?', [$nama]);
            return response()->json($query);        

        }
    }
}
