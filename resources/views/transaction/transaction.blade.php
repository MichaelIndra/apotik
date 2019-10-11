@extends('index')

@section('head')
    <div class="jumbotron">
        <h2>Transaksi</h2>
    </div>    
@endsection

@section('content')
<?php $totbyr = 0; ?>
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
                    @foreach(Cart::getContent() as $data)
                        @php $hargabrg = $data->price * $data->quantity;
                            $totbyr +=  $hargabrg;
                        @endphp
                    @endforeach
                    <h2>Rp. {{ number_format($totbyr,2,',','.') }}</h2>
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
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><select  class="namabrg form-control" id="namabrg" style="width:150px;" name="namabrg"></select></div>
                        <input type="hidden" id="idbarang"/>
                        <input type="hidden" id="namabarang"/>
                        <div class="col-md-2"><input type="text" id="stok" class="stok form-control" disabled/></div>
                        <div class="col-md-2"><input type="text" id="hargasatuan" class="hargasatuan form-control" disabled/></div>
                        <div class="col-md-2"><input type="number" id="stokbeli" class="stokbeli form-control" /></div>
                        <div class="col-md-2"><button id="addCart" class="addCart">Add</button></div>
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
                            
                            @foreach(Cart::getContent() as $data)
                                @php 
                                    $tempTot = $data->price * $data->quantity
                                @endphp   
                                <tr>
                                    <td>{{$data->name}}</td>
                                    <td>{{number_format($data->price, 2, ',', '.')}}</td>
                                    <td>{{$data->quantity}}</td>
                                    <td>{{number_format($tempTot,2,',','.')}}</td>
                                    <td>{!! Form::open(['method'=>'DELETE', 'route'=>['transactions.destroy', $data->id]]) !!}
                                            <button onclick="return confirm('Yakin hapus keranjang?');" type="submit" class="btn btn-circle btn-danger ">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                    
                            @endforeach
                              
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row panel-default">
                <div class="col-md-4 panel panel-default">
                    <div class="row">
                        <div class="col-md-4">Total Harga</div>
                        <div class="col-md-4"><input type="text" style="width:150px;" value ="{{number_format($totbyr,2,',','.')}}" id="totbayar" class="totbayar form-control" disabled/></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Bayar</div>
                        <div class="col-md-4"><input type="number" style="width:150px;" class="form-control"/></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Kembali</div>
                        <div class="col-md-4"><input type="text" style="width:150px;" class="form-control" disabled/></div>
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
            var nama = e.params.data.text;
            $("#idbarang").val(data);
            $("#namabarang").val(nama);
            var stok=0; harga = 0;
            $.ajax({
                type : "GET",
                url : "{{ route('transactions.stok') }}",
                data : { q:data },
                datatype : 'JSON',
                success : function(dt){
                    // console.log(dt);
                    // console.log(dt[0].stok);
                    if(dt[0] != null){
                        if(dt[0].stok == 0 || dt[0].stok == null)
                        {
                            alert('Stok tidak tersedia');
                            $("#stok").val('');
                            $("#hargasatuan").val('');
                        }else{
                            stok = dt[0].stok;
                            harga = dt[0].harga;     
                            $("#stok").val(stok);
                            $("#hargasatuan").val(harga);
                        }
                        
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

        $("#addCart").click(function(){
            if ( $("#idbarang").val().length === 0 )
            {
                alert('Belum pilih obat');
            }else{
                if ( $("#stokbeli").val().length != 0){
                    console.log($("#stok").val());
                    console.log($("#stokbeli").val());
                    if (Number($("#stok").val()) >= Number($("#stokbeli").val()) ) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('transactions.cartadd') }}",
                            data: {
                                id : $("#idbarang").val(),
                                qty : $("#stokbeli").val(),
                                harga : $("#hargasatuan").val(),
                                nama : $('#namabarang').val(),
                            },
                            dataType: "json",
                            success: function (response) 
                            {
                                location.reload();
                            },
                            error : function (a,b,c) 
                            {
                                alert(b);
                            }
                        });
                    }else{
                        alert("Pembelian melebihi stok tersedia");
                    }    
                }else{
                    alert("Stok beli kosong");
                }
                $("#stokbeli").val('');
                
            }
        });

    </script>
    
@endsection