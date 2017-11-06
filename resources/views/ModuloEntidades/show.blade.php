@extends('layouts/plataforma')
@section('header')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Institucion</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('instituciones.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Institucion:</strong>
                {{ $institucion->nombre}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Codigo:</strong>
                {{ $institucion->codigo}}
            </div>
        </div>
    </div>
@endsection