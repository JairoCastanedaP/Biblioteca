<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //protected $table = 'categorias';
    //protected $primarykey= 'id';

    protected $fillable=[
        'nombre','descripcion','condicion'
    ];
    public function libros()
    {
        return $this->hasMany('App\Libro');
    }
    
}
