<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    /*
        protected $table = 'series'; 
        O Laravel torna minúsculo e em plural o nome do model
    */

    protected $fillable = ['nome'];

    public $timestamps = true;  // Grava ou nao informacoes de datas
}