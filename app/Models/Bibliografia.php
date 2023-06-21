<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    //make a constructor to set the table name
//    public function __construct($archive)
//    {
//        //call parent constructor
//        parent::__construct();
//        $this->author = $archive->author;
//        $this->theme = $archive->theme;
//        $this->summary = $archive->summary;
//        $this->type = $archive->type;
//        $this->createdAt = $archive->createdAt;
//        $this->updatedAt = $archive->updatedAt;
//    }

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
