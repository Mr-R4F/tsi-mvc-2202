<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produtosVenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'idVenda',
        'idProduto',
        'quantidade',
        'valor'
    ];

    protected $table = 'produtovendas';
}
