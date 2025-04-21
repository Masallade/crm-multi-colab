<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\FinanceBankCash;
use App\Models\JobCandidate;
use App\Models\office_shift;
use App\Models\SupportTicket;
use App\Models\TaxType;
use Illuminate\Http\Request;

class DynamicDependent extends Controller {

	public function fetchDepartment(Request $request)
	{
		$value = $request->get('value');
		$dependent = $request->get('dependent');
		$data = Department::whereCompany_id($value)->groupBy('department_name')->get();
		$output = '';
		foreach ($data as $row)
		{
			$output .= '<option value=' . $row->id . '>' . $row->$dependent . '</option>';
		}

		return $output;
	}

	public function fetchOfficeShifts(Request $request)
	{
		$value = $request->get('value');
		$dependent = $request->get('dependent');
		$data = office_shift::whereCompany_id($value)->groupBy('shift_name')->get();
		$output = '';
		foreach ($data as $row)
		{
			$output .= '<option value=' . $row->id . '>' . $row->$dependent . '</option>';
		}

		return $output;
	}

	public function fetchEmployee(Request $request)
	{
		$value = $request->get('value');
		$first_name = $request->get('first_name');
		$last_name = $request->get('last_name');
        
$logged_user = auth()->user();
// Get logged-in user's role
$roleId = $logged_user->role_users_id;

// Base Query
$dataQuery = Employee::where('company_id', $value)
                     ->where('is_active', 1)
                     ->whereNull('exit_date');

// **Role-Based Filtering**
if (in_array($roleId, [1, 6])) {
    // **Admin & Manager: Get all employees (no additional filtering)**
    $data = $dataQuery->get();
} elseif ($roleId == 4) {
    // **Team Lead: Get own + employees where team_lead = logged_user->id**
    $data = $dataQuery->where(function($query) use ($logged_user) {
        $query->where('id', $logged_user->id)  
              ->orWhere('team_lead', $logged_user->id);
    })->get();
} elseif ($roleId == 2) {
    // **Normal Employee: Get only own data**
    $data = $dataQuery->where('id', $logged_user->id)->get();
}


		$output = '';
		foreach ($data as $row)
		{
			$output .= '<option value=' . $row->id . '>' . $row->$first_name . ' ' . $row->$last_name . '</option>';
		}

		return $output;
	}

	public function fetchEmployeeDepartment(Request $request)
	{
		$value = $request->get('value');
		$first_name = $request->get('first_name');
		$last_name = $request->get('last_name');
		$data = Employee::wheredepartment_id($value)
                    ->where('is_active',1)
                    ->where('exit_date',NULL)
                    ->get();
		$output = '';
		foreach ($data as $row)
		{
			$output .= '<option value=' . $row->id . '>' . $row->$first_name . ' ' . $row->$last_name . '</option>';
		}

		return $output;
	}

	public function fetchDesignationDepartment(Request $request)
	{
		$value = $request->get('value');
		$designation_name = $request->get('designation_name');
		$data = Designation::wheredepartment_id($value)->groupBy('designation_name')->get();
		$output = '';

		foreach ($data as $row)
		{
			$output .= '<option value=' . $row->id . '>' . $row->$designation_name . '</option>';
		}

		return $output;
	}

	public function fetchBalance(Request $request)
	{
		$value = $request->get('value');
		$dependent = $request->get('dependent');
		$data = FinanceBankCash::whereId($value)->pluck('account_balance')->first();
		$output = '';
		$output .= '<p> (Available Balance ' . $data  .  ' )</p>';
		return $output;
	}

	public function companyEmployee(SupportTicket $ticket){
		$value = $ticket->company_id;
		$data = Employee::whereCompany_id($value)
                ->where('is_active',1)
                ->where('exit_date',NULL)
                ->get();
		$output = '';
		foreach ($data as $row)
		{
			$output .= '<option value=' . $row->id . '>' . $row->first_name . ' ' . $row->last_name . '</option>';
		}

		return $output;
	}


	public function getTaxRate(Request $request)
	{
		$value = $request->get('value');
		$qty = $request->get('qty');
		$unit_price = $request->get('unit_price');

		$data = TaxType::findorFail($value);
		$total_cost = $qty * $unit_price;
		if($data->type=='fixed')
		{
			$tax = $data->rate;
			$sub_total = $total_cost + $tax;
		}
		else {
			$tax = (($total_cost)*($data->rate/100));
			$sub_total = $total_cost + $tax;
		}

		return response()->json(['data'=>$data,'sub_total'=>$sub_total,'tax'=>$tax,'total_cost'=>$total_cost]);

	}


	public function fetchCandidate(Request $request)
	{
		$value = $request->get('value');

		$data = JobCandidate::whereJob_id($value)->groupBy('full_name')->get();
		$output = '';
		foreach ($data as $row)
		{
			$output .= '<option value=' . $row->id . '>' . $row->full_name . '</option>';
		}

		return $output;
	}

}
