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
        Schema::create('temporary_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id');
            $table->foreignId('division_id');
            $table->foreignId('period', 10);
            $table->foreignId('club_id');
            $table->integer('number_of_match');
            $table->integer('win');
            $table->integer('draw');
            $table->integer('lost');
            $table->integer('gol_in');
            $table->integer('gol_out');
            $table->integer('point');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_positions');
    }
};
