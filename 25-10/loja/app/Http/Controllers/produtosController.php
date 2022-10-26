<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\produtos;

class produtosController extends Controller
{
    //atributo
    private $qtdPag = 5;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prod = produtos::orderBy('id', 'ASC')->paginate($this->qtdPag);
        return view('produtos.index', compact('prod'))->with('id', ($request->input('page', 1) - 1) * $this->qtdPag);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //chama o form para que os dados possam ser inseridos (mostra o form)
    {
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //requesição vinda do browser
    {
        $this->validate($request, ['nome' => 'required', 'descricao' => 'required', 'preco' => 'required']);
        $input = $request->all();
        $produto = produtos::create($input);
        return redirect()->route('produtos.index')->with('success', 'Produto gravado com sucesso!');
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
        $prod = produtos::find($id); //acha os dados
        // mostra na index
        //compact - cria um array contendo variaveis e seus valores
        return view('produtos.show', compact('prod')); //a var vem daqui
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
        $prod = produtos::find($id);
        return view('produtos.edit', compact('prod')); //a var vem daqui
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
        $this->validate($request, ['nome' => 'required', 'descricao' => 'required', 'preco' => 'required']); //valida e vê se está preenchido e formato válido
        //pega todos os dados do usuário
        $input = $request->all();
        //joga na model cliente (bd)
        $prod = produtos::find($id); //find primerio (retorna os dados)
        $prod->update($input); //atualiza tudo o que o usuário mandou
        //retorna um redirect para retorna para o index
        return redirect()->route('produtos.index')->with('success', 'Produtos atualizado com sucesso!');
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
        produtos::find($id)->delete(); //ache o id e delete; //delete método da model
        return redirect()->route('produtos.index')->with('success', 'Produto removido com sucesso!');
    }
}
