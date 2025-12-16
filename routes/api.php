<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('auth')->group(function (){
    Route::post('register',[AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['jwt.verify', 'role:admin'])->prefix('admin')->group(function(){
    Route::get('/users', [UsuarioController::class, 'index']);
    Route::get('/users/{id}', [UsuarioController::class, 'show']);        
    Route::post('/users', [UsuarioController::class, 'store']);          
    Route::put('/users/{id}', [UsuarioController::class, 'update']);      
    Route::delete('/users/{id}', [UsuarioController::class, 'destroy']);
});

Route::middleware(['jwt.verify'])->prefix('client')->group(function(){
    Route::get('/client', [ClienteController::class, 'index']);
    Route::get('/client/{id}', [ClienteController::class, 'show']);         
    Route::put('/client/{id}', [ClienteController::class, 'update']);      
    Route::delete('/client/{id}', [ClienteController::class, 'destroy']);
});
