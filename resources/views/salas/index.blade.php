@extends('layouts.app')

@section('title', 'Salas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Salas</h1>
    <a href="{{ route('salas.create') }}" class="btn btn-primary">Nova Sala</a>
</div>


@if ($salas->isEmpty())
    <div class="alert alert-info mb-0">Nenhuma sala cadastrada.</div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        @foreach ($salas as $sala)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if ($sala->imagem)
                        <img src="{{ asset('storage/' . $sala->imagem) }}" alt="Imagem da sala {{ $sala->nome }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-secondary-subtle text-muted d-flex align-items-center justify-content-center" style="height: 220px;">
                            Sem imagem
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h2 class="h5 mb-0">{{ $sala->nome }}</h2>
                            @if ($sala->status === 'disponivel')
                                <span class="badge text-bg-success">Disponível</span>
                            @elseif ($sala->status === 'indisponivel')
                                <span class="badge text-bg-danger">Indisponível</span>
                            @else
                                <span class="badge text-bg-warning">Manutenção</span>
                            @endif
                        </div>

                        <p class="mb-1"><strong>Capacidade:</strong> {{ $sala->capacidade }} pessoas</p>
                        <p class="small text-muted">{{ \Illuminate\Support\Str::limit($sala->descricao ?: 'Sem descrição informada.', 90) }}</p>

                        <hr>
                        <p class="mb-1"><strong>Responsável:</strong> {{ $sala->responsavel_nome ?: '-' }}</p>
                        <p class="mb-1"><strong>Telefone:</strong> {{ $sala->responsavel_telefone ?: '-' }}</p>
                        <p class="mb-2"><strong>E-mail:</strong> {{ $sala->responsavel_email ?: '-' }}</p>

                        <p class="mb-0 small">
                            <strong>Local:</strong>
                            {{ $sala->logradouro ?: '-' }}{{ $sala->numero ? ', ' . $sala->numero : '' }}<br>
                            {{ $sala->bairro ?: '-' }} - {{ $sala->cidade ?: '-' }}/{{ strtoupper($sala->uf ?: '-') }}<br>
                            CEP: {{ $sala->cep ?: '-' }}
                        </p>

                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('salas.show', $sala) }}" class="btn btn-outline-info btn-sm">Ver</a>
                            <a href="{{ route('salas.edit', $sala) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
                            <form action="{{ route('salas.destroy', $sala) }}" method="POST" onsubmit="return confirm('Deseja excluir esta sala?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
