<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/tarefas')->group(function() {
    
    Route::get('/', 'TarefaController@list')->name('tarefas.list'); // Listagem de tarefas

    Route::get('add', 'TarefaController@add')->name('tarefas.add'); // Tela de adição
    Route::post('add', 'TarefaController@addAction'); // Ação de adição

    Route::get('edit/{id}', 'TarefaController@edit')->name('tarefas.edit'); // Tela de edição
    Route::post('edit/{id}', 'TarefaController@editAction'); // Ação de edição

    Route::get('delete/{id}', 'TarefaController@del')->name('tarefas.del'); // Ação de deletar

    Route::get('marcar/{id}', 'TarefaController@done')->name('tarefas.done'); // Marcar resolvido/não.
});
