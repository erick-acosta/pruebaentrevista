<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;




class CustomerController extends Controller{

     function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dni' => 'required|string|unique:customers',
            'email' => 'required|email|unique:customers',
            'region_id' => 'required|exists:regions,id',
            'commune_id' => 'required|exists:communes,id',
        ]);

        // Crear el cliente
        $customer = Customer::create($request->only([
            'name',
            'last_name',
            'dni',
            'email',
            'region_id',
            'commune_id',
        ]));

        $customer = Customer::create($request->all());
        return response()->json(['success' => true, 'customer' => $customer], 201);
    }

     function show(Request $request)
    {
        // Consulta del cliente activo
        $customer = Customer::where('dni', $request->dni)
            ->orWhere('email', $request->email)
            ->where('status', 'A')
            ->first();

        $customer = Customer::where('dni', $request->dni)->orWhere('email', $request->email)->where('status', 'A')->first();
        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Cliente no encontrado'], 404);
        }

        return response()->json(['success' => true, 'customer' => $customer]);
    }

     function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer || $customer->status === 'trash') {
            return response()->json(['success' => false, 'message' => 'Registro no existe'], 404);
        }

        $customer->update(['status' => 'trash']);

        return response()->json(['success' => true, 'message' => 'Cliente eliminado lógicamente']);
    }

}
