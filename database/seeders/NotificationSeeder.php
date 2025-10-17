<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [
            [
                'title' => 'Yangi o\'quvchi ro\'yxatdan o\'tdi',
                'message' => 'Ali Valiyev JavaScript kursiga ro\'yxatdan o\'tdi',
                'type' => 'success',
                'target' => 'admins',
                'is_read' => false,
                'sent_at' => now()->subMinutes(5),
                'created_at' => now()->subMinutes(5)
            ],
            [
                'title' => 'To\'lov qabul qilindi',
                'message' => 'Nargiza Karimova 500,000 so\'m to\'lov qildi',
                'type' => 'success',
                'target' => 'admins',
                'is_read' => false,
                'sent_at' => now()->subMinutes(15),
                'created_at' => now()->subMinutes(15)
            ],
            [
                'title' => 'Yangi kurs arizasi',
                'message' => 'Bobur Toshmatov Python kursiga ariza berdi',
                'type' => 'info',
                'target' => 'admins',
                'is_read' => false,
                'sent_at' => now()->subMinutes(30),
                'created_at' => now()->subMinutes(30)
            ],
            [
                'title' => 'Davomat eslatmasi',
                'message' => 'Bugun 5 ta o\'quvchi darsga kelmadi',
                'type' => 'warning',
                'target' => 'admins',
                'is_read' => true,
                'sent_at' => now()->subHours(2),
                'created_at' => now()->subHours(2)
            ],
            [
                'title' => 'Yangi o\'qituvchi qo\'shildi',
                'message' => 'Aziza Rahimova tizimga qo\'shildi',
                'type' => 'info',
                'target' => 'admins',
                'is_read' => true,
                'sent_at' => now()->subHours(4),
                'created_at' => now()->subHours(4)
            ],
            [
                'title' => 'Oylik hisobot tayyor',
                'message' => 'Sentyabr oyining moliyaviy hisoboti tayyor',
                'type' => 'success',
                'target' => 'admins',
                'is_read' => true,
                'sent_at' => now()->subDays(1),
                'created_at' => now()->subDays(1)
            ]
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}