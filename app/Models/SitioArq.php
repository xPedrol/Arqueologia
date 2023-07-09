<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class SitioArq extends Model
{
    public $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'createdAt',
        'updatedAt',
        'legend'
    ];

    protected $table = 'sitioarqueologico';
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
}
