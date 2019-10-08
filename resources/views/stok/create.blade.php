@extends('stok.index')

@section('content')
    <div class ="panel panel-default">
        <div class ="panel-heading">
            <strong>Tambah Stok obat</strong>
        </div>
        {!! Form::open(['route'=>'stoks.store', 'class'=>'well form-horizontal']) !!}
            @include('stok.form')
        {!! Form::close() !!}
    </div>
@endsection