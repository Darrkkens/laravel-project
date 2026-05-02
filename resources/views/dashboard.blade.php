@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Dashboard</h1>
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

<div class="mt-4 d-flex gap-2">
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-primary">Gerenciar Clientes</a>
    <a href="{{ route('salas.index') }}" class="btn btn-outline-success">Gerenciar Salas</a>
    <a href="{{ route('reservas.index') }}" class="btn btn-outline-warning">Gerenciar Reservas</a>
</div>
@endsection
