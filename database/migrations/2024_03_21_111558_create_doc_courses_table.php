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
        Schema::create('doc_courses', function (Blueprint $table) {
            $table->id('dcf_id');
            $table->string('c_id');
            $table->string('dcf_name');
            $table->string('dcf_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_courses');
    }
};
