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
        Schema::table('dictionary', function (Blueprint $table) {
            // Thêm index cho cột word
            $table->index('word', 'idx_word');

            // Thêm index cho cột vietnamese
            $table->index('vietnamese', 'idx_vietnamese');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('dictionary', function (Blueprint $table) {
            // Xóa index nếu cần hoàn tác
            $table->dropIndex('idx_word');
            $table->dropIndex('idx_vietnamese');
        });
    }
};
