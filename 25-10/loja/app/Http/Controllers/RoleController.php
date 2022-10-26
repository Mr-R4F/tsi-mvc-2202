<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission; //pacote do composer para fazer controle de acesso por usuário (determina o que pode ser acessado)
use Spatie\Permission\Models\Role;
use DB;

class RoleController extends Controller
{
    //Doc.
    //docs.spatie.be/laravel-permission/v3/introduction (faz o controle por perfil)

    //chamar no construtor VVVV
    public function __construct() { //quando chamar a roleController isso é executado e controle se o usuario tem acesso a determinado metodo
        //o middle ware fazer o processamento da permissão para ver se pode acessar ou não e verifica se o usuário possui uma dessas permissões(administra o que faz ou não faz)

        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]); //middleware (passa o que vai usar, começa o controle de acesso)(diz quais middlewares se quer usar)(qualquer uma dessas permissões consegue ver os dados somente)
        //^^ se alguém tiver tentando acessar e tiver uma dessas permissões, já dá permissão ao index (lista os dados);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]); //se alguém tiver a permissão role create dá o acesso ao método create e store
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]); //se alguém tiver a permissão role edit dá o acesso ao método edit e update;
        $this->middleware('permission:role-delete', ['only' => ['destroy']]); //se alguém tiver a permissão role delete dá o acesso ao método edit e update;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) //pegar os perfis da index para mostra na view (muda de acordo c/ o perfil)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5); //recupera tudo do crud e mostra com o controle de paginação
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //aqui, pegar todas as permissões
    {
        //diz quais permissões o perfil possui, mostra todas as permissões disponíveis
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
        //devolve a view c/ o FORM
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //recebe do FORM pelo request
    {
        $this->validate($request, ['name' => 'required|unique:roles,name', 'permissions' => 'required']); //validar (único e roles e name) ( e permission que vem da view e é obrigatório)
        $role = Role::create(['name' => $request->input('name')]); //criar obj role , recebendo perfil que terá determinada permissão
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('roles.index')->with('sucess', 'Perfil criado com sucesso');
        //tudo que a pessõa tiver de permiussão devolve
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //mostra perfil
    {
        $role = Role::find($id); //retorna o perfil c/ base no ID
        //pegar as permissões do perfil
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $id)->get();//usa a model permission para pegar a permissão (fazer um JOIN na tabela) (vincula os dados nessa TABELA) (mudar na TABELA)
        //pegue tudo onde o ID for igual o ID, e faz join da has_permission com a permission  vinculando o join com a coluna ID da permission e pegue o dado -> o ORM é encarregado de fazer o JOIN de banco para banco
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) { //para EDIT pegar o perfil, permissões do perfil e todas as permissões (escolhe a permissão) (quais permissões existe e quais estão atribuidas)
        $role = Role::find($id); //recupera os dados do perfil
        $permissions = Permission::get(); //pega todas as permissões (da model) e joga na var
        //saber quais permissões o perfil tem
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)->pluck("role_has_permissions.permission_id")->all(); //faz consulta do banco (nessa tabela) (pega as permissões DESTE perfil)
        return view ('roles.edit', compact('role', 'permissions', 'rolePermissions')); //retorna a view c/ o forma para edita com todas ESSA variáveis
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //recebe dados do formulário, validar e atualizar banco (tipo de var que vai receber)
    {
        $this->validate($request, ['name' => 'required', 'permissions' => 'required']);
        $role = Role::find($id);//recupera qual perfil se quer alterar.
        $role->name = $request->input('name'); //Role só recebe o nome (atualiza)
        $role->save(); //salva o novo nome
        $role->syncPermissions($request->input('permissions')); //atualiza a permissão de determinado perfil
        return redirect()->route('roles.index')->with('sucess', 'Perfil atualizado com sucesso'); //e retorna na view
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Perfil apagado');
    }
}
