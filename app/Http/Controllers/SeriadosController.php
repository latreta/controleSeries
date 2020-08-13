<?php

namespace App\Http\Controllers; 

use App\Seriado;
use App\Http\Requests\SeriadosFormRequest;
use Illuminate\Http\Request;
use App\Services\SeriadosService;

class SeriadosController extends Controller {
    const MENSAGEM = 'mensagem'; 
    const MENSAGEM_ERRO = 'mensagemErro';
    
    public function index(Request $request) {
        $Seriados = Seriado::query()->orderBy('nome')->get();
        $mensagens = $this->recuperaMensagens($request);
        $mensagem = $mensagens[self::MENSAGEM];
        $mensagemErro = $mensagens[self::MENSAGEM_ERRO];
        return view('Seriados.index', compact('Seriados', 'mensagem', 'mensagemErro'));
    }
    
    private function recuperaMensagens(Request $request) {
        $mensagem = $request->session()->get(self::MENSAGEM);
        $mensagemErro = $request->session()->get(self::MENSAGEM_ERRO);
        return compact('mensagem', 'mensagemErro');
    }
    
    public function create() {
        return view('Seriados.create');
    }

    public function store(SeriadosFormRequest $request, SeriadosService $SeriadosService) {
        
        $Seriado = $SeriadosService->criarSeriado(
            $request->nome, 
            $request->qtd_temporadas, 
            $request->ep_temporada
        );

        $request->session()->flash(
            self::MENSAGEM,
            "Série {$Seriado->nome} criada com sucesso."
        );
            
        return redirect()->route('listar_Seriados');
    }
    
    public function destroy(Request $request, SeriadosService $SeriadosService) {
        $nomeSeriado = $SeriadosService->deletaSeriado($request->id);

        $request->session()
            ->flash(self::MENSAGEM,"Série {$nomeSeriado} removida com sucesso.");

        return redirect()->route('listar_Seriados');
    }
}
