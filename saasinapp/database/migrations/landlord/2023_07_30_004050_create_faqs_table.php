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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id');
            $table->string('heading');
            $table->text('sub_heading');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('language_id', 'faqs_language_id_foreign')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropForeign('faqs_language_id_foreign');
            $table->dropIfExists('faqs');
        });
    }
};


