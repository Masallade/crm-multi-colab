<?php
namespace App\Http\Controllers\Variables;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class VariableController extends Controller {

	public function index()
	{
		if(auth()->user()->can('access-variable_type'))
		{
			$leaveTypes = LeaveType::select('id', 'leave_type')->get();
			$general_settings_data = GeneralSetting::latest()->first();
			
			return view('settings.variables.index', compact('leaveTypes', 'general_settings_data'));
		}
		return abort('403', __('You are not authorized'));
	}

	/**
	 * Update "one day = X hours Y minutes" (stored in general_settings).
	 */
	public function updateOneDayHours(Request $request)
	{
		if (!auth()->user()->can('access-variable_type')) {
			return abort('403', __('You are not authorized'));
		}
		if (!env('USER_VERIFIED')) {
			return redirect()->route('variables.index')->with('error', __('This feature is disabled for demo!'));
		}
		$request->validate([
			'one_day_hours'   => 'required|integer|min:0|max:24',
			'one_day_minutes' => 'required|integer|min:0|max:59',
		]);
		$setting = GeneralSetting::latest()->first();
		if (!$setting) {
			return redirect()->route('variables.index')->with('error', __('General settings not found.'));
		}
		$setting->one_day_hours   = (int) $request->one_day_hours;
		$setting->one_day_minutes  = (int) $request->one_day_minutes;
		$setting->save();
		return redirect()->route('variables.index')->with('success', __('One day hours updated successfully.'));
	}

}
