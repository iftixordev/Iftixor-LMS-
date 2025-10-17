<?php

namespace Database\Seeders;

use App\Models\ShopItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'O\'quv Markazi T-shirt',
                'description' => 'Yuqori sifatli paxta t-shirt, markaz logotipi bilan',
                'coin_price' => 500,
                'stock' => 20,
                'category' => 'merchandise',
            ],
            [
                'name' => 'Ruchka to\'plami',
                'description' => '10 ta rangli ruchka to\'plami',
                'coin_price' => 150,
                'stock' => 50,
                'category' => 'stationery',
            ],
            [
                'name' => 'Ingliz tili lug\'ati',
                'description' => 'Oxford English Dictionary',
                'coin_price' => 800,
                'stock' => 15,
                'category' => 'books',
            ],
            [
                'name' => 'Daftar A4',
                'description' => '100 varaqli spiralli daftar',
                'coin_price' => 100,
                'stock' => 30,
                'category' => 'stationery',
            ],
            [
                'name' => 'Markaz kubogi',
                'description' => 'Brendli suv ichish kubogi',
                'coin_price' => 300,
                'stock' => 25,
                'category' => 'merchandise',
            ],
            [
                'name' => 'USB Flash 16GB',
                'description' => 'Markaz logotipi bilan USB xotira',
                'coin_price' => 600,
                'stock' => 10,
                'category' => 'electronics',
            ],
        ];

        foreach ($items as $item) {
            ShopItem::create($item);
        }
    }
}
