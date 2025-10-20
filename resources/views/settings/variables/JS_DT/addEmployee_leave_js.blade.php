$(document).ready(function () {
    // Load Leave Types for Dropdown Filter
    $.ajax({
        url: "{{ route('addLeave_employee.index') }}",
        type: "GET",
        success: function (response) {
            let select = $('#leaveTypeFilter');
            select.append('<option value="">All Leaves</option>');
            response.leaveTypes.forEach(type => {
                select.append(`<option value="${type.leave_type}">${type.leave_type}</option>`);
            });
            select.selectpicker('refresh');
        }
    });

    function loadDataTable(leaveType = '') {
        $('#addLeave_employee-table').DataTable().clear().destroy();
        
        $('#addLeave_employee-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('addLeave_employee.index') }}",
                data: { leave_type: leaveType }
            },
            columns: [
                { data: 'employee_name', name: 'employee_name' },
                { data: 'leave_type', name: 'leave_type' },
                { data: 'allocated_day', name: 'allocated_day', orderable: false },
                { data: 'remaining_allocated_day', name: 'remaining_allocated_day', orderable: false }
            ],
            language: {
                lengthMenu: '_MENU_ {{__("records per page")}}',
                info: '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                search: '{{trans("file.Search")}}',
                paginate: { previous: '{{trans("file.Previous")}}', next: '{{trans("file.Next")}}' }
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

    // 🚀 Update Button Functionality
    $('#updateLeaveButton').on('click', function () {
        let updates = [];
        $('.allocated-day, .remaining-allocated-day').each(function () {
            let employeeId = $(this).data('employee-id');
            let leaveTypeId = $(this).data('leave-type-id');
            let allocatedDay = $('input.allocated-day[data-employee-id="' + employeeId + '"][data-leave-type-id="' + leaveTypeId + '"]').val();
            let remainingDay = $('input.remaining-allocated-day[data-employee-id="' + employeeId + '"][data-leave-type-id="' + leaveTypeId + '"]').val();

            updates.push({
                employee_id: employeeId,
                leave_type_id: leaveTypeId,
                allocated_day: allocatedDay,
                remaining_allocated_day: remainingDay
            });
        });

$.ajax({
    url: '{{ route('addLeave_employee.update_leave') }}',
    type: "POST",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
    },
    data: {
        updates: updates
    },
    success: function(response) {
        alert(response.success);
        $('#addLeave_employee-table').DataTable().ajax.reload(); // Reload DataTable after update
        location.reload();
    },
    error: function(xhr) {
        console.error(xhr.responseJSON);
        alert("Update failed: " + xhr.responseJSON.message);
        location.reload();
    }
});



    });
});



    
$('#leave_type_submit').on('click', function(event) {
event.preventDefault();
let addLeave_employee = $('input[name="addLeave_employee"]').val();
let allocated_day = $('input[name="allocated_day"]').val();

$.ajax({
url: "{{ route('addLeave_employee.store') }}",
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

var target = "{{ route('addLeave_employee.index') }}/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){
$('#leave_type_edit').val(html.data.addLeave_employee);
$('#allocated_day_edit').val(html.data.allocated_day);

$('#hidden_leave_id').val(html.data.id);
$('#LeaveEditModal').modal('show');
}
})

});

$('#leave_type_edit_submit').on('click', function(event) {
event.preventDefault();
let leave_type_edit = $('input[name="leave_type_edit"]').val();
let allocated_day_edit = $('input[name="allocated_day_edit"]').val();
let hidden_leave_id= $('#hidden_leave_id').val();

$.ajax({
url: "{{ route('addLeave_employee.update') }}",
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
let target = "{{ route('addLeave_employee.index') }}/" + delete_id + '/delete';
if (confirm('{{__('Are You Sure you want to delete this data')}}')) {
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
