@extends('layouts.app')

@section('title', 'Editar Sala')

@section('content')
<h1 class="h3 mb-3">Editar Sala</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('salas.update', $sala) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $sala->nome) }}" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="capacidade" class="form-label">Capacidade</label>
                <input type="number" id="capacidade" name="capacidade" class="form-control @error('capacidade') is-invalid @enderror" value="{{ old('capacidade', $sala->capacidade) }}" min="1" required>
                @error('capacidade')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="4">{{ old('descricao', $sala->descricao) }}</textarea>
                @error('descricao')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="">Selecione</option>
                    <option value="disponivel" @selected(old('status', $sala->status) === 'disponivel')>Disponível</option>
                    <option value="indisponivel" @selected(old('status', $sala->status) === 'indisponivel')>Indisponível</option>
                    <option value="manutencao" @selected(old('status', $sala->status) === 'manutencao')>Manutenção</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" id="imagem" name="imagem" class="form-control @error('imagem') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
                @error('imagem')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if ($sala->imagem)
                <div class="mb-3">
                    <p class="form-label mb-2">Imagem atual</p>
                    <img src="{{ asset('storage/' . $sala->imagem) }}" alt="Imagem da sala {{ $sala->nome }}" class="img-thumbnail" style="max-width: 220px;">
                </div>
            @endif

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('salas.index') }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>
@endsection
