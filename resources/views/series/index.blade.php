@extends('layout')

@section('cabecalho')
Séries
@endsection


@section('conteudo')

@if($status == 1)
<div class="alert alert-success mt-2 mb-2" role="alert">
  Série adicionada com sucesso.
</div>
@elseif($status == 0)
<div class="alert alert-danger mt-2 mb-2" role="alert">
  Falha ao inserir nova série.
</div>
@endif

<a href="/series/criar" class="btn btn-dark mb-2">Adicionar</a>

<ul class="list-group">
    @foreach($series as $serie)
        <li class="list-group-item" style="text-transform:capitalize;">{{ $serie->nome }}</li>
    @endforeach
</ul>
@endsection