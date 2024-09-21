<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use Illuminate\Routing\Controller;

class CustomerController extends Controller
{

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:15',
        ]);


        $customer = Customer::create($validatedData);


        return redirect()->route('customers.show', $customer->id)
                         ->with('success', 'Cliente creado con éxito');
    }


    public function show($id)
    {

        $customer = Customer::findOrFail($id);


        return view('customers.show', compact('customer'));
    }


    public function destroy($id)
    {

        $customer = Customer::findOrFail($id);
        $customer->delete();


        return redirect()->route('customers.index')
                         ->with('success', 'Cliente eliminado con éxito');
    }
}
