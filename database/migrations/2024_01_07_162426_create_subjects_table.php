<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //วิชา
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id('s_id');
            $table->string('s_num');
            $table->string('s_name');
            $table->string('s_name2');
            $table->string('c_id');
            $table->string('p_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
