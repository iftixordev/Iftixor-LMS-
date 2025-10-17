<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Xona 101',
                'capacity' => 20,
                'equipment' => 'Proyektor, Doska, Konditsioner',
                'status' => 'available'
            ],
            [
                'name' => 'Xona 102',
                'capacity' => 15,
                'equipment' => 'Kompyuterlar, Proyektor, Konditsioner',
                'status' => 'available'
            ],
            [
                'name' => 'Xona 201',
                'capacity' => 25,
                'equipment' => 'Doska, Konditsioner, Audio tizim',
                'status' => 'available'
            ],
            [
                'name' => 'Xona 202',
                'capacity' => 12,
                'equipment' => 'Kompyuterlar, Proyektor',
                'status' => 'available'
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
