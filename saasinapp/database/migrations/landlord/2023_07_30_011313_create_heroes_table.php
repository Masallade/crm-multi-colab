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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->nullable();
            $table->string('heading');
            $table->text('sub_heading');
            $table->string('image');
            $table->string('button_text')->default('Try for free');
            $table->timestamps();

            $table->foreign('language_id', 'heroes_language_id_foreign')->references('id')->on('languages')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heroes', function (Blueprint $table) {
            $table->dropForeign('heroes_language_id_foreign');
            $table->dropIfExists('heroes');
        });
    }
};
