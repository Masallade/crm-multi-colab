<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class office_shift extends Model
{
	protected $table = 'office_shifts';

    protected $fillable=[
		'shift_name',
        'company_id',
        'default_shift',
        'monday_in','monday_out','monday_break_minutes',
        'tuesday_in','tuesday_out','tuesday_break_minutes',
        'wednesday_in','wednesday_out','wednesday_break_minutes',
        'thursday_in','thursday_out','thursday_break_minutes',
        'friday_in','friday_out','friday_break_minutes',
        'saturday_in','saturday_out','saturday_break_minutes',
        'sunday_in','sunday_out','sunday_break_minutes',
    	];

	public function company(){
		return $this->hasOne('App\Models\Company','id','company_id');
	}
}
