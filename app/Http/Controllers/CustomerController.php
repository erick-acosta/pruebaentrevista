<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer; // Asegúrate de que el modelo Customer existe y está importado correctamente

class CustomerController extends Controller
{
    // Método para almacenar un nuevo cliente
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:15',
        ]);

        // Crear un nuevo cliente en la base de datos
        $customer = Customer::create($validatedData);

        // Retornar una respuesta o redireccionar
        return redirect()->route('customers.show', $customer->id)
                         ->with('success', 'Cliente creado con éxito');
    }

    // Método para mostrar un cliente específico
    public function show($id)
    {
        // Buscar el cliente por ID
        $customer = Customer::findOrFail($id);

        // Retornar la vista y pasar los datos del cliente
        return view('customers.show', compact('customer'));
    }

    // Método para eliminar un cliente
    public function destroy($id)
    {
        // Buscar el cliente por ID y eliminarlo
        $customer = Customer::findOrFail($id);
        $customer->delete();

        // Redireccionar a la lista de clientes con un mensaje de éxito
        return redirect()->route('customers.index')
                         ->with('success', 'Cliente eliminado con éxito');
    }
}
