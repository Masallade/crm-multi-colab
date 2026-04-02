<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOneDayHoursMinutesToGeneralSettings extends Migration
{
    /**
     * Run the migrations.
     * One day = X hours Y minutes (for leave/work day duration).
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('one_day_hours')->default(8)->after('footer_link')->comment('Hours per one day (0-24)');
            $table->unsignedTinyInteger('one_day_minutes')->default(0)->after('one_day_hours')->comment('Minutes per one day (0-59)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn(['one_day_hours', 'one_day_minutes']);
        });
    }
}
