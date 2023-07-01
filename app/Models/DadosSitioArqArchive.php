<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DadosSitioArqArchive extends Model
{
    public $primaryKey = 'id';

    protected $fillable = [
        'id',
        'path',
        'dadosSitioArqId',
        'createdAt',
        'updatedAt'
    ];
    protected $table = 'dadossitioarqueologicodocs';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public function getArchiveName()
    {
        $split = explode('/', $this->path);
        if (count($split) == 1) {
            $split = explode('\\', $this->path);
        }
        if (count($split) > 0 && $split[count($split) - 1] != "")
            return $split[count($split) - 1];
        else if (count($split) > 1 && $split[count($split) - 2] != "")
            return $split[count($split) - 2];
        else
            return "Arquivo sem nome";
    }
}
