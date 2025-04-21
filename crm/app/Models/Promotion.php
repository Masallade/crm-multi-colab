<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
	protected $fillable = [
		'employee_id', 'company_id', 'promotion_title','description','promotion_date','designation_id'
	];

	public function company(){
		return $this->hasOne('App\Models\Company','id','company_id');
	}

	public function employee(){
		return $this->hasOne('App\Models\Employee','id','employee_id');
	}

	public function designation(){
		return $this->hasOne('App\Models\Designation','id','designation_id');
	}

	public function setPromotionDateAttribute($value)
	{
		$this->attributes['promotion_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getPromotionDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}
}
