<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $fillable=[
       'idcategoria','codigo','titulo','editorial','valor','stock','descripcion','condicion' 
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
