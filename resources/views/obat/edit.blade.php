@extends('index')

@section('content')
    <div class ="panel panel-default">
        <div class ="panel-heading">
            <strong>Edit data</strong>
        </div>
        {!! Form::model($obat, ['route'=>['obats.update', $obat->id], 'method'=>'PATCH', 'class'=>'well form-horizontal']) !!}
            @include('obat.form')
        {!! Form::close() !!}
    </div>
@endsection