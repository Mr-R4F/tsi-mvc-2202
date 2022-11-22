@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Detalhes do Vendedores</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('vendedores.index') }}"> Voltar</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Nome:</strong>

            {{ $vend->nome }}

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Matricula:</strong>

            {{ $vend->matricula }}

        </div>
    </div>
</div>

@endsection
