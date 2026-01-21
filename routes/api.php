<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UsuarioAuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS (Sin autenticación)
|--------------------------------------------------------------------------
*/

// Auth Clientes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']); //ok probada con bruno
    Route::post('login', [AuthController::class, 'login']); //ok probada con bruno
});

// USUARIOS (admin, mesero, cocinero)
Route::prefix('usuarios')->group(function () {
    Route::post('login', [UsuarioAuthController::class, 'login']); //ok probada con bruno
});

// Ítems públicos platos para el menú
Route::get('/items', [ItemController::class, 'index']);
Route::get('/items/{id}', [ItemController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);


/*
|--------------------------------------------------------------------------
| 2. RUTAS PARA STAFF (Admin, Mesero, Cocinero) - Guard: api_usuarios
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:api_usuarios'])->group(function () {
    
    Route::post('/usuarios/logout', [UsuarioAuthController::class, 'logout']); //ok probada con bruno

    // Administrador
    Route::middleware('role:administrador')->prefix('admin')->group(function () {
        
        // Dashboard Admin ejemplo sin funcionalidad real
        Route::get('/dashboard', fn() => response()->json('Bienvenido al Dashboard de Administrador')); //ok probada con bruno

        // Gestión de Clientes
        Route::apiResource('clientes', ClienteController::class)->only([
            'index', 'show', 'update', 'destroy']); //ok probada con bruno index, show, update, destroy

        // Gestión de Usuarios Staff
        Route::apiResource('usuarios', UsuarioController::class); //ok probada con bruno index, show, store, update, destroy

        // Gestión de Categorías
        Route::apiResource('categories', CategoryController::class)->only([
            'store', 'update', 'destroy']); //ok probada con bruno store, update, destroy

        // Gestión de Ítems o Platos
        Route::apiResource('items', ItemController::class)->only([
            'store', 'update', 'destroy']); //ok probada con bruno store, update, destroy
    });

    // Mesero
    Route::middleware('role:mesero')->group(function () {
        Route::get('/mesero/pedidos', fn() => response()->json('Lista de pedidos para el mesero')); //ok probada con bruno
    });

    // Cocinero
    Route::middleware('role:cocinero')->group(function () {
        Route::get('/cocinero/pedidos', fn() => response()->json('Lista de pedidos para el cocinero')); //ok probada con bruno
    });
});


/*
|--------------------------------------------------------------------------
| 3. RUTAS PARA CLIENTES (Protegidas) - Guard: api (Default)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:api'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']); //ok probada con bruno
    
    // Perfil de Cliente
    // Obtener mis datos
    Route::get('/me', function (Request $request) {
        return $request->user(); //ok probada con bruno
    });

    Route::prefix('clientes')->group(function () {
        // Actualizar mis datos
        Route::put('/{id}', [ClienteController::class, 'update']); //ok probada con bruno
        // Eliminar mi propia cuenta
        Route::delete('/{id}', [ClienteController::class, 'destroy']); //ok probada con bruno
    });
});