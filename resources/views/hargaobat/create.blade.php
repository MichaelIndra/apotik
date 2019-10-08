@extends('obat.index')

@section('content')
    <div class ="panel panel-default">
        <div class ="panel-heading">
            <strong>Tambah harga obat</strong>
        </div>
        {!! Form::open(['route'=>'hargaobats.store', 'class'=>'well form-horizontal']) !!}
            @include('hargaobat.form')
        {!! Form::close() !!}
    </div>
@endsection