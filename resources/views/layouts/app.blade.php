<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Reserva de Salas')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .form-control,
        .form-select {
            border: 1.5px solid #6c757d;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .required-label::after {
            content: " *";
            color: #dc3545;
            font-weight: 700;
        }

        .required-empty {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.18) !important;
        }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Reserva de Salas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('salas.*') ? 'active' : '' }}" href="{{ route('salas.index') }}">Salas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reservas.*') ? 'active' : '' }}" href="{{ route('reservas.index') }}">Reservas</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Existem erros de validação:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const requiredFields = Array.from(document.querySelectorAll('input[required], select[required], textarea[required]'))
        .filter((field) => field.type !== 'hidden' && !field.disabled);

    const isFieldEmpty = (field) => {
        if (field.type === 'checkbox' || field.type === 'radio') {
            return !field.checked;
        }

        return String(field.value || '').trim() === '';
    };

    const updateFieldState = (field) => {
        const empty = isFieldEmpty(field);
        field.classList.toggle('required-empty', empty);
        field.setAttribute('aria-invalid', empty ? 'true' : 'false');
    };

    requiredFields.forEach((field) => {
        const label = field.id ? document.querySelector('label[for="' + field.id + '"]') : null;
        if (label) {
            label.classList.add('required-label');
        }

        field.addEventListener('input', () => updateFieldState(field));
        field.addEventListener('change', () => updateFieldState(field));
        field.addEventListener('blur', () => updateFieldState(field));
    });

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => {
            requiredFields.forEach((field) => {
                if (form.contains(field)) {
                    updateFieldState(field);
                }
            });
        });
    });
});
</script>
</body>
</html>
