# Leave System - Complete File List

This document lists ALL files related to the leave management system that were modified or are relevant for deployment.

## Files Modified in This Fix

### 1. Controllers (3 files)
```
app/Http/Controllers/EmployeeLeaveTypeDetailController.php
app/Http/Controllers/Variables/EmployeeaddLeaveController.php
app/Http/Controllers/LeaveController.php
```

### 2. New Console Commands (2 files)
```
app/Console/Commands/DiagnoseLeaveData.php
app/Console/Commands/RecalculateLeaveBalances.php
```

### 3. Documentation (2 files)
```
LEAVE_BALANCE_FIX.md
LEAVE_SYSTEM_FILES.md (this file)
```

---

## Complete Leave System Files (For Reference)

### Models (3 files)
```
app/Models/leave.php                          - Main leave model
app/Models/LeaveType.php                      - Leave type model (Sick, Annual, etc.)
app/Models/EmployeeLeaveTypeDetail.php        - Employee leave balance storage
```

### Controllers (5 files)
```
app/Http/Controllers/LeaveController.php                      - Main leave CRUD operations
app/Http/Controllers/EmployeeLeaveController.php              - Employee-specific leave operations
app/Http/Controllers/EmployeeLeaveTypeDetailController.php    - Leave balance display (MODIFIED)
app/Http/Controllers/Variables/LeaveTypeController.php        - Leave type management
app/Http/Controllers/Variables/EmployeeaddLeaveController.php - Add/update employee leave (MODIFIED)
```

### Traits (2 files)
```
app/Http/traits/LeaveTypeDataManageTrait.php  - Shared leave calculation logic
app/Http/traits/CalendarableModelTrait.php    - Calendar integration for leaves
```

### Views - Main Leave Management (1 file)
```
resources/views/timesheet/leave/index.blade.php - Main leave management page (list, add, edit, approve)
```

### Views - Employee Dashboard Leave (2 files)
```
resources/views/employee/leave/index.blade.php     - Employee leave list
resources/views/employee/leave/index_js.blade.php  - JavaScript for employee leave
```

### Views - Employee Remaining Leave (3 files)
```
resources/views/employee/remaining_leave/index.blade.php           - Remaining leave display
resources/views/employee/remaining_leave/index_js.blade.php        - JavaScript for remaining leave
resources/views/employee/remaining_leave/tt_index_js_0.blade copy.php - Backup/old version
```

### Views - Dashboard (2 files)
```
resources/views/dashboard/employee_dashboard.blade.php - Employee dashboard with leave info
resources/views/dashboard/dashboard.blade.php          - Main dashboard
```

### Views - Settings/Variables (3 files)
```
resources/views/settings/variables/index.blade.php                  - Variables management page
resources/views/settings/variables/partials/addLeave_employee.blade.php - Add employee leave form
resources/views/settings/variables/JS_DT/addEmployee_leave_js.blade.php - JavaScript for add employee leave
```

### Views - Calendar (1 file)
```
resources/views/calendarable/leave.blade.php - Calendar view for leaves
```

### Routes (2 files)
```
routes/web.php                  - Main routes (non-tenant)
saasinapp/routes/tenant.php     - Tenant-specific routes
```

### Migrations (4 files)
```
database/migrations/primary/2023_05_06_053282_create_leave_types_table.php
database/migrations/primary/2023_05_06_053283_create_leaves_table.php
database/migrations/primary/2023_05_06_053238_create_employee_leave_type_details_table.php
database/migrations/modify/2026_03_03_000001_change_leaves_total_days_to_minutes.php
```

### JavaScript Files (2 files)
```
public/js/employee/remaining_leave/index.js
saasinapp/public/js/employee/remaining_leave/index.js
```

---

## Deployment Checklist

### Step 1: Backup Current Files
Before deploying, backup these critical files on the server:
```bash
# Backup controllers
cp app/Http/Controllers/EmployeeLeaveTypeDetailController.php app/Http/Controllers/EmployeeLeaveTypeDetailController.php.backup
cp app/Http/Controllers/Variables/EmployeeaddLeaveController.php app/Http/Controllers/Variables/EmployeeaddLeaveController.php.backup

# Backup views (if modified)
cp resources/views/timesheet/leave/index.blade.php resources/views/timesheet/leave/index.blade.php.backup
```

### Step 2: Upload Modified Files
Upload these files to the server:
1. `app/Http/Controllers/EmployeeLeaveTypeDetailController.php`
2. `app/Http/Controllers/Variables/EmployeeaddLeaveController.php`
3. `app/Console/Commands/DiagnoseLeaveData.php` (NEW)
4. `app/Console/Commands/RecalculateLeaveBalances.php` (NEW)

### Step 3: Clear Cache
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

### Step 4: Run Diagnostics (Optional but Recommended)
```bash
# Check for data issues
php artisan leave:diagnose

# Fix any data inconsistencies (dry run first)
php artisan leave:recalculate --dry-run

# Apply fixes if needed
php artisan leave:recalculate
```

### Step 5: Test
1. Go to Settings → Variables → Add Employee Leave
2. Verify leave balances display correctly
3. Try updating leave balances
4. Go to Timesheet → Leave
5. Apply for leave and verify dropdown shows correct balances
6. Approve a leave and verify it deducts correctly

---

## Key Changes Summary

### EmployeeLeaveTypeDetailController.php
- Changed `allocated_day` and `remaining` columns to return raw float values instead of formatted strings
- Added `remaining_allocated_day` column for JavaScript compatibility

### EmployeeaddLeaveController.php
- Removed debug line that was preventing updates from saving
- Uses MINUTES_PER_CALENDAR_DAY = 1440 (24 hours)

### New Commands
- `DiagnoseLeaveData.php` - Diagnose leave data inconsistencies
- `RecalculateLeaveBalances.php` - Recalculate and fix leave balances

---

## Database Tables

### leaves
- Stores individual leave applications
- `total_days` column stores leave duration in MINUTES (1 day = 1440 minutes)

### leave_types
- Stores leave type definitions (Sick Leave, Annual Leave, etc.)
- `allocated_day` stores default allocation as decimal days

### employee_leave_type_details
- Stores each employee's leave balances
- `leave_type_detail` column stores serialized array with:
  - `leave_type_id`
  - `leave_type`
  - `allocated_day` (decimal)
  - `remaining_allocated_day` (decimal)

---

## Important Constants

### Minutes Per Day
- **Calendar Day**: 1440 minutes (24 hours)
- **Work Day**: Varies by employee shift (typically 480 minutes = 8 hours)

Currently the system uses 1440 minutes (calendar day) for all calculations.

---

## Notes for Future Development

If you need to implement the work-day calculation (using shift hours instead of 24 hours):
1. Need to store employee shift duration in database
2. Modify `LeaveTypeDataManageTrait.php` to use shift duration
3. Update `EmployeeaddLeaveController.php` to use shift duration for partial days
4. Update views to display work days vs calendar days

---

## Support Files

### Documentation
- `LEAVE_BALANCE_FIX.md` - Detailed fix documentation
- `LEAVE_DECIMAL_REVIEW.md` - Decimal leave implementation review
- `HANDOFF_TOTAL_DAYS_LEAVE_FORM.md` - Leave form implementation details

### Related Features
- Payslip generation uses leave data
- Calendar integration displays approved leaves
- Dashboard shows leave statistics
- Notifications sent for leave approvals/rejections
