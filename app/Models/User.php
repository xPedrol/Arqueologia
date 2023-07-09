<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class User extends Authenticatable
{
    public $primaryKey = 'email';
    protected $fillable = [
        'id',
        'login',
        'password',
        'email',
        'socialName',
        'birthDate',
        'institution',
        'link',
        'location',
        'avatar',
        'keepPublic',
        'role',
        'status',
        'createdAt',
        'updatedAt',
        'lastAccess',
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
        $data =  Carbon::parse($this->createdAt)->tz(Config::get('app.default_timezone'));
        return $data->format('d/m/Y H:i') . ' - ' . $data->diffForHumans();
    }

    public function getFormatedUpdatedAt()
    {
        $data =  Carbon::parse($this->updatedAt)->tz(Config::get('app.default_timezone'));
        return $data->format('d/m/Y H:i') . ' - ' . $data->diffForHumans();
    }

    public function getFormatedLastAccess()
    {
        $data =  Carbon::parse($this->lastAccess)->tz(Config::get('app.default_timezone'));
        return $data->format('d/m/Y H:i') . ' - ' . $data->diffForHumans();
    }

    public function getStatus()
    {
        return $this->status == 'active' ? 'Ativo' : 'Inativo';
    }

    public function getRole()
    {
        if ($this->isAdmin()) {
            return 'Administrador';
        }
        if ($this->isUser()) {
            return 'Usuário';
        }
        if ($this->isIntern()) {
            return 'Estagiário';
        }
        return 'Desconhecido';

    }
}
