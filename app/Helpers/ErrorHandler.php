<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ErrorHandler
{
    public static function handleDatabaseError(\Exception $e, string $operation = 'database operation')
    {
        Log::error("Database error during {$operation}: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        
        if (str_contains($e->getMessage(), 'FOREIGN KEY constraint failed')) {
            return "Ma'lumotni o'chirishda xatolik: Bu ma'lumot boshqa joyda ishlatilmoqda. Avval bog'liq ma'lumotlarni o'chiring.";
        }
        
        if (str_contains($e->getMessage(), 'UNIQUE constraint failed')) {
            return "Takroriy ma'lumot xatoligi: Bu ma'lumot allaqachon mavjud.";
        }
        
        return "Ma'lumotlar bazasida xatolik yuz berdi. Iltimos, qaytadan urinib ko'ring.";
    }
    
    public static function safeExecute(callable $callback, string $errorMessage = 'Xatolik yuz berdi')
    {
        try {
            return $callback();
        } catch (\Exception $e) {
            Log::error($errorMessage . ': ' . $e->getMessage());
            return null;
        }
    }
}