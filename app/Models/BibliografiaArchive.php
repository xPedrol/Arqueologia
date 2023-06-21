<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BibliografiaArchive extends Model
{
    public $primaryKey = 'id';

    protected $fillable = [
        'id',
        'path',
        'bibliografiaId'
    ];
//    protected $fillable = [
//        'fundo',
//        'grupo',
//        'num_ordem',
//        'codigo_ttd',
//        'data_producao',
//        'localizacao' ,
//        'emissor',
//        'funcao_emissor',
//        'destinatario',
//        'funcao_destinatario',
//        'formato_suporte',
//        'quantidade',
//        'identificacao',
//        'observacao',
//        'usuario'
//    ];
    protected $table = 'bibliografiadocs';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    //make a constructor to set the table name
//    public function __construct($archive)
//    {
//        //call parent constructor
//        parent::__construct();
//        $this->path = $archive->path;
//        $this->id_documento = $archive->id_documento;
//        $this->id = $archive->id;
//
////        $this->fundo = $archive->fundo;
////        $this->grupo = $archive->grupo;
////        $this->num_ordem = $archive->num_ordem;
////        $this->codigo_ttd = $archive->codigo_ttd;
////        $this->data_producao = $archive->data_producao;
////        $this->localizacao = $archive->localizacao;
////        $this->emissor = $archive->emissor;
////        $this->funcao_emissor = $archive->funcao_emissor;
////        $this->destinatario = $archive->destinatario;
////        $this->funcao_destinatario = $archive->funcao_destinatario;
////        $this->formato_suporte = $archive->formato_suporte;
////        $this->quantidade = $archive->quantidade;
////        $this->identificacao = $archive->identificacao;
////        $this->observacao = $archive->observacao;
////        $this->usuario = $archive->usuario;
//
//    }

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
