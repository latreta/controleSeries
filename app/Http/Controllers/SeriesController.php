<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Serie;

class SeriesController extends Controller
{

    public function index(Request $request)
    {
        $series = Serie::all();
        $status = -1;

        return view('series.index', compact('series', 'status'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request){
        $nome = $request->nome; // $request->get('nome');
        if(strlen($nome) <= 0){
            $status = false;
        }
        else{
            $serie = Serie::create(
                [
                    'nome' => $nome
                ]
            );
            $status = $serie->save();
        }
        

        $series = Serie::query()->orderBy('nome')->get();
        return view('series.index', ['status' => $status, 'series' => $series]);
    }
}
