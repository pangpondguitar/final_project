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
        Schema::create('measure_prac_lists', function (Blueprint $table) {
            $table->id('mpl_id');
            $table->string('mpl_title');
            $table->string('mpt_id');
            $table->string('ts_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measure_prac_lists');
    }
};
