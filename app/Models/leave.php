<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class leave extends Model
{
	protected $fillable = [
		'leave_type_id','company_id','department_id','employee_id','start_date','end_date',
		'leave_reason','remarks','status','is_tl_action','is_hr_action','is_notify','total_days'
	];

	/** Appended when serialized (e.g. for API/DataTables). total_days is stored in minutes. */
	protected $appends = ['total_days_display', 'shift_based_display'];

	/** Format total_days (stored as minutes) as "X days Y hours Z minutes". */
	public function getTotalDaysDisplayAttribute()
	{
		$minutes = (int) ($this->attributes['total_days'] ?? 0);
		$days = (int) floor($minutes / 1440);
		$remainder = $minutes % 1440;
		$hours = (int) floor($remainder / 60);
		$mins = (int) ($remainder % 60);
		$parts = [];
		if ($days > 0) {
			$parts[] = $days . ' ' . ($days === 1 ? __('day') : __('days'));
		}
		if ($hours > 0) {
			$parts[] = $hours . ' ' . ($hours === 1 ? __('hour') : __('hours'));
		}
		if ($mins > 0 || empty($parts)) {
			$parts[] = $mins . ' ' . ($mins === 1 ? __('minute') : __('minutes'));
		}
		return implode(' ', $parts);
	}

	/** 
	 * Reverse calculate shift-based leave display from stored 24-hour calendar minutes.
	 * Shows actual shift time taken, not calendar deduction.
	 */
	public function getShiftBasedDisplayAttribute()
	{
		$totalMinutes = (int) ($this->attributes['total_days'] ?? 0);
		
		if ($totalMinutes <= 0) {
			return '0 ' . __('minutes');
		}

		// Calculate full days (always 24-hour calendar days)
		$fullDays = (int) floor($totalMinutes / 1440);
		$remainingMinutes = $totalMinutes % 1440;
		
		$parts = [];
		
		// Add full days if any
		if ($fullDays > 0) {
			$parts[] = $fullDays . ' ' . ($fullDays === 1 ? __('day') : __('days'));
		}
		
		// If no partial day, return full days only
		if ($remainingMinutes <= 0) {
			return empty($parts) ? '0 ' . __('minutes') : implode(' ', $parts);
		}
		
		// Get employee shift duration for reverse calculation
		$shiftMinutes = $this->getEmployeeShiftMinutes();
		
		if ($shiftMinutes <= 0) {
			// Fallback to calendar display if no shift found
			$hours = (int) floor($remainingMinutes / 60);
			$mins = (int) ($remainingMinutes % 60);
			if ($hours > 0) {
				$parts[] = $hours . ' ' . ($hours === 1 ? __('hour') : __('hours'));
			}
			if ($mins > 0 || (empty($parts) && $fullDays === 0)) {
				$parts[] = $mins . ' ' . ($mins === 1 ? __('minute') : __('minutes'));
			}
			return implode(' ', $parts);
		}
		
		// Reverse calculation: shift_leave = shift_duration - (1440 - calendar_deduction)
		$calendarDeduction = $remainingMinutes;
		$shiftLeaveMinutes = $shiftMinutes - (1440 - $calendarDeduction);
		
		// Ensure we don't get negative values
		$shiftLeaveMinutes = max(0, $shiftLeaveMinutes);
		
		// Convert shift leave minutes to hours and minutes
		$shiftHours = (int) floor($shiftLeaveMinutes / 60);
		$shiftMins = (int) ($shiftLeaveMinutes % 60);
		
		// Add shift-based partial day to display
		if ($shiftHours > 0) {
			$parts[] = $shiftHours . ' ' . ($shiftHours === 1 ? __('hour') : __('hours'));
		}
		if ($shiftMins > 0 || (empty($parts) && $fullDays === 0)) {
			$parts[] = $shiftMins . ' ' . ($shiftMins === 1 ? __('minute') : __('minutes'));
		}
		
		return empty($parts) ? '0 ' . __('minutes') : implode(' ', $parts);
	}

	/**
	 * Get employee shift duration in minutes for the leave end date.
	 */
	private function getEmployeeShiftMinutes()
	{
		try {
			// Load employee with office shift if not already loaded
			if (!$this->relationLoaded('employee')) {
				$this->load('employee.officeShift');
			} else if ($this->employee && !$this->employee->relationLoaded('officeShift')) {
				$this->employee->load('officeShift');
			}
			
			if (!$this->employee || !$this->employee->officeShift) {
				return 480; // Default 8-hour shift
			}
			
			// Get day of week from end date
			$endDate = $this->attributes['end_date'] ?? null;
			if (!$endDate) {
				return 480; // Default if no end date
			}
			
			$dayOfWeek = strtolower(\Carbon\Carbon::parse($endDate)->format('l')); // monday, tuesday, etc.
			
			$inColumn = $dayOfWeek . '_in';
			$outColumn = $dayOfWeek . '_out';
			
			$shiftIn = $this->employee->officeShift->$inColumn ?? null;
			$shiftOut = $this->employee->officeShift->$outColumn ?? null;
			
			if (!$shiftIn || !$shiftOut) {
				return 480; // Default 8-hour shift if no shift defined for this day
			}
			
			// Calculate shift duration in minutes
			$inTime = \Carbon\Carbon::parse($shiftIn);
			$outTime = \Carbon\Carbon::parse($shiftOut);
			$shiftMinutes = $outTime->diffInMinutes($inTime);
			
			return max(0, $shiftMinutes); // Ensure positive value
			
		} catch (\Exception $e) {
			// Error occurred, return default 8-hour shift
			return 480;
		}
	}

	public function company(){
		return $this->hasOne('App\Models\Company','id','company_id');
	}

	public function department(){
		return $this->hasOne('App\Models\Department','id','department_id');
	}

	public function LeaveType(){
		return $this->hasOne('App\Models\LeaveType','id','leave_type_id');
	}

	public function employee(){
		return $this->hasOne('App\Models\Employee','id','employee_id');
	}

	// public function employeeLeaveTypeDetail(){
	// 	return $this->hasOne('App\Models\EmployeeLeaveTypeDetail','employee_id','employee_id');
	// }

	public function setStartDateAttribute($value)
	{
		$this->attributes['start_date'] = $this->normalizeDateToYmd($value);
	}

	public function getStartDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

	public function setEndDateAttribute($value)
	{
		$this->attributes['end_date'] = $this->normalizeDateToYmd($value);
	}

	public function getEndDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'). '-- H:i');
	}

	/**
	 * Normalize a date string to Y-m-d. Accepts app Date_Format (e.g. d-m-Y), Y-m-d, or parseable string.
	 */
	protected function normalizeDateToYmd($value)
	{
		if (empty($value)) {
			return $value;
		}
		$format = env('Date_Format');
		if ($format) {
			try {
				$parsed = Carbon::createFromFormat($format, $value);
				if ($parsed) {
					return $parsed->format('Y-m-d');
				}
			} catch (\Exception $e) {
				// Fall through to other formats
			}
		}
		if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
			return $value;
		}
		try {
			return Carbon::parse($value)->format('Y-m-d');
		} catch (\Exception $e) {
			return $value;
		}
	}
}
