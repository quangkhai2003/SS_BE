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
        Schema::create('user_chests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('progress_id');
            $table->timestamp('opened_at')->nullable();
        
            $table->unique(['user_id', 'progress_id']); // đảm bảo 1 user chỉ mở 1 chest trong mỗi topic
        
            // Sửa khóa ngoại để tham chiếu đúng cột
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('progress_id')->references('progress_id')->on('progress_through_level')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chests');
    }
};
