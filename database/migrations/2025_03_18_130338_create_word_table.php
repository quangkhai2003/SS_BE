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
        Schema::create('word', function (Blueprint $table) {
            $table->id('id_word'); // Primary key
            $table->foreignId('id_level')->constrained('level', 'level_id')->onDelete('cascade');
            $table->string('word');
            $table->string('image')->nullable(); // Có thể null nếu không có ảnh
            $table->string('sound')->nullable(); // Có thể null nếu không có âm thanh
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word');
    }
};
