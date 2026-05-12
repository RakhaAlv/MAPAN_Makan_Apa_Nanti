<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id')->references('id_restoran')->on('restaurants')->cascadeOnDelete();
            $table->tinyInteger('rating');
            $table->text('komentar')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'restaurant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
