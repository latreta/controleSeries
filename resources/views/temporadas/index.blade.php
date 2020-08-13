@extends('layout')

@section('cabecalho')
    Temporadas de {{$Seriado->nome}}
@endsection


@section('conteudo')

<a href="{{ route('listar_Seriados') }}" class="btn btn-dark mb-2">Voltar</a>

<ul class="list-group">
  @foreach($temporadas as $temporada)
  <li class="list-group-item">Temporada {{ $temporada->numero }}
  </li>
  @endforeach
</ul>

@endsection