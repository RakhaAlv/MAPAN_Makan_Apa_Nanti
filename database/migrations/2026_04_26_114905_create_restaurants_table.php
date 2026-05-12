<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id('id_restoran');
            $table->unsignedBigInteger('id_merchant');
            $table->foreign('id_merchant')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('nama_restoran', 150);
            $table->text('deskripsi')->nullable();
            $table->string('alamat');
            $table->string('kontak', 20);
            $table->string('gmaps_link', 2048)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
