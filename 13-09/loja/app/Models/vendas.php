<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vendas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'idCliente',
        'idVendedor',
        'dataVenda'
    ]; //campos do

    protected $table = 'vendas';

    public function comprador() {
        return $this->belongsTo(clientes::class, 'idCliente'); //1 cliente pertence a( belongTo) (pertence há) //como clientes não podem ter duas compras
    }

    public function vendedor() {
        return $this->belongsTo(vendedores::class, 'idVendedor'); //pega o campo e associa com atabela (pega o id cliente e associo com o campo id desta MODEL)
    }

    public function notaFiscal() {
        return $this->hasOne(notasFiscais::class, 'idVenda'); //nota fiscal é relacionada a um produto
    }
}
