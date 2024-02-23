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
        Schema::create('planning_sum_hours', function (Blueprint $table) {
            $table->id('psh_id');
            $table->integer('psh_describe');
            $table->integer('psh_practice');
            $table->integer('psh_self');
            $table->string('ts_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_sum_hours');
    }
};
