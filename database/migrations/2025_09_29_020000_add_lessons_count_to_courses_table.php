<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Faqat yo'q ustunlarni qo'shamiz
            if (!Schema::hasColumn('courses', 'lessons_count')) {
                $table->integer('lessons_count')->default(0)->after('price');
            }
            if (!Schema::hasColumn('courses', 'requirements')) {
                $table->text('requirements')->nullable()->after('curriculum');
            }
            if (!Schema::hasColumn('courses', 'course_type')) {
                $table->string('course_type')->default('offline')->after('status');
            }
            if (!Schema::hasColumn('courses', 'meeting_link')) {
                $table->string('meeting_link')->nullable()->after('course_type');
            }
            if (!Schema::hasColumn('courses', 'certificate_template')) {
                $table->string('certificate_template')->nullable()->after('meeting_link');
            }
            if (!Schema::hasColumn('courses', 'branch_id')) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('certificate_template');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn([
                'lessons_count',
                'requirements', 
                'course_type',
                'meeting_link',
                'certificate_template',
                'branch_id'
            ]);
        });
    }
};