@extends('layouts.app')

@section('title', 'Detalhes da Sala')

@section('content')
@php
    $reservas = $sala->reservas()->with('cliente')->orderBy('data_reserva')->orderBy('horario_inicio')->get();
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detalhes da Sala</h1>
    <a href="{{ route('salas.index') }}" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        @if ($sala->imagem)
            <div class="mb-3">
                <p class="mb-2 fw-semibold">Imagem</p>
                <img src="{{ asset('storage/' . $sala->imagem) }}" alt="Imagem da sala {{ $sala->nome }}" class="img-fluid rounded border" style="max-width: 320px;">
            </div>
        @endif

        <dl class="row mb-0">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $sala->nome }}</dd>

            <dt class="col-sm-3">Capacidade</dt>
            <dd class="col-sm-9">{{ $sala->capacidade }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ ucfirst($sala->status) }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $sala->descricao ?: '-' }}</dd>
        </dl>
    </div>
</div>

<div class="card">
    <div class="card-header">Reservas vinculadas</div>
    <div class="card-body">
        @if ($reservas->isEmpty())
            <p class="text-muted mb-0">Esta sala não possui reservas.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservas as $reserva)
                            <tr>
                                <td>{{ $reserva->cliente?->nome ?: '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->horario_inicio)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->horario_fim)->format('H:i') }}</td>
                                <td>{{ ucfirst($reserva->status) }}</td>
                                <td>
                                    <a href="{{ route('reservas.show', $reserva) }}" class="btn btn-sm btn-outline-info">Ver</a>
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
