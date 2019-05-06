<?php

namespace App\Services;

use App\Serie;
use App\Temporada;
use App\Episodio;
use DB;
use phpDocumentor\Reflection\Types\Nullable;

class SeriesService
{
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epiPorTemporadas){

        DB::transaction(function() use ($nomeSerie, $qtdTemporadas, $epiPorTemporadas){
            $serie = Serie::create(['nome' => $nomeSerie]);
            $this->criaTemporadas($serie, $qtdTemporadas, $epiPorTemporadas);
        });
    }

    private function criaTemporadas(Serie &$serie, int $qtdTemporadas, int $episodiosPorTemporadas){
        for($i = 1; $i <= $qtdTemporadas; $i++){
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            $this->criaEpisodios($temporada, $episodiosPorTemporadas);
        }
    }

    private function criaEpisodios(Temporada &$temporada, int &$episodios){
        for($i = 1; $i <= $episodios; $i++){
            $temporada->episodios()->create(['numero' => $i]);
        }
    }

    public function deletaSerie(int $serieID): void{
        DB::transaction(function() use ($serieID) {
            $serie = Serie::find($serieID);
            $serie->temporadas->each(
                function(Temporada $temporada)
                {
                    $this->removeEpisodios($temporada);                
                    $temporada->delete();
                }
            );
            $serie->delete();
        });
    }

    private function removeEpisodios(Temporada $temporada): void{
        $temporada->episodios->each(
            function(Episodio $episodio){
                $episodio->delete();
            }
        );
    }
}