<?php

namespace App\Http\Controllers; 

use App\Serie;
use App\Http\Requests\SeriesFormRequest;
use Illuminate\Http\Request;
use App\Services\SeriesService;

class SeriesController extends Controller {
    const MENSAGEM = 'mensagem'; 
    const MENSAGEM_ERRO = 'mensagemErro';
    
    public function index(Request $request) {
        $series = Serie::query()->orderBy('nome')->get();
        $mensagens = $this->recuperaMensagens($request);
        $mensagem = $mensagens[self::MENSAGEM];
        $mensagemErro = $mensagens[self::MENSAGEM_ERRO];
        return view('series.index', compact('series', 'mensagem', 'mensagemErro'));
    }
    
    private function recuperaMensagens(Request $request) {
        $mensagem = $request->session()->get(self::MENSAGEM);
        $mensagemErro = $request->session()->get(self::MENSAGEM_ERRO);
        return compact('mensagem', 'mensagemErro');
    }
    
    public function create() {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, SeriesService $seriesService) {
        
        $seriesService->criarSerie(
            $request->nome, 
            $request->qtd_temporadas, 
            $request->ep_temporada
        );

        $request->session()->flash(
            self::MENSAGEM,
            "Série {$request->nome} criada com sucesso."
        );
            
        return redirect()->route('listar_series');
    }
    
    public function destroy(Request $request, SeriesService $seriesService) {
        $seriesService->deletaSerie($request->id);
        $request->session()
            ->flash(self::MENSAGEM,"Série removida com sucesso.");

        return redirect()->route('listar_series');
    }
}
