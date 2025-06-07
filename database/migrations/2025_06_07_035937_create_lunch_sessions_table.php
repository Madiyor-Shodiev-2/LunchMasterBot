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
        Schema::create('lunch_sessions', function (Blueprint $table) {
            $table->id('session_id')->autoIncrement()->primary();
            $table->foreignId('schedule_id')->constrained('lunch_schedules')->references('schedule_id');
            $table->date('date')->nullable();
            $table->string('status', 20)->default('collecting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lunch_sessions');
    }
};
