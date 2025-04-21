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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title');
            $table->string('site_logo')->nullable();
            $table->string('time_zone');
            $table->string('phone');
            $table->string('email');
            $table->double('free_trial_limit');
            $table->string('currency_code', 10)->default('USD');
            $table->string('frontend_layout')->default('regular');
            $table->string('date_format');
            $table->string('footer');
            $table->string('footer_link');
            $table->string('developed_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
