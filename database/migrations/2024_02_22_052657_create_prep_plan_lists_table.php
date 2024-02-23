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
        Schema::create('prep_plan_lists', function (Blueprint $table) {
            $table->id('ppl_id');
            $table->string('ppl_title');
            $table->string('ppt_id');
            $table->string('ts_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prep_plan_lists');
    }
};
