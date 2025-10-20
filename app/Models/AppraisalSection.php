<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AppraisalSection extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'name', 'weightage','evaluate_by','department_id','designation_ids'];

    public function indicators()
    {
        return $this->hasMany(AppraisalSectionIndicator::class);
    }

    public function appraisal()
    {
        return $this->belongsTo(Appraisal::class);
    }

    /**
     * Insert sections with indicators.
     *
     * @param array $data
     * @return void
     */
    public static function insertSectionsWithIndicators(array $data)
    {
        foreach ($data['section_name'] as $index => $sectionName) {
            // Create the section
            var_dump('hello 1');

            try {
                $section = self::create([
                    'company_id'   => $data['company_id'],
                    'name'         => $sectionName,
                ]);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            // Create related indicators for the section
           

            try {
                foreach ($data['indicators'][$index] as $indicatorName) {
                    $section->indicators()->create(['name' => $indicatorName]);
                }
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
            var_dump('hello 3');

        }
    }


    public static function storeSections(Request $request)
    {
        $sections = [];
        $insertedIds = [];

        foreach ($request->section_name as $index => $sectionName) {
            $roleKey = $index;
            
            $section = AppraisalSection::create([
                'company_id' => $request->company_id,
                'name' => $sectionName,
                'department_id' => json_encode($request->department_ids),
                'designation_ids' => $request->designation_ids,
                'weightage' => intval($request->section_weightage[$index]),
                'evaluate_by' => json_encode($request->employees[$roleKey]), // store as JSON array
            ]);
            ;

            $sections[] = $section;
            $insertedIds[] = $section->id;
        }

        return $insertedIds;
    } 

    public static function getSectionsByCompanyId($companyId)
    {
        return AppraisalSection::where('company_id', $companyId)->get();
    }




    

    // this function is created and will use for updating the Appraisal section
    // called in the NewAppraisalController.php 
    public static function updateSection($id, $name, $weightage) {

        // Convert id and evaluate_by to integers
        $id = (int) $id;
        $weightage= (int) $weightage;
        // $evaluate_by = (int) $evaluate_by;

        // Find the record by ID
        $appraisalSection = self::find($id);
        
        if (!$appraisalSection) {
            return ['message' => 'Record not found', 'status' => 404];
        }

        // Update the record
        $appraisalSection->update([
            'name' => $name,
            'weightage' => $weightage,
        ]);

        return ['status' => 200];
    }
}