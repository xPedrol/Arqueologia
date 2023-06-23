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

    public function isUser()
    {
        return $this->role == 'user';
    }

    public function isIntern()
    {
        return $this->role == 'intern';
    }

    public function isActive()
    {
        return $this->status == 'active';
    }

    public function getFormatedCreatedAt()
    {
        return \Carbon\Carbon::parse($this->createdAt)->format('d/m/Y H:i') . ' - ' . \Carbon\Carbon::parse($this->createdAt)->diffForHumans();
    }

    public function getFormatedUpdatedAt()
    {
        return \Carbon\Carbon::parse($this->updatedAt)->format('d/m/Y H:i') . ' - ' . \Carbon\Carbon::parse($this->updatedAt)->diffForHumans();
    }

    public function getFormatedLastAccess()
    {
        return \Carbon\Carbon::parse($this->lastAccess)->format('d/m/Y H:i') . ' - ' . \Carbon\Carbon::parse($this->lastAccess)->diffForHumans();
    }
}
