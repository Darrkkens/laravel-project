@extends('layouts.app')

@section('title', 'Salas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Salas</h1>
    <a href="{{ route('salas.create') }}" class="btn btn-primary">Nova Sala</a>
</div>

<div class="card">
    <div class="card-body">
        @if ($salas->isEmpty())
            <p class="text-muted mb-0">Nenhuma sala cadastrada.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Capacidade</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salas as $sala)
                            <tr>
                                <td>
                                    @if ($sala->imagem)
                                        <img src="{{ asset('storage/' . $sala->imagem) }}" alt="Imagem da sala {{ $sala->nome }}" class="img-thumbnail" style="width: 72px; height: 72px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">Sem imagem</span>
                                    @endif
                                </td>
                                <td>{{ $sala->nome }}</td>
                                <td>{{ $sala->capacidade }}</td>
                                <td>{{ ucfirst($sala->status) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('salas.show', $sala) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                    <a href="{{ route('salas.edit', $sala) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('salas.destroy', $sala) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir esta sala?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
