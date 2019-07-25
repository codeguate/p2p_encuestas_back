<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuestas extends Model
{
    protected $table = 'encuestas';

    public function imgs(){
        return $this->hasMany('App\EncuestasImgs','encuesta','id');
    }

    public function comentarios(){
        return $this->hasMany('App\ComentariosEncuestas','encuesta','id');
    }

    public function vendedores(){
        return $this->hasOne('App\Users','id','user');
    }
}
