@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">Novo Cliente</a>
</div>

<form method="GET" action="{{ route('clientes.index') }}" class="mb-3" id="clientesSearchForm">
    <div class="row g-2 align-items-end">
        <div class="col-12">
            <label for="q" class="form-label mb-1">Encontre rapidamente</label>
            <input type="text" id="q" name="q" class="form-control" value="{{ $q ?? '' }}" placeholder="Digite nome, documento, telefone ou e-mail">
        </div>
    </div>
</form>

<div class="card">
    <div class="card-body">
        @if ($clientes->isEmpty())
            <p class="text-muted mb-0">Nenhum cliente encontrado.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Documento</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr data-cliente-item>
                                <td>{{ $cliente->nome }}</td>
                                <td>{{ $cliente->documento }}</td>
                                <td>{{ $cliente->telefone ?: '-' }}</td>
                                <td>{{ $cliente->email ?: '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir este cliente?');">
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
            <p id="clientesNoResults" class="text-muted mb-0 d-none">Nenhum cliente encontrado para a busca.</p>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('clientesSearchForm');
    const input = document.getElementById('q');
    const items = Array.from(document.querySelectorAll('[data-cliente-item]'));
    const noResults = document.getElementById('clientesNoResults');

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
