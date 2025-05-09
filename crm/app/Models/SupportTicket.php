<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
	protected $fillable = [
		'ticket_code', 'subject','company_id','department_id','employee_id','description','ticket_note','ticket_remarks',
		'ticket_status','ticket_priority','ticket_attachment', 'from_employee'
	];

	public function company(){
		return $this->hasOne('App\Models\Company','id','company_id');
	}

	public function department(){
		return $this->hasOne('App\Models\Department','id','department_id');
	}

	public function employee(){
		return $this->hasOne('App\Models\Employee','id','employee_id');
	}

	public function fromEmployee(){
		return $this->hasOne('App\Models\Employee','id','from_employee');
	}

	public function assignedEmployees(){
		return $this->belongsToMany(Employee::class);
	}


	public function getRouteKeyName()
	{
		return 'ticket_code'; // TODO: Change the autogenerated stub
	}

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format').'--H:i');
	}


}
