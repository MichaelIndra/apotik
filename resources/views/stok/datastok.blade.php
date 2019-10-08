@extends('stok.index')

@section('head')
    <h2>Stok Obat </h2>
    <br>
    <a href="{{route('stoks.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Stok Obat</a>
    <br><br>
@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Perusahaan</th>
                <th>Stok</th>
                
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
               ajax: "{{ route('stoks.data') }}",
               columns :[
                     {data : 'nama_obat', name: 'nama_obat'},
                     {data : 'perusahaan', name : 'perusahaan'},
                     {data : 'count', name : 'count'},
                  ]
            });
         });
    </script>
    
@endsection