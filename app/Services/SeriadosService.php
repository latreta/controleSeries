<?php

namespace App\Services;

use App\Seriado;
use App\Temporada;
use App\Episodio;
use DB;

class SeriadosService
{
    public function criarSeriado(string $nomeSeriado, int $qtdTemporadas, int $epiPorTemporadas): Seriado{

        DB::beginTransaction();
        $Seriado = Seriado::create(['nome' => $nomeSeriado]);
        $this->criaTemporadas($Seriado, $qtdTemporadas, $epiPorTemporadas);
        DB::commit();
        return $Seriado;
    }

    private function criaTemporadas(Seriado &$Seriado, int $qtdTemporadas, int $episodiosPorTemporadas){
        for($i = 1; $i <= $qtdTemporadas; $i++){
            $temporada = $Seriado->temporadas()->create(['numero' => $i]);
            $this->criaEpisodios($temporada, $episodiosPorTemporadas);
        }
    }

    private function criaEpisodios(Temporada &$temporada, int &$episodios){
        for($i = 1; $i <= $episodios; $i++){
            $temporada->episodios()->create(['numero' => $i]);
        }
    }

    public function deletaSeriado(int $SeriadoID): string{
        $nomeSeriado = '';
        DB::transaction(function() use ($SeriadoID, &$nomeSeriado) {
            $Seriado = Seriado::find($SeriadoID);
            $nomeSeriado = $Seriado->nome;

            $this->removerTemporadas($Seriado);
            $Seriado->delete();
        });

        return $nomeSeriado;
    }


    private function removerTemporadas(Seriado $Seriado): void {
        $Seriado->temporadas->each(function (Temporada $temporada){
            $this->removerEpisodios($temporada);
            $temporada->delete();
        });
    }

    private function removerEpisodios(Temporada $temporada): void{
        $temporada->episodios->each(
            function(Episodio $episodio){
                $episodio->delete();
            }
        );
    }
}