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
        Schema::create('your_achievements', function (Blueprint $table) {
            $table->id('user_achievement_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Đổi từ account_id
            $table->foreignId('achievement_id')->constrained('achievements', 'achievement_id')->onDelete('cascade');
            $table->date('created_at')->nullable();
            $table->enum('status', ['complete', 'incomplete'])->default('incomplete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('your_achievements');
    }
};
