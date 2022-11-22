<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\vendedoresController;
use Tests\TestCase;

class VendedoresControllerTest extends TestCase //teste case se o padrão (nome-que-quer-testar e final teste)(teste-qlqr-coisa e método que qr testar)
{
    private $vendedor;

    public function __construct() {
        parent::__construct();
        $this->vendedor = new VendedoresController;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/'); //ve se consegue obter a raiz (faz req para a url raiz)

        $response->assertStatus(200); //e seretornar 200 (asserção/afirmação) que o status será 200 ,caso contrário o teste é bem sucessido
        //
    }

    public function testCheckVendedor() //método para testar vendedor
    {
        $this->assertTrue($this->vendedor->checkVendedor(-1)); //se a saida for true (se chamar e passar o param 1) (a saída deve ser se valor (TRUE)) / SÓ VE uma posibilidade, deve testar se for false tbm
        $this->assertTrue($this->vendedor->checkVendedor(1));
        $this->assertFalse($this->vendedor->checkVendedor(2)); //define que o 2 é falso
        $this->assertFalse($this->vendedor->checkVendedor(99999));
    }

    public function testExistsVendedor() //método para testar vendedor
    {
        $this->assertFalse($this->vendedor->existsVendedor('Marcos'));
        $this->assertTrue($this->vendedor->existsVendedor('Paula'));
    }

    public function testGetVendedor() //método para testar vendedor
    {
        $this->assertEquals('Romeu', $this->vendedor->getVendedor(2)); //criar teste, e veja se o id x é igual a tal id. (vê se o ID é = a 2)
        $this->assertNotEquals('Romeu', $this->vendedor->getVendedor(4));
    }

    public function testGetVendedorJson()
    {
        $this->assertJson($this->vendedor->GetVendedorJson(2)); //no json, pegue o vendedore 3 (ve se tem)
    }/*

    public function testGetVendedorJsonMissing()
    {
        $this->assertExactJson($this->vendedor->GetVendedorExactJson(1));
    }
    */
}
