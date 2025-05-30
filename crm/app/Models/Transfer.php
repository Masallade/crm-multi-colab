<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
	protected $fillable = [
		'description', 'company_id','from_department_id', 'to_department_id','employee_id','transfer_date','team_lead_id'
	];

	public function company(){
		return $this->hasOne('App\Models\Company','id','company_id');
	}

	public function from_department(){
		return $this->hasOne('App\Models\Department','id','from_department_id');
	}

	public function to_department(){
		return $this->hasOne('App\Models\Department','id','to_department_id');
	}

	public function employee(){
		return $this->hasOne('App\Models\Employee','id','employee_id');
	}

	public function team_lead(){
		return $this->hasOne('App\Models\Employee','id','team_lead_id');
	}

	public function setTransferDateAttribute($value)
	{
		$this->attributes['transfer_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getTransferDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}
}
