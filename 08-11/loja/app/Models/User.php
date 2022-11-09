<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; //para o controle de acesso por permissão.
use Tymon\JWTAuth\Contracts\JWTSubject; //colocar isso

class User extends Authenticatable implements JWTSubject //colocar isto /implements jwt...
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; //add HasRoles (a classe autenticável também vai usar a classe `Role`)

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //fazer isso
    public function getJWTIdentifier() {
        return $this->getKey(); //retornar a chave
    }

    public function getJWTCustomClaims() {//retorna nada (vetor)
        return []; //retorna vetor
    }
}
