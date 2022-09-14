<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\clientes; //chamar a model (como se fosse um require)(faz autoload)

class clienteController extends Controller //herda tudo de controler
{
    //atributo
    private $qtdPag = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) //cria métodos //mostra tudo da tabela (pág principal)
    {
        //chama a model clientes // paginação paginate //cria registro condensado os dados
        //faz a listagem
        $cli = clientes::orderBy('id', 'ASC')->paginate($this->qtdPag); //refere-se ao *objeto*
        //retorna view usando compact para disponilizar os dados na view, passar with para funcionar
        //view e condições (primeiro parâmetro é a view)(criar pasta) pasta e arqrv usa . criar o diretório (segundo parêmtro são os dados) e depois faz a conta para a páginação funcionar
        return view('clientes.index', compact('cli'))->with('id', ($request->input('page', 1) - 1) * $this->qtdPag);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //chama o form para que os dados possam ser inseridos (mostra o form)
    {
        return view('clientes.create'); //pega aqui ***
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //armazena os dados de acordo com o método create (recebe dados do form clientes) //recebe dados e armazena
    {
        //***
        //usa método herdado validate
        //pega todos os dados enviados
        //joga direto na model clientes
        //redireciona para o index, mostrando uma mensagem de sucesso

        //validate -> passa no vetor quais campos quer validar
        $this->validate($request, ['nome' => 'required', 'email' => 'required|email']); //valida e vê se está preenchido e formato válido
        //pega todos os dados do usuário
        $input = $request->all();
        //joga na model cliente (bd)
        $clientes = clientes::create($input);
        //retorna um redirect para retorna para o index
        return redirect()->route('clientes.index')->with('success', 'Cliente gravado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //clica num registro especifico e mostra
    {
        //mostra apenas os dados de um determinado registro
        //pega o id;
        $cliente = clientes::find($id); //acha os dados
        // mostra na index
        //compact - cria um array contendo variaveis e seus valores
        return view('clientes.show', compact('cliente')); //a var vem daqui
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) //traz o form para editar e manda para o update
    {
        //o usuário manda o id, e recupera os dados de um determinado cliente e joga
        $cliente = clientes::find($id);
        return view('clientes.edit', compact('cliente')); //a var vem daqui
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //recebe os dados do form e atualiza no banco (ao submeter vem para aqui)
    {
        $this->validate($request, ['nome' => 'required', 'email' => 'required|email']); //valida e vê se está preenchido e formato válido
        //pega todos os dados do usuário
        $input = $request->all();
        //joga na model cliente (bd)
        $clientes = clientes::find($id); //find primerio (retorna os dados)
        $cliente->update($input); //atualiza tudo o que o usuário mandou
        //retorna um redirect para retorna para o index
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //apaga dados do banco //método do controller
    {
        //pega os dados da model e chamar este método
        clientes::find($id)->delete(); //ache o id e delete; //delete método da model
        return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso!');
    }
}
