<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite uchun manual update
        DB::statement('UPDATE students SET parent_name = NULL WHERE parent_name = ""');
        DB::statement('UPDATE students SET parent_phone = NULL WHERE parent_phone = ""');
    }

    public function down(): void
    {
        // Rollback logic
    }
};