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

<a href="{{ route('form_criar_serie') }}" class="btn btn-dark mb-2">Adicionar</a>

<ul class="list-group">
  @foreach($series as $serie)
  <li class="list-group-item d-flex align-items-center justify-content-between" style="text-transform:capitalize;">{{ $serie->nome }}
    <span class="d-flex">
      <a href="/series/{{$serie->id}}/temporadas" class="btn btn-info btn-sm">
      <i class="fas fa-external-link-alt"></i>
    </a>    
    <form method="post" action="/series/remover/{{$serie->id}}" 
      onsubmit="return confirm('Tem certeza que deseja remover\?');">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash-alt"></i></button>
    </form>
    </span>
  </li>
  @endforeach
</ul>
@endsection
