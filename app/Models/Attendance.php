<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
	protected $fillable = [
		'employee_id',
		'attendance_date',
		'clock_in',
		'clock_in_ip',
		'clock_out',
		'clock_out_ip',
		'clock_in_out',
		'time_late',
		'early_leaving',
		'overtime',
		'total_work',
		'total_rest',
		'attendance_status',
		'clock_up',
		'early_arrival',
		'off_desk_hours',
		'message',
		'should_stream'
	];

	protected $guarded = [];

	public $timestamps = false;


	// public function employee(){
	// 	return $this->belongsTo('Employee::class');
	// }
	public function employee()
	{
		return $this->belongsTo(Employee::class, 'employee_id');
	}


	public function setAttendanceDateAttribute($value)
	{
		// Try to parse as Y-m-d first, fallback to env('Date_Format')
		try {
			$this->attributes['attendance_date'] = \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
		} catch (\Exception $e) {
			$this->attributes['attendance_date'] = \Carbon\Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
		}
	}

	public function getAttendanceDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}
}
 