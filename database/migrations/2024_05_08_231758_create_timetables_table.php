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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id');
            $table->foreignId('division_id');
            $table->string('period', 10);
            $table->bigInteger('date');
            $table->integer('home_id');
            $table->string('home_name');
            $table->integer('away_id');
            $table->string('away_name');
            $table->boolean('is_play');
            $table->integer('score_home');
            $table->integer('score_away');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
