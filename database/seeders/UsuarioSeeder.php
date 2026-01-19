<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        Usuario::firstOrCreate(
            ['email' => 'admin@gourmetgo.com'],
            [
                'nombres'    => 'Administrador',
                'apellidos'  => 'Sistema',
                'birthdate'  => '01/01/2000',
                'celular'    => '0999999999',
                'genero'     => 'Hombre',
                'password'   => Hash::make('admin123'),
                'role'       => 'administrador',
            ]
        );

        // Cocinero
        Usuario::firstOrCreate(
            ['email' => 'cocinero@gourmetgo.com'],
            [
                'nombres'    => 'Carlos',
                'apellidos'  => 'Chef',
                'birthdate'  => '01/01/2000',
                'celular'    => '0988888888',
                'genero'     => 'Hombre',
                'password'   => Hash::make('cocinero123'),
                'role'       => 'cocinero',
            ]
        );

        // Mesero
        Usuario::firstOrCreate(
            ['email' => 'mesero@gourmetgo.com'],
            [
                'nombres'    => 'Ana',
                'apellidos'  => 'Servicio',
                'birthdate'  => '01/01/2000',
                'celular'    => '0977777777',
                'genero'     => 'Mujer',
                'password'   => Hash::make('mesero123'),
                'role'       => 'mesero',
            ]
        );
    }
}