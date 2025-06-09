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
        Schema::create('operators', function (Blueprint $table) {
            $table->bigInteger('operator_id')->autoIncrement()->primary();
            $table->bigInteger('telegram_id')->unique();
            $table->string('username', 255);
            $table->string('fullname', 255);
            $table->boolean('is_supervisor')->default(false);
            $table->timestamps(); //creadet_at == joined_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
