<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) { //chama o método browser e 'pede' para visitar a rota raiz e afirma que 'enxerga' um conteúdo em algum lugar
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
}
