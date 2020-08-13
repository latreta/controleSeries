<?php

namespace App\Http\Controllers;

use App\Seriado;

class TemporadasController extends Controller
{
    public function index(int $SeriadoId)
    {
        $Seriado = Seriado::find($SeriadoId);
        $temporadas = $Seriado->temporadas;
        return view('temporadas.index', compact('temporadas', 'Seriado'));
    }
}
