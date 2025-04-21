<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppraisalSection;
use App\Models\AppraisalSectionIndicator;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;



class NewAppraisalController extends Controller
{
    /**
     * Handle new appraisal form submission.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNewAppraisalType(Request $request)
    {
        // Comment out or remove this line
        // return $request->all();
        
        // Validate incoming request

        $request->validate([
            'company_id' => 'required',
            'designation_ids' => 'required|array',
            'section_name' => 'required|array',
            'section_weightage' => 'required|array',
            'indicators' => 'required|array',
            'section_evaluators' => 'required|array'
        ]);

        try {
            \DB::beginTransaction();

            $sectionIdsArray = [];
            
            // For each designation, create all sections
            foreach ($request->designation_ids as $designationId) {
                // Create sections for this designation
                foreach ($request->section_name as $index => $sectionName) {
                    $section = new AppraisalSection();
                    $section->name = $sectionName;
                    $section->company_id = $request->company_id;
                    $section->weightage = $request->section_weightage[$index];
                    $section->designation_ids = $designationId;
                    
                    // Get departments for this designation
                    $departments = $request->departments[$designationId] ?? [];
                    $section->department_id = json_encode($departments);
                    
                    // Get section-specific evaluators for this designation's departments
                    $evaluators = [];
                    if (isset($request->section_evaluators[$index + 1][$designationId])) {
                        foreach ($departments as $deptId) {
                            if (isset($request->section_evaluators[$index + 1][$designationId][$deptId])) {
                                // Store only the evaluator IDs in a flat array, not as department_id => evaluator_id
                                $evaluators[] = $request->section_evaluators[$index + 1][$designationId][$deptId];
                            }
                        }
                    }
                    $section->evaluate_by = json_encode($evaluators);
                    
                    $section->save();
                    
                    // Store section ID for indicators
                    $sectionIdsArray[] = [
                        'section_id' => $section->id,
                        'indicators' => $request->indicators[$index + 1] // +1 because indicators array is 1-based
                    ];
                }
            }
            
            // Store indicators for all sections
            foreach ($sectionIdsArray as $sectionData) {
                foreach ($sectionData['indicators'] as $indicator) {
                    AppraisalSectionIndicator::create([
                        'section_id' => $sectionData['section_id'],
                        'name' => $indicator,
                        'weight' => null
                    ]);
                }
            }

            \DB::commit();
            return redirect()->route('variables.index')->with('success', 'Successfully Added New Appraisal Sections');
            
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }



    public function addDesignationNamesToSections($designationIds)
    {
        // Step 1: Handle null or empty values
        if (empty($designationIds)) {
            return '';
        }
    
        // Step 2: Try to decode as JSON
        if (is_string($designationIds)) {
            $decoded = json_decode($designationIds, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $designationIds = $decoded;
            } else {
                // Assume comma-separated string (e.g. "33,34,35")
                $designationIds = explode(',', $designationIds);
            }
        }
    
        // Step 3: If it's a single value like 33
        if (!is_array($designationIds)) {
            $designationIds = [$designationIds];
        }
    
        // Step 4: Cast all values to integers
        $designationIds = array_map('intval', $designationIds);
    
        // Step 5: Fetch designation names and return as comma-separated string
        return Designation::whereIn('id', $designationIds)
            ->pluck('designation_name')
            ->implode(', ');
    }


    public function getDepartmentNames($departmentIds)
        {
            // Decode if it's a JSON string (in case the input is a string representation of an array)
            $departmentIds = is_array($departmentIds) ? $departmentIds : json_decode($departmentIds, true);

            // Ensure it's an array
            if (!is_array($departmentIds)) {
                return []; // Return an empty array if decoding fails
            }

            // Fetch department names from the database
            return Department::whereIn('id', $departmentIds)
                ->pluck('department_name')
                ->toArray();
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

            

    

    
    
        public function viewAppraisal() 
        {
            $sections = AppraisalSection::getSectionsByCompanyId(9);
        
            foreach ($sections as $section) {
                $indicators = AppraisalSectionIndicator::getIndicatorsBySectionId($section->id);
                $section->performance_indicator = $indicators;
        
                $section->designation_name = $this->addDesignationNamesToSections($section->designation_ids);
                $section->department_names = $this->getDepartmentNames($section->department_id);
                $section->evaluator_names = $this->getEvaluatorNames($section->evaluate_by);

                // echo "<pre>";
                // print_r("-----------------------------");

                // print_r($section->department_names);
                // print_r($section->evaluate_by);
                // print_r($section->evaluator_names);

                // print_r("-----------------------------");

                // echo "<pre>";



            }
            
            
        
            return view('settings.variables.partials.view_appraisal', ["sections" => $sections]);
        }
        

    public function editAppraisalSection(Request $request)
    {
        $section = json_decode($request->input('section'), true);

        // Get all departments
        $departments = Department::all();
        
        // Get all active employees
        $employees = Employee::where('is_active', 1)->get();
        
        // Create a mapping of employees by department for the JavaScript filter
        $employeesByDepartment = [];
        foreach ($employees as $employee) {
            if ($employee->department_id) {
                if (!isset($employeesByDepartment[$employee->department_id])) {
                    $employeesByDepartment[$employee->department_id] = [];
                }
                $employeesByDepartment[$employee->department_id][] = $employee->id;
            }
        }
        
        // Pass the data to the view
        return view('settings.variables.partials.edit_appraisal_section', [
            'section' => $section,
            'departments' => $departments,
            'employees' => $employees,
            'employeesByDepartment' => $employeesByDepartment
        ]);
    }





    //currently this function will work for only the updation of each section with its indicators
    // linked wth AppraisalSection model and AppraisalSectionIndicator Model
    public function updateEditAppraisalSection(Request $request) {
        $data = $request->all();  // Get all request data
        $hasError = false;
        
        // Check if the request contains multiple sections
        if (isset($data['sections']) && is_array($data['sections'])) {
            foreach ($data['sections'] as $section) {
                $result = $this->updateSection($section);
                if ($result !== true) {
                    $hasError = true;
                }
            }
        } else {
            // Single section update
            $result = $this->updateSection($data);
            if ($result !== true) {
                $hasError = true;
            }
        }
        
        // Redirect with appropriate message
        if ($hasError) {
            return redirect()->route('variables.index')->with('error', 'An error occurred while updating appraisal sections');
        } else {
            return redirect()->route('variables.index')->with('success', 'Appraisal section updated successfully');
        }
    }
    
    private function updateSection($section) {
        // Basic section update (name and weightage)
        $sectionResponse = AppraisalSection::updateSection((int) $section['id'], $section['name'], (int)$section['weightage']);
        
        // Handle department-evaluator mapping
            // Update the mapping in the AppraisalSection model
            $appraisalSection = AppraisalSection::find($section['id']);
            if ($appraisalSection) {
                $appraisalSection->name = $section['name'];
                $appraisalSection->weightage = (int)$section['weightage'];
                $appraisalSection->department_id = $section['departments'];
                $appraisalSection->evaluate_by = $section['evaluators'];
                $appraisalSection->save();
            
        } elseif (isset($section['departments']) && isset($section['evaluators'])) {
            // If we're using the matrix interface with departments[] and evaluators[] arrays
            $mapping = [];
            
            // Create mapping from the parallel arrays (departments and evaluators)
            foreach ($section['departments'] as $index => $departmentId) {
                if (!empty($departmentId) && isset($section['evaluators'][$index]) && !empty($section['evaluators'][$index])) {
                    $mapping[$departmentId] = $section['evaluators'][$index];
                }
            }
            
            // Save the mapping
            $appraisalSection = AppraisalSection::find($section['id']);
            if ($appraisalSection) {
                $appraisalSection->save();
            }
        }
    
        // Handle performance indicators update
        if (isset($section["performance_indicator"]) && is_array($section["performance_indicator"])) {
            $indicatorResponse = AppraisalSectionIndicator::updateIndicatorsBySectionId($section["performance_indicator"], $section['id']);
    
            if ($sectionResponse['status'] !== 200 || $indicatorResponse['status'] !== 200) {
                return false;
            }
        } else if ($sectionResponse['status'] !== 200) {
            return false;
        }
    
        return true;
    }
    









    public function updateWholeAppraisal(Request $request)
    {
        $sections = json_decode($request->input('sections'), true);

        // Get all departments
        $departments = Department::all();
        
        // Get all active employees
        $employees = Employee::where('is_active', 1)->get();
        
        // Create a mapping of employees by department for the JavaScript filter
        $employeesByDepartment = [];
        foreach ($employees as $employee) {
            if ($employee->department_id) {
                if (!isset($employeesByDepartment[$employee->department_id])) {
                    $employeesByDepartment[$employee->department_id] = [];
                }
                $employeesByDepartment[$employee->department_id][] = $employee->id;
            }
        }
        
        // Pass the data to the view
        return view('settings.variables.partials.edit_appraisal_section', [
            'sections' => $sections,
            'departments' => $departments,
            'employees' => $employees,
            'employeesByDepartment' => $employeesByDepartment
        ]);
    }
    


    public function deleteAppraisal(Request $request)
{
    $sections = json_decode($request->input('sections'), true);

    try {
        DB::beginTransaction();

        foreach ($sections as $section) {
            $sectionId = $section['id'] ?? null;

            if (!$sectionId) {
                throw new \Exception("Invalid section ID found");
            }

            // Delete indicators
            AppraisalSectionIndicator::where('section_id', $sectionId)->delete();
            
            // Delete section
            $deleted = AppraisalSection::where('id', $sectionId)->delete();
            
            if (!$deleted) {
                throw new \Exception("Failed to delete section ID: $sectionId");
            }
        }

        DB::commit();
        return redirect()->route('variables.index')->with('success', "Deleted " . count($sections) . " appraisal sections");

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('variables.index')->with('error', 'An error occurred: ' . $e->getMessage());
    }
}
    
    
    


  
    

    
}