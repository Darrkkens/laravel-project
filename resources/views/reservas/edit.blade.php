@extends('layouts.app')

@section('title', 'Editar Reserva')

@section('content')
<h1 class="h3 mb-3">Editar Reserva</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('reservas.update', $reserva) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select id="cliente_id" name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                    <option value="">Selecione</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" @selected((string) old('cliente_id', $reserva->cliente_id) === (string) $cliente->id)>
                            {{ $cliente->nome }} ({{ $cliente->documento }})
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="sala_id" class="form-label">Sala</label>
                <select id="sala_id" name="sala_id" class="form-select @error('sala_id') is-invalid @enderror" required>
                    <option value="">Selecione</option>
                    @foreach ($salas as $sala)
                        <option value="{{ $sala->id }}" @selected((string) old('sala_id', $reserva->sala_id) === (string) $sala->id)>
                            {{ $sala->nome }} (Capacidade: {{ $sala->capacidade }})
                        </option>
                    @endforeach
                </select>
                @error('sala_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="data_reserva" class="form-label">Data da Reserva</label>
                    <input type="date" id="data_reserva" name="data_reserva" class="form-control @error('data_reserva') is-invalid @enderror" value="{{ old('data_reserva', $reserva->data_reserva) }}" required>
                    @error('data_reserva')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="horario_inicio" class="form-label">Horário Início</label>
                    <input type="time" id="horario_inicio" name="horario_inicio" class="form-control @error('horario_inicio') is-invalid @enderror" value="{{ old('horario_inicio', \Carbon\Carbon::parse($reserva->horario_inicio)->format('H:i')) }}" required>
                    @error('horario_inicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="horario_fim" class="form-label">Horário Fim</label>
                    <input type="time" id="horario_fim" name="horario_fim" class="form-control @error('horario_fim') is-invalid @enderror" value="{{ old('horario_fim', \Carbon\Carbon::parse($reserva->horario_fim)->format('H:i')) }}" required>
                    @error('horario_fim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="">Selecione</option>
                    <option value="pendente" @selected(old('status', $reserva->status) === 'pendente')>Pendente</option>
                    <option value="confirmada" @selected(old('status', $reserva->status) === 'confirmada')>Confirmada</option>
                    <option value="cancelada" @selected(old('status', $reserva->status) === 'cancelada')>Cancelada</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('reservas.index') }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>
@endsection
