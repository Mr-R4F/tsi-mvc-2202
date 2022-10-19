<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //controle c/ todas as permissions
        $permissions = [
            'role-list',
            'role-edit',
            'role-delete',
            'role-create',

            'user-list',
            'user-edit',
            'user-delete',
            'user-create',

            'vendedores-list',
            'vendedores-edit',
            'vendedores-delete',
            'vendedores-create',

            'clientes-list',
            'clientes-edit',
            'clientes-delete',
            'clientes-create',

            'produtos-list',
            'produtos-edit',
            'produtos-delete',
            'produtos-create'
        ];
        //loop para popular o banco de acordo com o que está no vetor
        foreach($permissions as $permission) {
            Permission::create(['name' => $permission]); //e cada interação vai colocar no campo name da model permission (pega a permissão e coloca no campo NAME)
        }
    }
}
