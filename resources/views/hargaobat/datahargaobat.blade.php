@extends('hargaobat.index')

@section('head')
    <h2>Harga Obat </h2>
    <br>
    <a href="{{route('hargaobats.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Data Harga Obat</a>
    <br><br>
@endsection
@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Perusahaan</th>
                <th>Harga Obat</th>
                <th>Kategori</th>
                <th>Tanggal Aktif</th>
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
               ajax: "{{ route('hargaobats.data') }}",
               columns :[
                     {data : 'nama_obat', name: 'nama_obat'},
                     {data : 'perusahaan', name : 'perusahaan'},
                     {data : 'harga',  name : 'harga_obats.harga',
                        render: $.fn.dataTable.render.number(',', '.', 2, 'Rp. ')
                     },
                     {data : 'kategori', name : 'harga_obats.kategori'},
                     {data : 'tgl_awal', name : 'harga_obats.tgl_awal'},
                     {data: 'action', name : 'action', orderable : false}
                  ]
                });
            
            
         });

        
        function del(id){
            if(confirm("Anda yakin nonaktifkan??")){
               $.ajax({
                   url : "{{url('hargaobats')}}" + '/' +id,
                   method : 'DELETE',
                   data : {
                       id : id,
                       _token : "{{ csrf_token() }}"
                   },
                   success: function(response){
                    //    console.log(response);
                       window.location.href ="hargaobats";
                   }
               });
            }    
        }
    </script>
    
@endsection