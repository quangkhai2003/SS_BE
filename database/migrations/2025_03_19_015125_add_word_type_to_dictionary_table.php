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
            //
            $table->string('word_type')->nullable()->after('word');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dictionary', function (Blueprint $table) {
            //
            $table->dropColumn('word_type');
        });
    }
};
