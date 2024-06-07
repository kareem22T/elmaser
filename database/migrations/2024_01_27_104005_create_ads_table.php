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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->text('ad_1')->nullable();
            $table->text('ad_2')->nullable();
            $table->text('ad_3')->nullable();
            $table->text('mobile_ad_1')->nullable();
            $table->text('mobile_ad_2')->nullable();
            $table->text('mobile_ad_3')->nullable();
            $table->text('main_ad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
