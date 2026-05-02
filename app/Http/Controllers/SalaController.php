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
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

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
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

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

        if ($sala->imagem) {
            Storage::disk('public')->delete($sala->imagem);
        }

        $sala->delete();

        return redirect()->route('salas.index')->with('success', 'Sala excluída com sucesso.');
    }
}
