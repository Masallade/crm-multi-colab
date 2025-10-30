<?php

namespace App\Http\Controllers\Performance;

use App\Models\Appraisal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\AppraisalSubmitController;
use App\Models\Designation;
use App\Models\AppraisalSection;
use App\Notifications\AppraisalEvaluatorNotification;
use Illuminate\Support\Facades\Log;

class AppraisalController extends Controller
{
    public function index(Request $request)
    {
        // dd('ok');
        if ($request->ajax())
        {
            // $appraisals = Appraisal::with('company:id,company_name','employee:id,first_name,last_name','department:id,department_name','designation:id,designation_name')
            //             ->orderBy('id','DESC')->get();
            $loggedUser = auth()->user();
            if (in_array($loggedUser->role_users_id, [1, 6])) {
                // Admin/Manager: see all appraisals
                $appraisals = Appraisal::with('company:id,company_name','employee:id,first_name,last_name,team_lead','department:id,department_name','designation:id,designation_name')
                    ->orderBy('id','DESC')->get();
            }  else {
                // Evaluator: see only appraisals where this user is an evaluator
                Log::info('AppraisalController@index: User ID: ' . auth()->user()->id);
                $employeeId = Employee::where('id', auth()->user()->id)->value('id');
                Log::info('AppraisalController@index: Retrieved Employee ID: ' . $employeeId);
            
                // Solution 1: Cast employee ID to string to match JSON string format
                $employeeIdString = (string) $employeeId;
                
                                // Fixed: Remove the path parameter to search the entire JSON
                            $appraisals = Appraisal::whereRaw("JSON_SEARCH(full_result, 'one', '$employeeIdString', NULL, '$[*].evaluator_id') IS NOT NULL")
                    ->with('company:id,company_name','employee:id,first_name,last_name,team_lead','department:id,department_name','designation:id,designation_name')
                    ->orderBy('id','DESC')->get();
                
                // Alternative Solution 2: Use JSON_EXTRACT with LIKE for more flexible matching
                /*
                $appraisals = Appraisal::whereRaw("JSON_EXTRACT(full_result, '$[*].evaluator_id') LIKE '%\"$employeeId\"%'")
                    ->with('company:id,company_name','employee:id,first_name,last_name,team_lead','department:id,department_name','designation:id,designation_name')
                    ->orderBy('id','DESC')->get();
                */
                
                // Alternative Solution 3: Use JSON_SEARCH function
                /*
                $appraisals = Appraisal::whereRaw("JSON_SEARCH(full_result, 'one', '$employeeId', NULL, '$[*].evaluator_id') IS NOT NULL")
                    ->with('company:id,company_name','employee:id,first_name,last_name,team_lead','department:id,department_name','designation:id,designation_name')
                    ->orderBy('id','DESC')->get();
                */
                
                Log::info('AppraisalController@index: Found ' . $appraisals->count() . ' appraisals for evaluator ID: ' . $employeeId);
            }
                        
                  

            return DataTables::of($appraisals)
                ->setRowId(function ($row)
                {
                    return $row->id;
                })
                ->addIndexColumn()
                ->addColumn('company_name', function ($row)
                {
                    return $row->company->company_name ?? '' ;
                })
                ->addColumn('employee_name', function ($row)
                {
                    if ($row->employee) {
                        return $row->employee->first_name.' '.$row->employee->last_name;
                    }else {
                        return '';
                    }

                })
                ->addColumn('department_name', function ($row)
                {
                    return $row->department->department_name ?? '';
                })
                ->addColumn('designation_name', function ($row)
                {
                    return $row->designation->designation_name ?? '' ;
                })
                ->addColumn('date', function ($row)
                {
                    return date("d M, Y", strtotime($row->date));;
                })

                // ->addColumn('full_result', function ($row) {
                //     if (!$row->full_result) return '';
                
                //     $sections = json_decode($row->full_result, true);
                
                //     if (!is_array($sections)) return '';
                
                //     $sectionNames = array_column($sections, 'evaluator_id');
                
                //     return '' . implode(' / ', $sectionNames) . '';
                // })
                // ->rawColumns(['full_result'])


                ->addColumn('full_result', function ($row) {
                    if (!$row->full_result) return '';
                    
                    $sections = json_decode($row->full_result, true);
                    
                    if (!is_array($sections)) return '';
                    
                    // Extract evaluator_ids and convert to integers
                    $evaluatorIds = array_map('intval', 
                        array_filter(array_column($sections, 'evaluator_id'))
                    );
                    
                    $evaluators = \App\Models\Employee::whereIn('id', $evaluatorIds)
                        ->get()
                        ->keyBy('id');
                    
                    $names = [];
                    foreach ($sections as $section) {
                        if (!empty($section['evaluator_id'])) {
                            $evaluatorId = (int)$section['evaluator_id'];
                            $evaluator = $evaluators->get($evaluatorId);
                            
                            // Use evaluator name instead of ID
                            if ($evaluator) {
                                $names[] = $evaluator->first_name . ' ' . $evaluator->last_name;
                            } else {
                                // If evaluator is not found, check if we have evaluator_name in the section
                                if (!empty($section['evaluator_name'])) {
                                    $names[] = $section['evaluator_name'];
                                } else {
                                    $names[] = 'Unknown (' . $section['evaluator_id'] . ')';
                                }
                            }
                        } elseif (!empty($section['evaluator_name'])) {
                            // Directly use evaluator_name if available
                            $names[] = $section['evaluator_name'];
                        }
                    }
                    
                    return implode(' / ', $names);
                })
                ->rawColumns(['full_result'])



                ->addColumn('full_record', function ($row) {
                    if (!$row->full_result) return '';
                    
                    $sections = json_decode($row->full_result, true);
                    if (!is_array($sections)) return '';
                    
                    // Get all evaluator IDs
                    $evaluatorIds = [];
                    foreach ($sections as $section) {
                        if (!empty($section['evaluator_id'])) {
                            $evaluatorIds[] = (int)$section['evaluator_id'];
                        }
                    }
                    
                    // Fetch all evaluators in one query
                    $evaluators = \App\Models\Employee::whereIn('id', $evaluatorIds)
                        ->get()
                        ->keyBy('id');
                    
                    // Replace evaluator_id with evaluator_name in each section
                    foreach ($sections as $key => $section) {
                        if (!empty($section['evaluator_id'])) {
                            $evaluatorId = (int)$section['evaluator_id'];
                            $evaluator = $evaluators->get($evaluatorId);
                            
                            if ($evaluator) {
                                // Add evaluator_name field
                                $sections[$key]['evaluator_name'] = $evaluator->first_name . ' ' . $evaluator->last_name;
                            }
                        }
                    }
                    
                    // Add result and increment_expected to the first section (or create a summary section)
                    if (!empty($sections)) {
                        // Add the fields to the first section
                        $sections[0]['result'] = $row->result;
                        $sections[0]['Increment_expected'] = $row->Increment_expected;
                    }
                    
                    return $sections;
                })
                ->rawColumns(['full_record'])

                

               



                ->addColumn('action', function($row){
                    $userRole = auth()->user()->role_users_id;
                    $actionBtn = '';
                    if ($userRole == 1 || $userRole == 6) {
                        $actionBtn .= '<div class="d-flex flex-column align-items-center">';
                        $actionBtn .= '<a href="javascript:void(0)" name="view" data-id="'.$row->id.'" class="view btn btn-info btn-sm mb-1"><i class="fa fa-eye"></i></a>';
                        $actionBtn .= '<a href="javascript:void(0)" name="delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></a>';
                        $actionBtn .= '</div>';
                    }
                    return $actionBtn;
                })
                
                ->rawColumns(['action'])
                ->make(true);
               
        }
 

        $companies = Company::select('id','company_name')->get();
    
        $loggedUser = auth()->user();

        if (in_array($loggedUser->role_users_id, [1, 6])) {
            // Role 1 & 6: Get all employees with specific email
            $employee_data = Employee::where('email', '!=', 'faisalc@basepracticesupport.co.uk')->get();
        } elseif ($loggedUser->role_users_id == 4) {
            // Role 4: Fetch logged-in user
            $loggedUserData = Employee::find($loggedUser->id);

            // Fetch team members where logged user is team lead
            $teamMembers = Employee::where('team_lead', $loggedUser->id)->get();

            // Merge logged-in user with their team members
            $companyId = auth()->user()->company_id; // Assuming the logged-in user's company ID
            $employee_data = Employee::where('company_id', 9)
                        ->where('is_active', 1)
                        ->with(['designation', 'department']) // Include related data if needed
                        ->get()
                        ->filter(function ($employee) {
                            if (!$employee->last_appraisal_date) return true; // If never appraised, allow
                            $last = \Carbon\Carbon::parse($employee->last_appraisal_date);
                            return $last->diffInYears(now()) >= 1;
                        })->values();
            // $employee_data = collect([$loggedUserData])->merge($teamMembers);
        } else {
            // Default case: Empty collection
            $companyId = auth()->user()->company_id; // Assuming the logged-in user's company ID
            $employee_data = Employee::where('company_id', 9)
                        ->where('is_active', 1)
                        ->with(['designation', 'department']) // Include related data if needed
                        ->get()
                        ->filter(function ($employee) {
                            if (!$employee->last_appraisal_date) return true; // If never appraised, allow
                            $last = \Carbon\Carbon::parse($employee->last_appraisal_date);
                            return $last->diffInYears(now()) >= 1;
                        })->values();
        }


        $sectionArray=$this->getFormattedSectionData();
        $appraisalData = session('appraisal_data'); 

        $recordToBeIncremented = AppraisalSubmitController::getAppraisalsWithFullResultLength4();
        
        return view('performance.appraisal.index', compact('employee_data','companies', 'sectionArray','recordToBeIncremented'))->with([
            'success' => session('success'),
            'error' => session('error')
        ]);

    }





public function getEvaluatorNames($evaluateBy)
{
    // Normalize input: handle both JSON array string and single integer
    $employeeIds = is_array($evaluateBy) 
        ? $evaluateBy 
        : json_decode($evaluateBy, true);

    if (!is_array($employeeIds)) {
        $employeeIds = [$evaluateBy];
    }

    // Fetch all employees first
    $employees = Employee::whereIn('id', $employeeIds)
        ->get()
        ->keyBy('id'); // Index by ID for quick lookup
    
    // Map in original order
    $orderedNames = [];
    foreach ($employeeIds as $id) {
        if (isset($employees[$id])) {
            $employee = $employees[$id];
            $orderedNames[] = trim("{$employee->first_name} {$employee->last_name}");
        }
    }
    
    return $orderedNames;
}


function getFormattedSectionData()
{
// This function returns an array, not a Response object
$sectionArray = app(AppraisalSubmitController::class)->getYourSection();

if (!empty($sectionArray)) {
    foreach ($sectionArray as $key => $section) {
        if (isset($section['section']['evaluate_by'])) {
            // Get the evaluator IDs from the section
            $evaluateBy = $section['section']['evaluate_by'];
            
            // Use the getEvaluatorNames function to get the employee names
            $evaluatorNames = $this->getEvaluatorNames($evaluateBy);
            
            // Replace the IDs with the names in the result
            $sectionArray[$key]['section']['evaluate_by'] = $evaluatorNames;
        }
    }
    
    return $sectionArray;
}

return [];
}


    public function getEmployee(Request $request)
    {
        $employees = Employee::where('company_id',$request->company_id)
                    ->select('id','first_name','last_name')
                    ->where('is_active',1)->where('exit_date',NULL)
                    ->get();

        return response()->json(['employees' => $employees]);
    }

    public function store(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('store-appraisal'))
		{
            if ($request->ajax())
            {
                $validator = Validator::make($request->only('company_id','employee_id'),[
                    'company_id' => 'required',
                    'employee_id' => 'required'
                ]);

                if ($validator->fails())
                {
                    return response()->json(['errors' => "<h3>Please fill the required option</h3>"]);
                }

                $employee = Employee::find($request->employee_id);

                $appraisal                = new Appraisal();
                $appraisal->company_id    = $request->company_id;
                $appraisal->employee_id   = $request->employee_id;
                $appraisal->department_id = $employee->department_id;
                $appraisal->designation_id= $employee->designation_id;
                $appraisal->customer_experience = $request->customer_experience;
                $appraisal->marketing     = $request->marketing;
                $appraisal->administration= $request->administration;
                $appraisal->professionalism = $request->professionalism;
                $appraisal->integrity     = $request->integrity;
                $appraisal->attendance    = $request->attendance;
                $appraisal->remarks       = $request->remarks;
                $appraisal->date          = $request->date;
                $appraisal->save();

                return response()->json(['success' => '<p><b>Data Saved Successfully.</b></p>']);
            }
        }
    }

    public function edit(Request $request)
    {
        if ($request->ajax())
        {
            $appraisal = Appraisal::find($request->id);
            $employees = Employee::select('id','first_name','last_name')->where('company_id',$appraisal->company_id)->where('is_active',1)->where('exit_date',NULL)->get();

            return response()->json(['appraisal' => $appraisal, 'employees'=> $employees]);
        }
    }

    public function update(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('edit-appraisal'))
		{
            if ($request->ajax())
            {
                $appraisal = Appraisal::find($request->appraisal_id);
                $employee  = Employee::find($request->employee_id);

                $appraisal->company_id    = $request->company_id;
                $appraisal->employee_id   = $request->employee_id;
                $appraisal->department_id = $employee->department_id;
                $appraisal->designation_id= $employee->designation_id;
                $appraisal->date          = $request->date          ;
                $appraisal->customer_experience = $request->customer_experience;
                $appraisal->marketing     = $request->marketing;
                $appraisal->administration= $request->administration;
                $appraisal->professionalism = $request->professionalism;
                $appraisal->integrity     = $request->integrity;
                $appraisal->attendance    = $request->attendance;
                $appraisal->remarks       = $request->remarks;
                $appraisal->update();

                return response()->json(['success' => '<p><b>Data Updated Successfully.</b></p>']);
            }
        }
    }


    public function AppraisalIncrement(Request $request)
    {
        // Validate request data
        $request->validate([
            'id' => 'required|exists:appraisals,id',
            'increment_granted' => 'required|numeric|min:0',
        ]);
    
        // Find the appraisal record
        $appraisal = Appraisal::findOrFail($request->id);
    
        // Update increment_granted field
        $appraisal->increment_granted = $request->increment_granted;
        $appraisal->save();
    
        return response()->json(['success' => true, 'message' => 'Increment updated successfully!']);
    }
    

    public function delete(Request $request)
    {
        $logged_user = auth()->user();

        if ($logged_user->can('delete-appraisal'))
		{
            if ($request->ajax()) {
                $appraisal = Appraisal::find($request->appraisal_id);
                $appraisal->delete();

                return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
            }
        }
    }

    public function deleteCheckbox(Request $request)
    {
        if ($request->ajax())
        {
            $all_id   = $request->all_checkbox_id;
            $total_id = count($all_id);
            for ($i=0; $i < $total_id; $i++) {
                $data = Appraisal::find($all_id[$i]);
                $data->delete();
            }

            return response()->json(['success' => '<p><b>Data Deleted Successfully.</b></p>']);
        }
    }



    public static function setIncrement(Request $request){
        // Extract the IDs and increments from the request
        $ids = $request->input('id');
        $increments = $request->input('increment');

        // Ensure both arrays have the same length
        if (count($ids) !== count($increments)) {
            return response()->json(['error' => 'IDs and increments count mismatch'], 400);
        }

        // Loop through the IDs and update the corresponding records
        foreach ($ids as $index => $id) {
            Appraisal::where('id', $id)->update([
                'increment_granted' => $increments[$index]
            ]);
        }
        return redirect(route('performance.appraisal.index'));
    }



    public function sendNotificationToEvaluators(Request $request)
    {
        // Increase execution time limit
        set_time_limit(300); // 5 minutes
        
        Log::info('Starting sendNotificationToEvaluators function');
        Log::info('=============================================');
        Log::info('');
        
        // Get current date
        $currentDate = now();
        Log::info('Current date: ' . $currentDate);
        Log::info('');
        
        // Get all employees whose last appraisal date is 1 year or more ago
        $employees = Employee::whereNotNull('last_appraisal_date')
            ->where('is_active', 1)
            ->where('exit_date', null)
            ->get()
            ->filter(function ($employee) use ($currentDate) {
                $lastAppraisalDate = \Carbon\Carbon::parse($employee->last_appraisal_date);
                $diffInYears = $lastAppraisalDate->diffInYears($currentDate);
                Log::info("Employee {$employee->id} ({$employee->first_name} {$employee->last_name}):");
                Log::info("    Last appraisal: {$lastAppraisalDate}");
                Log::info("    Diff in years: {$diffInYears}");
                return $diffInYears >= 1;
            });

        Log::info('');
        Log::info('=============================================');
        Log::info("Found " . count($employees) . " eligible employees");
        Log::info('=============================================');
        Log::info('');

        // Process employees in batches to avoid timeout
        $batchSize = 3; // Reduced batch size
        $totalEmployees = count($employees);
        $processedCount = 0;
        $notificationsToSend = [];

        foreach ($employees->chunk($batchSize) as $employeeBatch) {
            foreach ($employeeBatch as $employee) {
                $processedCount++;
                Log::info('=============================================');
                Log::info("Processing employee {$processedCount}/{$totalEmployees}:");
                Log::info("    ID: {$employee->id}");
                Log::info("    Name: {$employee->first_name} {$employee->last_name}");
                Log::info('');
                
                // Get employee's designation name
                $designation = Designation::find($employee->designation_id);
                if (!$designation) {
                    Log::warning("    Designation not found for employee {$employee->id}");
                    Log::info('=============================================');
                    Log::info('');
                    continue;
                }
                Log::info("    Designation: {$designation->designation_name}");

                // Get appraisal sections for the employee's designation
                $appraisalSections = AppraisalSection::where('designation_ids', $employee->designation_id)
                    ->get();

                Log::info("    Found " . $appraisalSections->count() . " appraisal sections");
                Log::info("    Department: " . $employee->department->name);
                Log::info("  ");

                foreach ($appraisalSections as $section) {
                    Log::info("    Processing section: " . $section->name);

                    // Decode the JSON arrays
                    $departmentIds = json_decode($section->department_id, true);
                    $evaluatorIds = json_decode($section->evaluate_by, true);

                    // Convert employee's department_id to string for comparison
                    $employeeDeptId = (string)$employee->department_id;

                    // Find the index of the employee's department in the array
                    $deptIndex = array_search($employeeDeptId, $departmentIds);

                    if ($deptIndex === false) {
                        Log::info("    Employee's department " . $employeeDeptId . " not found in section's department list: " . json_encode($departmentIds));
                        continue;
                    }

                    // Get the evaluator ID using the same index
                    $evaluatorId = $evaluatorIds[$deptIndex];

                    // Get evaluator employee
                    $evaluator = Employee::where('id', $evaluatorId)
                        ->where('is_active', 1)
                        ->where('exit_date', null)
                        ->first();

                    if (!$evaluator) {
                        Log::warning("    Evaluator {$evaluatorId} not found or inactive");
                        continue;
                    }

                    Log::info("    Queueing notification:");
                    Log::info("        Evaluator: {$evaluator->first_name} {$evaluator->last_name}");
                    Log::info("        Employee: {$employee->first_name} {$employee->last_name}");
                    Log::info("        Section: {$section->name}");
                    Log::info('');
                    
                    $notificationsToSend[] = [
                        'evaluator' => $evaluator,
                        'employee_name' => $employee->first_name . ' ' . $employee->last_name,
                        'designation' => $designation->designation_name,
                        'department' => $employee->department->department_name,
                        'section' => $section->name
                    ];
                }
                Log::info('=============================================');
                Log::info('');
            }
        }

        Log::info('=============================================');
        Log::info('Sending notifications in batches');
        Log::info('=============================================');
        Log::info('');

        // Send notifications in batches using queue
        $notificationBatches = array_chunk($notificationsToSend, 5);
        foreach ($notificationBatches as $batchIndex => $batch) {
            Log::info("Processing batch " . ($batchIndex + 1) . " of " . count($notificationBatches));
            foreach ($batch as $notification) {
                try {
                    $notification['evaluator']->notify(new AppraisalEvaluatorNotification(
                        $notification['employee_name'],
                        $notification['designation'],
                        $notification['department'],
                        $notification['section']
                    ));
                    
                    // push notification
                    notifyUser($notification['evaluator']->id, 'Appraisal Pending', 'You have been assigned to evaluate');
                    Log::info("    Successfully queued notification for {$notification['evaluator']->first_name} {$notification['evaluator']->last_name}");
                } catch (\Exception $e) {
                    Log::error("    Failed to queue notification for {$notification['evaluator']->first_name} {$notification['evaluator']->last_name}: " . $e->getMessage());
                }
            }
            Log::info('');
            // Small delay between batches
            usleep(500000); // 0.5 second delay
        }

        Log::info('=============================================');
        Log::info('Completed queueing notifications');
        Log::info('=============================================');
        return response()->json(['message' => 'Notifications have been queued for sending']);
    }
}