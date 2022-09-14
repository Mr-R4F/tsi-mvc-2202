@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Clientes</h2>
        </div>
        <div class="pull-right">

        @can('cliente-create')

            <a class="btn btn-success" href="{{ route('clientes.create') }}"> + Novo cliente</a>

        @endcan

        </div>
    </div>
</div>

<br>

@if ($message = Session::get('success'))

<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>

@endif

<table class="table table-bordered">

 <tr>
   <th>ID</th>
   <th>Nome</th>
   <th>Email</th>
   <th>Telefone</th>
   <th>Endereço</th>
   <th width="280px">Ação</th>
 </tr>

 @foreach ($cli as $key => $cliente)

  <tr>
    <td>{{ $cliente->id }}</td>
    <td>{{ $cliente->nome }}</td>
    <td>{{ $cliente->email }}</td>
    <td>{{ $cliente->telefone }}</td>
    <td>{{ $cliente->endereco }}</td>
    <td>
       <a class="btn btn-info" href="{{ route('clientes.show',$cliente->id) }}">Mostrar</a>
        <!-- Se o usuário tiver permissão -->

        <a class="btn btn-primary" href="{{ route('clientes.edit',$cliente->id) }}">Editar</a>

        @can('cliente-delete')

        {!! Form::open(['method' => 'DELETE','route' => ['clientes.destroy', $cliente->id],'style'=>'display:inline']) !!}

            {!! Form::submit('Apagar', ['class' => 'btn btn-danger']) !!}

        {!! Form::close() !!}

        @endcan

    </td>
  </tr>

 @endforeach

</table>

{!! $cli->render() !!}

@endsection
