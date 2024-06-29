<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('FLD', 100)->nullable()->default('text');
            $table->string('image', 100)->nullable()->default('text');
            $table->string('imgttl', 100)->nullable()->default('text');
            $table->string('editor', 100)->nullable()->default('text');
            $table->string('press_writer', 100)->nullable()->default('text');
            $table->string('useradd', 100)->nullable()->default('text');
            $table->string('press_modnum', 100)->nullable()->default('text');
            $table->string('keywords', 100)->nullable()->default('text');
            $table->string('dateadd', 100)->nullable()->default('text');
            $table->string('active', 100)->nullable()->default('text');
            $table->string('datelastTS', 100)->nullable()->default('text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            //
        });
    }
};
