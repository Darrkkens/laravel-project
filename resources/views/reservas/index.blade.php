@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Reservas</h1>
    <a href="{{ route('reservas.create') }}" class="btn btn-primary">Nova Reserva</a>
</div>

<div class="card">
    <div class="card-body">
        @if ($reservas->isEmpty())
            <p class="text-muted mb-0">Nenhuma reserva cadastrada.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Sala</th>
                            <th>Data</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservas as $reserva)
                            <tr>
                                <td>{{ $reserva->cliente?->nome ?: '-' }}</td>
                                <td>{{ $reserva->sala?->nome ?: '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->data_reserva)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->horario_inicio)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($reserva->horario_fim)->format('H:i') }}</td>
                                <td>{{ ucfirst($reserva->status) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('reservas.show', $reserva) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                    <a href="{{ route('reservas.edit', $reserva) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir esta reserva?');">
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
