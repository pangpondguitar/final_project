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
        Schema::create('edu_backgrounds', function (Blueprint $table) {
            $table->id('edu_id');
            $table->string('edu_level');
            $table->string('edu_program');
            $table->string('edu_university');
            $table->string('edu_year');
            $table->string('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edu_backgrounds');
    }
};
