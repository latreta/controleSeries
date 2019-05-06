<?php

namespace App\Services;

use App\Serie;
use App\Temporada;
use App\Episodio;
use DB;

class SeriesService
{
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epiPorTemporadas): Serie{

        DB::beginTransaction();
        $serie = Serie::create(['nome' => $nomeSerie]);
        $this->criaTemporadas($serie, $qtdTemporadas, $epiPorTemporadas);
        DB::commit();
        return $serie;
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

    public function deletaSerie(int $serieID): string{
        $nomeSerie = '';
        DB::transaction(function() use ($serieID, &$nomeSerie) {
            $serie = Serie::find($serieID);
            $nomeSerie = $serie->nome;

            $this->removerTemporadas($serie);
            $serie->delete();
        });

        return $nomeSerie;
    }


    private function removerTemporadas(Serie $serie): void {
        $serie->temporadas->each(function (Temporada $temporada){
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