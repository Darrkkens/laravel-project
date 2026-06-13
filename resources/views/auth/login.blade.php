<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistema de Reserva de Salas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .login-bg-video {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .login-bg-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .55);
            z-index: -1;
        }

        .login-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 25px 60px rgba(2, 6, 23, .45);
        }

        .input-group-text {
            background: #f1f5f9;
            border: 1.5px solid #cbd5e1;
            border-right: 0;
            color: #64748b;
        }

        .form-control {
            border: 1.5px solid #cbd5e1;
            padding-top: .65rem;
            padding-bottom: .65rem;
        }

        .input-group .form-control {
            border-left: 0;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control,
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: none;
        }

        .input-group:focus-within {
            border-radius: .375rem;
            box-shadow: 0 0 0 .25rem rgba(37, 99, 235, .15);
        }

        .input-group:focus-within .input-group-text {
            color: #2563eb;
        }

        .btn-login {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            border: 0;
            padding: .7rem;
            font-weight: 600;
            letter-spacing: .02em;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(37, 99, 235, .45);
        }

        .toggle-password {
            border: 1.5px solid #cbd5e1;
            border-left: 0;
            background: #fff;
            color: #64748b;
        }

        .toggle-password:hover {
            color: #2563eb;
            background: #fff;
        }

        .input-group:focus-within .toggle-password {
            border-color: #2563eb;
        }

    </style>
</head>
<body>
<video class="login-bg-video" id="loginBgVideo" autoplay muted loop playsinline preload="auto">
    <source src="{{ asset('videos/login-bg.mp4') }}" type="video/mp4">
</video>
<div class="login-bg-overlay"></div>

<main class="d-flex align-items-center min-vh-100 py-4 position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4">
                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold text-white mb-1">Reserva de Salas</h1>
                    <p class="text-white-50 mb-0">Acesse sua conta para continuar</p>
                </div>

                <div class="card login-card">
                    <div class="card-body p-4 p-md-5">
                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center gap-2 py-2" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required autofocus autocomplete="email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                                    <button type="button" class="btn toggle-password" id="togglePassword" aria-label="Mostrar senha">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-login w-100">
                                Entrar <i class="bi bi-arrow-right-short fs-5 align-middle"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <p class="text-center text-white-50 small mt-4 mb-0">Sistema de Reserva de Salas</p>
            </div>
        </div>
    </div>
</main>

<script>
    (function () {
        const video = document.getElementById('loginBgVideo');
        if (video) {
            video.muted = true;
            video.defaultMuted = true;
            const tryPlay = () => {
                const playback = video.play();
                if (playback && typeof playback.catch === 'function') {
                    playback.catch(() => {
                        const resume = () => {
                            video.play().catch(() => {});
                            document.removeEventListener('click', resume);
                            document.removeEventListener('keydown', resume);
                        };
                        document.addEventListener('click', resume, { once: true });
                        document.addEventListener('keydown', resume, { once: true });
                    });
                }
            };
            if (video.readyState >= 2) {
                tryPlay();
            } else {
                video.addEventListener('loadeddata', tryPlay, { once: true });
            }
        }
    })();

    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon = this.querySelector('i');
        const show = input.type === 'password';

        input.type = show ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !show);
        icon.classList.toggle('bi-eye-slash', show);
        this.setAttribute('aria-label', show ? 'Ocultar senha' : 'Mostrar senha');
    });
</script>
</body>
</html>
