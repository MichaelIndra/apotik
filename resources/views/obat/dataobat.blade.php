@extends('index')

@section('head')
    <h2>Master Obat </h2>
    <br>
    <a href="{{route('obats.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Data Obat</a>
    <br><br>
@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Keterangan</th>
                <th>Perusahaan</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('script')
    <script>
         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ route('obats.data') }}",
               columns :[
                     {data : 'nama_obat', name: 'nama_obat'},
                     {data : 'keterangan', name : 'keterangan'},
                     {data : 'perusahaan', name : 'perusahaan'},
                     {data : 'jenis', name : 'jenis'},
                     {data : 'kategori', name : 'kategori'},
                     {data: 'action', name : 'action', orderable : false}
                  ]
            });
         });
    </script>
    
@endsection