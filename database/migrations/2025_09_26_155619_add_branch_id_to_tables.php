<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};