<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notasFiscais extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'idVenda',
        'valor',
        'imposto'
    ];

    protected $table = 'notasFiscais';
}
