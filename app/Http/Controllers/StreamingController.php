<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StreamingController extends Controller
{
    public function index(Request $request)
    {
        // First, get the employee IDs whose last attendance record has off_desk_hours = 0
        $employeeIdsWithValidAttendance = DB::table('attendances as a1')
            ->join(DB::raw('(
                SELECT employee_id, MAX(attendance_date) as max_date
                FROM attendances
                GROUP BY employee_id
            ) as a2'), function($join) {
                $join->on('a1.employee_id', '=', 'a2.employee_id')
                    ->on('a1.attendance_date', '=', 'a2.max_date');
            })
            ->where('a1.off_desk_hours', 0)
            ->pluck('a1.employee_id');

        // Now get employees with these IDs
        $query = Employee::select('id', 'first_name', 'last_name', 'staff_id')
            ->whereIn('id', $employeeIdsWithValidAttendance)
            ->orderBy('first_name');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('staff_id', 'like', "%$search%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        }

        $employees = $query->get();

        $statusFilter = $request->input('status', '');
        $now = Carbon::now();
        $employeeData = $employees->map(function ($employee) use ($now) {
            $latestAttendance = Attendance::where('employee_id', $employee->id)
                ->orderByDesc('attendance_date')
                ->orderByDesc('id')
                ->first();

            $status = 'Inactive';
            $clockUp = $latestAttendance ? $latestAttendance->clock_up : null;
            $clockUpFormatted = $clockUp ? Carbon::parse($clockUp)->format('Y-m-d h:i:s A') : 'N/A';
            if ($clockUp) {
                $clockUpCarbon = Carbon::parse($clockUp);
                if ($clockUpCarbon->greaterThanOrEqualTo($now->copy()->subMinutes(5)) && $clockUpCarbon->lessThanOrEqualTo($now)) {
                    $status = 'Active';
                }
            }
            return [
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'staff_id' => $employee->staff_id,
                'employee_id' => $employee->id,
                'clock_up' => $clockUpFormatted,
                'status' => $status,
            ];
        });

        // Filter by status if requested
        if (in_array($statusFilter, ['Active', 'Inactive'])) {
            $employeeData = $employeeData->where('status', $statusFilter)->values();
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('streaming._employee_grid', ['employees' => $employeeData])->render()
            ]);
        }

        return view('streaming.index', [
            'employees' => $employeeData,
            'search' => $request->input('search', ''),
            'status' => $statusFilter,
        ]);
    }

    public function updateStreamStatus(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'staff_id' => 'required'
            ]);

            \Log::info('Starting stream status update', [
                'staff_id' => $request->staff_id,
                'headers' => $request->headers->all(),
                'all_data' => $request->all()
            ]);

            $employee = Employee::where('staff_id', $request->staff_id)->firstOrFail();
            \Log::info('Found employee', [
                'employee_id' => $employee->id,
                'staff_id' => $request->staff_id,
                'name' => $employee->first_name . ' ' . $employee->last_name
            ]);
            
            // Get the latest attendance record
            $attendance = Attendance::where('employee_id', $employee->id)
                ->orderByDesc('attendance_date')
                ->orderByDesc('id')
                ->first();
                
            if (!$attendance) {
                \Log::error('No attendance record found', [
                    'employee_id' => $employee->id,
                    'staff_id' => $request->staff_id
                ]);
                return response()->json(['error' => 'No attendance record found'], 404);
            }

            \Log::info('Found attendance record', [
                'attendance_id' => $attendance->id,
                'employee_id' => $employee->id,
                'attendance_date' => $attendance->attendance_date,
                'current_should_stream' => $attendance->should_stream
            ]);

            // Check if we're stopping the stream
            $shouldStream = $request->header('X-Stream-Action') !== 'stop';
            
            \Log::info('Calculated new stream status', [
                'should_stream' => $shouldStream,
                'X-Stream-Action' => $request->header('X-Stream-Action')
            ]);

            // Update the should_stream status
            $oldValue = $attendance->should_stream;
            $attendance->should_stream = $shouldStream;
            $saved = $attendance->save();

            \Log::info('Attendance update attempt completed', [
                'attendance_id' => $attendance->id,
                'old_value' => $oldValue,
                'new_value' => $shouldStream,
                'save_success' => $saved,
                'final_db_value' => Attendance::find($attendance->id)->should_stream
            ]);

            if (!$saved) {
                \Log::error('Failed to save attendance record', [
                    'attendance_id' => $attendance->id,
                    'employee_id' => $employee->id,
                    'staff_id' => $request->staff_id
                ]);
                return response()->json(['error' => 'Failed to save attendance record'], 500);
            }

            return response()->json(['success' => true, 'should_stream' => $shouldStream]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error', [
                'errors' => $e->errors(),
            ]);
            return response()->json(['error' => 'Invalid request data', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating stream status', [
                'staff_id' => $request->staff_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to update stream status'], 500);
        }
    }

    public function resetAllStreamStatus()
    {
        try {
            \Log::info('Starting reset of all stream statuses');
            
            // Get count before update
            $countBefore = Attendance::where('should_stream', 1)->count();
            \Log::info('Records to be reset', ['count' => $countBefore]);

            // Reset all should_stream values to 0 where they are currently 1
            $updated = Attendance::where('should_stream', 1)->update(['should_stream' => 0]);
            
            // Get count after update
            $countAfter = Attendance::where('should_stream', 1)->count();
            
            \Log::info('Reset stream status completed', [
                'records_before' => $countBefore,
                'records_updated' => $updated,
                'records_remaining' => $countAfter
            ]);

            return response()->json(['success' => true, 'records_updated' => $updated]);
        } catch (\Exception $e) {
            \Log::error('Error resetting stream status', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to reset stream status'], 500);
        }
    }

    public function getImageData()
    {
        try {
            // Define the path to the image.txt file
            $imagePath = public_path("streaming/image.txt");
            
            // Check if the file exists
            if (!file_exists($imagePath)) {
                return response()->json(['error' => 'Image not found'], 404);
            }
            
            // Read the base64 data from the file
            $base64Data = file_get_contents($imagePath);
            
            if (empty($base64Data)) {
                return response()->json(['error' => 'No image data available'], 404);
            }
            
            // Return the base64 data as plain text
            return response($base64Data, 200)
                ->header('Content-Type', 'text/plain');
                
        } catch (\Exception $e) {
            \Log::error('Error fetching image data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return response()->json(['error' => 'Failed to fetch image data'], 500);
        }
    }
} 