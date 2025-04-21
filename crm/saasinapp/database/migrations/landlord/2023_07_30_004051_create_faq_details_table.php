<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_id');
            $table->string('question');
            $table->longText('answer');
            $table->integer('position')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('faq_id', 'faq_details_faq_id_foreign')->references('id')->on('faqs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faq_details', function (Blueprint $table) {
            $table->dropForeign('faq_details_faq_id_foreign');
            $table->dropIfExists('faq_details');
        });
    }
};
