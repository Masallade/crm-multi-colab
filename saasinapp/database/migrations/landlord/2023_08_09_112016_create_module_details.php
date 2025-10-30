<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id');
            $table->string('name',100);
            $table->text('description');
            $table->string('icon',50);
            $table->integer('position')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('module_id', 'module_details_module_id_foreign')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('module_details', function (Blueprint $table) {
            $table->dropForeign('module_details_module_id_foreign');
            $table->dropIfExists('module_details');
        });
    }
};
