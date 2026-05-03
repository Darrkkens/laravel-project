@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Dashboard</h1>
    <a href="{{ route('reservas.create') }}" class="btn btn-primary">Nova Reserva</a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-primary h-100">
            <div class="card-body">
                <h2 class="h6 text-muted">Total de Clientes</h2>
                <p class="display-6 mb-0">{{ $totalClientes }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success h-100">
            <div class="card-body">
                <h2 class="h6 text-muted">Total de Salas</h2>
                <p class="display-6 mb-0">{{ $totalSalas }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-warning h-100">
            <div class="card-body">
                <h2 class="h6 text-muted">Total de Reservas</h2>
                <p class="display-6 mb-0">{{ $totalReservas }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 d-flex justify-content-between align-items-center">
    <h2 class="h4 mb-0">Salas Disponíveis</h2>
    <a href="{{ route('salas.index') }}" class="btn btn-outline-secondary">Ver Todas</a>
</div>

@if ($salas->isEmpty())
    <div class="alert alert-info mb-0">Nenhuma sala cadastrada no momento.</div>
@else
    <div class="row g-4">
        @foreach ($salas as $sala)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    @if ($sala->imagem)
                        <img src="{{ asset('storage/' . $sala->imagem) }}" class="card-img-top" alt="Imagem da sala {{ $sala->nome }}" style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-secondary-subtle d-flex align-items-center justify-content-center text-muted" style="height: 220px;">
                            Sem imagem
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="h5 mb-0">{{ $sala->nome }}</h3>
                            @if ($sala->status === 'disponivel')
                                <span class="badge text-bg-success">Disponível</span>
                            @elseif ($sala->status === 'indisponivel')
                                <span class="badge text-bg-danger">Indisponível</span>
                            @else
                                <span class="badge text-bg-warning">Manutenção</span>
                            @endif
                        </div>

                        <p class="text-muted mb-2">Capacidade: {{ $sala->capacidade }} pessoas</p>
                        <p class="small mb-4 flex-grow-1">{{ $sala->descricao ?: 'Sem descrição informada.' }}</p>

                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('salas.show', $sala) }}" class="btn btn-outline-primary btn-sm">Detalhes</a>
                            @if ($sala->status === 'disponivel')
                                <a href="{{ route('reservas.create', ['sala_id' => $sala->id]) }}" class="btn btn-primary btn-sm">Reservar</a>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm" disabled>Indisponível</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
