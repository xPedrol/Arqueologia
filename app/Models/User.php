<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $primaryKey = 'email';
    protected $fillable = [
        'id',
        'login',
        'password',
        'email',
        'niceName'
    ];
    protected $table = 'usuarios';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public function isAdmin()
    {
        return $this->role == 'admin';
    }
}
