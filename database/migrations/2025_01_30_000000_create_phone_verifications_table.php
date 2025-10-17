<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('phone_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('request_id');
            $table->string('code', 6)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('expires_at');
            $table->timestamps();
            
            $table->index(['phone', 'request_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('phone_verifications');
    }
};