<?php $__env->startSection('content'); ?>
<section>
    <div class="container-fluid"><span id="general_result"></span></div>

    <div class="container-fluid mb-3">
        <h4 class="font-weight-bold mt-3"><?php echo app('translator')->get('file.Performance Appraisal'); ?></h4>
        <div id="success_alert" role="alert"></div>
        <br>
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>


        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModalForm"><i class="fa fa-plus"></i><?php echo e(__('file.Add New')); ?></button>
        <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i><?php echo e(__('file.Bulk Delete')); ?></button>
        <!-- Button to trigger the modal -->
        <button type="button" class="btn btn-info" id="setIncrementButton" data-toggle="modal" data-target="#setIncrementModal">
            <i class="fa fa-set"></i> <?php echo e(__('Set Increment')); ?>

        </button>
    </div>

    <div class="table-responsive">
        <table id="appraisalTable" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th>Result</th>
                    <th>Increment Expected</th>
                    <?php if(auth()->user()->role_users_id ==6): ?>
                    <th>Increment Granted</th>
                    <?php endif; ?>
                    <th>Remarks</th>
                    <th>Evaluated by</th>
                    <th><?php echo app('translator')->get('file.Appraisal Date'); ?></th>
                    <th class="not-exported">
                        <?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
        </table>
    </div>
</section>


<?php echo $__env->make('performance.appraisal.create-modal',['sectionData' => $sectionArray], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.appraisal.set-increment', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.appraisal.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.indicator.delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('performance.goal-type.delete-checkbox-confirm-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- View Full Record Modal -->
<div class="modal fade" id="viewFullRecordModal" tabindex="-1" role="dialog" aria-labelledby="viewFullRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewFullRecordModalLabel">Full Record Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="fullRecordContent" class="bg-light p-3 rounded" style="max-height: 500px; overflow-y: auto;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
// Declare table variable globally
var table;

function formatFullRecord(data) {
    console.log('Raw data:', data);
    
    // Simple check if the data is valid
    if (!data) return '<p>No data available</p>';
    
    // Convert string to JSON if needed
    if (typeof data === 'string') {
        try {
            data = JSON.parse(data);
        } catch (e) {
            console.error('Error parsing JSON:', e);
            return '<pre>' + data + '</pre>';
        }
    }
    
    // Ensure we have an array to work with
    if (!Array.isArray(data)) {
        data = [data]; // Convert single object to array
    }
    
    var html = '<div style="font-family: Arial, sans-serif;">';
    
    // For each section in the data
    data.forEach(function(section, index) {
        html += '<div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">';
        
        // Section title
        if (section.section_name) {
            html += '<h3 style="color: #333; margin-top: 0;">' + section.section_name + '</h3>';
        }
        
        // Basic info (department, evaluator, date)
        html += '<table style="width: 100%; margin-bottom: 15px;">';
        html += '<tr><td style="width: 150px;"><strong>Department:</strong></td><td>' + (section.department_name || 'N/A') + '</td></tr>';
        html += '<tr><td><strong>Evaluator ID:</strong></td><td>' + (section.evaluator_id || 'N/A') + '</td></tr>';
        html += '<tr><td><strong>Date:</strong></td><td>' + (section.date || 'N/A') + '</td></tr>';
        
        if (section.total) {
            html += '<tr><td><strong>Total Score:</strong></td><td>' + section.total;
            if (section.percentage) {
                html += ' (' + section.percentage + '%)';
            }
            html += '</td></tr>';
        }
        html += '</table>';
        
        // Display performance indicators in a simple table
        if (section.performance_indicators) {
            html += '<h4 style="margin-top: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px;">Performance Indicators</h4>';
            
            // Process and deduplicate indicators
            var processedIndicators = {};
            var rawIndicators = section.performance_indicators;
            
            console.log('Raw indicators data:', rawIndicators);
            
            try {
                // If it's a string, try to parse it as JSON
                if (typeof rawIndicators === 'string') {
                    rawIndicators = JSON.parse(rawIndicators);
                }
                
                // Process each indicator, keeping only the highest score for duplicates
                if (typeof rawIndicators === 'object' && rawIndicators !== null) {
                    // First, normalize all keys to avoid case/whitespace issues
                    for (var key in rawIndicators) {
                        if (rawIndicators.hasOwnProperty(key)) {
                            var normalizedKey = String(key).trim();
                            var value = rawIndicators[key];
                            
                            // Skip if the value is an object (which would display as [object Object])
                            if (typeof value === 'object' && value !== null) {
                                console.log('Skipping object value for key:', key, value);
                                continue;
                            }
                            
                            // Convert value to number if possible
                            var score = !isNaN(value) ? Number(value) : value;
                            
                            // Only keep the highest score for duplicate keys
                            if (!processedIndicators[normalizedKey] || score > processedIndicators[normalizedKey]) {
                                processedIndicators[normalizedKey] = score;
                            }
                        }
                    }
                }
            } catch (e) {
                console.error('Error processing indicators:', e);
            }
            
            console.log('Processed indicators:', processedIndicators);
            
            // Display the deduplicated indicators
            html += '<table style="width: 100%; border-collapse: collapse;">';
            html += '<thead><tr style="background-color: #f5f5f5;">';
            html += '<th style="padding: 8px; text-align: left; border: 1px solid #ddd;">Indicator</th>';
            html += '<th style="padding: 8px; text-align: center; border: 1px solid #ddd; width: 80px;">Score</th>';
            html += '</tr></thead><tbody>';
            
            var hasEntries = false;
            
            // Sort indicators alphabetically for consistent display
            var sortedKeys = Object.keys(processedIndicators).sort();
            
            for (var i = 0; i < sortedKeys.length; i++) {
                var key = sortedKeys[i];
                var score = processedIndicators[key];
                
                // Skip if we have an object value or empty key
                if (typeof score === 'object' || key === '') continue;
                
                hasEntries = true;
                
                html += '<tr style="border: 1px solid #ddd;">';
                html += '<td style="padding: 8px; border: 1px solid #ddd;">' + key + '</td>';
                html += '<td style="padding: 8px; text-align: center; border: 1px solid #ddd;">' + score + '</td>';
                html += '</tr>';
            }
            
            if (!hasEntries) {
                html += '<tr><td colspan="2" style="padding: 8px; text-align: center;">No valid indicators found</td></tr>';
            }
            
            html += '</tbody></table>';
        }
        
        html += '</div>'; // End section
    });
    
    html += '</div>'; // End container
    
    return html;
}

$(document).ready(function() {
    $('#setIncrementButton').on('click', function() {
        $('#setIncrementModal').modal('show');
    });

    // Handle view button click
    $(document).on('click', '.view', function() {
        var row = $(this).closest('tr');
        var rowData = table.row(row).data();
        console.log('View button clicked, rowData:', rowData);
        
        if (rowData && rowData.full_record) {
            try {
                console.log('Full record:', rowData.full_record);
                var data = typeof rowData.full_record === 'string' ? 
                    JSON.parse(rowData.full_record) : rowData.full_record;
                var formattedHtml = formatFullRecord(data);
                $('#fullRecordContent').html(formattedHtml);
                $('#viewFullRecordModal').modal('show');
            } catch (e) {
                console.error('Error parsing JSON:', e);
                $('#fullRecordContent').text(typeof rowData.full_record === 'string' ? 
                    rowData.full_record : JSON.stringify(rowData.full_record));
                $('#viewFullRecordModal').modal('show');
            }
        } else {
            console.log('No full_record data found');
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var role_id = "<?php echo e(auth()->user()->role_users_id); ?>"; // Fetch role from backend

    var columnsConfig = [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
        { data: 'company_name', name: 'company_name' },
        { data: 'employee_name', name: 'employee_name' },
        { data: 'department_name', name: 'department_name' },
        { data: 'result', name: 'result' },
        { data: 'Increment_expected', name: 'Increment_expected' },
    ];

    if (role_id == 6) {
        columnsConfig.push({
            data: 'increment_granted',
            name: 'increment_granted',
            render: function(data, type, row) {
                return `
                    <div>
                        <input type="text" class="form-control editable-increment text-center border-primary"
                            data-id="${row.id}"
                            value="${data}"
                            placeholder="Enter increment"
                            style="max-width: 50px;"
                            title="${row.Increment_expected ? 'Allowed range: ' + row.Increment_expected : 'No increment expected'}"
                            ${!row.Increment_expected ? 'disabled' : ''}
                        >
                        <small class="increment-error" style="display: block; min-height: 20px;"></small>
                    </div>
                `;
            }
        });
    }

    // Add the remaining columns
    columnsConfig.push(
        { data: 'remarks', name: 'remarks' },
        { data: 'full_result', name: 'full_result' },
        { data: 'date', name: 'date' },
        { data: 'action', name: 'action', orderable: true, searchable: true }
    );

    // Initialize the DataTable
    table = $('#appraisalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?php echo e(route('performance.appraisal.index')); ?>",
        columns: columnsConfig,
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
            "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
            "search": '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                'previous': '<?php echo e(trans("file.Previous")); ?>',
                'next': '<?php echo e(trans("file.Next")); ?>'
            }
        }
    });

    $(document).on('focusout', '.editable-increment', function() {
        var $inputField = $(this);
        var appraisalId = $inputField.data('id');
        var newValue = parseInt($inputField.val().trim());

        // Find the expected increment range from the same row
        var row = $inputField.closest('tr');
        var expectedRange = row.find('td:eq(5)').text().trim(); // "Increment Expected" column
        var errorContainer = row.find('.increment-error');

        // Extract min and max values from the expected range
        var rangeParts = expectedRange.split('-').map(Number);
        var minExpected = rangeParts[0];
        var maxExpected = rangeParts.length > 1 ? rangeParts[1] : minExpected;

        // Clear previous errors
        errorContainer.text('');

        // Validate input
        if (isNaN(newValue)) {
            errorContainer.text("Please enter a valid number.").css("color", "red");
            $inputField.addClass("border-danger");
            return;
        }

        if (newValue < minExpected || newValue > maxExpected) {
            errorContainer.text(`Must be between ${minExpected} and ${maxExpected}.`).css("color", "red");
            $inputField.addClass("border-danger");
            return;
        }

        // Remove error styling if input is valid
        $inputField.removeClass("border-danger").addClass("border-success");

        // Proceed with AJAX request
        $.ajax({
            url: "<?php echo e(route('performance.appraisal.updateIncrement')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                id: appraisalId,
                increment_granted: newValue
            },
            success: function(response) {
                if (response.success) {
                    // Display success message in the row
                    errorContainer.text(response.message).css("color", "green");

                    // Optional: Remove success message after 3 seconds
                    setTimeout(() => errorContainer.text(''), 3000);
                }
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                if (response && response.error) {
                    errorContainer.text(response.error).css("color", "red");
                }
            }
        });
    });

    //after selecting Company then Designation will be loaded
    $('#companyId').change(function() {
        var companyId = $(this).val();
        if (companyId){
            $.get("<?php echo e(route('performance.appraisal.get-employee')); ?>",{company_id:companyId}, function (data){
                // $('#designationId').empty().html(data);

                let all_employees = '';
                $.each(data.employees, function (index, value) {
                    all_employees += '<option value=' + value['id'] + '>' + value['first_name'] + ' ' + value['last_name'] + '</option>';
                });
                $('#employeeId').selectpicker('refresh');
                $('#employeeId').empty().append(all_employees);
                $('#employeeId').selectpicker('refresh');
            });
        }else{
            $('#employeeId').empty().html('<option>--Select --</option>');
        }
    });


    //----------Insert Data----------------------
    $("#save-button").on("click",function(e){
        e.preventDefault();

        $.ajax({
            url: "<?php echo e(route('performance.appraisal.store')); ?>",
            type: "POST",
            data: $('#submitForm').serialize(),
            success: function(data){
                console.log(data);
                if (data.errors) {
                    $("#alertMessage").addClass('bg-danger text-center text-light p-1').html(data.errors) //Check in create modal
                }
                else if(data.success){
                    table.draw();
                    $('#submitForm')[0].reset();
                    $('select').selectpicker('refresh');
                    $("#createModalForm").modal('hide');
                    $('#success_alert').fadeIn("slow"); //Check in top in this blade
                    $('#success_alert').addClass('alert alert-success').html(data.success);
                    setTimeout(function() {
                        $('#success_alert').fadeOut("slow");
                    }, 3000);
                    $("#alertMessage").removeClass('bg-danger text-center text-light p-1');
                }
            }
        });
    });

    // --------------------- Edit ------------------
    $(document).on("click",".edit",function(e){
        e.preventDefault();
        // $('#EditformModal').modal('show');
        var appraisalId = $(this).data("id");
        var element = this;
        console.log(appraisalId)

        $.ajax({
            url: "<?php echo e(route('performance.appraisal.edit')); ?>",
            type: "GET",
            data: {id:appraisalId},
            success: function(data){
                console.log(data)
                $('#appraisalIdEdit').val(data.appraisal.id);
                $('#companyIdEdit').selectpicker('val', data.appraisal.company_id);

                let all_employees = '';
                $.each(data.employees, function (index, value) {
                    all_employees += '<option value=' + value['id'] + '>' + value['first_name'] + ' ' + value['last_name'] + '</option>';
                });
                $('#employeeIdEdit').empty().append(all_employees);
                $('#employeeIdEdit').selectpicker('refresh');
                $('#employeeIdEdit').selectpicker('val', data.appraisal.employee_id);
                $('#employeeIdEdit').selectpicker('refresh');


                $('#dateEdit').val(data.appraisal.date);
                $('#customerExperienceEdit').selectpicker('val', data.appraisal.customer_experience);
                $('#marketingEdit').selectpicker('val', data.appraisal.marketing);
                $('#administrationEdit').selectpicker('val', data.appraisal.administration);
                $('#professionalismEdit').selectpicker('val', data.appraisal.professionalism);
                $('#integrityEdit').selectpicker('val', data.appraisal.integrity);
                $('#attendanceEdit').selectpicker('val', data.appraisal.attendance);
                // $('#remarksEdit').selectpicker('val', data.appraisal.remarks);
                $('#remarksEdit').val(data.appraisal.remarks);
                $('#EditformModal').modal('show');
            }
        });
    });

    // ---------- Update by Id----------
    $("#update-button").on("click",function(e){
        e.preventDefault();

        $.ajax({
            url: "<?php echo e(route('performance.appraisal.update')); ?>",
            type: "POST",
            data: $('#updatetForm').serialize(),
            success: function(data){
                console.log(data);
                if(data.success)
                {
                    table.draw();
                    $('#updatetForm')[0].reset();
                    $('select').selectpicker('refresh');
                    $("#EditformModal").modal('hide');
                    $('#success_alert').fadeIn("slow"); //Check in top in this blade
                    $('#success_alert').addClass('alert alert-success').html(data.success);
                    setTimeout(function() {
                        $('#success_alert').fadeOut("slow");
                    }, 3000);
                }
            }
        });
    });

    //---------- Delete Data ----------
    $(document).on("click",".delete",function(e){
        $('#confirmDeleteModal').modal('show');
        var appraisalIdDelete = $(this).data("id");
        var element = this;
        // console.log(goalTypeIdDelete);

        $("#deleteSubmit").on("click",function(e){
            $.ajax({
                url: "<?php echo e(route('performance.appraisal.delete')); ?>",
                type: "GET",
                data: {appraisal_id:appraisalIdDelete},
                success: function(data){
                    console.log(data);
                    if(data.success)
                    {
                        table.draw();
                        $("#confirmDeleteModal").modal('hide');
                        $('#success_alert').fadeIn("slow"); //Check in top in this blade
                        $('#success_alert').addClass('alert alert-success').html(data.success);
                        setTimeout(function() {
                            $('#success_alert').fadeOut("slow");
                        }, 3000);
                    }
                }
            });
        });
    });

    // Multiple Data Delete using checkbox
    $("#bulk_delete").on("click",function(){
        var allCheckboxId = [];
        allCheckboxId = table.rows({selected: true}).ids().toArray();
        console.log(allCheckboxId);

        if(allCheckboxId.length == 0){
            alert("Please Select at least one checkbox.");
        }
        else{
            $('#confirmDeleteCheckboxModal').modal('show');
            $("#deleteCheckboxSubmit").on("click",function(e){
                $.ajax({
                    url : "<?php echo e(route('performance.appraisal.delete.checkbox')); ?>",
                    type : "GET",
                    data : {all_checkbox_id : allCheckboxId},
                    success : function(data){
                        console.log(data);
                        if(data.success)
                        {
                            table.ajax.reload();
                            table.rows('.selected').deselect();
                            $("#confirmDeleteCheckboxModal").modal('hide');
                            $('#success_alert').fadeIn("slow"); //Check in top in this blade
                            $('#success_alert').addClass('alert alert-success').html(data.success);
                            setTimeout(function() {
                                $('#success_alert').fadeOut("slow");
                            }, 3000);
                        }
                    }
                });
            });
        }
    });
});
</script> 
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/performance/appraisal/index.blade.php ENDPATH**/ ?>