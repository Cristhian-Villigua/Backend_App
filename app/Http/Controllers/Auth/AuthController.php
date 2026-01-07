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

        $token = JWTAuth::fromUser($client);

        return response()->json([
            'message' => 'Cliente creado exitosamente',
            'client' => $client,
            'token' => $token
        ], 201);
    }

     public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales incorrectas. Verifique su email o contraseña.'
            ], 401);
        }

        $client = auth()->user();

        return response()->json([
            'message' => 'Login exitoso',
            'user' => [
                'id'    => $client->id,
                'name'  => $client->nombres,
                'email' => $client->email,
            ],
            'token' => $token,
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ]);
    }
}