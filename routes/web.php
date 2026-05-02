<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\ReservaController;
use App\Models\Cliente;
use App\Models\Sala;
use App\Models\Reserva;

Route::get('/', function () {
    return view('dashboard', [
        'totalClientes' => Cliente::count(),
        'totalSalas' => Sala::count(),
        'totalReservas' => Reserva::count(),
    ]);
})->name('dashboard');

Route::resource('clientes', ClienteController::class);
Route::resource('salas', SalaController::class);
Route::resource('reservas', ReservaController::class);
