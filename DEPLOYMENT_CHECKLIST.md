# Leave System Fix + Calculator - Deployment Checklist

## Files to Upload to Server

### Modified Files (MUST UPLOAD)
- [ ] `app/Http/Controllers/EmployeeLeaveTypeDetailController.php`
- [ ] `app/Http/Controllers/Variables/EmployeeaddLeaveController.php`
- [ ] `resources/views/settings/variables/partials/addLeave_employee.blade.php` (NEW: Calculator UI)
- [ ] `resources/views/settings/variables/JS_DT/addEmployee_leave_js.blade.php` (NEW: Calculator Logic)

### New Files (MUST UPLOAD)
- [ ] `app/Console/Commands/DiagnoseLeaveData.php`
- [ ] `app/Console/Commands/RecalculateLeaveBalances.php`

### Documentation (OPTIONAL)
- [ ] `LEAVE_BALANCE_FIX.md`
- [ ] `LEAVE_SYSTEM_FILES.md`
- [ ] `LEAVE_CALCULATOR_FEATURE.md` (NEW)
- [ ] `DEPLOYMENT_CHECKLIST.md`
- [ ] `deploy_leave_fix.sh`

---

## Deployment Steps

### Before Deployment
- [ ] Backup the entire application
- [ ] Backup the database
- [ ] Note current server time for rollback reference

### Upload Files
- [ ] Upload modified controllers to `app/Http/Controllers/`
- [ ] Upload new commands to `app/Console/Commands/`
- [ ] Upload modified view files to `resources/views/settings/variables/`
- [ ] Set correct file permissions (644 for PHP files)

### On Server - Run Commands
```bash
# Navigate to application root
cd /path/to/your/application

# Clear all caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Optional: Run diagnostics
php artisan leave:diagnose

# Optional: Fix data if issues found
php artisan leave:recalculate --dry-run
php artisan leave:recalculate
```

### Testing
- [ ] Login to admin panel
- [ ] Go to Settings → Variables → Add Employee Leave
- [ ] **NEW: Test Calculator**
  - [ ] Calculator section displays at top of page
  - [ ] Enter shift time: 8 hours, 0 minutes
  - [ ] Enter work days: 12
  - [ ] Click Calculate button
  - [ ] Verify result shows: "4 Days, 0 Hours, 0 Minutes"
  - [ ] Verify explanation section displays calculation steps
- [ ] Verify table displays leave balances correctly
- [ ] Try updating a leave balance (change days/hours/minutes)
- [ ] Click Update button - should show success message
- [ ] Go to Timesheet → Leave
- [ ] Click "Add Leave" button
- [ ] Select an employee
- [ ] Verify dropdown shows correct leave balances in format: "Leave Type (X Days Y Hours Z Minutes)"
- [ ] Apply for a test leave
- [ ] Approve the leave
- [ ] Verify the balance deducts correctly

### Rollback Plan (If Issues Occur)
```bash
# Restore backup files
cp app/Http/Controllers/EmployeeLeaveTypeDetailController.php.backup app/Http/Controllers/EmployeeLeaveTypeDetailController.php
cp app/Http/Controllers/Variables/EmployeeaddLeaveController.php.backup app/Http/Controllers/Variables/EmployeeaddLeaveController.php
cp resources/views/settings/variables/partials/addLeave_employee.blade.php.backup resources/views/settings/variables/partials/addLeave_employee.blade.php
cp resources/views/settings/variables/JS_DT/addEmployee_leave_js.blade.php.backup resources/views/settings/variables/JS_DT/addEmployee_leave_js.blade.php

# Clear cache again
php artisan cache:clear
php artisan view:clear
```

---

## Quick Command Reference

### Diagnose leave data issues
```bash
# Check all employees
php artisan leave:diagnose

# Check specific employee
php artisan leave:diagnose 157
```

### Recalculate leave balances
```bash
# Preview changes (doesn't save)
php artisan leave:recalculate --dry-run

# Apply changes to all employees
php artisan leave:recalculate

# Apply changes to specific employee
php artisan leave:recalculate 157
```

---

## What Was Fixed & Added

### Issue #1: Leave Balance Display Inconsistency
**Problem:** Leave balances showing different values in dropdown vs table

**Solution:** 
- Fixed controller to return raw float values
- Removed debug line that prevented updates

### Feature #2: Leave Calculator (NEW)
**Purpose:** Convert work days (based on shift) to calendar days for data entry

**How it works:**
- Input: Employee shift time + number of work days
- Output: Calendar days/hours/minutes to enter in table
- Example: 8-hour shift × 12 work days = 4 calendar days

**Benefits:**
- Eliminates manual calculation errors
- Ensures consistent leave allocation
- Supports any shift duration

---

## Calculator Usage Example

**Scenario:** Employee works 8-hour shifts, entitled to 12 work days annual leave

**Steps:**
1. Go to Settings → Variables → Add Employee Leave
2. In calculator section:
   - Shift Time: 8 hours, 0 minutes
   - Work Days: 12
   - Click "Calculate"
3. Result: "4 Days, 0 Hours, 0 Minutes"
4. Enter this value in the table for that employee
5. Click "Update"

**Why 4 days?**
- 12 work days × 8 hours = 96 hours
- 96 hours ÷ 24 hours = 4 calendar days

---

## Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Run diagnostics: `php artisan leave:diagnose`
4. Restore from backup if needed

---

## Summary

**Total Files Modified:** 4  
**Total New Files:** 2  
**New Features:** 1 (Leave Calculator)  
**Database Changes:** None (data recalculation is optional)  
**Downtime Required:** None (just cache clear)  
**Risk Level:** Low (easy rollback available)
