<?php

namespace App\Http\Controllers;

use  App\Models\AppraisalSection;
use  App\Models\AppraisalSectionIndicator;
use Illuminate\Http\Request;
use App\Models\Appraisal;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AppraisalSubmitController extends Controller
{



    function submitEmployeeAppraisal(Request $request) {

      
        $data = $request->all();
    
        // Extract performance indicators
        $performanceIndicators = $data['performance_indicators'] ?? [];
    
        // Calculate total score
        $total = array_sum(array_map('intval', $performanceIndicators));
        $data['total'] = $total;
     
        // Get section weightage
        $sectionWeightage = isset($data['weightage']) ? intval($data['weightage']) : 100;
    
        // Determine max possible score dynamically
        $numIndicators = count($performanceIndicators);
        $maxScore = $numIndicators * 10; // Each indicator max is 10
    
        // Avoid division by zero
        $percentage = ($maxScore > 0) ? ($total / $maxScore) * $sectionWeightage : 0;
        $data['percentage'] = round($percentage, 2);
    
        // Fetch designation_id and department_id from Employee model
        $employee = Employee::getEmployeeDesDepartId($data['employee_id']);
    
        if (!$employee) {
            return redirect()->route("performance.appraisal.index")->with('error', 'Employee not found');
        }
    
        // Save appraisal using model function
        $appraisal = Appraisal::saveAppraisal($data, $employee->designation_id, $employee->department_id);
    
        // Extract message from response (assuming saveAppraisal returns JSON)
        $appraisalData = $appraisal->getData();
    
        // Store message properly in session
        if (isset($appraisalData->error)) {

            return redirect()->route("performance.appraisal.index")->with('error', $appraisalData->error);
        }

    
        return redirect()->route("performance.appraisal.index")->with('success', 'Appraisal saved successfully!');
    }
    
    
    




    function getUserRoleId()
    {
        // Get the currently authenticated user
        $user = auth()->user();
    
        // Check if a user is logged in
        if (!$user) {
            return 0;
        }
    
        // Return the role_users_id
        return $user->role_users_id;
    }


    function getYourSection_()
    {
        // Get the logged-in user's role ID
        $user = auth()->user();
        $employee = Employee::find($user->id);
        $roleId = $user->role_users_id; // Fetch role_users_id from the authenticated user
        $directorChecking=$employee->appraisal;
        $userDepartmentId = $employee->department_id;

        $normalizedSections = AppraisalSection::all()->map(function($section) {
            $evaluateBy = json_decode($section->evaluate_by, true);
            
            // If it's an associative array (like {"3":"251"}), extract just the values
            if (is_array($evaluateBy) && !array_is_list($evaluateBy)) {
                $section->evaluate_by = json_encode(array_values($evaluateBy));
            }
            // Otherwise, keep it as-is (already an array)
            
            return $section;
        });
        
    
        // Fetch sections assigned to this role (evaluator)
        // if($directorChecking==20){
        //     $appraisalSections = AppraisalSection::where('evaluate_by', $directorChecking)->get();
        // }else if($roleId == 4){


        //             // Fetch appraisal sections based on new conditions
        // $appraisalSections = AppraisalSection::where(function ($query) use ($roleId, $userDepartmentId) {
            
        //     // User ka apna department ka section dikhega
        //     $query->where('department_id', '=', $userDepartmentId)
        //           // Global-b sabko dikhana hai
        //           ->orWhere('department_id', 'global-b')
        //           // Global-a sirf unko dikhega jinka department match nahi karta
        //           ->orWhere(function ($subQuery) use ($userDepartmentId) {
        //               $subQuery->where('department_id', 'global-a')
        //                        ->where('department_id', '!=', $userDepartmentId);
        //           });
    
        // })->get();


        // }else{
            // $appraisalSections = AppraisalSection::where('evaluate_by', $roleId)->get();

        // }

            // Filter the normalized records
            $appraisalSections = $normalizedSections->filter(function($section) use ($roleId) {
                $evaluateBy = json_decode($section->evaluate_by, true);
                return in_array($roleId, $evaluateBy);
            });

    
        // If no sections are found, return an error response
        if ($appraisalSections->isEmpty()) {
            return response()->json(['message' => 'No sections found for this evaluator'], 404);
        }
    
        // Process each section and fetch its indicators
        $sectionsWithIndicators = [];
        foreach ($appraisalSections as $section) {
            $indicators = AppraisalSectionIndicator::getIndicatorsBySectionId($section->id);
            $sectionsWithIndicators[] = [
                'section' => $section,
                'indicators' => $indicators
            ];
        }

        
    
        return response()->json($sectionsWithIndicators);
    }

    
    // function getYourSection()
    // {
    //     // Get the logged-in user's role ID
    //     $user = auth()->user();
    //     $employee = Employee::find($user->id);
    //     $roleId = $user->role_users_id; // Fetch role_users_id from the authenticated user
    //     $directorChecking=$employee->appraisal;
    //     $userDepartmentId = $employee->department_id;
    // // dd($directorChecking);
    //     // Fetch sections assigned to this role (evaluator)
    //     if($directorChecking==1){
    //         $directorChecking = 20;
    //         $appraisalSections = AppraisalSection::where('evaluate_by', $directorChecking)->get();

    //         // dd($appraisalSections);
    //     }else if($roleId == 4){

    //     // Pehle check karo k appraisal_sections mn konsay department_id mojood hain
    //     $validDepartmentIds = AppraisalSection::distinct()->pluck('department_id')->toArray();

    //     $appraisalSections = AppraisalSection::where(function ($query) use ($userDepartmentId, $validDepartmentIds) {
    //         if (in_array($userDepartmentId, $validDepartmentIds)) {
    //             // Sirf wohi departments show hon jo appraisal_sections me mojood hain
    //             $query->where('department_id', $userDepartmentId)
    //                 ->orWhere('department_id', 'global-b');
    //         } else {
    //             // Jab department match *NA* kare, tabhi global-b aur global-a dikhna chahiye
    //             $query->where('department_id', 'global-b')
    //                 ->orWhere('department_id', 'global-a');
    //         }
    //     })->get();

            
            
            
    //         // dd($appraisalSections);

    //     }else{
    //         $appraisalSections = AppraisalSection::where('evaluate_by', $roleId)->get();
    //     }

    
    //     // If no sections are found, return an error response
    //     if ($appraisalSections->isEmpty()) {
    //         return response()->json(['message' => 'No sections found for this evaluator'], 404);
    //     }
    
    //     // dd($appraisalSections);
    //     // Process each section and fetch its indicators
    //     $sectionsWithIndicators = [];
    //     foreach ($appraisalSections as $section) {
    //         $indicators = AppraisalSectionIndicator::getIndicatorsBySectionId($section->id);
    //         $sectionsWithIndicators[] = [
    //             'section' => $section,
    //             'indicators' => $indicators
    //         ];
    //     }

        
    
    //     return response()->json($sectionsWithIndicators);
    // }




function getYourSection()
{
    // Get the logged-in user's info
    $user = auth()->user();
    $employee = Employee::find($user->id);
    $employeeId = $employee->id;
    
    // Get all sections where this employee might be an evaluator
    $appraisalSections = AppraisalSection::all();
    
    $yourSections = [];
    
    foreach ($appraisalSections as $section) {
        // Parse the JSON strings
        $evaluatorIds = json_decode($section->evaluate_by, true);
        $departmentIds = json_decode($section->department_id, true);
        
        // Make sure both are valid arrays
        if (!is_array($evaluatorIds) || !is_array($departmentIds)) {
            continue;
        }
        
        // Find all occurrences of the employee ID in the evaluator list
        $indexes = array_keys(array_filter($evaluatorIds, function($id) use ($employeeId) {
            return $id == $employeeId;
        }));
        
        // If employee is an evaluator for this section
        if (!empty($indexes)) {
            // Get indicators for this section
            $indicators = AppraisalSectionIndicator::getIndicatorsBySectionId($section->id);
            
            // Create an entry for each matching index
            foreach ($indexes as $index) {
                // Only add if there's a corresponding department ID
                if (isset($departmentIds[$index])) {
                    $deptId = $departmentIds[$index];
                    
                    // Query the departments table to get the department name
                    $department = Department::find($deptId);
                    $departmentName = $department ? $department->department_name : 'Unknown Department';

                    $designation = Designation::find($section->designation_ids);
                    $correspondingDesignationName = $designation ? $designation->designation_name : 'Unknown Designation';
 
                    $yourSections[] = [
                        'section' => $section,
                        'corresponding_department_id' => $deptId,
                        'corresponding_department_name' => $departmentName,
                        'corresponding_designation_name' =>$correspondingDesignationName,
                        'corresponding_designation_ids' => $section->designation_ids,
                        'indicators' => $indicators
                    ];
                }
            }
        }
    }
    
    return $yourSections;
}





























    public static function getAppraisalsWithFullResultLength4()
    {
        try {
            // Get initial records
            $recordToBeIncremented = Appraisal::getAppraisalsWithFullResultLength4();
            
            // Transform each record to add related data
            $transformedRecords = $recordToBeIncremented->map(function ($record) {
                // Get company data
                $company = DB::table('companies')
                    ->where('id', $record->company_id)
                    ->select('id', 'company_name')
                    ->first();
    
                // Get employee data
                $employee = DB::table('employees')
                    ->where('id', $record->employee_id)
                    ->select('id', 'first_name', 'last_name', 'department_id')
                    ->first();
    
                // Get department data
                $department = null;
                if ($employee && $employee->department_id) {
                    $department = DB::table('departments')
                        ->where('id', $employee->department_id)
                        ->select('id', 'department_name')
                        ->first();
                }
    
                // For debugging
            Log::info('Processing record:', [
                    'appraisal_id' => $record->id,
                    'company_data' => $company,
                    'employee_data' => $employee,
                    'department_data' => $department
                ]);
    
                // Add new fields to the record
                $record->company_name = $company ? $company->company_name : 'N/A';
                $record->full_name = $employee ? 
                    trim($employee->first_name . ' ' . $employee->last_name) : 'N/A';
                $record->department_name = $department ? 
                    $department->department_name : 'N/A';
    
                return $record;
            });
    
            // For debugging
            Log::info('Transformed records count: ' . $transformedRecords->count());
    
            // return view('performance.appraisal.set-increment', ['recordToBeIncremented' => $transformedRecords]);
            return $transformedRecords;
            
        } catch (\Exception $e) {
            Log::error('Error in getAppraisalsWithFullResultLength4: ' . $e->getMessage());
            return view('performance.appraisal.set-increment', ['recordToBeIncremented' => collect()]);
        }
    }

    
            

}