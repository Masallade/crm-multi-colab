$('#leave_type-table').DataTable().clear().destroy();

var table_table = $('#leave_type-table').DataTable({
    initComplete: function () {
        this.api().columns([1]).every(function () {
            var column = this;
            var select = $('<select><option value=""></option></select>')
                .appendTo($(column.footer()).empty())
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });

            column.data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '">' + d + '</option>');
                $('select').selectpicker('refresh');
            });
        });
    },
    responsive: true,
    fixedHeader: {
        header: true,
        footer: true
    },
    processing: true,
    serverSide: true,
    ajax: {
        url: "<?php echo e(route('leave_type.index')); ?>",
    },
    columns: [
        {
            data: 'leave_type',
            name: 'leave_type',
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
    ],
    "order": [],
    'language': {
        'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
        "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
        "search": '<?php echo e(trans("file.Search")); ?>',
        'paginate': {
            'previous': '<?php echo e(trans("file.Previous")); ?>',
            'next': '<?php echo e(trans("file.Next")); ?>'
        }
    },
    'columnDefs': [
        {
            "orderable": false,
            'targets': [0, 1],
        },
    ],
        'select': {style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);



    
$('#leave_type_submit').on('click', function(event) {
event.preventDefault();
let leave_type = $('input[name="leave_type"]').val();
let allocated_day = $('input[name="allocated_day"]').val();

$.ajax({
url: "<?php echo e(route('leave_type.store')); ?>",
method: "POST",
data: { leave_type:leave_type,allocated_day:allocated_day},
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
$('#leave_type-table').DataTable().ajax.reload();
}
$('.leave_result').html(html).slideDown(300).delay(5000).slideUp(300);

}
});

});

$(document).on('click', '.leave_edit', function(){
var id = $(this).attr('id');
$('.leave_result').html('');

var target = "<?php echo e(route('leave_type.index')); ?>/"+id+'/edit';
$.ajax({
url:target,
dataType:"json",
success:function(html){
$('#leave_type_edit').val(html.data.leave_type);
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
    let hidden_leave_id = $('#hidden_leave_id').val();

    $.ajax({
        url: "<?php echo e(route('leave_type.update')); ?>",
        method: "POST",
        data: { 
            leave_type_edit: leave_type_edit, 
            allocated_day_edit: allocated_day_edit, 
            hidden_leave_id: hidden_leave_id 
        },
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
                
                // ✅ Reload the whole page
                setTimeout(function(){
                    location.reload();
                }, 2000); // Page will reload after 2 seconds
            }

            $('.leave_result_edit').html(html).slideDown(300).delay(3000).slideUp(300);
        }
    });
});



$(document).on('click', '.leave_delete', function() {

let delete_id = $(this).attr('id');
let target = "<?php echo e(route('leave_type.index')); ?>/" + delete_id + '/delete';
if (confirm('<?php echo e(__('Are You Sure you want to delete this data')); ?>')) {
$.ajax({
url: target,
success: function (data) {
var html = '';
html = '<div class="alert alert-success">' + data.success + '</div>';
setTimeout(function () {
$('#leave_type-table').DataTable().ajax.reload();
}, 2000);
$('.leave_result').html(html).slideDown(300).delay(3000).slideUp(300);

}
})
}

});

$('#leave_close').on('click', function() {
$('#leave_type_form')[0].reset();
$('#leave_type-table').DataTable().ajax.reload();
});
<?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/settings/variables/JS_DT/leave_type_js.blade.php ENDPATH**/ ?>