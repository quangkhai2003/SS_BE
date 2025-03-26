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
            $table->text('examples_vietnamese')->nullable()->after('examples'); // Thêm cột examples_vietnamese
            $table->string('ipa')->nullable()->after('word'); // Thêm cột ipa
        });
    }

    public function down(): void
    {
        Schema::table('dictionary', function (Blueprint $table) {
            $table->dropColumn('examples_vietnamese'); // Xóa cột nếu rollback
            $table->dropColumn('ipa'); // Xóa cột nếu rollback
        });
    }
};
