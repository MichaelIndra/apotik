@extends('racikan.index')

@section('head')
    <h2>Master Racikan </h2>
    <br>
    <a href="{{route('detracikans.create')}}" class="btn btn-info ml-3" id="create-new-user">Tambah Data Racikan</a>
    <br><br>
@endsection

@section('content')
    <div class="row-md-1">   
        <table class="display " id="table" style="width:100%">
            <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Penggunaan per hari</th>
                <th>Harga</th>
                <th>Tanggal Aktif</th>
                <th>Detail Racikan<th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="modal fade bs-example-modal-lg" id="modalRacik" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="classModalLabel">Detail Racikan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    
                </div>

                <div class="modal-body">
                    <table id="detRacikTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Nama Racik</td>
                                <td>Keterangan</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        
        function show(id){
            $('#modalRacik').modal('show');
            $.ajax({
                url : "{{url('detracikans')}}" + '/' +id+'/racik',
                method : 'GET',
                data : {
                    id : id,
                    _token : "{{ csrf_token() }}"
                },
                success: function(response){
                   $('#detRacikTable tbody > tr').remove(); 
                   var obj = JSON.parse(JSON.stringify(response));
                   var trhtml = '';
                   $.each(obj['data'], function(i, item){
                       trhtml += '<tr><td>'+item.nama_obat+'</td><td>'+item.keterangan+'</td></tr>'
                   });
                   $('#detRacikTable tbody').append(trhtml);
                    
                }
            });
                
        }

         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ route('detracikans.data') }}",
               columns :[
                     {data : 'nama_obat', name: 'nama_obat'},
                     {data : 'penggunaan', name : 'penggunaan'},
                     {data : 'harga', name : 'harga_obats.harga',
                        render: $.fn.dataTable.render.number(',', '.', 2, 'Rp. ')},
                     {data : 'tgl_awal', name : 'harga_obats.tgl_awal'},
                     {data: 'action', name : 'action', orderable : false}
                     
                  ]
            });
         });
    </script>
    
@endsection