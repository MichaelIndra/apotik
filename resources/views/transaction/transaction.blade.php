@extends('transaction.index')

@section('head')
    <div class="jumbotron">
        <h2>Transaksi</h2>
    </div>    
@endsection

@section('content')
    <div class="form-group">
        <div class ="panel-group">
            <div class="row panel ">
                <div class="col-md-4 panel panel-default">
                    
                        <div class="row">
                            <div class="col-md-3">
                                No Nota
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" style="width:150px;" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                Tanggal
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" style="width:150px;" />
                            </div>
                        </div>
                        </br>    
                </div>
                <div class="col-md-8 panel panel-default">
                    Total Bayar 
                    
                </div>
                
            </div>
            
        </div>

        <div class ="panel-group">
            <div class="row panel">
                <div class="col-md-12 panel panel-default">
                    <div class="row">
                        <div class="col-md-2">Nama Barang</div>
                        <div class="col-md-2">Stok</div>
                        <div class="col-md-2">Harga Satuan</div>
                        <div class="col-md-2">Total Beli</div>
                        <div class="col-md-2">Total Harga</div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><select  class="namabrg form-control" id="namabrg" style="width:150px;" name="namabrg"></select></div>
                        <div class="col-md-2"><input type="text" id="stok" class="stok form-control" /></div>
                        <div class="col-md-2"><input type="text" id="hargasatuan" class="hargasatuan form-control" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" /></div>
                        <div class="col-md-2"><input type="text" class="form-control" /></div>
                        <div class="col-md-2"><button>Add</button></div>
                    </div> 
                    </br>
                </div>
            </div>
        </div>

        <div class ="panel-group">
            <div class="row panel">
                <div class="col-md-12 panel panel-default">   
                    <table class="display" id="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Item</th>
                                <th>Harga Satuan</th>
                                <th>Total Beli</th>
                                <th>Total Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Nama Item</th>
                                <th>Harga Satuan</th>
                                <th>Total Beli</th>
                                <th>Total Harga</th>
                                <th>Action</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row panel-default">
                <div class="col-md-4 panel panel-default">
                    <div class="row">
                        <div class="col-md-4">Total Harga</div>
                        <div class="col-md-4"><input type="text" class="form-control"/></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Bayar</div>
                        <div class="col-md-4"><input type="text" class="form-control"/></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Kembali</div>
                        <div class="col-md-4"><input type="text" class="form-control"/></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button>Simpan</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection

@section('script')
    <script>
        $('.namabrg').select2({
            placeholder: 'Nama item...',
            ajax: {
                url: "{{ route('transactions.cari') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                            text: item.nama_obat,
                            id: item.obat_id
                            }
                        })
                    };
            },
            cache: true
            }
        });
        $('#namabrg').on('select2:select', function (e) {
            var data = e.params.data.id;
            var stok=0; harga = 0;
            console.log(data);
            $.ajax({
                type : "GET",
                url : "{{ route('transactions.stok') }}",
                data : { q:data },
                datatype : 'JSON',
                success : function(dt){
                            //console.log(dt);
                            // console.log(dt[0].stok);
                            if(dt[0] != null){
                                stok = dt[0].stok;
                                harga = dt[0].harga;     
                                $("#stok").val(stok);
                                $("#hargasatuan").val(harga);
                            }else{
                                alert('Harga atau stok tidak tersedia');
                            }
                        },
                error: function(jqXHR, exception) {
                        if (jqXHR.status === 0) {
                            alert('Not connect.\n Verify Network.');
                        } else if (jqXHR.status == 404) {
                            alert('Requested page not found. [404]');
                        } else if (jqXHR.status == 500) {
                            alert('Internal Server Error [500].');
                        } else if (exception === 'parsererror') {
                            alert('Requested JSON parse failed.');
                        } else if (exception === 'timeout') {
                            alert('Time out error.');
                        } else if (exception === 'abort') {
                            alert('Ajax request aborted.');
                        } else {
                            alert('Uncaught Error.\n' + jqXHR.responseText);
                        }
        }    

            });
        });
        $(document).ready(function(){
            
        });    

    </script>
    
@endsection