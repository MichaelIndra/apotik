
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
                            <label for="stok" class="control-label col-md-3">Stok</label>
                            <div class="col-md-8">
                                {!! Form::number('stok', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="keterangan" class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-8">
                                {!! Form::text('keterangan', null, ['class'=>'form-control']) !!}
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
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{route('stoks.index')}}" class="btn btn-default">Cancel</a>
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