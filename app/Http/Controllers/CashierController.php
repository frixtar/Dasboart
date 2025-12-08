<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CashierController extends Controller
{
    public function index()
    {
        $cashiers = User::where('role', 'cajero')->get();
        return view('cashiers.index', compact('cashiers'));
    }

    public function create()
    {
        return view('cashiers.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'confirmed'],
            
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
        ];

        $messages = [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            
            'email.unique' => 'Este correo ya está registrado.',
            'email.confirmed' => 'La confirmación del correo no coincide.',
            
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ];

        $request->validate($rules, $messages);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cajero',
        ]);

        return redirect()->route('cashiers.index')->with('success', 'Cajero registrado correctamente.');
    }

    public function edit($id)
    {
        $cashier = User::where('id', $id)->where('role', 'cajero')->firstOrFail();
        return view('cashiers.edit', compact('cashier'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email,'.$id],
            'password' => ['nullable', 'confirmed', 'min:8', Rules\Password::defaults()],
        ];

        $messages = [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];

        $request->validate($rules, $messages);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('cashiers.index')->with('success', 'Datos del cajero actualizados.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->role !== 'administrador') {
            $user->delete();
            return back()->with('success', 'Cajero eliminado.');
        }
        return back()->with('error', 'No puedes eliminar al administrador.');
    }
}