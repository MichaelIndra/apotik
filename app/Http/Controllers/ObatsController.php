<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Obat;
use yajra\Datatables\Datatables;

class ObatsController extends Controller
{
    private $rules=[
        'nama_obat' => ['required', 'min:3'],
        'keterangan' => ['required'],
        'perusahaan' => ['required'],
        'jenis' => ['required'],
        'kategori' => ['required']
    ];
    public function index(){
        return view('obat.dataobat');
    }

    public function data(Datatables $datatables){
        
        $builder = Obat::query()
            ->select('id', 'nama_obat', 'keterangan', 'perusahaan', 'jenis', 'kategori')
            ->where('status', 1);

        return $datatables->eloquent($builder)
            ->addColumn('action', 'datatables.action')
            ->rawColumns(['action'])
            ->make();
    }

    public function store(Request $request){
        $this->validate($request, $this->rules);
        $this->hurufBesar($request);
        $obat_id = substr($request->kategori, 0, 4) . substr($request->nama_obat, 0, 4) 
                 . substr($request->perusahaan, 0, 4)  . substr($request->jenis, 0, 4);
        $request['obat_id'] = ($obat_id);
        
        $request['status'] = 1;

        $data = $request->all();
        Obat::create($data);
        return redirect('obats')->with('message', 'Master obat tersimpan');
        
    }

    public function create(){
        return view('obat.create');
    }

    public function edit($id){
        $obat = Obat::find($id);
        return view('obat.edit', compact('obat'));
    }

    public function update($id, Request $request){

    }

    public function destroy($id){
        Obat::find($id)
            ->update(['status'=>0]);
        return redirect('obats')->with('message', 'Master obat terhapus');    
    }

    private function hurufBesar($request){
        $request['nama_obat'] = strtoupper($request->nama_obat);
        $request['keterangan'] = strtoupper($request->keterangan);
        $request['perusahaan'] = strtoupper($request->perusahaan);
        $request['jenis'] = strtoupper($request->jenis);
        $request['kategori'] = strtoupper($request->kategori);
        
        
    }

}
