<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        $users = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($searchQuery) use ($q) {
                    $searchQuery->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->get();

        return view('users.index', compact('users', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'ativo' => ['nullable', 'boolean'],
            'perfil' => ['required', Rule::in(User::PERFIS)],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'ativo' => $request->boolean('ativo'),
            'perfil' => $validated['perfil'],
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'ativo' => ['nullable', 'boolean'],
            'perfil' => ['required', Rule::in(User::PERFIS)],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->perfil = $validated['perfil'];

        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        // O usuário não pode inativar a própria conta.
        if ($user->id !== $request->user()->id) {
            $user->ativo = $request->boolean('ativo');
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Toggle the active state of the specified resource.
     */
    public function toggle(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return redirect()
                ->route('users.index')
                ->with('success', 'Você não pode inativar a própria conta.');
        }

        $user->ativo = ! $user->ativo;
        $user->save();

        $estado = $user->ativo ? 'ativado' : 'inativado';

        return redirect()->route('users.index')->with('success', "Usuário {$estado} com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return redirect()
                ->route('users.index')
                ->with('success', 'Você não pode excluir a própria conta.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
