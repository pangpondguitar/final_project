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
        Schema::create('users_details', function (Blueprint $table) {
            $table->id('user_d_id');
            $table->string('user_d_name');
            $table->string('user_d_name2');
            $table->string('user_d_add')->nullable();
            $table->string('user_d_email');
            $table->string('user_d_phone');
            $table->string('id');
            $table->string('p_id')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_details');
    }
};
