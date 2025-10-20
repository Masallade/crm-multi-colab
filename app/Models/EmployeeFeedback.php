<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeFeedback extends Model
{
    protected $table = "employee_appraisal_feedback";
        protected $fillable = [
            'employee_id',
            'name',
            'department',
            'reporting_manager',
            'position',
            'duration_of_appraisal',
            'joining_date',
            'clarity_expectations',
            'feasibility_goals',
            'fairness_evaluation',
            'feedback_frequency',
            'manager_support',
            'communication_effectiveness',
            'accessibility',
            'recognition',
            'achievements',
            'challenges',
            'professional_development',
            'self_assessment',
            'support_resources',
            'any_comment',
            'submission_status',
        ];
}
