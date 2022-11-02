<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <!--
            Recursos para deixar o título dinâmico, para não ficar no padrão
            yield -dê preferência para title (vai ficar variando)
        -->
    </head>
    <body>
        @section('sidebar')<!-- seção para mandar os dados para aparecer na página -->
           ==== Barra Superior Geral ====
        @show
        <div class="container">
            <h1>ATENÇÃO, PRESTE MUITA ATENÇÃO!</h1>
            @yield('content') <!-- Vai colocar algo com esse nome  -->
            <!-- Quando há certas repetições no desenvolvimento web, 'header, footer' -->
        </div>
    </body>
</html>
