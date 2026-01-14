<?php

namespace App\Services;

use App\Repositories\Interfaces\ClientRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthService{
    
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository){
        $this->clientRepository = $clientRepository;
    }

    public function register(array $data){
        $existingUser = $this->clientRepository->findByEmail($data['email']);
        if ($existingUser) {
            return [
                'error' => 'El correo ya está registrado.',
                'status' => 404,
            ];
        }
        $client = $this->clientRepository->create([
            'nombres'   => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'birthdate' => $data['birthdate'],
            'celular'   => $data['celular'],
            'genero'    => $data['genero'],
            'email'     => $data['email'],
            'photo'     => $data['photo'],
            'password'  => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($client);
        return[
            'message' => 'Cliente creado exitosamente',
            'client' => $client,
            'token' => $token,
        ];
    }
}