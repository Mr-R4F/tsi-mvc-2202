<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Clientes;
use Illuminate\Foundation\Testing\DatabaseTransactions; //para transações c/ o banco
use Tests\TestCase;

class ClientesTest extends TestCase
{
    use DataBaseTransactions;
    /*para transação (executa tudo com transação, e no final,
    dá o rollback (desfaz)) (usar o id, ve se existe,
    dá o rollback e volta o ID)
    - para não gerar lixo
    */
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate() //e ver se tem no banco e retorna
    {
        $cliente = Clientes::create([
            'nome' => 'teste',
            'endereco' => 'Rua dos bobo, 0',
            'email' => 'meu@email.com',
            'telefone' => '0012345678'
        ]);
        $this->assertDataBaseHas('Clientes', ['nome' => 'teste']);
        /* dessa forma, usa o id do banco (gasta um)
        $cliente->destroy($cliente->id);
        $this->assertDataBaseMissing('Clientes', ['nome' => 'teste']); //veja se está faltando este dado no banco de dados
        */
    }
}
