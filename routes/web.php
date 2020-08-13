<?php

Route::get('/', function () {
    return redirect('/seriados');
});
Route::get('/seriados', 'SeriadosController@index')->name('listar_Seriados');
Route::get('/seriados/criar', 'SeriadosController@create')->name('form_criar_Seriado');
Route::post('/seriados/criar', 'SeriadosController@store')->name('form_criar_Seriado');
Route::get('/seriados/remover/{id}', 'SeriadosController@destroy')->name('form_exclui_Seriado');
Route::get('/seriados/{seriadoid}/temporadas', 'TemporadasController@index')->name('listar_temporadas');