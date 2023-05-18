<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $primaryKey = 'email';
    protected $fillable = [
        'nome',
        'senha',
        'email',
        'cargo',
        'ultimoLogin',
        'dataRegistro',
        'status'
    ];
    protected $table = 'usuarios';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    protected $attributes = [
        'status' => false
    ];
}
