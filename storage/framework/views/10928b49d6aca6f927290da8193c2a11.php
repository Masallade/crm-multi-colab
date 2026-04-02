$(document).ready(function () {
    // Leave type filter is populated from blade ($leaveTypes). DataTable loads from addLeave_employee.index (AJAX).
    function loadDataTable(leaveType = '') {
        $('#addLeave_employee-table').DataTable().clear().destroy();
        
        $('#addLeave_employee-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo e(route('addLeave_employee.index')); ?>",
                data: { leave_type: leaveType }
            },
            columns: [
                { data: 'employee_name', name: 'employee_name' },
                { data: 'leave_type', name: 'leave_type' },
                { data: 'allocated_day', name: 'allocated_day', orderable: false },
                { data: 'remaining_allocated_day', name: 'remaining_allocated_day', orderable: false }
            ],
            language: {
                lengthMenu: '_MENU_ <?php echo e(__("records per page")); ?>',
                info: '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
                search: '<?php echo e(trans("file.Search")); ?>',
                paginate: { previous: '<?php echo e(trans("file.Previous")); ?>', next: '<?php echo e(trans("file.Next")); ?>' }
            }
        });
    }

    // Initialize DataTable
    loadDataTable();

    // Filter Data on Leave Type Selection
    $('#leaveTypeFilter').on('change', function () {
        let leaveType = $(this).val();
        loadDataTable(leaveType);
    });

    // 📊 Leave Calculator
    $('#calculateLeaveBtn').on('click', function () {
        const MINUTES_PER_CALENDAR_DAY = 1440; // 24 hours

        // Get inputs
        let shiftHours = parseInt($('#calc_shift_hours').val(), 10) || 0;
        let shiftMinutes = parseInt($('#calc_shift_minutes').val(), 10) || 0;
        let workDays = parseFloat($('#calc_work_days').val()) || 0;

        // Validate inputs
        if (shiftHours === 0 && shiftMinutes === 0) {
            alert('<?php echo e(__("Please enter employee shift time")); ?>');
            return;
        }
        if (workDays <= 0) {
            alert('<?php echo e(__("Please enter number of work days")); ?>');
            return;
        }

        // Calculate shift duration in minutes
        let shiftMinutesTotal = shiftHours * 60 + shiftMinutes;

        // Calculate total work minutes
        let totalWorkMinutes = workDays * shiftMinutesTotal;

        // Convert to calendar days
        let totalCalendarDays = totalWorkMinutes / MINUTES_PER_CALENDAR_DAY;

        // Break down into Days, Hours, Minutes
        let days = Math.floor(totalCalendarDays);
        let remainingMinutes = Math.round((totalCalendarDays - days) * MINUTES_PER_CALENDAR_DAY);
        let hours = Math.floor(remainingMinutes / 60);
        let minutes = remainingMinutes % 60;

        // Display result
        let resultText = days + ' <?php echo e(__("Days")); ?>, ' + hours + ' <?php echo e(__("Hours")); ?>, ' + minutes + ' <?php echo e(__("Minutes")); ?>';
        $('#calc_result_text').html('<i class="fa fa-check-circle"></i> ' + resultText);
        $('#calc_result').removeClass('alert-info').addClass('alert-success');

        // Show explanation
        let explanation = '<ul class="mb-0">';
        explanation += '<li><?php echo e(__("Shift Duration")); ?>: ' + shiftHours + 'h ' + shiftMinutes + 'm = ' + shiftMinutesTotal + ' <?php echo e(__("minutes")); ?></li>';
        explanation += '<li><?php echo e(__("Work Days")); ?>: ' + workDays + ' <?php echo e(__("days")); ?></li>';
        explanation += '<li><?php echo e(__("Total Work Minutes")); ?>: ' + workDays + ' × ' + shiftMinutesTotal + ' = ' + totalWorkMinutes + ' <?php echo e(__("minutes")); ?></li>';
        explanation += '<li><?php echo e(__("Calendar Days")); ?>: ' + totalWorkMinutes + ' ÷ ' + MINUTES_PER_CALENDAR_DAY + ' = ' + totalCalendarDays.toFixed(4) + ' <?php echo e(__("days")); ?></li>';
        explanation += '<li><strong><?php echo e(__("Enter in table")); ?>: ' + days + ' <?php echo e(__("Days")); ?>, ' + hours + ' <?php echo e(__("Hours")); ?>, ' + minutes + ' <?php echo e(__("Minutes")); ?></strong></li>';
        explanation += '</ul>';
        
        $('#calc_explanation_text').html(explanation);
        $('#calc_explanation').slideDown(300);
    });

    // Reset calculator result when inputs change
    $('#calc_shift_hours, #calc_shift_minutes, #calc_work_days').on('change input', function() {
        $('#calc_result_text').text('<?php echo e(__("Click Calculate")); ?>');
        $('#calc_result').removeClass('alert-success').addClass('alert-info');
        $('#calc_explanation').slideUp(300);
    });

    // 🚀 Update Button: collect Days, Hours, Minutes per row and send to server (use same row for remaining to avoid wrong cell)
    $('#updateLeaveButton').on('click', function () {
        let updates = [];
        $('.allocated-dhm').each(function () {
            let $allocated = $(this);
            let $tableRow = $allocated.closest('tr');
            let employeeId = $allocated.data('employee-id');
            let leaveTypeId = $allocated.data('leave-type-id');
            let allocatedDays   = parseInt($allocated.find('.allocated-days').val(), 10) || 0;
            let allocatedHours  = parseInt($allocated.find('.allocated-hours').val(), 10) || 0;
            let allocatedMinutes = parseInt($allocated.find('.allocated-mins').val(), 10) || 0;
            let $remaining = $tableRow.find('.remaining-dhm');
            let remainingDays   = parseInt($remaining.find('.remaining-days').val(), 10) || 0;
            let remainingHours  = parseInt($remaining.find('.remaining-hours').val(), 10) || 0;
            let remainingMinutes = parseInt($remaining.find('.remaining-mins').val(), 10) || 0;

            updates.push({
                employee_id: employeeId,
                leave_type_id: leaveTypeId,
                allocated_days: allocatedDays,
                allocated_hours: allocatedHours,
                allocated_minutes: allocatedMinutes,
                remaining_days: remainingDays,
                remaining_hours: remainingHours,
                remaining_minutes: remainingMinutes
            });
        });

        $.ajax({
            url: '<?php echo e(route('addLeave_employee.update_leave')); ?>',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                updates: updates,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                alert(response.success);
                $('#addLeave_employee-table').DataTable().ajax.reload();
            },
            error: function(xhr) {
                console.error(xhr.responseJSON);
                var msg = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Update failed';
                alert(msg);
                $('#addLeave_employee-table').DataTable().ajax.reload();
            }
        });
    });
});



    
$('#leave_type_submit').on('click', function(event) {
event.preventDefault();
let addLeave_employee = $('input[name="addLeave_employee"]').val();
let allocated_day = $('input[name="allocated_day"]').val();

$.ajax({
url: "<?php echo e(route('addLeave_employee.store')); ?>",
method: "POST",
data: { addLeave_employee:addLeave_employee,allocated_day:allocated_day},
success: function (data) {
console.log(data);
var html = '';
if (data.errors) {
html = '<div class="alert alert-danger">';
    for (var count = 0; count < data.errors.length; count++) {
    html += '<p>' + data.errors[count] + '</p>';
    }
    html += '</div>';
}
if (data.success) {
html = '<div class="alert alert-success">' + data.success + '</div>';
$('#leave_type_form')[0].reset();
$('#addLeave_employee-table').DataTable().ajax.reload();
}
$('.leave_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.leave_edit', function(){
var id = $(this).attr('id');
$('.leave_result').html('');

var target = "<?php echo e(route('addLeave_employee.index')); ?>/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){
$('#leave_type_edit').val(html.data.addLeave_employee);
// Set select value - format to match option values (e.g., 12.0 -> 12.0, 12.5 -> 12.5)
var allocatedDay = parseFloat(html.data.allocated_day);
if (!isNaN(allocatedDay)) {
    $('#allocated_day_edit').val(allocatedDay.toFixed(1));
}

$('#hidden_leave_id').val(html.data.id);
$('#LeaveEditModal').modal('show');
}
})

});

$('#leave_type_edit_submit').on('click', function(event) {
event.preventDefault();
let leave_type_edit = $('input[name="leave_type_edit"]').val();
let allocated_day_edit = $('select[name="allocated_day_edit"]').val();
let hidden_leave_id= $('#hidden_leave_id').val();

$.ajax({
url: "<?php echo e(route('addLeave_employee.update')); ?>",
method: "POST",
data: { leave_type_edit:leave_type_edit,allocated_day_edit:allocated_day_edit,hidden_leave_id:hidden_leave_id},
success: function (data) {
console.log(data);

var html = '';
if (data.errors) {
html = '<div class="alert alert-danger">';
    for (var count = 0; count < data.errors.length; count++) {
    html += '<p>' + data.errors[count] + '</p>';
    }
    html += '</div>';
}
if (data.success) {
html = '<div class="alert alert-success">' + data.success + '</div>';
$('#leave_type_form_edit')[0].reset();
$('#addLeave_employee-table').DataTable().ajax.reload();
}
$('.leave_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
setTimeout(function(){
$('#LeaveEditModal').modal('hide')
}, 5000);

}
});

});



$(document).on('click', '.leave_delete', function() {

let delete_id = $(this).attr('id');
let target = "<?php echo e(route('addLeave_employee.index')); ?>/" + delete_id + '/delete';
if (confirm('<?php echo e(__('Are You Sure you want to delete this data')); ?>')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#addLeave_employee-table').DataTable().ajax.reload();
}, 2000);
$('.leave_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#leave_close').on('click', function() {
$('#leave_type_form')[0].reset();
$('#addLeave_employee-table').DataTable().ajax.reload();
});
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/urtasker_crm/resources/views/settings/variables/JS_DT/addEmployee_leave_js.blade.php ENDPATH**/ ?>