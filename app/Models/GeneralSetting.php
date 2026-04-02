<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable =[
        "site_title",
        "site_logo",
        "time_zone",
        "currency",
        "currency_format",
        "default_payment_bank",
        "date_format",
        "theme",
        "footer",
        "footer_link",
        "one_day_hours",
        "one_day_minutes"
    ];

    /**
     * Get total hours per one day as decimal (e.g. 8.5 for 8 hours 30 minutes).
     */
    public function getOneDayTotalHoursAttribute(): float
    {
        $h = (int) ($this->one_day_hours ?? 8);
        $m = (int) ($this->one_day_minutes ?? 0);
        return round($h + $m / 60, 2);
    }
}
