@extends('layouts.app')

@section('title', 'Detalhes da Reserva')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detalhes da Reserva</h1>
    <a href="{{ route('reservas.index') }}" class="btn btn-outline-secondary">Voltar</a>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Cliente</dt>
            <dd class="col-sm-9">{{ $reserva->cliente?->nome ?: '-' }}</dd>

            <dt class="col-sm-3">Sala</dt>
            <dd class="col-sm-9">{{ $reserva->sala?->nome ?: '-' }}</dd>

            <dt class="col-sm-3">Data</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Horário Início</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($reserva->horario_inicio)->format('H:i') }}</dd>

            <dt class="col-sm-3">Horário Fim</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($reserva->horario_fim)->format('H:i') }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ ucfirst($reserva->status) }}</dd>
        </dl>
    </div>
</div>
@endsection
