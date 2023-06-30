<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitioArq extends Model
{
    public $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'createdAt',
        'updatedAt'
    ];

    protected $table = 'sitioarqueologico';
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
}
