<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\ReservaController;
use App\Models\Cliente;
use App\Models\Sala;
use App\Models\Reserva;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return view('dashboard', [
            'totalClientes' => Cliente::count(),
            'totalSalas' => Sala::count(),
            'totalReservas' => Reserva::count(),
            'salas' => Sala::orderBy('nome')->get(),
        ]);
    })->name('dashboard');

    Route::resource('clientes', ClienteController::class)->only(['index']);
    Route::resource('salas', SalaController::class)->only(['index']);

    Route::resource('reservas', ReservaController::class)->only(['index', 'create', 'store', 'show']);

    Route::middleware('admin')->group(function () {
        Route::patch('usuarios/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
        Route::resource('usuarios', UserController::class)
            ->parameters(['usuarios' => 'user'])
            ->names('users')
            ->except('show');

        Route::resource('clientes', ClienteController::class)->except(['index', 'show']);
        Route::resource('salas', SalaController::class)->except(['index', 'show']);
        Route::resource('reservas', ReservaController::class)->only(['edit', 'update', 'destroy']);
    });

    Route::resource('clientes', ClienteController::class)->only(['show']);
    Route::resource('salas', SalaController::class)->only(['show']);
});
