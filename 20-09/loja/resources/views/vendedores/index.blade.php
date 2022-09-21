@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Vendedores</h2>
        </div>
        <div class="pull-right">

            <a class="btn btn-success" href="{{ route('vendedores.create') }}"> + Novo vendedores</a>

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
   <th>Matricula</th>
   <th width="280px">Ação</th>
 </tr>

 @foreach ($vend as $key => $vendedor)

  <tr>
    <td>{{ $vendedor->id }}</td>
    <td>{{ $vendedor->nome }}</td>
    <td>{{ $vendedor->matricula }}</td>
    <td>
       <a class="btn btn-info" href="{{ route('vendedores.show',$vendedor->id) }}">Mostrar</a>
        <!-- Se o usuário tiver permissão -->

        <a class="btn btn-primary" href="{{ route('vendedores.edit',$vendedor->id) }}">Editar</a>

        {!! Form::open(['method' => 'DELETE','route' => ['vendedores.destroy', $vendedor->id],'style'=>'display:inline']) !!}

            {!! Form::submit('Apagar', ['class' => 'btn btn-danger']) !!}

        {!! Form::close() !!}


    </td>
  </tr>

 @endforeach

</table>

{!! $vend->render() !!}

@endsection
