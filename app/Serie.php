<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'seriados';
    public $timestamps = true;  // Grava ou nao informacoes de datas
    protected $fillable = ['nome'];

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }
}