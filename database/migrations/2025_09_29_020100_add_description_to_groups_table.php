<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            if (!Schema::hasColumn('groups', 'description')) {
                $table->text('description')->nullable()->after('max_students');
            }
            if (!Schema::hasColumn('groups', 'photo')) {
                $table->string('photo')->nullable()->after('description');
            }
            if (!Schema::hasColumn('groups', 'branch_id')) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('photo');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn(['description', 'photo', 'branch_id']);
        });
    }
};