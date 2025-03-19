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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id('achievement_id'); // Sửa từ achiverment_id
            $table->string('name');
            $table->integer('requirement');
            $table->string('sticker')->nullable();
            $table->enum('type', ['Date', 'Word', 'Level'])->default('Level'); // Viết hoa Level cho nhất quán
            $table->integer('bonus_points')->default(0); // Chuẩn hóa tên cột
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
