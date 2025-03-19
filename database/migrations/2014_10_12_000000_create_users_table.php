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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Khóa chính, tự động tăng
            $table->string('username')->unique()->index(); // Tên đăng nhập, có thể null, thêm index
            $table->string('password'); // Lưu mật khẩu đã hash
            $table->string('full_name'); // Tên đầy đủ
            $table->string('avatar')->nullable(); // Đường dẫn ảnh, có thể null
            $table->string('email')->unique()->index(); // Email duy nhất, thêm index
            $table->unsignedInteger('point')->default(0); // Sử dụng unsigned để tiết kiệm bộ nhớ
            $table->enum('role', ['Admin', 'User'])->default('User'); // Vai trò
            $table->unsignedInteger('study_day')->default(0); // Số ngày học, unsigned
            $table->timestamps(); // Tự động tạo created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
