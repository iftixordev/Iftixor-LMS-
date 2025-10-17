<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Teachers table
        if (Schema::hasTable('teachers') && !Schema::hasColumn('teachers', 'branch_id')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('status');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });
        }

        // Students table
        if (Schema::hasTable('students') && !Schema::hasColumn('students', 'branch_id')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('notes');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });
        }

        // Payments table
        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'branch_id')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('notes');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });
        }

        // Expenses table
        if (Schema::hasTable('expenses') && !Schema::hasColumn('expenses', 'branch_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('receipt');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });
        }

        // Schedules table
        if (Schema::hasTable('schedules') && !Schema::hasColumn('schedules', 'branch_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('notes');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        $tables = ['teachers', 'students', 'payments', 'expenses', 'schedules'];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->dropForeign(['branch_id']);
                    $blueprint->dropColumn('branch_id');
                });
            }
        }
    }
};