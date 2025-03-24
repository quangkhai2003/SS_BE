<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Thay đổi cột role thành ENUM với các giá trị mới
            $table->enum('role', ['user', 'admin', 'guest'])->default('user')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Khôi phục về trạng thái cũ (nếu cần rollback)
            $table->enum('role', ['user', 'admin'])->default('user')->change();
        });
    }
};
