<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLeaveTypeDetail;
use App\Models\leave;
use Illuminate\Http\Request;

class EmployeeLeaveTypeDetailController extends Controller
{
    public function index($employee)
	{
        if (request()->ajax())
        {
            // $data = EmployeeLeaveTypeDetail::where('employee_id',$employee)->get();

            $employeeLeaveTypeDetail = EmployeeLeaveTypeDetail::where('employee_id',$employee)->first();
            $leaveTypeUnserialize = [];

            if ($employeeLeaveTypeDetail) {
                $leaveTypeUnserialize = unserialize($employeeLeaveTypeDetail->leave_type_detail);
            }



            return datatables()->of($leaveTypeUnserialize)
                ->setRowId(function ($row)
                {
                    return $row['leave_type_id'];
                })
                ->addColumn('leave_type', function ($row)
                {
                    return $row['leave_type'];
                })
                ->addColumn('allocated_day', function ($row)
                {
                    $value = $row['allocated_day'] ?? 0;
                    // Return raw numeric value for JavaScript processing
                    return is_numeric($value) ? (float)$value : 0;
                })
                ->addColumn('remaining', function ($row)
                {
                    $value = $row['remaining_allocated_day'] ?? 0;
                    // Return raw numeric value for JavaScript processing
                    return is_numeric($value) ? (float)$value : 0;
                })
                ->addColumn('remaining_allocated_day', function ($row)
                {
                    // Add this column for compatibility with leave form JavaScript
                    $value = $row['remaining_allocated_day'] ?? 0;
                    return is_numeric($value) ? (float)$value : 0;
                })
                ->make(true);
        }
    }
}



// if ($employeeLeaveTypeDetail) {
//     $leaveTypeUnserialize = unserialize($employeeLeaveTypeDetail->leave_type_detail);

    // $remainingleaveTypeUnserialize = unserialize($employeeLeaveTypeDetail->leave_type_remaining);
    // for($i=0; $i< count($leaveTypeUnserialize) ; $i++) {
    //     $data[$i]['leave_type_id'] = $leaveTypeUnserialize[$i]['leave_type_id'];
    //     $data[$i]['leave_type'] = $leaveTypeUnserialize[$i]['leave_type'];
    //     $data[$i]['allocated_day'] = $leaveTypeUnserialize[$i]['allocated_day'];
    //     $data[$i]['remaining_allocated_day'] = $leaveTypeUnserialize[$i]['remaining_allocated_day'];
    // }
// }
