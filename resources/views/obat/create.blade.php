@extends('index')

@section('content')
    <div class ="panel panel-default">
        <div class ="panel-heading">
            <strong>Tambah data</strong>
        </div>
        {!! Form::open(['route'=>'obats.store', 'class'=>'well form-horizontal']) !!}
            @include('obat.form')
        {!! Form::close() !!}
    </div>
@endsection