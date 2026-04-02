<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeLeavesTotalDaysToMinutes extends Migration
{
    /** Minutes per calendar day (24h). */
    private const MINUTES_PER_DAY = 1440;

    /**
     * Run the migrations.
     * Store leave duration in minutes in total_days column (keep name for compatibility).
     *
     * @return void
     */
    public function up()
    {
        // Convert existing decimal-days values to minutes, then change column type
        DB::statement('UPDATE leaves SET total_days = ROUND(total_days * ' . self::MINUTES_PER_DAY . ')');
        Schema::table('leaves', function (Blueprint $table) {
            $table->unsignedInteger('total_days')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->decimal('total_days', 10, 4)->change();
        });
        DB::statement('UPDATE leaves SET total_days = total_days / ?', [self::MINUTES_PER_DAY]);
    }
}
