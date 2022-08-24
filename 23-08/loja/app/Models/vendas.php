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
        'idVendedor'
    ];

    protected $table = 'vendas';
}
