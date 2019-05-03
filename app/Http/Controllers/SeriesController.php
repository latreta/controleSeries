<?php

namespace App\Http\Controllers;

use App\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    const MENSAGEM = 'mensagem';
    const MENSAGEM_ERRO = 'mensagemErro';

    public function index(Request $request)
    {
        $series = Serie::query()->orderBy('nome')->get();
        $mensagens = $this->recuperaMensagens($request);
        $mensagem = $mensagens[self::MENSAGEM];
        $mensagemErro = $mensagens[self::MENSAGEM_ERRO];
        return view('series.index', compact('series', 'mensagem', 'mensagemErro'));
    }

    private function recuperaMensagens(Request $request)
    {
        $mensagem = $request->session()->get(self::MENSAGEM);
        $mensagemErro = $request->session()->get(self::MENSAGEM_ERRO);
        // $request->session()->remove(self::MENSAGEM);
        // $request->session()->remove(self::MENSAGEM_ERRO);
        return compact('mensagem', 'mensagemErro');

    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $nome = $request->nome;
        if (strlen($nome) <= 0) {
            $request->session()->flash(
                self::MENSAGEM_ERRO,
                "Ocorreu um erro ao tentar incluir."
            );
        } else {
            $serie = Serie::create(
                [
                    'nome' => $nome,
                ]
            );
            $status = $serie->save();
            $request->session()->flash(
                self::MENSAGEM,
                "Série {$serie->nome} criada com sucesso."
            );
        }

        return redirect('/series');
    }

    public function delete(Request $request){
        $serie_id = $request->id;

        if(!is_null($serie_id)){
            $status = Serie::destroy($serie_id);
            if($status){
                $request->session()->flash(self::MENSAGEM, "Série removida com sucesso.");
            }
            else{
                $request->session()->flash(self::MENSAGEM_ERRO, "Falha ao realizar operação.");

            }
        }

        return redirect('/series');

    }
}
