<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

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