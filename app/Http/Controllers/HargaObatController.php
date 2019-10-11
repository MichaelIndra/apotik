<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HargaObat;
use App\Obat;
use yajra\Datatables\Datatables;
use DB;

class HargaObatController extends Controller
{

    private $rules=[
        'harga' => ['required', 'numeric'],
        'tgl_awal' => ['required', 'date']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hargaobat.datahargaobat', ['title'=>'Harga Obat']);
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
                    ->pluck('nama_obat','obat_id');
        return view('hargaobat.create')->with(['obt' => $namaobat, 'title'=>'Harga Obat']);
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
        $data = $request->all();
        
        $obat_id = $data['obat_id'];
        
        $hrg_obt = HargaObat::where('obat_id','=',$obat_id)
                            ->whereNull('tgl_akhir');
        $obt = Obat::where('obat_id','=',$obat_id)
                    ->where('status', 1)
                    ->first();            
        if($hrg_obt->count() == 1){
            $tgl_awal = $hrg_obt->first()->tgl_awal;
            $tgl_input = $data['tgl_awal'];
            $tgl_akhir = date('Y-m-d', strtotime('-1 days', strtotime($tgl_input)));
            if($tgl_awal < $tgl_akhir){
                $hrg_obt->update(['tgl_akhir'=>$tgl_akhir]);
            }else{
                return redirect('hargaobats')->with('message', 'Tanggal akhir lebih kecil dari tanggal akhir');     
                exit();
            }
            
        }
        $data['kategori'] = $obt->kategori;
        HargaObat::create($data);
        return redirect('hargaobats')->with('message', 'Master harga obat tersimpan');
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
        HargaObat::find($id)
                    ->update(
                        array(
                            'tgl_akhir'=>now()
                        )
                    );
        // return $master->obat_id;
    }

    public function data(Datatables $datatables){
        
        $builder = DB::table('obats')
                ->join('harga_obats', 'obats.obat_id', '=', 'harga_obats.obat_id')
                ->select(array('obats.nama_obat', 'obats.perusahaan', 
                                'harga_obats.harga', 'obats.obat_id as obat_id', 'harga_obats.id as hargaobat_id'
                                ,'harga_obats.kategori','harga_obats.tgl_awal'))
                ->where('obats.status', 1)
                ->whereNull('harga_obats.tgl_akhir');

        return $datatables->of($builder)
            ->addColumn('action', function ($user) {
                return 
                "<button onclick=del('$user->hargaobat_id'); type='button' class='btn btn-circle btn-danger '><i class='glyphicon glyphicon-remove'></i>Delete</button>";
                
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
