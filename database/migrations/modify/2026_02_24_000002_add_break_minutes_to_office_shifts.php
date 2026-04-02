<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBreakMinutesToOfficeShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('office_shifts', function (Blueprint $table) {
            $table->unsignedSmallInteger('monday_break_minutes')->default(60)->after('monday_out');
            $table->unsignedSmallInteger('tuesday_break_minutes')->default(60)->after('tuesday_out');
            $table->unsignedSmallInteger('wednesday_break_minutes')->default(60)->after('wednesday_out');
            $table->unsignedSmallInteger('thursday_break_minutes')->default(60)->after('thursday_out');
            $table->unsignedSmallInteger('friday_break_minutes')->default(60)->after('friday_out');
            $table->unsignedSmallInteger('saturday_break_minutes')->default(60)->after('saturday_out');
            $table->unsignedSmallInteger('sunday_break_minutes')->default(60)->after('sunday_out');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('office_shifts', function (Blueprint $table) {
            $table->dropColumn([
                'monday_break_minutes',
                'tuesday_break_minutes',
                'wednesday_break_minutes',
                'thursday_break_minutes',
                'friday_break_minutes',
                'saturday_break_minutes',
                'sunday_break_minutes',
            ]);
        });
    }
}

