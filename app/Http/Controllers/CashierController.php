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
        // Solo mostramos a los cajeros, no al admin
        $cashiers = User::where('role', 'cajero')->get();
        return view('cashiers.index', compact('cashiers'));
    }

    public function create()
    {
        return view('cashiers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cajero', // <--- Importante: Siempre se crea como cajero
            // Si el checkbox viene marcado, es true. Si no, false.
            'can_edit_products' => $request->has('can_edit_products'), 
            'can_delete_products' => $request->has('can_delete_products'),
        ]);

        return redirect()->route('cashiers.index')->with('success', 'Cajero registrado correctamente.');
    }
    
    // Método para borrar cajeros (Opcional pero útil)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->role !== 'administrador') { // Protegemos al admin
            $user->delete();
            return back()->with('success', 'Cajero eliminado.');
        }
        return back()->with('error', 'No puedes eliminar al administrador.');
    }
}