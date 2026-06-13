@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Usuários</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Novo Usuário</a>
</div>

<form method="GET" action="{{ route('users.index') }}" class="mb-3" id="usersSearchForm">
    <div class="row g-2 align-items-end">
        <div class="col-12">
            <label for="q" class="form-label mb-1">Encontre rapidamente</label>
            <input type="text" id="q" name="q" class="form-control" value="{{ $q ?? '' }}" placeholder="Digite nome ou e-mail">
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body">
        @if ($users->isEmpty())
            <p class="text-muted mb-0">Nenhum usuário encontrado.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr data-user-item>
                                <td>
                                    {{ $user->name }}
                                    @if ($user->id === auth()->id())
                                        <span class="badge bg-info text-dark ms-1">Você</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->perfil === 'admin' ? 'Administrador' : 'Usuário' }}</td>
                                <td>
                                    @if ($user->ativo)
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-secondary">Inativo</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">Editar</a>

                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('users.toggle', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if ($user->ativo)
                                                <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Deseja inativar este usuário?');">Inativar</button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-outline-success">Ativar</button>
                                            @endif
                                        </form>

                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir este usuário?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p id="usersNoResults" class="text-muted mb-0 d-none">Nenhum usuário encontrado para a busca.</p>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('usersSearchForm');
    const input = document.getElementById('q');
    const items = Array.from(document.querySelectorAll('[data-user-item]'));
    const noResults = document.getElementById('usersNoResults');

    if (!form || !input) {
        return;
    }

    const normalize = (value) =>
        (value || '')
            .toString()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();

    const applyFilter = () => {
        const term = normalize(input.value);
        let visible = 0;

        items.forEach((item) => {
            const text = normalize(item.innerText);
            const match = term === '' || text.includes(term);

            item.classList.toggle('d-none', !match);
            if (match) {
                visible += 1;
            }
        });

        if (noResults) {
            noResults.classList.toggle('d-none', visible > 0 || items.length === 0);
        }
    };

    form.addEventListener('submit', function (event) {
        event.preventDefault();
    });

    let timer = null;

    input.addEventListener('input', function () {
        clearTimeout(timer);

        timer = setTimeout(function () {
            applyFilter();
        }, 250);
    });

    applyFilter();
});
</script>
@endsection
