<?php

namespace App\Services;

use App\Serie;
use App\Temporada;
use App\Episodio;

class CriadorDeSerie
{
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epiPorTemporadas){
        $serie = Serie::create(['nome' => $nomeSerie]);
        
        for($i = 1; $i <= $qtdTemporadas; $i++){
            $temporada = $serie->temporadas()->create(['numero' => $i]);

            for($j = 1 ; $j <= $epiPorTemporadas; $j++){
                $temporada->episodios()->create(['numero' => $j]);
            }
        }
        return $serie;
    }

    public function deletaSerie(Serie $serie){
        $serie->temporadas->each(
            function(Temporada $temporada)
            {
                $temporada->episodios->each(function(Episodio $episodio){
                    $episodio->delete();
                });
                $temporada->delete();
            }
        );
        $serie->delete();
    }
}