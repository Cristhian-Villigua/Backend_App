<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
{
    $platos = [
        ['title' => 'Hamburguesa Royal', 'description' => 'Carne angus, huevo, queso y tocino.', 'price' => 8.50, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500']],
        ['title' => 'Pizza Napolitana', 'description' => 'Salsa de tomate casera y mozzarella.', 'price' => 12.00, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?w=500']],
        ['title' => 'Ensalada César', 'description' => 'Pollo grillado, lechuga romana y crotones.', 'price' => 6.50, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1550304943-4f24f54ddde9?w=500']],
        ['title' => 'Tacos al Pastor', 'description' => '3 piezas con piña, cilantro y cebolla.', 'price' => 7.00, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?w=500']],
        ['title' => 'Lasaña Boloñesa', 'description' => 'Capas de pasta artesanal con ragú de carne y queso.', 'price' => 11.50, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=500']],
        ['title' => 'Salmón al Grill', 'description' => 'Filete de salmón fresco con espárragos y puré.', 'price' => 15.00, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=500']],
        ['title' => 'Lomo Saltado', 'description' => 'Carne de res salteada con cebolla, tomate y papas.', 'price' => 13.50, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1544124499-58912cbddaad?w=500']],
        ['title' => 'Ramen de Cerdo', 'description' => 'Caldo concentrado, fideos, panceta y huevo marinado.', 'price' => 10.50, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=500']],
        ['title' => 'Pollo al Curry', 'description' => 'Pechuga en salsa de curry y coco con arroz jazmín.', 'price' => 9.75, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1588166524941-3bf61a9c41db?w=500']],
        ['title' => 'Paella de Mariscos', 'description' => 'Arroz azafranado con mariscos frescos y limón.', 'price' => 16.50, 'category_id' => 2, 'picUrl' => ['https://images.unsplash.com/photo-1512058564366-18510be2db19?w=500']],
    ];

    foreach ($platos as $plato) {
        \App\Models\Item::create($plato);
    }
}

}
