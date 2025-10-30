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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_free_trial');
            $table->double('monthly_fee');
            $table->double('yearly_fee');
            $table->integer('number_of_user_account');
            $table->integer('number_of_employee');
            $table->longText('features');
            $table->longText('permissions');
            $table->longText('permission_names');
            $table->longText('permission_ids');
            // $table->longText('role_permission_values')->nullable(); // remove later
            $table->boolean('is_active');
            $table->integer('position')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
