# Database Tables & Changes - Leave System

## 📊 DATABASE TABLES RELATED TO LEAVES

### Total: 3 Tables

---

## 1. `leave_types` Table
**Purpose:** Stores leave type definitions (Sick Leave, Annual Leave, etc.)

### Columns:
| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| leave_type | varchar(50) | Leave type name (e.g., "Annual Leave") |
| allocated_day | integer/decimal | Default days allocated per year |
| company_id | bigint (FK) | Foreign key to companies table |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### Foreign Keys:
- `company_id` → `companies.id` (CASCADE on delete)

### Example Data:
```
id | leave_type    | allocated_day | company_id
1  | Sick Leave    | 8             | 1
2  | Annual Leave  | 17            | 1
3  | Casual Leave  | 0             | 1
```

---

## 2. `leaves` Table
**Purpose:** Stores individual leave applications/records

### Columns:
| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| leave_type_id | bigint (FK) | Foreign key to leave_types |
| company_id | bigint (FK) | Foreign key to companies |
| department_id | bigint (FK) | Foreign key to departments |
| employee_id | bigint (FK) | Foreign key to employees |
| start_date | date | Leave start date |
| end_date | date | Leave end date |
| total_days | integer | Leave duration in MINUTES (1 day = 1440 min) |
| leave_reason | text | Reason for leave |
| remarks | varchar(191) | Admin remarks |
| status | varchar(40) | Status: pending/approved/rejected |
| is_notify | boolean | Notification sent flag |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### Foreign Keys:
- `company_id` → `companies.id` (CASCADE on delete)
- `department_id` → `departments.id` (CASCADE on delete)
- `employee_id` → `employees.id` (SET NULL on delete)
- `leave_type_id` → `leave_types.id` (SET NULL on delete)

### Important Note:
**`total_days` column stores leave duration in MINUTES, not days!**
- 1 calendar day = 1440 minutes (24 hours)
- Example: 3.5 days = 5040 minutes

### Example Data:
```
id | employee_id | leave_type_id | start_date | end_date   | total_days | status
1  | 157         | 2             | 2025-03-10 | 2025-03-12 | 4320       | approved
2  | 158         | 1             | 2025-03-15 | 2025-03-15 | 1440       | pending
```

---

## 3. `employee_leave_type_details` Table
**Purpose:** Stores each employee's leave balance for each leave type

### Columns:
| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| employee_id | bigint (FK) | Foreign key to employees |
| leave_type_detail | longtext | Serialized array of leave balances |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

### Foreign Keys:
- `employee_id` → `employees.id` (CASCADE on delete)

### Data Structure (Serialized):
The `leave_type_detail` column stores a PHP serialized array:
```php
[
    [
        'leave_type_id' => 1,
        'leave_type' => 'Sick Leave',
        'allocated_day' => 8.0,
        'remaining_allocated_day' => 6.5
    ],
    [
        'leave_type_id' => 2,
        'leave_type' => 'Annual Leave',
        'allocated_day' => 17.0,
        'remaining_allocated_day' => 12.0
    ]
]
```

### Example Data:
```
id | employee_id | leave_type_detail (serialized array)
1  | 157         | a:2:{i:0;a:4:{s:13:"leave_type_id";i:1;...}}
2  | 158         | a:2:{i:0;a:4:{s:13:"leave_type_id";i:1;...}}
```

---

## 🔧 DATABASE CHANGES MADE

### Summary: **ZERO DATABASE CHANGES**

**No migrations were created or modified.**  
**No table structure changes.**  
**No column additions or modifications.**

---

## 📝 CODE CHANGES MADE

### Total Changes: **6 Files Modified/Created**

### 1. Controllers (2 files modified)

#### File: `app/Http/Controllers/EmployeeLeaveTypeDetailController.php`
**Changes:**
- Modified `allocated_day` column to return raw float instead of formatted string
- Modified `remaining` column to return raw float instead of formatted string
- Added `remaining_allocated_day` column for JavaScript compatibility

**Before:**
```php
->addColumn('remaining', function ($row) {
    $value = $row['remaining_allocated_day'] ?? 0;
    return is_numeric($value) ? number_format((float)$value, 1, '.', '') : $value;
})
```

**After:**
```php
->addColumn('remaining', function ($row) {
    $value = $row['remaining_allocated_day'] ?? 0;
    return is_numeric($value) ? (float)$value : 0;
})
->addColumn('remaining_allocated_day', function ($row) {
    $value = $row['remaining_allocated_day'] ?? 0;
    return is_numeric($value) ? (float)$value : 0;
})
```

**Impact:** Fixes dropdown display issue in leave application form

---

#### File: `app/Http/Controllers/Variables/EmployeeaddLeaveController.php`
**Changes:**
- Removed debug line that was preventing updates from saving

**Before:**
```php
$leaveDetails = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);
return response()->json($leaveDetails); // ← This was causing early return

foreach ($leaveDetails as &$leave) {
    // Update logic never executed
}
```

**After:**
```php
$leaveDetails = unserialize($employee->employeeLeaveTypeDetail->leave_type_detail);

foreach ($leaveDetails as &$leave) {
    // Update logic now executes properly
}
```

**Impact:** Fixes update functionality on Add Employee Leave page

---

### 2. Views (2 files modified)

#### File: `resources/views/settings/variables/partials/addLeave_employee.blade.php`
**Changes:**
- Added calculator UI section (60+ lines)
- Added input fields for shift time and work days
- Added calculate button
- Added result display area
- Added explanation section

**Impact:** Adds leave calculator feature to the page

---

#### File: `resources/views/settings/variables/JS_DT/addEmployee_leave_js.blade.php`
**Changes:**
- Added calculator JavaScript functionality (50+ lines)
- Added calculation logic (work days → calendar days)
- Added input validation
- Added result display and explanation
- Added reset functionality when inputs change

**Impact:** Makes calculator functional

---

### 3. Console Commands (2 files created)

#### File: `app/Console/Commands/DiagnoseLeaveData.php`
**Purpose:** Diagnostic tool to check for leave data inconsistencies

**Features:**
- Compares stored remaining leave vs calculated remaining leave
- Shows allocated, remaining, and taken leave for each employee
- Highlights mismatches
- Can check all employees or specific employee

**Usage:**
```bash
php artisan leave:diagnose
php artisan leave:diagnose 157
```

**Impact:** Helps identify data corruption issues

---

#### File: `app/Console/Commands/RecalculateLeaveBalances.php`
**Purpose:** Fix tool to recalculate and correct leave balances

**Features:**
- Recalculates remaining leave based on approved leaves
- Supports dry-run mode (preview without saving)
- Can fix all employees or specific employee
- Uses database transactions for safety

**Usage:**
```bash
php artisan leave:recalculate --dry-run
php artisan leave:recalculate
php artisan leave:recalculate 157
```

**Impact:** Fixes data inconsistencies

---

## 📊 CHANGE SUMMARY

### Database Changes
| Category | Count | Details |
|----------|-------|---------|
| Tables Modified | 0 | No table structure changes |
| Columns Added | 0 | No new columns |
| Columns Modified | 0 | No column type changes |
| Migrations Created | 0 | No new migrations |
| **Total Database Changes** | **0** | **No database changes** |

### Code Changes
| Category | Count | Details |
|----------|-------|---------|
| Controllers Modified | 2 | EmployeeLeaveTypeDetailController, EmployeeaddLeaveController |
| Views Modified | 2 | addLeave_employee.blade.php, addEmployee_leave_js.blade.php |
| Commands Created | 2 | DiagnoseLeaveData, RecalculateLeaveBalances |
| Models Modified | 0 | No model changes |
| Routes Modified | 0 | No route changes |
| **Total Code Changes** | **6** | **6 files modified/created** |

---

## 🎯 WHAT EACH CHANGE DOES

### Change #1: Fix Leave Balance Display
**Problem:** Dropdown showed "3 Days 12 Hours" while table showed "12 Days"  
**Solution:** Return raw float values instead of formatted strings  
**Files:** EmployeeLeaveTypeDetailController.php  
**Database Impact:** None - only changes how data is returned

### Change #2: Fix Update Functionality
**Problem:** Update button didn't save changes  
**Solution:** Removed debug line causing early return  
**Files:** EmployeeaddLeaveController.php  
**Database Impact:** None - only fixes save logic

### Change #3: Add Leave Calculator
**Problem:** Manual calculation of work days → calendar days is error-prone  
**Solution:** Added calculator tool on the page  
**Files:** addLeave_employee.blade.php, addEmployee_leave_js.blade.php  
**Database Impact:** None - UI feature only

### Change #4: Add Diagnostic Tools
**Problem:** No way to check for data inconsistencies  
**Solution:** Created artisan commands for diagnosis and fixing  
**Files:** DiagnoseLeaveData.php, RecalculateLeaveBalances.php  
**Database Impact:** RecalculateLeaveBalances can update data (optional)

---

## 🔍 DATA INTEGRITY

### How Leave Data is Stored

1. **Leave Types** (`leave_types` table)
   - Stores default allocation as decimal days
   - Example: 17.0 days

2. **Employee Balances** (`employee_leave_type_details` table)
   - Stores allocated and remaining as decimal days in serialized array
   - Example: allocated_day = 17.0, remaining_allocated_day = 12.0

3. **Leave Applications** (`leaves` table)
   - Stores duration in MINUTES (not days!)
   - Example: 3 days = 4320 minutes (3 × 1440)

### Calculation Flow

1. Employee applies for leave → Duration stored in minutes
2. Leave approved → Minutes deducted from remaining balance
3. Remaining balance = Allocated - (Total approved minutes ÷ 1440)

---

## ⚠️ IMPORTANT NOTES

### No Database Migration Required
- All changes are code-only
- No need to run migrations
- Existing data structure unchanged
- Safe to deploy without database backup (but always backup anyway!)

### Data Recalculation (Optional)
- If you have data inconsistencies, run: `php artisan leave:recalculate`
- This updates existing records in `employee_leave_type_details` table
- Always run with `--dry-run` first to preview changes

### Backward Compatibility
- All changes are backward compatible
- Existing data continues to work
- No breaking changes

---

## 📋 DEPLOYMENT CHECKLIST

- [ ] No database migrations to run
- [ ] Upload 6 modified/new files
- [ ] Clear cache: `php artisan cache:clear`
- [ ] Clear views: `php artisan view:clear`
- [ ] Test calculator functionality
- [ ] Test leave balance updates
- [ ] Optional: Run `php artisan leave:diagnose`
- [ ] Optional: Run `php artisan leave:recalculate` if issues found

---

## 🎉 SUMMARY

**Database Tables:** 3 tables (leave_types, leaves, employee_leave_type_details)  
**Database Changes:** 0 changes  
**Code Changes:** 6 files  
**Migration Required:** No  
**Data Loss Risk:** None  
**Rollback Difficulty:** Easy (just restore 6 files)  
**Testing Required:** Yes (functional testing only)

---

**Version:** 1.0  
**Date:** March 2026  
**Impact Level:** Low (code-only changes)
