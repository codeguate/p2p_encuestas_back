<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marcas extends Model
{
    protected $table = 'marcas';

    public function encuestas(){
        return $this->hasMany('App\Encuestas','marca','id');
    }
}
