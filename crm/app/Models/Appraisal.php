<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Appraisal extends Model
{
    protected $fillable = [
        'company_id',
        'employee_id',
        'department_id',
        'designation_id',
        'customer_experience',
        'marketing',
        'administration',
        'professionalism',
        'integrity',
        'attendance',
        'remarks',
        'full_result',
        'result',
        'increment_granted',
        'Increment_expected',
        'date',
    ];

    public function company(){
      return $this->hasOne('App\Models\Company','id','company_id');
    }

    public function employee(){
      return $this->hasOne('App\Models\Employee','id','employee_id');
    }

    public function department(){
		  return $this->hasOne('App\Models\Department','id','department_id');
	  }

    public function designation(){
		  return $this->hasOne('App\Models\Designation','id','designation_id');
    }


    public static function saveAppraisal($data, $designationId, $departmentId)
    {

        try {
            // Store company_id and employee_id separately
            $companyId = $data['company_id'];
            $employeeId = $data['employee_id'];
    
            // Remove unwanted fields from full_result
            unset($data['company_id'], $data['employee_id'], $data['_token']);
    
            // Check if an appraisal already exists for this employee
            $existingAppraisal = self::where('employee_id', $employeeId)->first();
    
            if ($existingAppraisal) {
                // Decode existing full_result
                $existingData = json_decode($existingAppraisal->full_result, true) ?? [];
                
                // Check if the same section_name already exists
                foreach ($existingData as $entry) {
                    if ($entry['section_name'] === $data['section_name']) {
                        return response()->json(['error' => 'This section already exists in the appraisal'], 409);
                    }
                }
    
                // Append new data to full_result and update the existing record
                $existingData[] = $data;
                $existingAppraisal->update([
                    'full_result' => json_encode($existingData, JSON_PRETTY_PRINT),
                    'updated_at' => now(),
                ]);
    
                // Check if full_result has 3 elements, then update result column
               
                // Check if full_result has the required number of sections for this department
                $requiredSectionsCount = \DB::table('appraisal_sections')
                    ->whereRaw('JSON_CONTAINS(department_id, ?)', ['"'.$departmentId.'"'])
                    ->where('designation_ids', $designationId)
                    ->count();

                // Debug the query and values
                \Log::info('Department ID: ' . $departmentId);
                \Log::info('Designation ID: ' . $designationId);
                \Log::info('Required Sections Count: ' . $requiredSectionsCount);
                \Log::info('existing Data count' . count($existingData));

                
                // Check if we have any sections at all
                $totalSections = \DB::table('appraisal_sections')->count();
                \Log::info('Total Sections in table: ' . $totalSections);
                
                // If no sections found, set a default value
                if ($requiredSectionsCount === 0) {
                    $requiredSectionsCount = 1; // Default to 1 if no sections found
                }

                if (count($existingData) === $requiredSectionsCount) {
                $totalPercentage = array_sum(array_column($existingData, 'percentage'));

                $remarksPlusIncreExpected = ($totalPercentage > 0 && $totalPercentage <= 30) ? 5 :
                                        (($totalPercentage > 30 && $totalPercentage <= 50) ? 4 :
                                        (($totalPercentage > 50 && $totalPercentage <= 70) ? 3 :
                                        (($totalPercentage > 70 && $totalPercentage <= 89) ? 2 : 1)));

                $existingAppraisal->update([
                    'result' => $totalPercentage,
                    'Increment_expected' => $remarksPlusIncreExpected,
                    'remarks' => $remarksPlusIncreExpected,
                ]);
                }
    
                return response()->json(['success' => 'Appraisal updated successfully'], 200);
            } else {
                // Create a new appraisal record
                self::create([
                    'company_id' => $companyId,
                    'employee_id' => $employeeId,
                    'department_id' => $departmentId,
                    'designation_id' => $designationId,
                    'full_result' => json_encode([$data], JSON_PRETTY_PRINT),
                    'date' => $data['date'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
                return response()->json(['success' => 'Appraisal added successfully'], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    







  // In Appraisal model
  public static function getAppraisalsWithFullResultLength4()
  {
      return self::whereNotNull('full_result')
          ->get()
          ->filter(function ($appraisal) {
              try {
                  // Check if increment_granted is null
                  if ($appraisal->increment_granted !== null) {
                      return false;
                  }
  
                  // Decode the full_result and check its length
                  $fullResult = json_decode($appraisal->full_result, true);
                  return is_array($fullResult) && count($fullResult) === 4;
              } catch (\Exception $e) {
                  Log::error('Error decoding full_result for appraisal ID ' . $appraisal->id);
                  return false;
              }
          });
  }


}