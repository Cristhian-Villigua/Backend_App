<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Usuario;
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
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 1️⃣ Buscar primero en USUARIOS (admin / staff)
        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {

            $token = JWTAuth::fromUser($usuario);

            return response()->json([
                'message' => 'Login usuario exitoso',
                'type'    => 'usuario',
                'role'    => $usuario->role,
                'user'    => [
                    'id'        => $usuario->id,
                    'nombres'   => $usuario->nombres,
                    'apellidos' => $usuario->apellidos,
                    'email'     => $usuario->email,
                ],
                'token' => $token,
            ], 200);
        }

        // 2️⃣ Buscar en CLIENTES
        $cliente = Cliente::where('email', $request->email)->first();

        if ($cliente && Hash::check($request->password, $cliente->password)) {

            $token = JWTAuth::fromUser($cliente);

            return response()->json([
                'message' => 'Login cliente exitoso',
                'type'    => 'cliente',
                'user'    => [
                    'id'        => $cliente->id,
                    'nombres'   => $cliente->nombres,
                    'apellidos' => $cliente->apellidos,
                    'email'     => $cliente->email,
                ],
                'token' => $token,
            ], 200);
        }

        // 3️⃣ Si no coincide ninguno
        return response()->json([
            'message' => 'Credenciales incorrectas',
        ], 401);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ]);
    }
}