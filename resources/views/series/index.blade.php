@extends('layout')

@section('cabecalho')
Séries
@endsection


@section('conteudo')

@if(!empty($mensagem))
<div class="alert alert-success" role="alert">
  {{$mensagem}}
</div>
@endif
@if(!empty($mensagemErro))
<div class="alert alert-danger" role="alert">
  {{$mensagemErro}}
</div>
@endif

<a href="/series/criar" class="btn btn-dark mb-2">Adicionar</a>

<ul class="list-group">
    @foreach($series as $serie)
      <form method="post" action="/series/remover/{{$serie->id}}">
        @csrf
        @method('DELETE')
        <li class="list-group-item" style="text-transform:capitalize;">{{ $serie->nome }}
          <button class="btn btn-danger">Excluir</button>   
        </li>   
      </form>
    @endforeach
</ul>
@endsection
