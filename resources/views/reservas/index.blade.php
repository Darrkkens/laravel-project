@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
@php
    $calendarEvents = $reservas->map(function ($reserva) {
        $statusColor = match ($reserva->status) {
            'confirmada' => '#198754',
            'cancelada' => '#dc3545',
            default => '#ffc107',
        };

        return [
            'id' => $reserva->id,
            'title' => ($reserva->sala?->nome ?: 'Sala') . ' | ' . ($reserva->cliente?->nome ?: 'Cliente'),
            'start' => \Carbon\Carbon::parse($reserva->data_reserva . ' ' . $reserva->horario_inicio)->format('Y-m-d\TH:i:s'),
            'end' => \Carbon\Carbon::parse($reserva->data_reserva . ' ' . $reserva->horario_fim)->format('Y-m-d\TH:i:s'),
            'url' => route('reservas.show', $reserva),
            'backgroundColor' => $statusColor,
            'borderColor' => $statusColor,
            'extendedProps' => [
                'status' => $reserva->status,
                'sala' => $reserva->sala?->nome,
                'cliente' => $reserva->cliente?->nome,
            ],
        ];
    })->values();
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Reservas</h1>
    <a href="{{ route('reservas.create') }}" class="btn btn-primary">Nova Reserva</a>
</div>

<form method="GET" action="{{ route('reservas.index') }}" class="mb-3" id="reservasSearchForm">
    <div class="row g-2 align-items-end">
        <div class="col-12">
            <label for="q" class="form-label mb-1">Encontre rapidamente</label>
            <input type="text" id="q" name="q" class="form-control" value="{{ $q ?? '' }}" placeholder="Digite cliente, sala, status, data ou horário">
        </div>
    </div>
</form>

@if ($reservas->isEmpty())
    <div class="card mb-4">
        <div class="card-body">
            <p class="text-muted mb-0">Nenhuma reserva encontrada.</p>
        </div>
    </div>
@else
    <div class="card mb-4">
        <div class="card-body">
            <div id="reservasCalendar"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="h5 mb-3">Lista de Reservas</h2>
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
                            <tr data-reserva-item>
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
            <p id="reservasNoResults" class="text-muted mb-0 d-none">Nenhuma reserva encontrada para a busca.</p>
        </div>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.20/locales/pt-br.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('reservasSearchForm');
    const searchInput = document.getElementById('q');
    const tableItems = Array.from(document.querySelectorAll('[data-reserva-item]'));
    const noResults = document.getElementById('reservasNoResults');
    const calendarElement = document.getElementById('reservasCalendar');
    const reservaCreateBaseUrl = @json(route('reservas.create'));

    const normalize = (value) =>
        (value || '')
            .toString()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();

    let calendar = null;
    const allEvents = @json($calendarEvents);

    const applyFilter = () => {
        const term = normalize(searchInput?.value || '');
        let visible = 0;

        tableItems.forEach((item) => {
            const text = normalize(item.innerText);
            const match = term === '' || text.includes(term);

            item.classList.toggle('d-none', !match);
            if (match) {
                visible += 1;
            }
        });

        if (noResults) {
            noResults.classList.toggle('d-none', visible > 0 || tableItems.length === 0);
        }

        if (calendar) {
            const filteredEvents = allEvents.filter((event) => {
                if (term === '') {
                    return true;
                }

                const blob = normalize([
                    event.title,
                    event.extendedProps?.status,
                    event.extendedProps?.sala,
                    event.extendedProps?.cliente,
                    event.start,
                    event.end,
                ].join(' '));

                return blob.includes(term);
            });

            calendar.removeAllEvents();
            calendar.addEventSource(filteredEvents);
        }
    };

    if (searchForm) {
        searchForm.addEventListener('submit', function (event) {
            event.preventDefault();
        });
    }

    if (searchInput) {
        let searchTimer = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                applyFilter();
            }, 250);
        });
    }

    if (!calendarElement) {
        applyFilter();
        return;
    }

    function formatDate(date) {
        return date.toISOString().slice(0, 10);
    }

    function formatTime(date) {
        return String(date.getHours()).padStart(2, '0') + ':' + String(date.getMinutes()).padStart(2, '0');
    }

    function goToCreateForm(params) {
        const query = new URLSearchParams(params);
        window.location.href = reservaCreateBaseUrl + '?' + query.toString();
    }

    calendar = new FullCalendar.Calendar(calendarElement, {
        locale: 'pt-br',
        initialView: 'dayGridMonth',
        height: 'auto',
        selectable: true,
        selectMirror: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia',
        },
        events: allEvents,
        eventDidMount: function (info) {
            const status = info.event.extendedProps.status || '';
            info.el.title = 'Status: ' + status;
        },
        dateClick: function (info) {
            goToCreateForm({
                data_reserva: info.dateStr.slice(0, 10),
            });
        },
        select: function (selectionInfo) {
            if (selectionInfo.allDay) {
                goToCreateForm({
                    data_reserva: selectionInfo.startStr.slice(0, 10),
                });
                return;
            }

            goToCreateForm({
                data_reserva: formatDate(selectionInfo.start),
                horario_inicio: formatTime(selectionInfo.start),
                horario_fim: formatTime(selectionInfo.end),
            });
        },
    });

    calendar.render();
    applyFilter();
});
</script>
@endsection
