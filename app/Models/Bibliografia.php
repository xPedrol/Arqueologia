<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bibliografia extends Model
{
    public $primaryKey = 'id';

    protected $fillable = [
        'id',
        'author',
        'theme',
        'summary',
        'type',
        'createdAt',
        'updatedAt'
    ];

    protected $table = 'bibliografia';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;


    public function getFormatedCreatedAt()
    {
        return \Carbon\Carbon::parse($this->createdAt)->format('d/m/Y H:i') . ' - ' . \Carbon\Carbon::parse($this->createdAt)->diffForHumans();
    }

    public function getFormatedUpdatedAt()
    {
        return \Carbon\Carbon::parse($this->updatedAt)->format('d/m/Y H:i') . ' - ' . \Carbon\Carbon::parse($this->updatedAt)->diffForHumans();
    }

    public function getFormatedtype()
    {
        if ($this->type == 'book') {
            return 'Livro';
        } else if ($this->type == 'article') {
            return 'Artigo';
        } else if ($this->type == 'disserts') {
            return 'Tese';

        }
        return 'Outro';
    }
}
