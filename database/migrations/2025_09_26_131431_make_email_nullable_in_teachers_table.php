<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the table
        Schema::create('teachers_new', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('specializations');
            $table->string('education')->nullable();
            $table->decimal('hourly_rate', 8, 2);
            $table->date('hire_date');
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
        
        // Copy data
        DB::statement('INSERT INTO teachers_new (id, first_name, last_name, phone, address, specializations, education, hourly_rate, hire_date, photo, status, created_at, updated_at) SELECT id, first_name, last_name, phone, address, specializations, education, hourly_rate, hire_date, photo, status, created_at, updated_at FROM teachers');
        
        // Drop old table and rename new one
        Schema::drop('teachers');
        Schema::rename('teachers_new', 'teachers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse operation - make email required again
        Schema::create('teachers_new', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('specializations');
            $table->string('education')->nullable();
            $table->decimal('hourly_rate', 8, 2);
            $table->date('hire_date');
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
        
        DB::statement('INSERT INTO teachers_new (id, first_name, last_name, email, phone, address, specializations, education, hourly_rate, hire_date, photo, status, created_at, updated_at) SELECT id, first_name, last_name, COALESCE(email, ""), phone, address, specializations, education, hourly_rate, hire_date, photo, status, created_at, updated_at FROM teachers');
        
        Schema::drop('teachers');
        Schema::rename('teachers_new', 'teachers');
    }
};
