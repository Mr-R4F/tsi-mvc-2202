<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//model perfil e permission do pacote ACL. (List control acess)
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; //chamar model usuários

class SeederUserAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@sp.senac.br',
            'password' => bcrypt('12345678')
        ]); //da model usuário criar (pegar as infos para atribuir p/ o usuário ADM)
        $permissions = Permission::pluck('id', 'id')->all(); //(pluck -> pega todas as permissões pela id para associar os id da permissão para o usuário)(pega os id para atribuir p/ o usuário)
        $role = Role::create(['name' => 'Administrador']); // criar um perfil
        $role->syncPermissions($permissions);//associar as permissões para o perfil
        //associar o perfil ao USUÁRIO
        $user->assignRole([$role->id]); //delegando um perfil para o usuário
    }
}
