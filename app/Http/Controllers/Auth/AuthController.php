<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Request\Auth\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller{

    public function register(RegisterRequest $request){

        $client = Cliente::create([
            'nombres'   => $request->nombres,
            'apellidos' => $request->apellidos,
            'birthdate' => $request->birthdate,
            'celular'   => $request->celular,
            'genero'    => $request->genero,
            'email'     => $request->email,
            'photo'     => $request->photo,
            'password'  => Hash::make($request['password']),
        ]);

        if (!$client) {
            return response()->json(['message' => 'Error al crear el cliente'], 500);
        }

        // Genera el token para el cliente
        try {
            $token = JWTAuth::fromUser($client);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al generar el token'], 500);
        }


        $token = JWTAuth::fromUser($client);

        return response()->json([
            'message' => 'Cliente creado exitosamente',
            'client' => $client,
            'token' => $token
        ], 201);
    }
}