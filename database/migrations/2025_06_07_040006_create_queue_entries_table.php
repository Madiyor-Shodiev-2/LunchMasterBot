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
        Schema::create('queue_entries', function (Blueprint $table) {
            $table->id('entry_id')->autoIncrement()->primary();
            $table->foreignId('session_id')->constrained('lunch_sessions')->references('session_id');
            $table->foreignId('operator_id')->constrained('operators')->references('operator_id');
            $table->integer('position');
            $table->string('status', 20)->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_entries');
    }
};
