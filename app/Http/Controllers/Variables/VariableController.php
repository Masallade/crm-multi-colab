<?php
namespace App\Http\Controllers\Variables;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;

class VariableController extends Controller {

	public function index()
	{
		if(auth()->user()->can('access-variable_type'))
		{
			$leaveTypes = LeaveType::select('id', 'leave_type')->get();
			
			return view('settings.variables.index', compact('leaveTypes'));
		}
		return abort('403', __('You are not authorized'));
	}

}
