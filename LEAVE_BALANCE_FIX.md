# Leave Balance Display Issue - Fix Documentation

## Problem Summary

The leave balances are showing different values in two places:
1. **Dropdown** (Leave Application Form): Shows "Annual Leave (3 Days 12 Hours 0 Minutes)"
2. **Table** (Add Employee Leave): Shows "12 Days" in the Days Per Year column

## Root Cause

The issue was in `app/Http/Controllers/EmployeeLeaveTypeDetailController.php`:

1. The controller was formatting decimal values as strings using `number_format()` (e.g., "12.0")
2. The JavaScript in the leave application form expects raw numeric values to convert them to Days/Hours/Minutes format
3. When the JavaScript received "12.0" as a string, it may have been parsing it incorrectly or there was corrupted data in the database showing 3.5 instead of 12

## Fix Applied

### 1. Controller Fix

**File:** `app/Http/Controllers/EmployeeLeaveTypeDetailController.php`

**Changes:**
- Changed `allocated_day` column to return raw float values instead of formatted strings
- Changed `remaining` column to return raw float values instead of formatted strings  
- Added `remaining_allocated_day` column for compatibility with the leave form JavaScript

**Before:**
```php
->addColumn('remaining', function ($row)
{
    $value = $row['remaining_allocated_day'] ?? 0;
    return is_numeric($value) ? number_format((float)$value, 1, '.', '') : $value;
})
```

**After:**
```php
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
```

### 2. Diagnostic Tools

Created two artisan commands to help diagnose and fix data issues:

#### Diagnose Leave Data
```bash
php artisan leave:diagnose [employee_id]
```

This command will:
- Show allocated days, stored remaining days, and calculated remaining days
- Highlight any mismatches between stored and calculated values
- Help identify data corruption issues

#### Recalculate Leave Balances
```bash
# Dry run (preview changes without saving)
php artisan leave:recalculate --dry-run

# Recalculate for all employees
php artisan leave:recalculate

# Recalculate for specific employee
php artisan leave:recalculate 157
```

This command will:
- Recalculate remaining leave balances based on approved leaves in the database
- Fix any discrepancies between stored and actual values
- Can be run in dry-run mode to preview changes first

## How to Verify the Fix

1. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

2. **Run diagnostics:**
   ```bash
   php artisan leave:diagnose
   ```

3. **If data issues are found, recalculate:**
   ```bash
   # Preview changes first
   php artisan leave:recalculate --dry-run
   
   # Apply fixes
   php artisan leave:recalculate
   ```

4. **Test in browser:**
   - Go to the leave application form
   - Select an employee
   - Verify the dropdown shows correct leave balances
   - Go to Settings → Variables → Add Employee Leave
   - Verify the table shows the same values

## Expected Behavior After Fix

For an employee with 12 days of Annual Leave remaining:
- **Dropdown:** "Annual Leave (12 Days 0 Hours 0 Minutes)"
- **Table:** Days column shows "12", Hours shows "0", Minutes shows "0"

Both should now display the same value consistently.

## Technical Details

### Data Storage Format
- Leave balances are stored as serialized arrays in `employee_leave_type_details.leave_type_detail`
- Each leave type has: `allocated_day` and `remaining_allocated_day` as decimal values
- Approved leaves are stored in `leaves.total_days` as minutes (1 day = 1440 minutes)

### Conversion Logic
- 1 calendar day = 1440 minutes (24 hours)
- JavaScript converts decimal days to Days/Hours/Minutes for display
- Example: 3.5 days = 3 days + 12 hours (3.5 × 1440 = 5040 minutes = 3 days × 1440 + 12 hours × 60)

## Files Modified

1. `app/Http/Controllers/EmployeeLeaveTypeDetailController.php` - Fixed data format
2. `app/Console/Commands/DiagnoseLeaveData.php` - New diagnostic command
3. `app/Console/Commands/RecalculateLeaveBalances.php` - New fix command

## Notes

- The fix ensures consistent data format between the controller and JavaScript
- If you still see discrepancies after applying the fix, run the recalculate command
- The diagnostic command can be used anytime to verify data integrity
