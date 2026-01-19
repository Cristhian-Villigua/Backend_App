<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
{
    try {
        // Esto lee el rol del token sin importar si es Cliente o Usuario
        $payload = JWTAuth::parseToken()->getPayload();
        $userRole = $payload->get('role'); 

        if (!$userRole || strtolower(trim($userRole)) !== strtolower(trim($role))) {
            return response()->json([
                'message' => 'No tienes permisos para acceder',
                'rol_detectado' => $userRole
            ], 403);
        }

        return $next($request);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Token no válido'], 401);
    }
}
}
