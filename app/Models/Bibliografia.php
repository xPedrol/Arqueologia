<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

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
        $data =  Carbon::parse($this->createdAt)->tz(Config::get('app.default_timezone'));
        return $data->format('d/m/Y H:i') . ' - ' . $data->diffForHumans();
    }

    public function getFormatedUpdatedAt()
    {
        $data =  Carbon::parse($this->updatedAt)->tz(Config::get('app.default_timezone'));
        return $data->format('d/m/Y H:i') . ' - ' . $data->diffForHumans();
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
