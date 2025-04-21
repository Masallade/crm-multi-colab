<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\Designation;
use App\Models\Role;
use App\Models\Role_User;
use App\Models\EmployeeFeedback;
use Illuminate\Support\Facades\Notification;
use App\Notifications\FeedbackReminderNotification;
use Carbon\Carbon;


if (!function_exists('employee_data')) {
    function employee_data($employee_id, $field)
    {
        // Fetch the employee record
        $employee = Employee::find($employee_id);

        if (!$employee) {
            return null; // Employee not found
        }

        // Handle different fields
        switch ($field) {
            case 'department':
                // Fetch the department name from the department table
                $department = Department::find($employee->department_id);
                return $department ? $department->department_name : null;

            case 'joining_date':
            return $employee ? $employee->joining_date : null;

            case 'team_lead':
                // Fetch the team_lead name from the Employee table
                $Employee = Employee::find($employee->team_lead);
                return $Employee ? $Employee->first_name.' '. $Employee->last_name: null;

            case 'team_lead_id':
                // Fetch the team_lead_id name from the Employee table
                $Employee = Employee::find($employee->team_lead);
                $Designation = Designation::find($Employee->designation_id);
                return $Designation ? $Designation->designation_name : null;

            case 'position':
                // Fetch the Designation name from the Designation table
                $Designation = Designation::find($employee->designation_id);
                return $Designation ? $Designation->designation_name : null;

            case 'last_appraisal_date':
                // Fetch the last_appraisal_date name from the last_appraisal_date table
                $last_appraisal_date = $employee->last_appraisal_date;
                return $last_appraisal_date ? $last_appraisal_date : null;

            case 'appraisal_status':
                // Fetch the appraisal_status name from the appraisal_status table
                $EmployeeFeedback = EmployeeFeedback::where('employee_id',$employee->id)->first();
                return $EmployeeFeedback ? $EmployeeFeedback->submission_status : null;

            // Add more cases for other fields if needed
            default:
                return null;
        }
    }
}



if (!function_exists('submission_status')) {
    function submission_status($employee_id)
    {
        // Fetch the employee's last appraisal date
        $lastAppraisalDate = employee_data($employee_id, 'last_appraisal_date');
       
        // Ensure lastAppraisalDate is not null
        if (!$lastAppraisalDate) {
            return 0; // No appraisal date, assume expired
        }

        // Convert to Carbon instance and remove time component
        $deadline = \Carbon\Carbon::parse($lastAppraisalDate)->addYear()->startOfDay();
        $today = now()->startOfDay(); // Remove time from today's date

        // Debugging: Check values
        \Log::info("Deadline: $deadline, Today: $today");

        // If today is before the deadline, return 0 (feedback expired)
        if ($today->greaterThanOrEqualTo($deadline)) {
            return 0;
        }

        // If today is equal to or after the deadline, allow feedback
        // return 1;

        
        // Check if feedback was submitted in the current appraisal cycle
        $EmployeeFeedback = EmployeeFeedback::where('employee_id', $employee_id)
            ->where('submission_status', 1)
            ->whereBetween('created_at', [$lastAppraisalDate, $deadline]) // Feedback must be within this cycle
            ->first();

        // Debugging: Log values to check
        \Log::info("Employee ID: $employee_id, Last Appraisal Date: $lastAppraisalDate, Deadline: $deadline, Today: $today, Feedback Found: " . ($EmployeeFeedback ? 'Yes' : 'No'));

        // Only return 1 if valid feedback exists
        return $EmployeeFeedback ? 1 : 0;
    }
}



if (!function_exists('check_feedback_email')) {
    function check_feedback_email($employee_id)
    {
        // Fetch employee details
        $employee = Employee::find($employee_id);

        // If employee record is not found, return
        if (!$employee) {
            return;
        }

        // Get last appraisal date and add one year
        $lastAppraisalDate = $employee->last_appraisal_date;
        $nextAppraisalDate = Carbon::parse($lastAppraisalDate)->addYear()->startOfDay();
        $today = now()->startOfDay();

        // If today is before the next appraisal date, do nothing
        if ($today->lessThan($nextAppraisalDate)) {
            return;
        }

        // Check if email has already been sent (appraisal_date_mail = 1)
        if ($employee->appraisal_date_mail == 1) {
            return;
        }

        // Add 1 year to the last appraisal date
        $nextAppraisalDate = Carbon::parse($employee->last_appraisal_date)->addYear();

        if ($employee->email) {
            Notification::route('mail', $employee->email)
                ->notify(new FeedbackReminderNotification(
                    $employee->name,
                    $nextAppraisalDate->format('Y-m-d') // Send the updated date
                ));
        }


        // Update the appraisal_date_mail to prevent duplicate emails
        $employee->update(['appraisal_date_mail' => 1]);

        \Log::info("Feedback reminder email sent to Employee ID: {$employee_id}");
    }



    if (!function_exists('notifyUser')) {
        function notifyUser($userId, $title, $body)
        {
            \Log::info("🔔 Notifying user ID $userId with title: $title");
        
            $tokens = \App\Models\PushNotificationToken::where('user_id', $userId)->pluck('token')->toArray();
            \Log::info("📱 Tokens found: ", $tokens);
        
            foreach ($tokens as $token) {
                \Log::info("➡️ Sending notification to: $token");
                app(\App\Services\FirebaseService::class)->sendNotification($token, $title, $body);
            }
        }
        
    }
    
}