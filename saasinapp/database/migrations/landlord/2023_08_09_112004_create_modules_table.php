<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id');
            $table->string('heading');
            $table->text('sub_heading');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('language_id', 'modules_language_id_foreign')->references('id')->on('languages')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropForeign('modules_language_id_foreign');
            $table->dropIfExists('modules');
        });
    }
};
