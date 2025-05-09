<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualificationSkill extends Model
{
	protected $guarded= [];

	public function company(){
		return $this->hasOne('App\Models\Company','id','company_id');
	}
}
