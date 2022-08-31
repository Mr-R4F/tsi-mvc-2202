<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        tabelas/ models /relacionamento
        ao criar endereço criar separado

        char() -> aloca um pouco de espaço (economiza)
        double(quantos posições, quantos decimais) 10,2 (ex)
        :: chamando a função da classe schema sem intancia
        xx->f() função do objeto
        muitos para muitos (criar tabela intermediaria)
        */
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('nome');
            $table->char('endereco');
            $table->char('email');
            $table->char('telefone');
        });

        Schema::create('vendedores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('nome');
            $table->char('matricula');
        });

        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('idCliente')->unsigned();
            $table->foreign('idCliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->bigInteger('idVendedor')->unsigned();
            $table->foreign('idVendedor')->references('id')->on('vendedores')->onDelete('cascade');
            $table->date('dataVenda');
        });

        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('nome');
            $table->char('matricula');
            $table->double('preco', 12, 2);
        });

        Schema::create('produtoVendas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('idVenda')->unsigned();
            $table->foreign('idVenda')->references('id')->on('vendas')->onDelete('cascade');
            $table->bigInteger('idProduto')->unsigned();
            $table->foreign('idProduto')->references('id')->on('produtos')->onDelete('cascade');
            $table->Integer('quantidade');
            $table->double('valor', 12, 2);
        });

        Schema::create('notasFiscais', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('idVenda')->unsigned();
            $table->foreign('idVenda')->references('id')->on('vendas')->onDelete('cascade');
            $table->double('valor', 12, 2);
            $table->double('imposto', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
