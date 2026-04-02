# Leave Calculator Feature - Documentation

## Overview

A calculator tool has been added to the "Add Employee Leave" page to help convert work days (based on employee shift duration) into calendar days (24 hours) for proper data entry.

## The Problem It Solves

The system stores leave balances in **calendar days** (24 hours = 1440 minutes), but employees work **shift days** (e.g., 8 hours = 480 minutes). When allocating "12 days of annual leave", it should represent 12 work days (12 × 8 hours = 96 hours), not 12 × 24 hours (288 hours).

Without the calculator, admins would need to manually calculate the conversion, which is error-prone.

## How It Works

### Input Fields:
1. **Employee Shift Time**: Hours and Minutes (e.g., 8 hours, 0 minutes)
2. **Number of Work Days**: How many work days to allocate (e.g., 12 days)

### Calculation Process:
1. Convert shift time to minutes: `shift_minutes = hours × 60 + minutes`
2. Calculate total work minutes: `total_work_minutes = work_days × shift_minutes`
3. Convert to calendar days: `calendar_days = total_work_minutes ÷ 1440`
4. Break down into Days, Hours, Minutes for display

### Output:
The calculator shows the exact values to enter in the table's Days/Hours/Minutes dropdowns.

## Examples

### Example 1: Standard 8-hour shift, 12 work days

**Input:**
- Shift Time: 8 hours, 0 minutes
- Work Days: 12 days

**Calculation:**
- Shift duration: 8 × 60 = 480 minutes
- Total work minutes: 12 × 480 = 5,760 minutes
- Calendar days: 5,760 ÷ 1,440 = 4.0 days

**Output:** Enter **4 Days, 0 Hours, 0 Minutes** in the table

---

### Example 2: 8.5-hour shift, 10 work days

**Input:**
- Shift Time: 8 hours, 30 minutes
- Work Days: 10 days

**Calculation:**
- Shift duration: 8 × 60 + 30 = 510 minutes
- Total work minutes: 10 × 510 = 5,100 minutes
- Calendar days: 5,100 ÷ 1,440 = 3.541666... days
- Breakdown: 3 days + 0.541666 × 1440 = 3 days + 780 minutes = 3 days, 13 hours, 0 minutes

**Output:** Enter **3 Days, 13 Hours, 0 Minutes** in the table

---

### Example 3: 9-hour shift, 15 work days

**Input:**
- Shift Time: 9 hours, 0 minutes
- Work Days: 15 days

**Calculation:**
- Shift duration: 9 × 60 = 540 minutes
- Total work minutes: 15 × 540 = 8,100 minutes
- Calendar days: 8,100 ÷ 1,440 = 5.625 days
- Breakdown: 5 days + 0.625 × 1440 = 5 days + 900 minutes = 5 days, 15 hours, 0 minutes

**Output:** Enter **5 Days, 15 Hours, 0 Minutes** in the table

---

### Example 4: Part-time 4-hour shift, 20 work days

**Input:**
- Shift Time: 4 hours, 0 minutes
- Work Days: 20 days

**Calculation:**
- Shift duration: 4 × 60 = 240 minutes
- Total work minutes: 20 × 240 = 4,800 minutes
- Calendar days: 4,800 ÷ 1,440 = 3.333... days
- Breakdown: 3 days + 0.333 × 1440 = 3 days + 480 minutes = 3 days, 8 hours, 0 minutes

**Output:** Enter **3 Days, 8 Hours, 0 Minutes** in the table

## User Interface

### Location
Settings → Variables → Add Employee Leave (top of the page, above the table)

### Layout
```
┌─────────────────────────────────────────────────────────────────────┐
│  🧮 Leave Calculator (Convert Work Days to Calendar Days)           │
├─────────────────────────────────────────────────────────────────────┤
│  Employee Shift Time:  [8▼] Hours  [0▼] Minutes                    │
│  Number of Work Days:  [12        ]                                 │
│  [Calculate Button]                                                 │
│                                                                      │
│  Result (Enter in Table):                                           │
│  ✓ 4 Days, 0 Hours, 0 Minutes                                      │
│                                                                      │
│  Calculation:                                                        │
│  • Shift Duration: 8h 0m = 480 minutes                             │
│  • Work Days: 12 days                                               │
│  • Total Work Minutes: 12 × 480 = 5,760 minutes                    │
│  • Calendar Days: 5,760 ÷ 1,440 = 4.0000 days                      │
│  • Enter in table: 4 Days, 0 Hours, 0 Minutes                      │
└─────────────────────────────────────────────────────────────────────┘
```

## Files Modified

### View Files (2 files)
1. `resources/views/settings/variables/partials/addLeave_employee.blade.php`
   - Added calculator UI section with input fields and result display

2. `resources/views/settings/variables/JS_DT/addEmployee_leave_js.blade.php`
   - Added calculator JavaScript functionality
   - Calculation logic
   - Input validation
   - Result display and explanation

## Technical Details

### Constants
- **MINUTES_PER_CALENDAR_DAY**: 1440 (24 hours × 60 minutes)

### Calculation Formula
```javascript
shift_minutes = shift_hours × 60 + shift_minutes
total_work_minutes = work_days × shift_minutes
calendar_days = total_work_minutes ÷ 1440

// Break down into D/H/M
days = floor(calendar_days)
remaining_minutes = (calendar_days - days) × 1440
hours = floor(remaining_minutes ÷ 60)
minutes = remaining_minutes % 60
```

### Input Validation
- Shift time cannot be 0 hours and 0 minutes
- Work days must be greater than 0
- All inputs must be numeric

### Features
- Real-time calculation on button click
- Detailed explanation of calculation steps
- Result resets when inputs change
- Responsive design
- Supports decimal work days (e.g., 12.5 days)

## Usage Instructions

### For Administrators:

1. **Navigate to the page:**
   - Go to Settings → Variables
   - Click on "Add Employee Leave" tab

2. **Use the calculator:**
   - Enter the employee's shift time (e.g., 8 hours, 0 minutes)
   - Enter the number of work days to allocate (e.g., 12)
   - Click "Calculate" button

3. **Read the result:**
   - The calculator shows: "4 Days, 0 Hours, 0 Minutes"
   - This is what you should enter in the table

4. **Enter in the table:**
   - Find the employee row
   - In "Days Per Year" column: Select 4 Days, 0 Hours, 0 Minutes
   - In "Remaining" column: Select 4 Days, 0 Hours, 0 Minutes (initially same as allocated)
   - Click "Update" button

5. **Verify:**
   - The leave balance is now correctly stored
   - When employee applies for leave, it will deduct correctly

## Common Scenarios

### Scenario 1: New Employee Setup
- Employee works 8-hour shifts
- Company policy: 12 days annual leave per year
- Use calculator: 8h 0m shift × 12 days = 4 Days, 0 Hours, 0 Minutes
- Enter this value in both "Days Per Year" and "Remaining" columns

### Scenario 2: Mid-Year Adjustment
- Employee's shift changed from 8 hours to 9 hours
- Need to recalculate remaining leave
- Use calculator with new shift time
- Update only the "Remaining" column

### Scenario 3: Part-Time Employee
- Employee works 4-hour shifts
- Entitled to 10 work days leave
- Use calculator: 4h 0m shift × 10 days = 1 Day, 16 Hours, 40 Minutes
- Enter this value in the table

## Benefits

1. **Accuracy**: Eliminates manual calculation errors
2. **Transparency**: Shows detailed calculation steps
3. **Flexibility**: Supports any shift duration
4. **Ease of Use**: Simple interface with clear instructions
5. **Consistency**: Ensures all leave allocations follow the same logic

## Future Enhancements (Optional)

1. Store employee shift duration in database
2. Auto-populate shift time based on selected employee
3. Bulk calculation for multiple employees
4. Export calculation results
5. Integration with payroll system

## Testing Checklist

- [ ] Calculator displays correctly on the page
- [ ] Shift time dropdowns work (hours 0-12, minutes 0-59)
- [ ] Work days input accepts decimal values
- [ ] Calculate button performs calculation
- [ ] Result displays in correct format
- [ ] Explanation section shows detailed steps
- [ ] Input validation works (prevents 0 shift time)
- [ ] Result resets when inputs change
- [ ] Calculator works on different screen sizes
- [ ] No JavaScript errors in console

## Support

If you encounter issues:
1. Check browser console for JavaScript errors
2. Verify jQuery is loaded
3. Clear browser cache
4. Test with different browsers
5. Check Laravel logs for server-side errors

---

**Version:** 1.0  
**Date:** March 2026  
**Author:** Leave System Enhancement
