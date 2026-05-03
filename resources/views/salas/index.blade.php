@extends('layouts.app')

@section('title', 'Salas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Salas</h1>
    <a href="{{ route('salas.create') }}" class="btn btn-primary">Nova Sala</a>
</div>

<form method="GET" action="{{ route('salas.index') }}" class="mb-3" id="salasSearchForm">
    <div class="row g-2 align-items-end">
        <div class="col-12">
            <label for="q" class="form-label mb-1">Encontre rapidamente</label>
            <input type="text" id="q" name="q" class="form-control" value="{{ $q ?? '' }}" placeholder="Digite nome, responsável, contato ou localização">
        </div>
    </div>
</form>


@if ($salas->isEmpty())
    <div class="alert alert-info mb-0">Nenhuma sala encontrada.</div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        @foreach ($salas as $sala)
            <div class="col" data-sala-item>
                <div class="card h-100 shadow-sm">
                    @if ($sala->imagem)
                        <img src="{{ asset('storage/' . $sala->imagem) }}" alt="Imagem da sala {{ $sala->nome }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                    @else
                        <div class="bg-secondary-subtle text-muted d-flex align-items-center justify-content-center" style="height: 220px;">
                            Sem imagem
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h2 class="h5 mb-0">{{ $sala->nome }}</h2>
                            @if ($sala->status === 'disponivel')
                                <span class="badge text-bg-success">Disponível</span>
                            @elseif ($sala->status === 'indisponivel')
                                <span class="badge text-bg-danger">Indisponível</span>
                            @else
                                <span class="badge text-bg-warning">Manutenção</span>
                            @endif
                        </div>

                        <p class="mb-1"><strong>Capacidade:</strong> {{ $sala->capacidade }} pessoas</p>
                        <p class="small text-muted">{{ \Illuminate\Support\Str::limit($sala->descricao ?: 'Sem descrição informada.', 90) }}</p>

                        <hr>
                        <p class="mb-1"><strong>Responsável:</strong> {{ $sala->responsavel_nome ?: '-' }}</p>
                        <p class="mb-1"><strong>Telefone:</strong> {{ $sala->responsavel_telefone ?: '-' }}</p>
                        <p class="mb-2"><strong>E-mail:</strong> {{ $sala->responsavel_email ?: '-' }}</p>

                        <p class="mb-0 small">
                            <strong>Local:</strong>
                            {{ $sala->logradouro ?: '-' }}{{ $sala->numero ? ', ' . $sala->numero : '' }}<br>
                            {{ $sala->bairro ?: '-' }} - {{ $sala->cidade ?: '-' }}/{{ strtoupper($sala->uf ?: '-') }}<br>
                            CEP: {{ $sala->cep ?: '-' }}
                        </p>

                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('salas.show', $sala) }}" class="btn btn-outline-info btn-sm">Ver</a>
                            <a href="{{ route('salas.edit', $sala) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
                            <form action="{{ route('salas.destroy', $sala) }}" method="POST" onsubmit="return confirm('Deseja excluir esta sala?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div id="salasNoResults" class="alert alert-info mt-3 d-none">Nenhuma sala encontrada para a busca.</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('salasSearchForm');
    const input = document.getElementById('q');
    const items = Array.from(document.querySelectorAll('[data-sala-item]'));
    const noResults = document.getElementById('salasNoResults');

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
