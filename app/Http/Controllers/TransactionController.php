<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Cart;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transaction.transaction', ['title'=>'Transaksi']);
    }

    public function getData(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            // $query = DB::table('obats')->select('obat_id','nama_obat')->where('nama_obat','LIKE','%$nama%')->get();
            // $query = DB::select('SELECT obat_id, nama_obat FROM obats WHERE nama_obat LIKE ?', [$nama]);
            $query = DB::table('obats')
                ->where('nama_obat', 'LIKE', "%{$nama}%")
                ->where('status', '1')
                ->where('kategori', '=', 'OBAT')
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
                ->select('stoks.obat_id', 'harga_obats.harga', DB::raw('SUM(stoks.stok) AS stok'))
                ->get();
            return response()->json($query);        

        }
    }

    public function cart_add(Request $request){
        $qty = (int) $request->input('qty');
        $harga = (int) $request->input('harga'); 
        $totharga = $qty * $harga;
        $nama = $request->input('nama');
        $data = array(
            'id' => $request->input('id'),
            'price' => $harga,
            'hargasatuan' => $harga,
            'name' => $nama,
            'quantity' => $qty
        );
        Cart::add($data);
        return response()->json($data, 200);
    }

    public function cart_contents()
    {
        $cartCollection = Cart::getContent();
        $cartCollection->count();
 
        // transformations
        return $cartCollection->toArray();
        
         $cartCollection->toJson();
    }

    public function destroy($rowid)
    {
        Cart::remove($rowid);
        return redirect('transactions')->with('message', 'Berhasil hapus keranjang');
    }

    public function removeall()
    {
        Cart::clear();
        return Redirect::to('/transactions');
    }

}