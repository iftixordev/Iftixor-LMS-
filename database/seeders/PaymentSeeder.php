<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        
        if ($students->isEmpty()) {
            return;
        }

        $paymentMethods = ['cash', 'card', 'transfer', 'online'];
        $paymentTypes = ['Kurs to\'lovi', 'Oylik to\'lov', 'Qarz to\'lovi', 'Oldindan to\'lov'];
        
        // So'nggi 6 oy uchun to'lovlar yaratish
        for ($i = 0; $i < 50; $i++) {
            $student = $students->random();
            $amount = rand(300000, 1500000);
            $discountPercent = rand(0, 20);
            $discountAmount = ($amount * $discountPercent) / 100;
            $finalAmount = $amount - $discountAmount;
            
            Payment::create([
                'student_id' => $student->id,
                'amount' => $finalAmount,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_date' => Carbon::now()->subDays(rand(0, 180)),
                'status' => rand(0, 10) > 1 ? 'completed' : 'pending',
                'receipt_number' => 'PAY-' . date('Y') . '-' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'description' => $paymentTypes[array_rand($paymentTypes)] . ' - Demo ma\'lumot',
                'notes' => rand(0, 3) == 0 ? 'Demo to\'lov ma\'lumoti' : null,
            ]);
        }
    }
}