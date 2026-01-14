<?php

namespace App\Repositories\Interfaces;

interface ClientRepositoryInterface{
    public function create(array $data);
    public function findByEmail(string $email);
}