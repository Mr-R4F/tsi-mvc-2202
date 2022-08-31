<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'endereco',
        'email',
        'telefone',
    ];

    protected $table = 'clientes';
    //model nome da classe
    //tbl no atributo table
}



