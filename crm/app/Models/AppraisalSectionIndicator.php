<?php

namespace App\Models;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalSectionIndicator extends Model
{
    protected $table = 'appraisal_section_indicators';
    protected $fillable = ['section_id', 'name', 'weight'];

    public static function storeIndicators(array $insertedIds, Request $request)
    {
        $indicatorsData = [];
        foreach ($insertedIds as $index => $sectionId) {
            if (!isset($request->indicators[$index]) || !is_array($request->indicators[$index])) {
                continue; // Skip if no indicators exist for this section
            }


            foreach ($request->indicators[$index] as $indicatorName) {
                $indicatorsData[] = [
                    'section_id' => $sectionId,
                    'name' => $indicatorName, // Directly store the name from the array
                    'weight' => null, // No weight provided in the data
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }


        }

        // Insert all indicators in bulk
        self::insert($indicatorsData);

        return response()->json([
            'message' => 'Indicators stored successfully',
            'data' => $indicatorsData
        ], 201);
    }

    public static function getIndicatorsBySectionId($sectionId)
    {
        return self::where('section_id', $sectionId)->get();
    }



    public static function updateIndicatorsBySectionId($indicatorList, $sectionID)
{
    // Delete all existing indicators for the given section
    self::where('section_id', $sectionID)->delete();

    // Insert new indicators
    foreach ($indicatorList as $indicator) {
        self::create([
            'section_id' => $sectionID, 
            'name' => $indicator['name']
        ]);
    }

    return ['status' => 200, 'message' => 'Indicators updated successfully'];
}

}