<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendedores;

class VendedoresApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Vendedores::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = $request->getContent(); //recebe um JSON e se der certo cria
        return Vendedores::create(json_decode($json, JSON_OBJECT_AS_ARRAY));
        /* recebe um json, tranforma em array //pois o método create espera receba um vetor
        //pega o json e converte para o vetor
        (JSON_OBJECT_AS_ARRAY -> converte em objeto em vetor não em PHP (pois esse método espera receber um vetor)) */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendedor = Vendedores::find($id);
        return $vendedor ? $vendedor : json_encode([$id => 'Não existe']);; //retorna se existir senão retorna mensagem.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vendedor = Vendedores::find($id);

        if ($vendedor) {
            $json = $request->getContent(); //pega o conteudo
            $atualizacao = json_decode($json, JSON_OBJECT_AS_ARRAY);
            $vendedor->nome = $atualizacao['nome'];
            $vendedor->matricula = $atualizacao['matricula'];
            $ret = $vendedor->update() ? [$id => 'Atualizado'] : [$id => 'Erro ao atualizar'];
            //se der certo atualiza (achar o id) senão
        } else {
            $ret = [$id => 'Não existe'];
        } //verifica se o usuario existe, se existe pega o json do usuario, transforma em vetor
        return json_encode($ret);
        //encode -> transforma em json
        //decode -> deixa de ser json
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendedor = Vendedores::find($id); //usa o find da model vendedores
        $vendedor ? ($ret = $vendedor->delete() ? [$id => 'Apagado'] : [$id => 'Erro ao apagar']) : $ret = [$id => 'Usuário não existe']; //se o vendedores for true e  $ret tbm
        return json_encode($ret);
    }
}
