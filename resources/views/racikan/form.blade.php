
<div class="panel-body">
            <div class="well form-horizontal">
                <div class="row">
                    <div class="col-md-8">
                        @if (count($errors))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="nama " class="control-label col-md-3">Nama Racikan</label>
                            <div class="col-md-8">
                                {!! Form::text('nama_obat', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan" class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-8">
                                {!! Form::text('keterangan', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="penggunaan" class="control-label col-md-3">Penggunaan (per hari)</label>
                            <div class="col-md-8">
                                {!! Form::number('penggunaan', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_obat" class="control-label col-md-3">Racikan</label>
                            <div class="col-md-8 inputGroupContainer">
                                {!! Form::select('idracik', $obt, null, ['class'=>'idracik form-control']) !!}
                                <button id="add-racik">Tambah Racik</button>
                            </div>
                        </div>

                        

                        
                        
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('detracik', '', ['id'=>'detracik']) !!}
        <div class="row-md-1">   
            <table class="display " id="table" style="width:100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Nama Obat</th>
                    <th>Keterangan</th>
                    <th>Perusahaan</th>
                    <th>Jenis</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>

        <div class ="panel-footer">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <button type="submit" class="btn btn-primary">{{ !empty($obat->id) ? "Update" : "Save" }}</button>
                            <a href="{{route('detracikans.index')}}" class="btn btn-default">Cancel</a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>


@section('script')
    <script>
        var table = $('#table').DataTable({
            stateSave : true,
            columns : [
                {data : 'id_obat', name : 'id_obat', visible : false},
                {data : 'nama_obat', name:'nama_obat'},
                {data : 'keterangan', name:'keterangan'},
                {data : 'perusahaan', name:'perusahaan'},
                {data : 'jenis', name:'jenis'},
                {
                    data: 'action', 
                    name : 'action', 
                    orderable : false,
                    render : function(data, type, row){
                        return "<button type ='button' class='btn btn-circle btn-danger'><i class='glyphicon glyphicon-remove'></i>Delete</button>";
                    }
                }
            ]
        });
        $('#add-racik').on('click', function(){
            var ido = $(".idracik option:selected").val();
            var nme = $(".idracik option:selected").text();
            var ket =''; var per =''; var jens='';
            $.ajax({
                url : "{{url('detracikans')}}" + '/' +ido,
                method : 'GET',
                data : {
                    _token : "{{ csrf_token() }}"
                },
                success: function(data){
                    var obj = JSON.parse(JSON.stringify(data)); 
                    
                    $.each(obj['data'], function(key, val){
                        ket  = (val.keterangan);
                        per  = (val.perusahaan);
                        jens = (val.jenis);
                    });
                    table.row.add({
                        id_obat : ido,
                        nama_obat  : nme,
                        keterangan : ket,
                        perusahaan : per,
                        jenis : jens,
                        
                    }).draw(false);
                }
            });
            return false;
            
        });
        $("#table").on('click',"button", function(){
            table.row($(this).parents('tr')).remove().draw(false);
            return false;
        });
        
        $("#formracik").on('submit', function(e){
            // table.rows().nodes().page.len(-1).draw(false);
            var length = table.rows().data().length;
            var rows = table.rows().data();
            var data ="";
            for(i=0; i<length; i++){
                data+= rows[i].id_obat;
                if(i != length-1){
                    data+=",";
                }
            }
            $('#detracik').val(data);
            if($(this).valid()){
                return true;
            }
            e.preventDefault();
        });        
    </script>
@endsection