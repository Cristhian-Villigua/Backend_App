<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Usuario::create([
            'nombres'=>'Cristhian',
            'apellidos'=>'Villigua',
            'birthdate'=>'12/06/2004',
            'celular'=>'0987654321',
            'genero'=>'Masculino',
            'email'=>'admin@example.com',
            'password'=>Hash::make('pwd12345'),
            'role'=>'administrador',
        ]);
    }
}
