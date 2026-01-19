<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioController extends Controller
{
    public function index(){

        $user = Usuario::all();
        return response()->json($user, 200);
    }

    public function store(Request $request){

        $request->validate([
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'birthdate' => 'required|max:10',
            'celular' => 'required|string|max:10',
            'genero' => 'required|string|max:10',
            'photo' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:100|unique:usuarios',
            'password' => 'required|string|min:8|max:15',
            'role' => 'required|in:cocinero,mesero',
        ]);

        $user = new Usuario();
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->birthdate = $request->birthdate;
        $user->celular = $request->celular;
        $user->genero = $request->genero;
        $user->email = $request->email;
        $user->password = Hash::make($request['password']);
        $user->role = $request->role;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo = $photoPath;
        }
        $user->save();
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function show($id){
        $user = Usuario::find($id);
        if(!$user){
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = Usuario::find($id);

        if(!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'nombres'   => 'sometimes|string',
            'apellidos' => 'sometimes|string',
            'birthdate' => 'sometimes',
            'celular'   => 'sometimes|string',
            'genero'    => 'sometimes|string',
            'email'     => 'sometimes|string|email|unique:usuarios,email,' . $id,
            'password'  => 'nullable|min:8|max:15',
            'role'      => 'sometimes|in:cocinero,mesero,administrador',
        ]);

        if ($request->has('nombres'))   $user->nombres = $request->nombres;
        if ($request->has('apellidos')) $user->apellidos = $request->apellidos;
        if ($request->has('birthdate')) $user->birthdate = $request->birthdate;
        if ($request->has('celular'))   $user->celular = $request->celular;
        if ($request->has('genero'))    $user->genero = $request->genero;
        if ($request->has('email'))     $user->email = $request->email;
        if ($request->has('role'))      $user->role = $request->role;

        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'user'    => $user
        ], 200);
    }

    public function destroy($id)
    {
        $user = Usuario::find($id);

        if(!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente',
            'user'    => $user
        ], 200);
    }
}
