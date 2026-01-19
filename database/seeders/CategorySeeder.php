<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['title' => 'Entradas'],
            ['title' => 'Platos Principales'],
            ['title' => 'Postres'],
        ];

        foreach ($categorias as $cat) {
            Category::firstOrCreate($cat);
        }
    }
}
