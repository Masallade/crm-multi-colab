<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLeaveTypesAllocatedDayToDecimal extends Migration
{
    /**
     * Run the migrations.
     * Supports half-day leave (e.g. 0.5, 2.5).
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->decimal('allocated_day', 5, 1)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_types', function (Blueprint $table) {
            $table->integer('allocated_day')->nullable()->change();
        });
    }
}
