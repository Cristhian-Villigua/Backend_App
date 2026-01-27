<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{

    public function index()
    {
        $client = Cliente::all();
        return response()->json($client, 200);
    }

    public function show($id)
    {
        $client = Cliente::find($id);
        if(!$client){
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($client, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
            'celular'   => 'nullable|string|max:20',
            'genero'    => 'nullable|string|max:20',
            'photo'     => 'nullable|string',
            'email'     => 'required|email|unique:clientes,email',
            'password'  => 'required|min:8',
        ]);

        $client = Cliente::create([
            'nombres'   => $request->nombres,
            'apellidos' => $request->apellidos,
            'birthdate' => $request->birthdate,
            'celular'   => $request->celular,
            'genero'    => $request->genero,
            'photo'     => $request->photo,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Cliente creado exitosamente',
            'client'  => $client
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $client = Cliente::find($id);
        
        if(!$client){
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $request->validate([
            'nombres'   => 'sometimes|string',
            'apellidos' => 'sometimes|string',
            'birthdate' => 'sometimes|date',
            'celular'   => 'sometimes|string',
            'genero'    => 'sometimes|string',
            'email'     => 'sometimes|email|unique:clientes,email,' . $id,
            'password'  => 'nullable|min:8',
        ]);

        if ($request->has('nombres'))   $client->nombres = $request->nombres;
        if ($request->has('apellidos')) $client->apellidos = $request->apellidos;
        if ($request->has('birthdate')) $client->birthdate = $request->birthdate;
        if ($request->has('celular'))   $client->celular = $request->celular;
        if ($request->has('genero'))    $client->genero = $request->genero;
        if ($request->has('photo'))     $client->photo = $request->photo;
        if ($request->has('email'))     $client->email = $request->email;
        
        if($request->filled('password')){
            $client->password = Hash::make($request->password);
        }

        $client->save();

        return response()->json([
            'message' => 'Cliente actualizado exitosamente',
            'client' => $client
        ], 200);
    }

    public function destroy($id)
    {
        $client = Cliente::find($id);

        if(!$client){
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $client->delete();

        return response()->json([
            'message' => 'Cliente eliminado exitosamente',
            'client' => $client
        ], 200);
    }
}