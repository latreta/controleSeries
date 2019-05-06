<?php

Route::get('/series', 'SeriesController@index')->name('listar_series');
Route::get('/series/criar', 'SeriesController@create')->name('form_criar_serie');
Route::post('/series/criar', 'SeriesController@store')->name('form_criar_serie');
Route::delete('/series/remover/{id}', 'SeriesController@destroy')->name('form_exclui_serie');
Route::get('/series/{serieId}/temporadas', 'TemporadasController@index')->name('listar_temporadas');