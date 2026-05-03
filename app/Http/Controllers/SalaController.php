<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salas = Sala::orderBy('nome')->get();

        return view('salas.index', compact('salas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('salas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'capacidade' => ['required', 'integer', 'min:1'],
            'descricao' => ['nullable', 'string'],
            'status' => ['required', 'in:disponivel,indisponivel,manutencao'],
            'responsavel_nome' => ['required', 'string', 'max:255'],
            'responsavel_telefone' => ['required', 'string', 'max:20'],
            'responsavel_email' => ['required', 'email', 'max:255'],
            'cep' => ['required', 'regex:/^\d{5}-?\d{3}$/'],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'size:2'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['cep'] = $this->normalizeCep($validated['cep']);
        $validated['uf'] = strtoupper($validated['uf']);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('salas', 'public');
        }

        Sala::create($validated);

        return redirect()->route('salas.index')->with('success', 'Sala criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sala $sala)
    {
        return view('salas.show', compact('sala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sala $sala)
    {
        return view('salas.edit', compact('sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sala $sala)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'capacidade' => ['required', 'integer', 'min:1'],
            'descricao' => ['nullable', 'string'],
            'status' => ['required', 'in:disponivel,indisponivel,manutencao'],
            'responsavel_nome' => ['required', 'string', 'max:255'],
            'responsavel_telefone' => ['required', 'string', 'max:20'],
            'responsavel_email' => ['required', 'email', 'max:255'],
            'cep' => ['required', 'regex:/^\d{5}-?\d{3}$/'],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'size:2'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['cep'] = $this->normalizeCep($validated['cep']);
        $validated['uf'] = strtoupper($validated['uf']);

        if ($request->hasFile('imagem')) {
            if ($sala->imagem) {
                Storage::disk('public')->delete($sala->imagem);
            }

            $validated['imagem'] = $request->file('imagem')->store('salas', 'public');
        } else {
            unset($validated['imagem']);
        }

        $sala->update($validated);

        return redirect()->route('salas.index')->with('success', 'Sala atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sala $sala)
    {
        if ($sala->reservas()->exists()) {
            return redirect()
                ->route('salas.index')
                ->with('success', 'Sala não pode ser excluída porque possui reservas vinculadas.');
        }

        $sala->delete();

        return redirect()->route('salas.index')->with('success', 'Sala excluída com sucesso.');
    }

    private function normalizeCep(string $cep): string
    {
        $digits = preg_replace('/\D/', '', $cep) ?? '';

        if (strlen($digits) === 8) {
            return substr($digits, 0, 5) . '-' . substr($digits, 5, 3);
        }

        return $cep;
    }
}
