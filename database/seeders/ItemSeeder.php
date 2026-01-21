<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
{
    $platos = [
        // ===== 2 Entradas =====
        ['title' => 'Calamares Fritos', 'description' => 'Servidos con salsa tártara casera.', 'price' => 7.25, 'category_id' => 1, 'picUrl' => ['https://images.unsplash.com/photo-1600891964599-f61ba0e24092?w=500']],
        ['title' => 'Ensalada Caprese', 'description' => 'Tomate, mozzarella y albahaca fresca.', 'price' => 5.50, 'category_id' => 1, 'picUrl' => ['https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=500']],

        // ===== 10 Platos Principales =====
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

        // ===== 8 Postres =====
        ['title' => 'Tarta de Chocolate', 'description' => 'Tarta de chocolate con crema de vainilla.', 'price' => 5.50, 'category_id' => 3, 'picUrl' => ['https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500']],
        ['title' => 'Helado de Vainilla', 'description' => 'Helado artesanal con topping de chocolate.', 'price' => 4.50, 'category_id' => 3, 'picUrl' => ['https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=500']],
        ['title' => 'Cheesecake', 'description' => 'Pastel de queso con base de galleta.', 'price' => 6.00, 'category_id' => 3, 'picUrl' => ['https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=500']],
        ['title' => 'Brownie con Helado', 'description' => 'Brownie de chocolate con helado de vainilla.', 'price' => 5.75, 'category_id' => 3, 'picUrl' => ['https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?w=500']],
        ['title' => 'Crema Catalana', 'description' => 'Crema catalana con caramelo crujiente.', 'price' => 5.25, 'category_id' => 3, 'picUrl' => ['https://images.unsplash.com/photo-1481391319762-47dff72954d9?w=500']],
        ['title' => 'Panqueques con Dulce de Leche', 'description' => 'Panqueques rellenos de dulce de leche.', 'price' => 4.75, 'category_id' => 3, 'picUrl' => ['https://images.unsplash.com/photo-1504113888839-1c8eb50233d3?w=500']],
        ['title' => 'Mousse de Frutilla', 'description' => 'Mousse de frutilla fresca con crema.', 'price' => 5.50, 'category_id' => 3, 'picUrl' => ['https://images.unsplash.com/photo-1541783245831-57d6fb0926d3?w=500']],
        ['title' => 'Tiramisú', 'description' => 'Postre italiano con café y mascarpone.', 'price' => 6.50, 'category_id' => 3, 'picUrl' => ['https://images.unsplash.com/photo-1586040140378-b5634cb4c8fc?w=500']],
    ];

    foreach ($platos as $plato) {
        \App\Models\Item::create($plato);
    }
}

}
