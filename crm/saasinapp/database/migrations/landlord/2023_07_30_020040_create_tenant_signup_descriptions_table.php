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
        Schema::create('tenant_signup_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id');
            $table->string('heading');
            $table->string('sub_heading');
            $table->timestamps();

            $table->foreign('language_id', 'tenant_signup_descriptions_language_id_foreign')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_signup_descriptions', function (Blueprint $table) {
            $table->dropForeign('tenant_signup_descriptions_language_id_foreign');
            $table->dropIfExists('tenant_signup_descriptions');
        });
    }
};
