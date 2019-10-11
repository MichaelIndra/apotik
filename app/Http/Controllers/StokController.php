<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use yajra\Datatables\Datatables;
use App\Obat;
use App\Stok;
use Carbon\Carbon;
use DB;


class StokController extends Controller
{
    private $rules=[
        'stok' => ['required', 'numeric'],
        
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data(Datatables $datatables){
        
        $builder= DB::table('stoks')
                ->join('obats', 'stoks.obat_id', '=', 'obats.obat_id')
                ->select(DB::raw('SUM(stoks.stok) as count, obats.nama_obat, obats.perusahaan, stoks.obat_id, stoks.id as id_stok'))
                ->where('obats.status', 1)
                ->groupBy('stokss.obat_id');
                
        $b = DB::select("select SUM(stoks.stok) as count, obats.nama_obat, obats.perusahaan, stoks.obat_id, stoks.id as id_stok 
        from stoks join obats on stoks.obat_id = obats.obat_id 
        where obats.status = 1 
        group by stoks.obat_id
        union
        SELECT min(stk.stok) as count, obats.nama_obat, obats.perusahaan, obats.obat_id, stk.id as id_stok
        FROM  (SELECT sum(stok) stok, obat_id, id FROM stoks GROUP BY obat_id) stk 
        JOIN det_racikans ON det_racikans.id_obat = stk.obat_id
        JOIN obats on obats.obat_id = det_racikans.id_racikan
        WHERE det_racikans.id_racikan in (SELECT obat_id FROM obats WHERE kategori = 'MRACIK' AND status = 1)
        GROUP BY obats.obat_id");        
        
        // $final = $builder->union($b);
        return $datatables->of($b)
            ->make(true);
    }
    public function index()
    {
        return view('stok.datastok' , ['title'=>'Stok']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $namaobat = Obat::orderBy('nama_obat')
                    ->where('status','=','1')
                    ->where('kategori', '<>', 'MRACIK')
                    ->pluck('nama_obat','obat_id');
        return view('stok.create')->with(['obt'=> $namaobat, 'title'=>'Stok']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $data = request()->except(['_token']);
        $data['tgl_transaksi'] = date('Y-m-d');
        Stok::create($data);
        return redirect('stoks')->with('message', 'Stok obat tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
