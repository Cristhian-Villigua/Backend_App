<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        $token = JWTAuth::fromUser($usuario);

        return response()->json([
            'message' => 'Login exitoso',
            'user' => [
                'id'        => $usuario->id,
                'nombres'   => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'email'     => $usuario->email,
                'role'      => $usuario->role,
            ],
            'token' => $token,
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Sesión cerrada',
        ]);
    }
}
