<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Obat;
use App\Det_racikan;
use yajra\Datatables\Datatables;
use Carbon\Carbon;
use DB;

class DetRacikanController extends Controller
{
    private $rules=[
        'nama_obat' => ['required', 'min:3'],
        'keterangan' => ['required'],
        'detracik' =>['required'],
        'penggunaan' => ['required']
        
    ];

    public function racikan($racikan){
        $data = DB::table('det_racikans')
                ->join('obats', 'obats.obat_id', '=', 'det_racikans.id_obat')
                ->select(
                    array(
                        'obats.nama_obat', 
                        'obats.keterangan')
                        )
                ->where('obats.status', 1)->get();
            return response()->json(array('successs'=>true, 'data'=>$data));        
    }

    public function data(Datatables $datatables){
        
        $builder = DB::table('obats')
                    ->join('harga_obats', 'obats.obat_id', '=', 'harga_obats.obat_id')
                    ->select(
                        array(
                            'obats.nama_obat', 
                            'obats.penggunaan',
                            'harga_obats.harga', 
                            'obats.obat_id as obat_id',
                            'harga_obats.tgl_awal')
                            )
                    ->where('obats.status', 1)
                    ->where('obats.kategori', 'MRACIK')
                    ->whereNull('harga_obats.tgl_akhir');

        return $datatables->of($builder)
            ->addColumn('action', function ($data) {
                return 
                "<button onclick=show('$data->obat_id'); type='button' class='btn btn-circle btn-danger '><i class='glyphicon glyphicon-alert'></i>Racikan</button>";
                
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('racikan.detracikanobat');
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
                    ->where('kategori','=','RACIKAN')
                    ->pluck('nama_obat','obat_id');
        return view('racikan.create')->with('obt', $namaobat);
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
        $nama_obat = strtoupper($request->nama_obat);
        $keterangan = strtoupper($request->keterangan);
        $perusahaan = 'INTERNAL';
        $jenis = "RACIK";
        $kategori = "MRACIK";
        $penggunaan = $request->penggunaan;
        $obat_id = substr($kategori, 0, 4)   . substr($nama_obat, 0, 4)
                  .substr($perusahaan, 0, 4) . substr($jenis, 0, 4); 
        $detracikan = explode(',', $request->detracik);
        $mstr_racik = array(
            'obat_id' => $obat_id,
            'nama_obat' => $nama_obat,
            'keterangan' => $keterangan,
            'perusahaan' => $perusahaan,
            'jenis' => $jenis,
            'kategori' => $kategori,
            'penggunaan' => $penggunaan,
            'status' => 1 
        );
        
        $det_racik = array();
        for($i=0; $i<count($detracikan); $i++){
            $row = array(
                'id_racikan'=>$obat_id, 
                'id_obat' => $detracikan[$i],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            );
            $det_racik[] = $row;
        }
        Obat::create($mstr_racik);
        Det_racikan::insert($det_racik);
        return redirect('detracikans')->with('message', 'Detail racikan tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = Obat::where('obat_id', '=', $id)
                        ->get();
        return response()->json(array('successs'=>true, 'data'=>$data));
        // return $id;                
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
