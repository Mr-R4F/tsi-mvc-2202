<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//necessário chamar as dependencias
use Illuminate\Support\Arr; //Doc.-https://laravel.com/docs/master/helpersuse / funções para trabalhar com o vetor
use App\User; //model user
use useSpatie\Permission\Models\Role; //pacote da classe de perfil
use DB; //acesso ao banco de dados
use Hash; //criptografia de senha

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5); //5 em ordem decrescente
        return view('users.index', compact('data'))->with('i',($request->input('page', 1) - 1) * 5); //para a var data para useres
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() //Criação de perfis
    {
        $roles = Role::pluck('name','name')->all(); //pega os dados de determinada classe (nome nesse caso) (pluck)
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //enviar os dados para o banco
    {
        //valida campos do formulário
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|email|unique:users,email', //email único
            'password'=>'required|same:confirm-password', //obrigatório e bater com a confirm password
            'roles'=>'required'
        ]);
        $input = $request->all(); //pega tudo do form
        $input['password'] = Hash::make($input['password']); //pega o campo senha e usa a classe hash (para criptografar a senha)
        $user = User::create($input); //grava com base do que enviado no form (perfil)
        $user->assignRole($request->input('roles')); //delega, ao grava escolhe a opção do perfil (delega tal papel para um usuário)(ao criar o usuário associar o perfil)
        return redirect()->route('users.index')->with('success','Usuário criado com sucesso'); //redireciona com uma mensagem
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //mostrar determinado usuario (com base no ID)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) //pega todos os perfis
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all(); //pega o perfil do usuário
        return view('users.edit', compact('user','roles','userRole')); //e mostra na view
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //recebe os dados do form e manda para o banco
    {
        $this->validate($request, [ //campos para validação
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'. $id, //mesma coisa do email só passando um ID
            'password'=>'same:confirm-password',
            'roles'=>'required'
        ]);
        $input = $request->all(); //pega tudo do form e joga na variavel input

        if(!empty($input['password'])) { //se não for enviada uma senha manter a atual senão mudar.
            $input['password'] = Hash::make($input['password']); // muda a senha
        } else {
            $input = Arr::except($input, array('password')); //muda todos os campos menos este campo (senha)
        }

        $user = User::find($id); //acha o usuário por um determinado ID
        $user->update($input); //atualiza o usuario com os dados do input
        DB::table('model_has_roles')->where('model_id', $id)->delete(); //apaga da tabela has roles (define os perfis). (pois outro perfil será definido)
        $user->assignRole($request->input('roles')); //atribui novo perfil p/ o usuário.
        return redirect()->route('users.index')->with('success','Usuário atualizado com sucesso'); //redireciona para o index com a mensagem de erro
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete(); //com o ID apaga o usuário
        return redirect()->route('users.index')->with('success','Usuário removido com sucesso'); //index com a mensagem.
    }
}
