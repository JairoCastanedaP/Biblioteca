<?php

Route::get('/', function () {
    return view('contenido/contenido');
});


Route::get('/categoria','CategoriaController@index');
Route::post('/categoria/registrar','CategoriaController@store');
Route::put('/categoria/actualizar','CategoriaController@update');
Route::put('/categoria/desactivar','CategoriaController@desactivar');
Route::put('/categoria/activar','CategoriaController@activar');
Route::get('/categoria/selectCategoria','CategoriaController@selectCategoria');

Route::get('/libro','LibroController@index');
Route::post('/libro/registrar','LibroController@store');
Route::put('/libro/actualizar','LibroController@update');
Route::put('/libro/desactivar','LibroController@desactivar');
Route::put('/libro/activar','LibroController@activar');

Route::get('/cliente', 'ClienteController@index');
Route::post('/cliente/registrar', 'ClienteController@store');
Route::put('/cliente/actualizar', 'ClienteController@update');

Route::get('/rol', 'RolController@index');
Route::get('/rol/selectRol', 'RolController@selectRol');

Route::get('/user','UserController@index');
Route::post('/user/registrar','UserController@store');
Route::put('/user/actualizar','UserController@update');
Route::put('/user/desactivar','UserController@desactivar');
Route::put('/user/activar','UserController@activar');

