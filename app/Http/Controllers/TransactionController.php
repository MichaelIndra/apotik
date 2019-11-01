<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Cart;
use App\Transaction;
use App\Stok;
use PDF;    

class TransactionController extends Controller
{

    private function getKategori($id)
    {
        $dt = DB::Table('obats')
        ->where('obat_id',$id)->first();
        return $dt->kategori;
    }
    private function getNoNota()
    {
        $count = DB::Table('counts')->find(1)->count;
        $now = Carbon::now()->format('d-m-Y');
        return $count .'-'.$now.'-INV';
    }

    public function index()
    {
        $c = DB::Table('counts')->find(1);
        $blnUpdate = Carbon::parse($c->updated_at)->format('M Y');
        $blnNow = Carbon::now()->format('M Y');
        $now = Carbon::now()->format('d/m/Y');
        
        if ($blnUpdate != $blnNow)
        {
            $nw = Carbon::now()->toDateTimeString();
            DB::Table('counts')
            ->where('tipe','INV')
            ->update(['count'=>1, 'updated_at' => $nw]);
        }
        $nota = $this->getNoNota();
        return view('transaction.transaction', ['title'=>'Transaksi', 'tgl'=>$now, 'nota'=>$nota]);
    }

    public function getData(Request $request){
        if ($request->has('q')){
            $nama = $request->q;
            // $query = DB::table('obats')->select('obat_id','nama_obat')->where('nama_obat','LIKE','%$nama%')->get();
            // $query = DB::select('SELECT obat_id, nama_obat FROM obats WHERE nama_obat LIKE ?', [$nama]);
            $query = DB::table('obats')
                ->where('nama_obat', 'LIKE', "%{$nama}%")
                ->where('status', '1')
                ->whereIn('kategori', ['OBAT','MRACIK'])
                ->get(); 
            return response()->json($query);        

        }
    }

    public function getStok(Request $request){
        $now = Carbon::now()->toDateString();
        
        if ($request->has('q')){
            $obt_id = $request->q;

            if($this->getKategori($obt_id) == 'OBAT') {
                $query = DB::table('stoks')
                    ->join('harga_obats', 'stoks.obat_id', '=', 'harga_obats.obat_id')
                    ->where('stoks.obat_id',$obt_id)
                    ->where('harga_obats.tgl_awal', '<', $now)
                    ->where('harga_obats.tgl_akhir','=', null)
                    ->select('stoks.obat_id', 'harga_obats.harga', DB::raw('SUM(stoks.stok) AS stok'))
                    ->get();
            } else if($this->getKategori($obt_id) == 'MRACIK'){
                $query = DB::select("SELECT min(stk.stok) as stok, obats.obat_id, harga_obats.harga
                    FROM  (SELECT sum(stok) stok, obat_id, id FROM stoks GROUP BY obat_id) stk 
                    JOIN det_racikans ON det_racikans.id_obat = stk.obat_id
                    JOIN obats on obats.obat_id = det_racikans.id_racikan
                    JOIN harga_obats on harga_obats.obat_id = obats.obat_id
                    WHERE det_racikans.id_racikan = '$obt_id'
                    GROUP BY obats.obat_id");
            }
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

    private function stokRacikan($id_racik, $data, $now){
        $query = DB::table('obats')
            ->join('det_racikans', 'obats.obat_id', '=', 'det_racikans.id_racikan')
            ->where('obats.obat_id',$id_racik)
            ->select('obats.penggunaan', 'det_racikans.id_obat')
            ->get();
        foreach ($query as $racik){
            $arr['no_invoice'] = $this->getNoNota();
            $arr['id'] = $racik->id_obat;
            $arr['qty'] = $data->quantity;
            $arr['harga'] = $data->price;
            $arr['ttl_harga'] = $data->price * $data->quantity;
            $arr['tgl_transaksi'] = $now;
            $arr['id_racik'] = $id_racik;
            $arr['jenis'] = $this->getKategori($data->id);

            $stk['obat_id'] = $racik->id_obat;
            $stk['stok'] = -1* $data->quantity *$racik->penggunaan;
            $stk['keterangan'] = $this->getNoNota();
            $stk['tgl_transaksi'] = $now;
            Stok::create($stk);
            Transaction::create($arr);
        }    
    }

    public function addtransaksi(Request $request){
        $now = Carbon::now();
        $count = DB::Table('counts')->find(1)->count;
        $upcount = $count + 1;
        $bayar = (int) $request->input('bayar');

        
        foreach(Cart::getContent() as $data){
            
            if($this->getKategori($data->id) == 'OBAT'){
                $arr['no_invoice'] = $this->getNoNota();
                $arr['id'] = $data->id;
                $arr['qty'] = $data->quantity;
                $arr['harga'] = $data->price;
                $arr['ttl_harga'] = $data->price * $data->quantity;
                $arr['tgl_transaksi'] = $now;
                $arr['jenis'] = $this->getKategori($data->id);
                $arr['id_racik'] = '-';
                
                $stk['obat_id'] = $data->id;
                $stk['stok'] = -1* $data->quantity;
                $stk['keterangan'] = $this->getNoNota();
                $stk['tgl_transaksi'] = $now;
                Stok::create($stk);
                Transaction::create($arr);
            } else if($this->getKategori($data->id) == 'MRACIK'){
                $this->stokRacikan($data->id, $data, $now);
            }
        }    
        
        $nota['pembayaran'] = $bayar;
        $nota['no_invoice'] = $this->getNoNota();

        $final['status'] = 'Sukses';
        $final['bayar'] = $nota;     
        //$this->cetakinvoice(Cart::getContent(), $this->getNoNota(), $bayar);
        
        $nw = Carbon::now()->toDateTimeString();
            DB::Table('counts')
            ->where('tipe','INV')
            ->update(['count'=>$upcount, 'updated_at' => $nw]);
        //$this->removeall();
        return route('transactions.cetak', ['noinvoice'=>$nota['no_invoice'], 'bayar'=>$bayar]);

        
    }

    public function destroy($rowid)
    {
        Cart::remove($rowid);
        return redirect('transactions')->with('message', 'Berhasil hapus keranjang');
    }

    public function removeall()
    {
        Cart::clear();
    }

    public function cetakinvoice($noinvoice, $bayar){
        $nota = DB::Table('transactions')->where('no_invoice', $noinvoice)->get();
        $pdf = PDF::loadview('transaction.invoice',['nota'=>$nota, 'invoice'=>$noinvoice, 'pembayaran' =>$bayar])->setPaper('a4', 'landscape');
	    return $pdf->stream();
    }

}