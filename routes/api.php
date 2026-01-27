<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UsuarioAuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS (Sin autenticación)
|--------------------------------------------------------------------------
*/

// Auth Clientes + USUARIOS (admin, mesero, cocinero)
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']); // Cliente
    Route::post('login', [AuthController::class, 'login']);       // Cliente + Usuario
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

    Route::get('/usuarios/me', function (Request $request) {
        // $request->user() ya devuelve el usuario autenticado
        return response()->json($request->user());
    });

    // Rutas para que cualquier usuario staff pueda actualizar o eliminar su perfil
    Route::prefix('usuarios')->group(function () {
        // Actualizar mi propio perfil
        Route::put('/{id}', [UsuarioController::class, 'update']); 

        // Eliminar mi propia cuenta
        Route::delete('/{id}', [UsuarioController::class, 'destroy']); 
    });

    
    Route::post('/usuarios/logout', [UsuarioAuthController::class, 'logout']); //ok probada con bruno

    // Administrador
    Route::middleware('role:administrador')->prefix('admin')->group(function () {
        
        // Dashboard Admin ejemplo sin funcionalidad real
        Route::get('/dashboard', fn() => response()->json('Bienvenido al Dashboard de Administrador')); //ok probada con bruno

        // Gestión de Clientes
        Route::apiResource('clientes', ClienteController::class); //ok probada con bruno index, show, store update, destroy

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
        Route::get('/cocinero/orders/pending', [\App\Http\Controllers\OrderController::class, 'pendingOrders']);
        Route::get('/cocinero/orders/history', [\App\Http\Controllers\OrderController::class, 'history']);
        Route::put('/cocinero/orders/{id}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus']);
        Route::delete('/cocinero/orders/{id}', [\App\Http\Controllers\OrderController::class, 'destroy']);
    });
});

Route::middleware(['auth:api'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::prefix('clientes')->group(function () {
        Route::put('/{id}', [ClienteController::class, 'update']);
        Route::delete('/{id}', [ClienteController::class, 'destroy']);
    });

    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index']);
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store']);
});