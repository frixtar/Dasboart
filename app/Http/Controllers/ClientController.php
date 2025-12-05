<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
public function index()
{
    $clientes = Client::all();
    return view('clientes.index', compact('clientes'));
}

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Client::create($request->all());

        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente agregado correctamente.');
    }

    public function edit(Client $client)
    {
        return view('clientes.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $client->update($request->all());

        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente eliminado correctamente.');
    }
}
