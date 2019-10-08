
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
                            <label for="nama_obat" class="control-label col-md-3">Nama obat</label>
                            <div class="col-md-8 inputGroupContainer">
                                {!! Form::select('obat_id', $obt,null, ['class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="harga" class="control-label col-md-3">Harga</label>
                            <div class="col-md-8">
                                {!! Form::number('harga', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tanggalefektif" class="control-label col-md-3">Tanggal Efektif</label>
                            <div class="col-md-8">
                                {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class ="panel-footer">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <button type="submit" class="btn btn-primary">{{ !empty($obat->id) ? "Update" : "Save" }}</button>
                            <a href="{{route('hargaobats.index')}}" class="btn btn-default">Cancel</a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>


@section('script')
    <script>
        //bla bla bla
    </script>
@endsection