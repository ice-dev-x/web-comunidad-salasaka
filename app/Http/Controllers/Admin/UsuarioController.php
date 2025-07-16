<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /* ─────────────────────────
     |  Listado con filtros
     ───────────────────────── */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        // Filtro por estado
        if ($request->filled('activo')) {
            $query->where('activo', $request->boolean('activo'));
        }

        $usuarios = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    /* ─────────────────────────
     |  Formulario de creación
     ───────────────────────── */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /* ─────────────────────────
     |  Guardar nuevo usuario
     ───────────────────────── */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'rol'      => ['required', Rule::in([User::ROL_ADMIN, User::ROL_EDITOR, User::ROL_USUARIO])],
            'activo'   => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['activo']   = $request->boolean('activo');

        User::create($validated);

        return redirect()->route('admin.usuarios.index')
                         ->with('success', 'Usuario creado correctamente');
    }

    /* ─────────────────────────
     |  Formulario de edición
     ───────────────────────── */
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /* ─────────────────────────
     |  Actualizar usuario
     ───────────────────────── */
    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name'   => 'required|max:255',
            'email'  => ['required', 'email', Rule::unique('users')->ignore($usuario->id)],
            'rol'    => ['required', Rule::in([User::ROL_ADMIN, User::ROL_EDITOR, User::ROL_USUARIO])],
            'activo' => 'boolean',
        ]);

        // Cambiar password opcional
        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $validated['password'] = bcrypt($request->password);
        }

        $validated['activo'] = $request->boolean('activo');

        $usuario->update($validated);

        return redirect()->route('admin.usuarios.index')
                         ->with('success', 'Usuario actualizado');
    }

    /* ─────────────────────────
     |  Eliminar usuario
     ───────────────────────── */
    public function destroy(User $usuario)
    {
        $usuario->delete();   // SoftDelete si lo configuras
        return back()->with('success', 'Usuario eliminado');
    }

    /* ─────────────────────────
     |  Activar / Desactivar
     ───────────────────────── */
    public function toggle(User $user)
    {
        $user->update(['activo' => ! $user->activo]);
        return back()->with('success', 'Estado de usuario actualizado');
    }
}
