<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libro;

class LibroController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax())return redirect('/');

        $buscar =$request->buscar;
        $criterio=$request->criterio;
        if($buscar==''){
            $libros = Libro::join('categorias','libros.idcategoria','=','categorias.id')
            ->select('libros.id','libros.idcategoria','libros.codigo','libros.titulo','libros.editorial','libros.valor','libros.stock','libros.descripcion','libros.condicion','categorias.nombre as nombre_categoria')
            ->orderBy('libros.id','desc')->paginate(3);
        }
        else{
            $libros = Libro::join('categorias','libros.idcategoria','=','categorias.id')
            ->select('libros.id','libros.idcategoria','libros.codigo','libros.titulo','libros.editorial','libros.valor','libros.stock','libros.descripcion','libros.condicion','categorias.nombre as nombre_categoria')
            ->where('libros.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('libros.id','desc')->paginate(3);     
        }
        return [
            'pagination'=>[
                'total'            =>$libros->total(),
                'current_page'     =>$libros->currentPage(),
                'per_page'         => $libros->perPage(),
                'last_page'        =>$libros->lastPage(),
                'from'             => $libros->firstItem(),
                'to'               => $libros->lastItem(),
            ],
            'libros'=>$libros
        ];
    }
    public function store(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $libro = new libro();
        $libro->idcategoria =$request->idcategoria;
        $libro->titulo =$request->titulo;
        $libro->descripcion=$request->descripcion;
        $libro->codigo =$request->codigo;
    
        $libro->valor =$request->valor;
        $libro->stock =$request->stock;
        $libro->editorial=$request->editorial;
       
        $libro->condicion='1'; 
        $libro->save();  
    }
    public function update(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $libro = Libro::findOrFail($request->id);
        $libro->idcategoria =$request->idcategoria;
        $libro->codigo =$request->codigo;
        $libro->titulo =$request->titulo;
        $libro->valor =$request->valor;
        $libro->stock =$request->stock;
        $libro->editorial=$request->editorial;
        $libro->descripcion=$request->descripcion;
        $libro->condicion='1'; 
        $libro->save();    
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $libro =  Libro::findOrFail($request->id);
        $libro->condicion='0'; 
        $libro->save();   
    }
    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $libro =  Libro::findOrFail($request->id);
        $libro->condicion='1'; 
        $libro->save();   
    }
}
