<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
	protected $fillable = [
		'description', 'company_id','department_id','employee_id','resignation_date','notice_date',
		'status', 'hr_approved', 'admin_approved', 'hr_approved_by', 'admin_approved_by',
		'hr_approved_at', 'admin_approved_at', 'hr_approval_notes', 'admin_approval_notes'
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

	public function hrApprovedBy(){
		return $this->belongsTo('App\Models\User','hr_approved_by','id');
	}

	public function adminApprovedBy(){
		return $this->belongsTo('App\Models\User','admin_approved_by','id');
	}

	public function setResignationDateAttribute($value)
	{
		$this->attributes['resignation_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getResignationDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

	public function setNoticeDateAttribute($value)
	{
		$this->attributes['notice_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getNoticeDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

	/**
	 * Check if resignation is fully approved (both HR and Admin approved)
	 */
	public function isFullyApproved()
	{
		return $this->hr_approved && $this->admin_approved;
	}

	/**
	 * Check if resignation is pending approval
	 */
	public function isPending()
	{
		return $this->status === 'pending';
	}

	/**
	 * Check if resignation is approved
	 */
	public function isApproved()
	{
		return $this->status === 'approved';
	}

	/**
	 * Check if resignation is rejected
	 */
	public function isRejected()
	{
		return $this->status === 'rejected';
	}

	/**
	 * Get approval status text
	 */
	public function getApprovalStatusText()
	{
		if ($this->isApproved()) {
			return 'Approved';
		} elseif ($this->isRejected()) {
			return 'Rejected';
		} elseif ($this->hr_approved && !$this->admin_approved) {
			return 'HR Approved - Pending Admin';
		} elseif (!$this->hr_approved && $this->admin_approved) {
			return 'Admin Approved - Pending HR';
		} else {
			return 'Pending Approval';
		}
	}
}
