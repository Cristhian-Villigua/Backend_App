<?php

namespace App\Repositories;

use App\Models\Cliente;
use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface{

    public function create(array $data){
        return Cliente::create($data);
    }

    public function findByEmail(string $email){
        return Cliente::where('email', $email)->first();
    }
}