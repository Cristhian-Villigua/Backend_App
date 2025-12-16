<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function index(){
        $client = Cliente::all();
        return response()->json($client, 200);
    }

    public function show($id){
        $client = Cliente::find($id);
        if(!$client){
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($client, 200);
    }

    public function update(Request $request, $id){
        $client = Cliente::find($id);
        
        if(!$client){
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'birthdate' => 'required',
            'celular' => 'required',
            'genero' => 'required',
            'photo' => 'nullable',
            'email' => 'required|string|email|max:100|unique:usuarios' . $id,
            'password' => 'nullable|min:8|max:15',
        ]);

        $client->nombres = $request->nombres;
        $client->apellidos = $request->apellidos;
        $client->birthdate = $request->birthdate;
        $client->celular = $request->celular;
        $client->genero = $request->genero;
        $client->photo = $request->photo;
        $client->email = $request->email;
        if($request->filled('password')){
            $client->password = Hash::make($request['password']);
        }
        $client->save();

        return response()->json([
            'message' => 'Cliente actualizado exitosamente',
            'client' => $client
        ], 201);
    }

    public function destroy($id){
        $client = Cliente::find($id);

        if(!$client){
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
        return response()->json([
            'message' => 'Cliente eliminado exitosamente',
            'client' => $client
        ], 200);
    }
}
