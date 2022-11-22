<!--
    Diz para usar o layout padrão (em todos os layouts)
    extends -> "herda" tudo de um arquivo
    extends 'pasta.nome-do-arquivo-a-ser-herdado'
    Serve para montar um site separadamente
-->
@extends('layouts.padrao')
@section('title', 'Quadro de avisos')
@section('sidebar')<!-- para inserir o conteudo no layout padrão-->
    @parent <!-- Continue usando a barra herdada -->
        ---- Barra superior especifica ----
        <h1>Quadro de avisos</h1><br><br>

        <h1>Exp com sintaxe Blade</h1>
        <!-- Condicional / com if -->
        @foreach($avisos as $aviso)
            @if($aviso['exibir'])  {{$aviso['data']}}: {{$aviso['aviso']}}<br>
            @else Não há aviso
            @endif
        @endforeach
        <br><br>

        <h1>Exp com sintaxe PHP</h1>
        <?php
            foreach ($avisos as $aviso) {
               echo $aviso['exibir'] ?  "{$aviso['data']}: {$aviso['aviso']} <br>" : "Não há aviso <br>";
            }
        ?>
@endsection
