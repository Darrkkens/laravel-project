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
                <input type="text" id="documento" name="documento" class="form-control @error('documento') is-invalid @enderror" value="{{ old('documento') }}" maxlength="18" required>
                @error('documento')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control @error('telefone') is-invalid @enderror" value="{{ old('telefone') }}" maxlength="15">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const documentoInput = document.getElementById('documento');
    const telefoneInput = document.getElementById('telefone');

    function formatDocumento(value) {
        const digits = value.replace(/\D/g, '').slice(0, 14);

        if (digits.length <= 11) {
            return digits
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        return digits
            .replace(/^(\d{2})(\d)/, '$1.$2')
            .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
            .replace(/\.(\d{3})(\d)/, '.$1/$2')
            .replace(/(\d{4})(\d)/, '$1-$2');
    }

    function formatTelefone(value) {
        const digits = value.replace(/\D/g, '').slice(0, 11);

        if (digits.length <= 10) {
            return digits
                .replace(/^(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{4})(\d)/, '$1-$2');
        }

        return digits
            .replace(/^(\d{2})(\d)/, '($1) $2')
            .replace(/(\d{5})(\d)/, '$1-$2');
    }

    documentoInput.addEventListener('input', function () {
        documentoInput.value = formatDocumento(documentoInput.value);
    });

    telefoneInput.addEventListener('input', function () {
        telefoneInput.value = formatTelefone(telefoneInput.value);
    });

    documentoInput.value = formatDocumento(documentoInput.value);
    telefoneInput.value = formatTelefone(telefoneInput.value);
});
</script>
@endsection
