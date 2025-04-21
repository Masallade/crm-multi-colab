<?php


namespace App\Http\Controllers\Variables;

use App\Models\Employee;
use App\Models\EmployeeLeaveTypeDetail;
use App\Http\traits\LeaveTypeDataManageTrait;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use DataTables;
class EmployeeaddLeaveController {

    use LeaveTypeDataManageTrait;


    public function index(Request $request)
{
    if ($request->ajax()) {
        $employees = Employee::with('employeeLeaveTypeDetail')->get();

        if ($employees->isEmpty()) {
            return response()->json(['error' => 'No employees found']);
        }

        $filteredEmployees = $employees->map(function ($employee) use ($request) {
            if (!$employee->employeeLeaveTypeDetail) {
                return null;
            }

            // Convert serialized leave_type_detail to array
            $leaveDetails = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);

            if (!is_array($leaveDetails)) {
                return null;
            }

            // 🔍 **Check if filtering is applied**
            if ($request->has('leave_type') && !empty($request->leave_type)) {
                // ✅ Filter by `leave_type_id`
                $leaveDetails = collect($leaveDetails)->where('leave_type_id', (int) $request->leave_type)->values();
            } else {
                // ✅ Load only "Annual Leave" by default
                $leaveDetails = collect($leaveDetails)->where('leave_type', 'Annual Leave')->values();
            }

            return [
                'employee' => $employee,
                'leaveDetails' => $leaveDetails
            ];
        })->filter(); // Remove null values

        if ($filteredEmployees->isEmpty()) {
            return response()->json(['error' => 'No matching employees found']);
        }

        $leaveData = $filteredEmployees->map(function ($item) {
            return collect($item['leaveDetails'])->map(function ($leave) use ($item) {
                return [
                    'employee_id' => $item['employee']->id,
                    'employee_name' => $item['employee']->first_name . ' ' . $item['employee']->last_name,
                    'leave_type_id' => $leave['leave_type_id'],
                    'leave_type' => $leave['leave_type'],
                    'allocated_day' => '<input type="number" class="form-control allocated-day" value="' . $leave['allocated_day'] . '" data-employee-id="' . $item['employee']->id . '" data-leave-type-id="' . $leave['leave_type_id'] . '">',
                    'remaining_allocated_day' => '<input type="number" class="form-control remaining-allocated-day" value="' . $leave['remaining_allocated_day'] . '" data-employee-id="' . $item['employee']->id . '" data-leave-type-id="' . $leave['leave_type_id'] . '">',
                ];
            });
        })->flatten(1);

        return DataTables::of($leaveData)->rawColumns(['allocated_day', 'remaining_allocated_day'])->make(true);
    }
}

// 🚀 Function to Update Leave Data
public function updateLeave(Request $request)
{
    $validatedData = $request->validate([
        'updates' => 'required|array',
        'updates.*.employee_id' => 'required|exists:employees,id',
        'updates.*.leave_type_id' => 'required',
        'updates.*.allocated_day' => 'required|integer|min:0',
        'updates.*.remaining_allocated_day' => 'required|integer|min:0',
    ]);

    try {
        DB::beginTransaction();

        $uniqueUpdates = collect($validatedData['updates'])->unique(function ($item) {
            return $item['employee_id'] . '-' . $item['leave_type_id'];
        });

        foreach ($uniqueUpdates as $update) {
            $employee = Employee::find($update['employee_id']);

            if (!$employee || !$employee->employeeLeaveTypeDetail) {
                continue; // Skip if no leave details exist
            }

            $leaveDetails = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);

            foreach ($leaveDetails as &$leave) {
                if ($leave['leave_type_id'] == $update['leave_type_id']) {
                    $leave['allocated_day'] = $update['allocated_day'];
                    $leave['remaining_allocated_day'] = $update['remaining_allocated_day'];
                }
            }

            // Save updated data
            $employee->employeeLeaveTypeDetail->leave_type_detail = serialize($leaveDetails);
            $employee->employeeLeaveTypeDetail->save();
        }

        DB::commit();
        return response()->json(['success' => 'Leave details updated successfully']);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Failed to update leave: ' . $e->getMessage()], 500);
    }
}

    

	public function store(Request $request)
	{

		$logged_user = auth()->user();

			$validator = Validator::make($request->only('leave_type','allocated_day'),
				[
					'leave_type' => 'required|unique:leave_types',
					'allocated_day' => 'nullable|numeric',
				]
			);


			if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$newData = [];
			$newData['leave_type'] = $request->get('leave_type');
			$newData['allocated_day'] = $request->get('allocated_day');

			$leaveType =LeaveType::create($newData);

            // New
            $newData['leave_type_id'] = $leaveType->id;
            $newData['remaining_allocated_day'] = $request->get('allocated_day');

            $employees  = Employee::with('employeeLeave','employeeLeaveTypeDetail')->get();
            $leaveTypes = LeaveType::select('id','leave_type','allocated_day')->get();

            $existingData  = [];
            // $dataLeaveType = [];
            foreach($employees as $employee) {
                if($employee->employeeLeaveTypeDetail) {
                    $existingData = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
                    array_push($existingData, $newData);
                    $employee->employeeLeaveTypeDetail->leave_type_detail =  serialize($existingData);
                    $employee->employeeLeaveTypeDetail->update();
                }else{
                    $this->allLeaveTypeDataNewlyStore($employee);
                }
            }

			return response()->json(['success' => __('Data Added successfully.')]);
		


	}


	public function edit($id)
	{
		if(request()->ajax())
		{
			$data = LeaveType::findOrFail($id);

			return response()->json(['data' => $data]);
		}
	}


	public function update(Request $request)
	{
		$logged_user = auth()->user();

			$id = $request->get('hidden_leave_id');

			$validator = Validator::make($request->only('leave_type_edit'),
				[
					'leave_type_edit' => 'required|unique:leave_types,leave_type,'.$id,
					 'allocated_day' => 'nullable|numeric'
				]
			);


			if ($validator->fails()){
				return response()->json(['errors' => $validator->errors()->all()]);
			}

			$data = [];
			$data['leave_type'] = $request->get('leave_type_edit');
			$data['allocated_day'] = $request->get('allocated_day_edit');


			LeaveType::whereId($id)->update($data);

            $this->leaveTypeManageUpdate($request, $id);

			return response()->json(['success' => __('Data is successfully updated')]);
		
	}

    private function leaveTypeManageUpdate($request, $leaveTypeId)
    {
        $employees  = Employee::with('employeeLeave','employeeLeaveTypeDetail')->get(); //Have to Change
        $leaveTypes = LeaveType::select('id','leave_type','allocated_day')->get();

        foreach($employees as $employee){
            if($employee->employeeLeaveTypeDetail) {
                $leave_type_details = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
                $specificLeaveType = null;
                foreach ($leave_type_details as $value) {
                    if ($value["leave_type_id"] == $leaveTypeId) {
                        $specificLeaveType = $value;
                        break;
                    }
                }

                $dataLeaveType = [];
                foreach($leaveTypes as $key => $item) {
                    $dataLeaveType[$key]['leave_type_id'] = $item->id;
                    $dataLeaveType[$key]['leave_type'] = $item->leave_type;
                    $dataLeaveType[$key]['allocated_day'] = $item->allocated_day;

                    if($item->id == $leaveTypeId) {
                        // condition apply
                        if ($request->get('allocated_day_edit') > $specificLeaveType['allocated_day']) {
                            $dataLeaveType[$key]['remaining_allocated_day'] = $specificLeaveType['remaining_allocated_day'] + ($request->get('allocated_day_edit') - $specificLeaveType['allocated_day']);
                        }
                        elseif ($request->get('allocated_day_edit') < $specificLeaveType['allocated_day']) {
                            $remaining_leave = $specificLeaveType['remaining_allocated_day'] - ($specificLeaveType['allocated_day'] - $request->get('allocated_day_edit'));
                            $dataLeaveType[$key]['remaining_allocated_day'] = $remaining_leave < 0 ? 0 : $remaining_leave;
                        }else{
                            $dataLeaveType[$key]['remaining_allocated_day']  = $specificLeaveType['remaining_allocated_day'];
                        }
                    }else{
                        $totalPaidLeave = $employee->employeeLeave->where('leave_type_id',$item->id)->sum('total_days');
                        $remaining_leave = $item->allocated_day - $totalPaidLeave;
                        $dataLeaveType[$key]['remaining_allocated_day'] = $remaining_leave < 0 ? 0 : $remaining_leave;
                    }
                }
                EmployeeLeaveTypeDetail::updateOrCreate(
                    ['employee_id' => $employee->id],
                    ['leave_type_detail' => serialize($dataLeaveType)]
                );
            }else{
                $this->allLeaveTypeDataNewlyStore($employee);
            }

        }
    }



	public function destroy($id)
	{
		if(!env('USER_VERIFIED'))
		{
			return response()->json(['error' => 'This feature is disabled for demo!']);
		}
		$logged_user = auth()->user();

			LeaveType::whereId($id)->delete();

            $this->leaveTypeManageDelete($id);

			return response()->json(['success' => __('Data is successfully deleted')]);
		
	}

    private function leaveTypeManageDelete($leaveTypeId)
    {
        $employees  = Employee::with('employeeLeave','employeeLeaveTypeDetail')->get();
        $existingData = [];
        foreach($employees as $employee) {
            if($employee->employeeLeaveTypeDetail) {
                $existingData = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
                foreach ($existingData as $key => $value) {
                    if ($value['leave_type_id'] == $leaveTypeId) {
                        unset($existingData[$key]);
                    }
                }
                $employee->employeeLeaveTypeDetail->leave_type_detail =  serialize($existingData);
                $employee->employeeLeaveTypeDetail->update();
            }
            else{
                $this->allLeaveTypeDataNewlyStore($employee);
            }
        }
    }



    public function rem_leave_update(){
        $employees = [
            ["name" => "Faisal Ayub", "balance_sl" => 6, "balance_al" => 13],
            ["name" => "Sadia Latif", "balance_sl" => 8, "balance_al" => 18],
            ["name" => "Awais Liaqat", "balance_sl" => 6, "balance_al" => 0],
            ["name" => "Ahsan Masood", "balance_sl" => 2, "balance_al" => 15],
            ["name" => "Khurram Ali Butt", "balance_sl" => 8, "balance_al" => 18],
            ["name" => "Syed Ibad Hussain", "balance_sl" => 7, "balance_al" => 6],
            ["name" => "Arman Arif", "balance_sl" => 8, "balance_al" => 9],
            ["name" => "M. Zishan", "balance_sl" => 4, "balance_al" => 3],
            ["name" => "Imtinan Fazal Haq Chaudhry", "balance_sl" => 5, "balance_al" => 13],
            ["name" => "Ahsan Sadiq Butt", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Muhammad Khawar", "balance_sl" => 6, "balance_al" => 10],
            ["name" => "Hina Iftikhar", "balance_sl" => 6, "balance_al" => 9],
            ["name" => "Zohaib Hassan", "balance_sl" => 6, "balance_al" => 9],
            ["name" => "Amir Asghar Butt", "balance_sl" => 8, "balance_al" => 2],
            ["name" => "Aziz ur Rehman", "balance_sl" => 8, "balance_al" => 16],
            ["name" => "Hamza Khan", "balance_sl" => 7, "balance_al" => 7],
            ["name" => "Imran Khattak", "balance_sl" => 6, "balance_al" => 10],
            ["name" => "Sarmad Hassan Tariq", "balance_sl" => 6, "balance_al" => 6],
            ["name" => "Musadiq Mehmood", "balance_sl" => 2, "balance_al" => 3],
            ["name" => "Mukashfa", "balance_sl" => 3, "balance_al" => 5],
            ["name" => "Ghulam Ghous", "balance_sl" => 6, "balance_al" => 3],
            ["name" => "Usam- ul-Haq", "balance_sl" => 5, "balance_al" => 8],
            ["name" => "Iatzaz Ahsan", "balance_sl" => 6, "balance_al" => 1],
            ["name" => "M Umer Hayat", "balance_sl" => 3, "balance_al" => 1],
            ["name" => "Naveed Iqbal", "balance_sl" => 6, "balance_al" => 2],
            ["name" => "Muhammad Sameer", "balance_sl" => 2, "balance_al" => 4],
            ["name" => "Zubair Ali", "balance_sl" => 2, "balance_al" => 0],
            ["name" => "Saeed Ur Rehman", "balance_sl" => 4, "balance_al" => 4],
            ["name" => "Zahid Hassan", "balance_sl" => 2, "balance_al" => 5],
            ["name" => "Munaam Malik", "balance_sl" => 4, "balance_al" => 8],
            ["name" => "Ain Ul Afin", "balance_sl" => 0, "balance_al" => 2],
            ["name" => "Muhammad Waqas", "balance_sl" => 3, "balance_al" => 4],
            ["name" => "Shahneel Fatima", "balance_sl" => 6, "balance_al" => 9],
            ["name" => "Muhammad Afaq", "balance_sl" => 7, "balance_al" => 5],
            ["name" => "Laiba Naveed", "balance_sl" => 3, "balance_al" => 7],
            ["name" => "Haram Mustafa", "balance_sl" => 2, "balance_al" => 8],
            ["name" => "Faisal Zeb", "balance_sl" => 1, "balance_al" => 1],
            ["name" => "Hadayat Ullah", "balance_sl" => 5, "balance_al" => 3],
            ["name" => "Wasif Ali", "balance_sl" => 2, "balance_al" => 8],
            ["name" => "Ajmal Farooq", "balance_sl" => 2, "balance_al" => 4],
            ["name" => "Umar Saleem", "balance_sl" => 5, "balance_al" => 3],
            ["name" => "Asghar Ali", "balance_sl" => 0, "balance_al" => 5],
            ["name" => "Areej Fatima", "balance_sl" => 7, "balance_al" => 6],
            ["name" => "Rafeh Hafeez", "balance_sl" => 8, "balance_al" => 4],
            ["name" => "Shehryar Hussain", "balance_sl" => 7, "balance_al" => 0],
            ["name" => "SanaUllah", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Hammad Hussain", "balance_sl" => 2, "balance_al" => 0],
            ["name" => "Faheem Ul Hassan", "balance_sl" => 5, "balance_al" => 6],
            ["name" => "Khawaja Ans", "balance_sl" => 4, "balance_al" => 9],
            ["name" => "Ashfaq Ahmed Khan", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Muhammad Daniyal Javed", "balance_sl" => 5, "balance_al" => 6],
            ["name" => "Haris Ahmad Khan", "balance_sl" => 3, "balance_al" => 7],
            ["name" => "Muhammad Waleed", "balance_sl" => 7, "balance_al" => 8],
            ["name" => "Muhammad Rayyan", "balance_sl" => 0, "balance_al" => 1],
            ["name" => "Ibtisam Shahid", "balance_sl" => 4, "balance_al" => 4],
            ["name" => "Bilal Amin", "balance_sl" => 3, "balance_al" => 1],
            ["name" => "Saud Khan", "balance_sl" => 4, "balance_al" => 3],
            ["name" => "Mathew Francis", "balance_sl" => 1, "balance_al" => 6],
            ["name" => "Junaid Rasheed", "balance_sl" => 3, "balance_al" => 5],
            ["name" => "Junaid Babar", "balance_sl" => 0, "balance_al" => 2],
            ["name" => "Zayan Rashid", "balance_sl" => 3, "balance_al" => 4],
            ["name" => "Muhammad Salar Asif", "balance_sl" => 2, "balance_al" => 4],
            ["name" => "Muhammad Ahmed", "balance_sl" => 2, "balance_al" => 5],
            ["name" => "Irfan Azam Baig", "balance_sl" => 4, "balance_al" => 0],
            ["name" => "Mahnoor Rehman", "balance_sl" => 2, "balance_al" => 3],
            ["name" => "Muhammad Ibrahim", "balance_sl" => 4, "balance_al" => 5],
            ["name" => "Nouman Hayat", "balance_sl" => 2, "balance_al" => 3],
            ["name" => "Abdul Mannan Butt", "balance_sl" => 3, "balance_al" => 0],
            ["name" => "Muhammad Ali Hussain", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Afnan Ahmad", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Muhammad Daniyal", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Muhammad Faisal Irfan", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Muhammad Wahaj", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Muhammad Ashir Siddique", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Jawad Hussain", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Hamza Waheed", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Kamran Khalid", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Muhammad Hassan Iqbal", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Ali Abid", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Hamza Qamar", "balance_sl" => 0, "balance_al" => 0],
            ["name" => "Hadi Raza", "balance_sl" => 0, "balance_al" => 0]
        ];

        $array_with_id = [];

foreach ($employees as $key) {
    $full_name = $key['name']; // Full name from array

    // Fetch employee where first_name + last_name matches full name
    $data = DB::table('employees')
        ->whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$full_name])
        ->first();

    if ($data) {
        $array_with_id[] = [
            "user_id" => $data->id,
            "db_name" => $data->first_name . ' ' . $data->last_name,
            "db_balance_sl" => 0, 
            "db_balance_al" => 0,
            "name" => $key['name'],
            "balance_sl" => $key['balance_sl'],
            "balance_al" => $key['balance_al'],
        ];
    }
}


// $data = [
//     [
//         "leave_type_id" => 1,
//         "leave_type" => "Sick Leave",
//         "allocated_day" => 10,
//         "remaining_allocated_day" => $skey['balance_sl'] // Ensure this is an integer
//     ],
//     [
//         "leave_type_id" => 2,
//         "leave_type" => "Annual Leave",
//         "allocated_day" => 20,
//         "remaining_allocated_day" => $skey['balance_al'] // Ensure this is an integer
//     ]
// ];

// $serializedData = serialize($data);
// echo $serializedData;

// exit;
//         // Dump and die to inspect the output
//         echo "<pre>";
//         print_r($array_with_id);
        
// exit;
foreach ($array_with_id as $skey) {
    $balance_sl = (int) $skey['balance_sl'];
    $balance_al = (int) $skey['balance_al'];
    $employee_id = (int) $skey['user_id'];

    $data = [
        [
            "leave_type_id" => 1,
            "leave_type" => "Sick Leave",
            "allocated_day" => 10,
            "remaining_allocated_day" => $balance_sl
        ],
        [
            "leave_type_id" => 2,
            "leave_type" => "Annual Leave",
            "allocated_day" => 20,
            "remaining_allocated_day" => $balance_al
        ]
    ];

    $serializedData = addslashes(serialize($data));

    $query = "
        UPDATE employee_leave_type_details 
        SET leave_type_detail = '{$serializedData}', status = 1
        WHERE employee_id = {$employee_id};
    ";

    echo $query . "<br>"; // Debugging

    // DB::statement($query);
}

        
    }

}



























