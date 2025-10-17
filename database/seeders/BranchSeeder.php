<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\User;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('role', 'admin')->first();
        
        Branch::create([
            'name' => 'Asosiy filial',
            'address' => 'Toshkent sh., Chilonzor tumani, Bunyodkor ko\'chasi 1-uy',
            'phone' => '+998901234567',
            'manager_id' => $admin?->id,
            'is_active' => true,
            'is_main' => true
        ]);

        Branch::create([
            'name' => 'Yunusobod filiali',
            'address' => 'Toshkent sh., Yunusobod tumani, Amir Temur ko\'chasi 15-uy',
            'phone' => '+998901234568',
            'manager_id' => $admin?->id,
            'is_active' => true
        ]);

        Branch::create([
            'name' => 'Sergeli filiali',
            'address' => 'Toshkent sh., Sergeli tumani, Mustaqillik ko\'chasi 25-uy',
            'phone' => '+998901234569',
            'manager_id' => $admin?->id,
            'is_active' => true
        ]);
    }
}