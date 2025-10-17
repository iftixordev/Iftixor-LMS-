<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->boolean('can_terminate_others')->default(false);
        });
    }

    public function down()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->dropColumn('can_terminate_others');
        });
    }
};