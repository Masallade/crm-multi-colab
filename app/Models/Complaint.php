<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
	protected $fillable = [
		'complaint_title','description', 'company_id','complaint_from','complaint_against','complaint_date','status'
	];

	public function company(){
		return $this->hasOne('App\Models\Company','id','company_id');
	}

	public function complaint_from_employee(){
		return $this->belongsTo('App\Models\Employee', 'complaint_from', 'id');
	}

	public function complaint_against_employee(){
		return $this->belongsTo('App\Models\Employee', 'complaint_against', 'id');
	}

	public function setComplaintDateAttribute($value)
	{
		$this->attributes['complaint_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getComplaintDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}
}
