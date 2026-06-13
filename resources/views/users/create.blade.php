@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<h1 class="h3 mb-3">Novo Usuário</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="6" required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" minlength="6" required autocomplete="new-password">
            </div>

            <div class="mb-3">
                <label for="perfil" class="form-label">Perfil</label>
                <select id="perfil" name="perfil" class="form-select @error('perfil') is-invalid @enderror" required>
                    <option value="usuario" {{ old('perfil', 'usuario') === 'usuario' ? 'selected' : '' }}>Usuário</option>
                    <option value="admin" {{ old('perfil') === 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('perfil')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check form-switch mb-3">
                <input type="hidden" name="ativo" value="0">
                <input type="checkbox" id="ativo" name="ativo" value="1" class="form-check-input" {{ old('ativo', '1') ? 'checked' : '' }}>
                <label for="ativo" class="form-check-label">Usuário ativo</label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>
@endsection
