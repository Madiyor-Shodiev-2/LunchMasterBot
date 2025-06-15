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
        Schema::create('lunch_schedules', function (Blueprint $table) {
            $table->id('schedule_id')->autoIncrement()->primary();
            $table->foreignId('group_id')->constrained('groups')->references('group_id');
            $table->integer('hour')->nullable()->unique();
            $table->integer('minute')->default(0);
            $table->integer('max_per_round')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lunch_schedules');
    }
};
