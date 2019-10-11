@extends('index')

@section('content')
    <div class ="panel panel-default">
        <div class ="panel-heading">
            <strong>Tambah data</strong>
        </div>
        {!! Form::open(['route'=>'detracikans.store', 'id'=>'formracik', 'class'=>'well form-horizontal']) !!}
            @include('racikan.form')
        {!! Form::close() !!}
    </div>
@endsection