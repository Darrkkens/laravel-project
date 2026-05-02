<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Sala;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::with(['cliente', 'sala'])
            ->orderBy('data_reserva')
            ->orderBy('horario_inicio')
            ->get();

        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $salas = Sala::where('status', 'disponivel')->orderBy('nome')->get();

        return view('reservas.create', compact('clientes', 'salas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'sala_id' => ['required', 'exists:salas,id'],
            'data_reserva' => ['required', 'date'],
            'horario_inicio' => ['required', 'date_format:H:i'],
            'horario_fim' => ['required', 'date_format:H:i', 'after:horario_inicio'],
            'status' => ['required', 'in:pendente,confirmada,cancelada'],
        ]);

        $businessRuleError = $this->validateBusinessRules($validated);
        if ($businessRuleError !== null) {
            return back()->withErrors(['reserva' => $businessRuleError])->withInput();
        }

        Reserva::create($validated);

        return redirect()->route('reservas.index')->with('success', 'Reserva criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        $reserva->load(['cliente', 'sala']);

        return view('reservas.show', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        $clientes = Cliente::orderBy('nome')->get();
        $salas = Sala::orderBy('nome')->get();

        return view('reservas.edit', compact('reserva', 'clientes', 'salas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        $validated = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'sala_id' => ['required', 'exists:salas,id'],
            'data_reserva' => ['required', 'date'],
            'horario_inicio' => ['required', 'date_format:H:i'],
            'horario_fim' => ['required', 'date_format:H:i', 'after:horario_inicio'],
            'status' => ['required', 'in:pendente,confirmada,cancelada'],
        ]);

        $businessRuleError = $this->validateBusinessRules($validated, $reserva->id);
        if ($businessRuleError !== null) {
            return back()->withErrors(['reserva' => $businessRuleError])->withInput();
        }

        $reserva->update($validated);

        return redirect()->route('reservas.index')->with('success', 'Reserva atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva excluída com sucesso.');
    }

    private function validateBusinessRules(array $data, ?int $ignoreReservaId = null): ?string
    {
        $salaDisponivel = Sala::where('id', $data['sala_id'])
            ->where('status', 'disponivel')
            ->exists();

        if (! $salaDisponivel) {
            return 'Não é permitido reservar uma sala indisponível ou em manutenção.';
        }

        $clienteJaPossuiReservaNoDia = Reserva::where('cliente_id', $data['cliente_id'])
            ->whereDate('data_reserva', $data['data_reserva'])
            ->when($ignoreReservaId !== null, function ($query) use ($ignoreReservaId) {
                $query->where('id', '!=', $ignoreReservaId);
            })
            ->exists();

        if ($clienteJaPossuiReservaNoDia) {
            return 'O cliente já possui uma reserva nesta data.';
        }

        $dataReserva = Carbon::parse($data['data_reserva']);
        $reservasNoMes = Reserva::where('cliente_id', $data['cliente_id'])
            ->whereYear('data_reserva', $dataReserva->year)
            ->whereMonth('data_reserva', $dataReserva->month)
            ->when($ignoreReservaId !== null, function ($query) use ($ignoreReservaId) {
                $query->where('id', '!=', $ignoreReservaId);
            })
            ->count();

        if ($reservasNoMes >= 3) {
            return 'O cliente atingiu o limite de 3 reservas neste mês.';
        }

        $temConflitoHorario = Reserva::where('sala_id', $data['sala_id'])
            ->whereDate('data_reserva', $data['data_reserva'])
            ->where('horario_inicio', '<', $data['horario_fim'])
            ->where('horario_fim', '>', $data['horario_inicio'])
            ->when($ignoreReservaId !== null, function ($query) use ($ignoreReservaId) {
                $query->where('id', '!=', $ignoreReservaId);
            })
            ->exists();

        if ($temConflitoHorario) {
            return 'Já existe uma reserva para esta sala com conflito de horário.';
        }

        return null;
    }
}
