@extends('layouts.app')

@section('title', 'Novo Cliente')

@section('content')
<h1 class="h3 mb-3">Novo Cliente</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="documento" class="form-label">Documento (CPF/CNPJ)</label>
                <input type="text" id="documento" name="documento" class="form-control @error('documento') is-invalid @enderror" value="{{ old('documento') }}" required>
                @error('documento')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control @error('telefone') is-invalid @enderror" value="{{ old('telefone') }}">
                @error('telefone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>
@endsection
