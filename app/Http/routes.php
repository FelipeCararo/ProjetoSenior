<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/painel/produtos/administrador', 'Painel\ProdutoController@administrador');
Route::get('/painel/produtos/buscaProdutos', 'Painel\ProdutoController@buscaProdutos');
Route::get('/painel/produtos/cancelar',      'Painel\ProdutoController@cancelar');
Route::get('/painel/produtos/insereVenda',   'Painel\ProdutoController@insereVenda');
Route::resource('/painel/produtos',          'Painel\ProdutoController');
