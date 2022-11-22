<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Vendedores; //chamar p/ usar a model (import)

class vendedoresController extends Controller
{
    //atributo
    private $qtdPag = 5;

    public function __construct() { //quando chamar a roleController isso é executado e controle se o usuario tem acesso a determinado metodo
        //o middle ware fazer o processamento da permissão para ver se pode acessar ou não e verifica se o usuário possui uma dessas permissões(administra o que faz ou não faz)

        $this->middleware('permission:vendedores-list|vendedores-create|vendedores-edit|vendedores-delete', ['only' => ['index', 'show']]); //middleware (passa o que vai usar, começa o controle de acesso)(diz quais middlewares se quer usar)(qualquer uma dessas permissões consegue ver os dados somente)
        //^^ se alguém tiver tentando acessar e tiver uma dessas permissões, já dá permissão ao index (lista os dados);
        $this->middleware('permission:vendedores-create', ['only' => ['create', 'store']]); //se alguém tiver a permissão role create dá o acesso ao método create e store
        $this->middleware('permission:vendedores-edit', ['only' => ['edit', 'update']]); //se alguém tiver a permissão role edit dá o acesso ao método edit e update;
        $this->middleware('permission:vendedores-delete', ['only' => ['destroy']]); //se alguém tiver a permissão role delete dá o acesso ao método edit e update;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vend = vendedores::orderBy('id', 'ASC')->paginate($this->qtdPag);
        return view('vendedores.index', compact('vend'))->with('id', ($request->input('page', 1) - 1) * $this->qtdPag);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //chama o form para que os dados possam ser inseridos (mostra o form)
    {
        return view('vendedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //requesição vinda do browser
    {
        $this->validate($request, ['nome' => 'required', 'matricula' => 'required']);
        $input = $request->all();
        $vendedor = vendedores::create($input);
        return redirect()->route('vendedores.index')->with('success', 'Vendedor gravado com sucesso!');
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
        $vend = vendedores::find($id); //acha os dados
        // mostra na index
        //compact - cria um array contendo variaveis e seus valores
        return view('vendedores.show', compact('vend')); //a var vem daqui
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
        $vend = vendedores::find($id);
        return view('vendedores.edit', compact('vend')); //a var vem daqui
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
        $this->validate($request, ['nome' => 'required', 'matricula' => 'required']); //valida e vê se está preenchido e formato válido
        //pega todos os dados do usuário
        $input = $request->all();
        //joga na model cliente (bd)
        $vend = vendedores::find($id); //find primerio (retorna os dados)
        $vend->update($input); //atualiza tudo o que o usuário mandou
        //retorna um redirect para retorna para o index
        return redirect()->route('vendedores.index')->with('success', 'Vendedores atualizado com sucesso!');
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
        vendedores::find($id)->delete(); //ache o id e delete; //delete método da model
        return redirect()->route('vendedores.index')->with('success', 'Vendedor removido com sucesso!');
    }

    //criar método para teste
    public function checkVendedor(int $x)
    {
        return ($x <= 1) ? true : false; //checa vendedor
    }

    public function existsVendedor(string $nome):bool
    {
        $vendedores = ['Paula','Romeu','Amanda','José']; //simulação de banco de dados
        return (in_array($nome, $vendedores)) ? true : false; //checa se o val (nome no 'bd) existe no array (o q qr + o q tem)
    }

    public function getVendedor(int $id):?string //espera recebe id do vendedor, e retorna nulo(?) ou string
    {
        $vendedores = [1 => 'Paula', 2 => 'Romeu', 3 => 'Amanda', 4 => 'José']; //simula banco
        return (isset($vendedores[$id])) ? $vendedores[$id] : null; //testa se o vendedor existe
    }

    public function getVendedorJson(int $id):?string //espera recebe id do vendedor, e retorna nulo(?) ou string
    {
        $vendedores = [1 => 'Paula', 2 => 'Romeu', 3 => 'Amanda', 4 => 'José']; //simula banco
        return isset($vendedores[$id]) ? json_encode($vendedores[$id]) : null; //passando um id dif, dá erro
    }

    public function GetVendedorExactJson(int $id):?string
    {
        $vendedores = [1 => 'Paula', 2 => 'Romeu', 3 => 'Amanda', 4 => 'José'];
        return isset($vendedores[$id]) ? json_encode($vendedores[$id]) : null;
    }
}
