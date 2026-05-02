@extends('layouts.app')

@section('title', 'Detalhes do Cliente')

@section('content')
@php
    $reservas = $cliente->reservas()->with('sala')->orderBy('data_reserva')->orderBy('horario_inicio')->get();
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detalhes do Cliente</h1>
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $cliente->nome }}</dd>

            <dt class="col-sm-3">Documento</dt>
            <dd class="col-sm-9">{{ $cliente->documento }}</dd>

            <dt class="col-sm-3">Telefone</dt>
            <dd class="col-sm-9">{{ $cliente->telefone ?: '-' }}</dd>

            <dt class="col-sm-3">E-mail</dt>
            <dd class="col-sm-9">{{ $cliente->email ?: '-' }}</dd>
        </dl>
    </div>
</div>

<div class="card">
    <div class="card-header">Reservas vinculadas</div>
    <div class="card-body">
        @if ($reservas->isEmpty())
            <p class="text-muted mb-0">Este cliente não possui reservas.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Sala</th>
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
                                <td>{{ $reserva->sala?->nome ?: '-' }}</td>
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
