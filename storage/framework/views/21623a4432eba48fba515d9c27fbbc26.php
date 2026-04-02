<?php
$loggedUser = auth()->user(); 
$loggedEmployee = \App\Models\Employee::find($loggedUser->id);
// dd($loggedUser->id);
// if ($loggedUser->role_users_id == 4) {
// }
?>


<?php $__env->startSection('content'); ?>
<style>
    /* Ensure disabled textareas are visible and readable */
    textarea#leave_reason:disabled {
        background-color: #f5f5f5 !important;
        opacity: 1 !important;
        color: #495057 !important;
        cursor: not-allowed;
    }
    /* Force description container to always be visible */
    #leave_reason_container {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: auto !important;
        overflow: visible !important;
    }
    /* Force description field to always be visible */
    #leave_reason {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        min-height: 60px !important;
        width: 100% !important;
    }
    /* Force label to always be visible */
    label[for="leave_reason"] {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    /* Override any Bootstrap hiding classes */
    #leave_reason_container.d-none,
    #leave_reason_container.hidden,
    #leave_reason.d-none,
    #leave_reason.hidden {
        display: block !important;
        visibility: visible !important;
    }
</style>
    <section>
        <div class="container-fluid"><span id="general_result"></span></div>
        <div class="container-fluid mb-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-leave')): ?>
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> <?php echo e(__('Add Leave')); ?></button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-leave')): ?>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            <?php endif; ?>
        </div>

        <div class="container-fluid mb-3 d-flex align-items-center">
            <label for="status_filter" class="mr-2"><?php echo e(__('Filter by Status')); ?>:</label>
            <select id="status_filter" class="form-control" style="width: 200px; max-width: 100%; display: inline-block;">
                <option value=""><?php echo e(__('All')); ?></option>
                <option value="pending"><?php echo e(__('Pending')); ?></option>
                <option value="approved"><?php echo e(__('Approved')); ?></option>
                <option value="1"><?php echo e(__('Approved by Teamlead')); ?></option>
                <option value="rejected"><?php echo e(__('Rejected')); ?></option>
            </select>
        </div>



        <div class="table-responsive">
            <table id="leave-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(__('Leave Type')); ?></th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th><?php echo e(trans('file.Duration')); ?></th>
                    <th><?php echo e(__('Applied Date')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Leave')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">

                        <?php echo csrf_field(); ?>
                        <div class="row">

                            <div class="col-md-6 form-group">
                                <?php if($loggedUser->role_users_id == 4): ?>:
                                    <label id="status_heading"><?php echo e(trans('file.Status')); ?></label>
                                <select name="status" id="status" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...'>
                                    <option value="pending"><?php echo e(trans('file.Pending')); ?></option>
                                    <option value="1">Approved By Teamlead</option>
                                    <option value="rejected"><?php echo e(trans('file.Rejected')); ?></option>
                                </select>
                                <?php else: ?>
                                <label id="status_heading"><?php echo e(trans('file.Status')); ?></label>
                                <select name="status" id="status" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...'>
                                    <option value="pending"><?php echo e(trans('file.Pending')); ?></option>
                                    <option value="approved"><?php echo e(trans('file.Approved')); ?></option>
                                    <option value="rejected"><?php echo e(trans('file.Rejected')); ?></option>
                                </select>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Leave Type')); ?> *</label>
                                <select id="leave_type" name="leave_type" class="form-control selectpicker" data-live-search="true" data-live-search-style="contains" title='<?php echo e(__('Leave Type')); ?>'>
                                    <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($leave_type->id); ?>"><?php echo e($leave_type->leave_type); ?>

                                            <!-- (<?php echo e($leave_type->allocated_day); ?> Days) -->
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>


                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Company')); ?> *</label>
                                <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                        data-live-search="true" title="Select Company..." data-dependent="department_name">
                                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($company->id); ?>" <?php echo e($loggedEmployee->company_id == $company->id ? 'selected' : ''); ?>>
                                            <?php echo e($company->company_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input type="hidden" name="company_id" value="<?php echo e($loggedEmployee->company_id); ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Department')); ?> *</label>
                                <select name="department_id" id="department_id" class="form-control selectpicker"
                                        data-live-search="true" title="Select Department...">
                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>" <?php echo e($loggedEmployee->department_id == $department->id ? 'selected' : ''); ?>>
                                            <?php echo e($department->department_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input type="hidden" name="department_id" value="<?php echo e($loggedEmployee->department_id); ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Employee')); ?> *</label>
                                <select name="employee_id" id="employee_id" class="form-control selectpicker"
                                        data-live-search="true" title="Select Employee...">
                                    <option value="<?php echo e($loggedEmployee->id); ?>" selected>
                                        <?php echo e($loggedEmployee->first_name); ?> <?php echo e($loggedEmployee->last_name); ?>

                                    </option>
                                </select>
                                <input type="hidden" name="employee_id" value="<?php echo e($loggedEmployee->id); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Total Days')); ?></label>
                                <select id="total_days" name="total_days" class="form-control" style="display:none;">
                                    <option value=""><?php echo e(__('Select')); ?></option>
                                </select>
                                <input type="text" readonly id="total_days_readonly" class="form-control" style="display:none;">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Start Date')); ?> *</label>
                                <input type="text" name="start_date" id="start_date" class="form-control date" value="">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('End Date')); ?> *</label>
                                <input type="text" name="end_date" id="end_date" class="form-control test date" value="" readonly>
                            </div>

                            <div class="col-md-6 form-group" id="leave_reason_container">
                                <label for="leave_reason"><?php echo e(trans('file.Description')); ?></label>
                                <textarea class="form-control" id="leave_reason" name="leave_reason" rows="3" style="width: 100%; display: block !important; visibility: visible !important;"></textarea>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="remarks"><?php echo e(trans('file.Remarks')); ?></label>
                                <textarea class="form-control" id="remarks" name="remarks"
                                          rows="3"></textarea>
                            </div>
 
                            
                            

                            <div class="col-md-6 form-group">
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="is_notify" id="is_notify" value="1" checked>
                                    <label class="custom-control-label"
                                           for="is_notify"><?php echo e(trans('file.Notification')); ?></label>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="hidden" name="diff_date_hidden" id="diff_date_hidden"/>
                                    <input type="hidden" name="employee_id_hidden" id="employee_id_hidden"/>
                                    <input type="hidden" name="leave_type_hidden" id="leave_type_hidden"/>
                                    <input type="hidden" name="ticket_status" value="open"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                           value=<?php echo e(trans('file.Add')); ?>>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="leave_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Leave Info')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table  table-bordered">

                                    <tr>
                                        <th><?php echo e(trans('file.Company')); ?></th>
                                        <td id="company_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Leave For')); ?></th>
                                        <td id="employee_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Department')); ?></th>
                                        <td id="department_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Leave Type')); ?></th>
                                        <td id="leave_type_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Leave Reason')); ?></th>
                                        <td id="leave_reason_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Remarks')); ?></th>
                                        <td id="remarks_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Status')); ?></th>
                                        <td id="status_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Start Date')); ?></th>
                                        <td id="start_date_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('End Date')); ?></th>
                                        <td id="end_date_id"></td>
                                    </tr>


                                    <tr>
                                        <th><?php echo e(__('Applied Date')); ?></th>
                                        <td id="applied_date_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Total Days')); ?></th>
                                        <td id="total_days_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Half Day')); ?></th>
                                        <td id="is_half_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Notification')); ?></th>
                                        <td id="is_notify_id"></td>
                                    </tr>

                                </table>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('file.Close')); ?></button>
            </div>
        </div>
    </div>


    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title"><?php echo e(trans('file.Confirmation')); ?></h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center"><?php echo e(__('Are you sure you want to remove this data?')); ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger"><?php echo e(trans('file.OK')); ?>'
                    </button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal"><?php echo e(trans('file.Cancel')); ?></button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

    (function($) {
        "use strict";

        let global_start_date;
        let global_end_date;
        let global_diff;

        $(document).ready(function () {

            let date = $('.date');
            date.datepicker({
                format: '<?php echo e(env('Date_Format_JS')); ?>',
                autoclose: true,
                todayHighlight: true,
                startDate: new Date(new Date().setDate(new Date().getDate() - 6)) // Only allow last 7 days including today
            });
            // .on('change', function(){
            //     let start_date = $("#start_date").datepicker('getDate');
            //     let end_date = $("#end_date").datepicker('getDate');
            //     if (start_date!=null && end_date!=null && end_date>=start_date) {
            //     let dayDiff = Math.ceil((end_date - start_date) / (1000 * 60 * 60 * 24)) + 1;
            //     // console.log(dayDiff);
            //         $('#total_days').val(dayDiff);
            //     }
            //     else if(start_date!=null && end_date!=null && end_date<start_date){
            //         // console.log(987);
            //         $('#total_days').val(0);
            //     }
            // });


            const startDateInput = $('#start_date');
            const endDateInput = $('#end_date');
            const totalDaysSelect = $('#total_days');
            const totalDaysReadonly = $('#total_days_readonly');

            startDateInput.on('change', function() {
                getDateResult();
            });

            endDateInput.on('change', function() {
                getDateResult();
            });

            const getDateResult = ()  => {

                // Convert Date format to YYYY-MM-DD
                if (!startDateInput.val() || !endDateInput.val()) {
                    totalDaysSelect.hide().empty();
                    totalDaysReadonly.hide();
                    return;
                }

                let startDateFormat = convertDataFormat(startDateInput.val());
                let endDateFormat = convertDataFormat(endDateInput.val());

                let startDate = new Date(startDateFormat);
                let endDate = new Date(endDateFormat);
                let timeDiff = endDate.getTime() - startDate.getTime();
                let totalDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

                if (totalDays < 0) {
                    totalDays = 0;
                }

                if (startDate.getTime() === endDate.getTime()) {
                    // Same day: show 0.5 and 1 day options (half-day support)
                    totalDaysSelect.html('<option value="0.5">0.5 <?php echo e(__("Day")); ?></option><option value="1">1 <?php echo e(__("Day")); ?></option>').show();
                    totalDaysReadonly.hide();
                } else {
                    totalDaysReadonly.val(totalDays).show();
                    totalDaysSelect.hide().empty();
                }
            }

            const convertDataFormat = getDateValue => {
                const inputDate = getDateValue;
                const parts = inputDate.split("-");
                const date = new Date(parts[2], parts[1] - 1, parts[0]);
                const outputDate = date.toISOString().substring(0, 10);
                return outputDate;
            }

            var is_tl_action = 'Approved by Teamlead';
            let table_table = $('#leave-table').DataTable({
                
                initComplete: function () {
                    this.api().columns([1]).every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
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
                    url: "<?php echo e(route('leaves.index')); ?>",
                    data: function (d) {
                        d.status = $('#status_filter').val(); // Send selected status to backend
                    }
                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        
                        data: null,
                        render: function (data) {
                            
                            if(data.status=='rejected') {
                                return data.leave_type + "<br><td><div class = 'badge badge-danger'> (" + data.status + ")</div></td><br>";
                            }else if(data.is_tl_action==1 && data.status != 'approved') {
                                return data.leave_type + "<br><td><div class = 'badge badge-info'> (" + 'Approved By Teamlead' + ")</div></td><br>";
                            }else if (data.status=='pending') {
                                return data.leave_type + "<br><td><div class = 'badge badge-warning'> " + data.status + "</div></td><br>";
                            }else{
                                return data.leave_type + "<br><td><div class = 'badge badge-success'> (" + data.status + ")</div></td><br>";
                            }
                        }
                    },
                    {
                        data: 'employee',
                        name: 'employee',
                    },
                    {
                        data: 'department',
                        name: 'department',
                    },
                    {
    data: null,
    render: function (data) {
        let startDate = data.start_date;
        let endDate = data.end_date;
        let totalDays = parseFloat(data.total_days);

        let totalDaysHtml = '';
        // Apply background only to total_days text
        if (totalDays === 0.5) {
            totalDaysHtml = '<div style="background-color: #FFF176; font-size:12px; padding: 3px; border-radius: 5px; display: inline-block; color:black;">' +
                            '<?php echo e(__("Half Day")); ?>' +
                            '</div>';
        } else {
            totalDaysHtml = '<div style="background-color: #81C784; font-size:12px; padding: 3px; border-radius: 5px; display: inline-block; color:white;">' +
                            '<?php echo e(trans("file.Total")); ?> ' + data.total_days + ' <?php echo e(trans("file.Days")); ?>' +
                            '</div>';
        }

        return startDate + ' <?php echo e(trans('file.To')); ?> ' + endDate + '<br>' + totalDaysHtml;
    }
},

                    {
                        data: 'created_at',
                        name: 'created_at',
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
                        // 'targets': [0, 6],
                        'targets': [0, 5],
                    },
                    {
                        'render': function (data, type, row, meta) {
                            if (type == 'display') {
                                data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                            }

                            return data;
                        },
                        'checkboxes': {
                            'selectRow': true,
                            'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                        },
                        'targets': [0]
                    }
                ],


                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: '<"row"lfB>rtip',
                buttons: [
                    {
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ],

                
            });

    // ✅ When Status Filter Changes, Refresh the Table
    $('#status_filter').on('change', function () {
        table_table.ajax.reload(); // Reload table with new filter
    });

            new $.fn.dataTable.FixedHeader(table_table);
        });




        $('#create_record').on('click', function () {
            $('.modal-title').text('<?php echo e(__('Add Leave')); ?>');
            $('#action_button').val('<?php echo e(trans('file.Add')); ?>');
            $('#action').val('<?php echo e(trans('file.Add')); ?>');
            $('#sample_form')[0].reset(); // Reset the form for new entry
            
            // Ensure description field is visible and enabled for new entries
            $('#leave_reason_container').show().css({
                'display': 'block !important',
                'visibility': 'visible !important'
            });
            $('#leave_reason').prop('disabled', false).show().val('').css({
                'background-color': '',
                'opacity': '1',
                'cursor': 'text',
                'display': 'block !important',
                'visibility': 'visible !important',
                'min-height': '60px'
            });
            $('label[for="leave_reason"]').show().css({
                'display': 'block !important',
                'visibility': 'visible !important'
            });
            
            // Explicitly enable all fields that might have been disabled in edit mode
            $('#leave_type').prop('disabled', false);
            $('#start_date').prop('disabled', false);
            $('#end_date').prop('disabled', false);
            $('#total_days').prop('disabled', false);
            $('#total_days_readonly').prop('disabled', false);
            totalDaysSelect.hide().empty();
            totalDaysReadonly.hide();
            $('#leave_reason').prop('disabled', false);
            $('#is_notify').prop('disabled', false);
            $('#remarks').prop('disabled', false);
            
            const currentRoleId = <?php echo e(auth()->user()->role_users_id); ?>;
            // Use setTimeout to ensure selectpicker is fully initialized
            setTimeout(function() {
                // Set the default values for company, department, and employee after reset
                $('#company_id').selectpicker('val', '<?php echo e($loggedEmployee->company_id); ?>');
                $('#department_id').selectpicker('val', '<?php echo e($loggedEmployee->department_id); ?>');
                $('#employee_id').selectpicker('val', '<?php echo e($loggedEmployee->id); ?>');
                
                // Admin (role 1) should be able to choose any company/department/employee
                if (currentRoleId === 1) {
                    $('#company_id').prop('disabled', false).selectpicker('refresh');
                    $('#department_id').prop('disabled', false).selectpicker('refresh');
                    $('#employee_id').prop('disabled', false).selectpicker('refresh');
                } else {
                    // Non-admins: keep fields locked to their own values
                    $('#company_id').prop('disabled', true).selectpicker('refresh');
                    $('#department_id').prop('disabled', true).selectpicker('refresh');
                    $('#employee_id').prop('disabled', true).selectpicker('refresh');
                }
            }, 100);
            
            // Refresh all selectpickers
            $('#leave_type').selectpicker('refresh');
            
            $('#formModal').modal('show');
        });
        
        // Force description field visibility whenever modal is shown
        $('#formModal').on('shown.bs.modal', function () {
            // Remove any hiding classes
            $('#leave_reason_container').removeClass('d-none hidden').show();
            $('#leave_reason').removeClass('d-none hidden').show();
            $('label[for="leave_reason"]').removeClass('d-none hidden').show();
            
            // Force visibility with inline styles
            $('#leave_reason_container').css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1'
            });
            $('#leave_reason').css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1',
                'min-height': '60px'
            });
            $('label[for="leave_reason"]').css({
                'display': 'block',
                'visibility': 'visible'
            });
            
            console.log('Modal shown - Description field check:', {
                containerVisible: $('#leave_reason_container').is(':visible'),
                fieldVisible: $('#leave_reason').is(':visible'),
                containerDisplay: $('#leave_reason_container').css('display'),
                fieldDisplay: $('#leave_reason').css('display'),
                fieldValue: $('#leave_reason').val()
            });
        });

        $('#sample_form').on('submit', function (event) {
       event.preventDefault();

    // Remove any previously added hidden fields to prevent duplicates
    $('#temp_company_id, #temp_department_id, #temp_employee_id, #temp_status, #temp_leave_type, #temp_start_date, #temp_end_date, #temp_leave_reason').remove();

    // Capture the current status value ONCE before anything else
    let currentStatus = $('#status').val();
    console.log('🟡 Status captured on submit:', currentStatus);

    // Always inject status as hidden field (selectpicker disabled fields get lost)
    $('#sample_form').append('<input type="hidden" name="status" id="temp_status" value="' + currentStatus + '">');

    // Other disabled fields
    if ($('#company_id').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="company_id" id="temp_company_id" value="' + $('#company_id').val() + '">');
    }
    if ($('#department_id').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="department_id" id="temp_department_id" value="' + $('#department_id').val() + '">');
    }
    if ($('#employee_id').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="employee_id" id="temp_employee_id" value="' + $('#employee_id').val() + '">');
    }
    if ($('#leave_type').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="leave_type" id="temp_leave_type" value="' + $('#leave_type').val() + '">');
    }
    if ($('#start_date').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="start_date" id="temp_start_date" value="' + $('#start_date').val() + '">');
    }
    if ($('#end_date').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="end_date" id="temp_end_date" value="' + $('#end_date').val() + '">');
    }
    if ($('#leave_reason').prop('disabled')) {
        let leaveReasonValue = $('#leave_reason').val() || '';
        let encodedValue = $('<div>').text(leaveReasonValue).html();
        $('#sample_form').append('<input type="hidden" name="leave_reason" id="temp_leave_reason" value="' + encodedValue + '">');
    }

    if ($('#action').val() == '<?php echo e(trans('file.Add')); ?>') {

        let start_date = $("#start_date").datepicker('getDate');
        let end_date = $("#end_date").datepicker('getDate');
        let dayDiff;
        if ($('#total_days').is(':visible') && $('#total_days').val()) {
            dayDiff = parseFloat($('#total_days').val());
        } else {
            dayDiff = Math.ceil((end_date - start_date) / (1000 * 60 * 60 * 24)) + 1;
        }
        $('#diff_date_hidden').val(dayDiff);

        var formDataAdd = new FormData(this);
        var debugDataAdd = {};
        formDataAdd.forEach(function (value, key) { debugDataAdd[key] = value; });
        console.log('Leave form submit (Add) – data being sent:', debugDataAdd);

        $.ajax({
            url: "<?php echo e(route('leaves.update')); ?>",
            method: "POST",
            data: formDataAdd,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                let html = '';
                if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (let count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if (data.limit) { html = '<div class="alert alert-danger">' + data.limit + '</div>'; }
                if (data.remaining_leave) { html = '<div class="alert alert-danger">' + data.remaining_leave + '</div>'; }
                if (data.error) { html = '<div class="alert alert-danger">' + data.error + '</div>'; }
                if (data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('select').selectpicker('refresh');
                    $('.date').datepicker('update');
                    $('#leave-table').DataTable().ajax.reload();
                }
                location.reload();
                $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            }
        });
    }

    if ($('#action').val() == '<?php echo e(trans('file.Edit')); ?>') {

        var totalDays = $('#total_days').is(':visible') ? $('#total_days').val() : $('#total_days_readonly').val();
        $('#diff_date_hidden').val(totalDays);

        var formDataEdit = new FormData(this);
        var debugDataEdit = {};
        formDataEdit.forEach(function (value, key) { debugDataEdit[key] = value; });
        console.log('Leave form submit (Edit) – data being sent:', debugDataEdit);
        console.log('🔵 Status in FormData:', debugDataEdit['status']);

        $.ajax({
            url: "<?php echo e(route('leaves.update')); ?>",
            method: "POST",
            data: formDataEdit,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                let html = '';
                if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (let count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if (data.limit) { html = '<div class="alert alert-danger">' + data.limit + '</div>'; }
                if (data.remaining_leave) { html = '<div class="alert alert-danger">' + data.remaining_leave + '</div>'; }
                if (data.error) { html = '<div class="alert alert-danger">' + data.error + '</div>'; }
                if (data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    setTimeout(function () {
                        $('#formModal').modal('hide');
                        $('.date').datepicker('update');
                        $('select').selectpicker('refresh');
                        $('#leave-table').DataTable().ajax.reload();
                        $('#sample_form')[0].reset();
                    }, 2000);
                }
                location.reload();
                $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            },
            complete: function () {
                $('#temp_company_id, #temp_department_id, #temp_employee_id, #temp_status, #temp_leave_type, #temp_start_date, #temp_end_date, #temp_leave_reason').remove();
            }
        });
    }
});

        $(document).on('click', '.show_new', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            let target = '<?php echo e(route('leaves.index')); ?>/' + id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (result) {

                    $('#leave_type_id').html(result.leave_type_name);
                    $('#company_id_show').html(result.company_name);
                    $('#employee_id_show').html(result.employee_name);
                    $('#department_id_show').html(result.department);
                    $('#start_date_id').html(result.start_date_name);
                    $('#end_date_id').html(result.end_date_name);
                    $('#applied_date_id').html(result.data.created_at);
                    $('#total_days_id').html(result.data.total_days);
                    $('#status_id').html(result.data.status);
                    $('#leave_reason_id').html(result.data.leave_reason);
                    $('#remarks_id').html(result.data.remarks);

                    // Check if total_days is 0.5 to determine half day
                    let totalDays = parseFloat(result.data.total_days);
                    if (totalDays === 0.5 || result.data.is_half == 1) {
                        $('#is_half_id').html('Yes');
                    } else {
                        $('#is_half_id').html('No');
                    }
                    if (result.data.is_notify == 1)
                        $('#is_notify_id').html('On');
                    else {
                        $('#is_notify_id').html('On');
                    }


                    $('#leave_model').modal('show');
                    $('.modal-title').text("<?php echo e(__('Leave Info')); ?>");
                }
            });
        });


        $(document).on('click', '.edit', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            // IMMEDIATELY ensure description field is visible before any AJAX call
            $('#leave_reason_container').show().removeClass('d-none hidden').css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1'
            });
            $('#leave_reason').show().removeClass('d-none hidden').css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1'
            });
            $('label[for="leave_reason"]').show().removeClass('d-none hidden');

            let target = "<?php echo e(route('leaves.index')); ?>/" + id + '/edit';

            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {

                    // Always show status field and label at the start
                    $('#status, #status_heading').show();
                    $('#status, #status_heading').parent().show();

                    let currentDate = new Date().toJSON().slice(0, 10);
                    // Do not auto-disable start date for Admin/CEO (role 1)
                    if ("<?php echo e(auth()->user()->role_users_id); ?>" != 1) {
                    if (Date.parse(html.leaveStartDate) < Date.parse(currentDate)) {
                        $('#start_date').prop('disabled', true);
                        }
                    }


                    let roleId = "<?php echo e(auth()->user()->role_users_id); ?>";
                    let loggedUserId = "<?php echo e(auth()->user()->id); ?>";
                    let leaveEmployeeId = html.data.employee_id;
                    let is_tl_action = html.data.is_tl_action;
                    let is_hr_action = html.data.is_hr_action;
                    let status_val = html.data.status;

                    if(is_tl_action == 1){
                        $('#status_heading').text('Approved by Teamlead');
                    }else{
                        $('#status_heading').text('Status');
                    }
                    // Status dropdown can be edited only if current status is 'pending',
                    // except Admin (role 1) who can always edit.
                    let canEditStatus = false;
                    if (roleId == 1) {
                        canEditStatus = true;
                    } else if (status_val === 'pending') {
                        canEditStatus = true;
                    }
                    $('#status').prop('disabled', !canEditStatus);

                 // Change Approved option value if roleId is 2 or 4 and $is_tl_action is 0
if ((roleId == 2 || roleId == 4) && is_tl_action == 0) {
    $('#status option[value="approved"]').val("1"); // Change value to 1
}

// Ensure the Status UI is visible; we only disable, not hide
$('#status, #status_heading').show();
$('#status, #status_heading').css('display', 'block');
$('#status, #status_heading').parent().show();


                    // Preselect current status, handling TL flow where 'approved' value becomes 1
                    (function(){
                        var currentStatus = status_val; // e.g., 'pending' | 'approved' | 'rejected' | '1'
                        // If the option 'approved' has been remapped to value "1", ensure selection matches
                        if (currentStatus === 'approved' && $('#status option[value="approved"]').length === 0 && $('#status option[value="1"]').length > 0) {
                            currentStatus = '1';
                        }
                        $('#status').selectpicker('val', currentStatus);
                    })();

                    // Refresh Selectpicker
                    $('#status').selectpicker('refresh');


                    // Set values for all fields
                    $('#remarks').val(html.data.remarks || '');
                    
                    // Ensure description field is visible FIRST
                    $('#leave_reason_container').show().css({
                        'display': 'block',
                        'visibility': 'visible'
                    });
                    $('#leave_reason').show().css({
                        'display': 'block',
                        'visibility': 'visible',
                        'opacity': '1',
                        'min-height': '60px'
                    });
                    $('label[for="leave_reason"]').show().css({
                        'display': 'block',
                        'visibility': 'visible'
                    });
                    
                    // Get leave_reason value - check multiple possible locations
                    let leaveReason = html.data.leave_reason || 
                                    html.data.leaveReason || 
                                    html.leave_reason || 
                                    '';
                    
                    console.log('=== LEAVE REASON DEBUG ===');
                    console.log('html.data:', html.data);
                    console.log('html.data.leave_reason:', html.data.leave_reason);
                    console.log('leaveReason variable:', leaveReason);
                    console.log('Type of leaveReason:', typeof leaveReason);
                    
                    // Set the value using multiple methods
                    if (leaveReason) {
                        // Method 1: jQuery val()
                        $('#leave_reason').val(leaveReason);
                        
                        // Method 2: Direct DOM property
                        var textareaElement = document.getElementById('leave_reason');
                        if (textareaElement) {
                            textareaElement.value = leaveReason;
                            // Also set innerHTML as fallback
                            textareaElement.innerHTML = leaveReason;
                        }
                        
                        // Method 3: jQuery text() for textarea
                        $('#leave_reason').text(leaveReason);
                        
                        console.log('Value set using multiple methods');
                    } else {
                        console.warn('leaveReason is empty or undefined!');
                    }
                    
                    // Verify immediately
                    console.log('Immediate check - jQuery val():', $('#leave_reason').val());
                    console.log('Immediate check - DOM value:', document.getElementById('leave_reason')?.value);
                    
                    // Verify after a short delay
                    setTimeout(function() {
                        console.log('Delayed check - jQuery val():', $('#leave_reason').val());
                        console.log('Delayed check - DOM value:', document.getElementById('leave_reason')?.value);
                        console.log('Field visible:', $('#leave_reason').is(':visible'));
                    }, 200);
                    
                    $('#leave_type').selectpicker('val', html.data.leave_type_id);

                    // Handle Company dropdown
                    let companyName = html.data.company ? html.data.company.company_name : 'N/A';
                    $('#company_id').empty();
                    $('#company_id').append('<option value="' + html.data.company_id + '" selected>' + companyName + '</option>');
                    $('#company_id').prop('disabled', true);
                    $('#company_id').selectpicker('refresh');

                    // Handle Department dropdown
                    let departmentName = html.data.department ? html.data.department.department_name : 'N/A';
                    console.log('Department Data:', html.data.department); // Log department data

                    $('#department_id').empty();
                    $('#department_id').append('<option value="' + html.data.department_id + '" selected>' + departmentName + '</option>');
                    $('#department_id').prop('disabled', true);
                    $('#department_id').selectpicker('refresh');

                    // Handle Employee dropdown
                    let selectedEmployeeName = 'N/A';
                    if (html.data.employee) {
                        selectedEmployeeName = html.data.employee.first_name + ' ' + html.data.employee.last_name;
                    }
                    console.log('Employee Data:', html.data.employee); // Log employee data

                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="' + html.data.employee_id + '" selected>' + selectedEmployeeName + '</option>');
                    $('#employee_id').prop('disabled', true);
                    $('#employee_id').selectpicker('refresh');

                    $('#start_date').val(html.data.start_date);
                    $('#end_date').val(html.data.end_date);

                    var totalDaysVal = parseFloat(html.data.total_days);
                    if (totalDaysVal === 0.5 || totalDaysVal === 1) {
                        $('#total_days').html('<option value="0.5">0.5 <?php echo e(__("Day")); ?></option><option value="1">1 <?php echo e(__("Day")); ?></option>').val(String(totalDaysVal)).show().prop('disabled', true);
                        $('#total_days_readonly').hide();
                    } else {
                        $('#total_days_readonly').val(html.data.total_days).show();
                        $('#total_days').hide().empty();
                    }

                    // Disable all fields except remarks and status
                    $('#leave_type').prop('disabled', true).selectpicker('refresh');
                    // For Admin/CEO (role 1), keep Start and End Date editable
                    if ("<?php echo e(auth()->user()->role_users_id); ?>" == 1) {
                        $('#start_date').prop('disabled', false);
                        $('#end_date').prop('disabled', false);
                    } else {
                    $('#start_date').prop('disabled', true);
                    $('#end_date').prop('disabled', true);
                    }
                    $('#total_days_readonly').prop('disabled', true);
                    // Keep description field visible but disabled (read-only) so user can see the content
                    $('#leave_reason_container').show().css({
                        'display': 'block !important',
                        'visibility': 'visible !important'
                    });
                    $('#leave_reason').prop('disabled', true).css({
                        'background-color': '#f5f5f5',
                        'opacity': '1',
                        'cursor': 'not-allowed',
                        'display': 'block !important',
                        'visibility': 'visible !important',
                        'min-height': '60px'
                    });
                    $('label[for="leave_reason"]').show().css({
                        'display': 'block !important',
                        'visibility': 'visible !important'
                    });
                    $('#is_notify').prop('disabled', true);

                    // Keep remarks and status enabled (status is already handled above)
                    $('#remarks').prop('disabled', false);

                    if (html.data.is_half == 1) {
                        $('#is_half').prop('checked', true);
                    } else {
                        $('#is_half').prop('checked', false);
                    }

                    if (html.data.is_notify == 1) {
                        $('#is_notify').prop('checked', true);
                    } else {
                        $('#is_notify').prop('checked', true);
                    }

                    $('#hidden_id').val(html.data.id);
                    $('#employee_id_hidden').val(html.data.employee_id);
                    $('#leave_type_hidden').val(html.data.leave_type_id);
                    $('.modal-title').text('Submit Leave');
                    $('#action_button').val('Submit');
                    $('#action').val('<?php echo e(trans('file.Edit')); ?>');
                    
                    // Store leave_reason value for later use
                    let storedLeaveReason = html.data.leave_reason || '';
                    
                    // Final check to ensure description field is visible and value is set before showing modal
                    setTimeout(function() {
                        // Re-set the value in case it was cleared
                        $('#leave_reason').val(storedLeaveReason);
                        var textareaEl = document.getElementById('leave_reason');
                        if (textareaEl) {
                            textareaEl.value = storedLeaveReason;
                        }
                        
                        $('#leave_reason_container').css({
                            'display': 'block',
                            'visibility': 'visible',
                            'opacity': '1'
                        });
                        $('#leave_reason').css({
                            'display': 'block',
                            'visibility': 'visible',
                            'opacity': '1',
                            'min-height': '60px'
                        });
                        $('label[for="leave_reason"]').css({
                            'display': 'block',
                            'visibility': 'visible'
                        });
                        console.log('Before modal show - Description field check:', {
                            container: $('#leave_reason_container').is(':visible'),
                            field: $('#leave_reason').is(':visible'),
                            value: $('#leave_reason').val(),
                            storedValue: storedLeaveReason
                        });
                    }, 100);
                    
                    $('#formModal').modal('show');
                    
                    // One more check after modal is fully shown - use one() to prevent multiple bindings
                    $('#formModal').off('shown.bs.modal').on('shown.bs.modal', function() {
                        // Re-set the value after modal is fully rendered
                        $('#leave_reason').val(storedLeaveReason);
                        var textareaEl = document.getElementById('leave_reason');
                        if (textareaEl) {
                            textareaEl.value = storedLeaveReason;
                            // Force a re-render
                            textareaEl.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                        console.log('After modal shown - Setting leave_reason to:', storedLeaveReason);
                        console.log('After modal shown - Current value:', $('#leave_reason').val());
                        
                        // One more check after a delay
                        setTimeout(function() {
                            $('#leave_reason').val(storedLeaveReason);
                            console.log('Final check - leave_reason value:', $('#leave_reason').val());
                        }, 300);
                    });
                }
            })
        });


        let delete_id;

        $(document).on('click', '.delete', function () {
            delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('<?php echo e(__('DELETE Record')); ?>');
            $('#ok_button').text('<?php echo e(trans('file.OK')); ?>');

        });


        $(document).on('click', '#bulk_delete', function () {

            let id = [];
            let table = $('#leave-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Leave')])); ?>')) {
                    $.ajax({
                        url: '<?php echo e(route('mass_delete_leaves')); ?>',
                        method: 'POST',
                        data: {
                            leaveIdArray: id
                        },
                        success: function (data) {
                            let html = '';
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                            }
                            if (data.error) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            table.ajax.reload();
                            table.rows('.selected').deselect();
                            if (data.errors) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            location.reload();
                            $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);

                        }

                    });
                }
            } else {
                alert('<?php echo e(__('Please select atleast one checkbox')); ?>');
            }
        });


        $('#close').on('click', function () {
            resetFormToDefaults();
        });

        // Handle modal hidden event (when modal is closed by any means)
        $('#formModal').on('hidden.bs.modal', function () {
            resetFormToDefaults();
        });

        // Function to reset form to default values
        function resetFormToDefaults() {
            // Ensure description field is visible before reset
            $('#leave_reason_container').show().css({
                'display': 'block',
                'visibility': 'visible'
            });
            $('#leave_reason').show().css({
                'display': 'block',
                'visibility': 'visible'
            });
            $('label[for="leave_reason"]').show();
            
            $('#sample_form')[0].reset();
            
            // Restore original dropdown options for company
            $('#company_id').empty();
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $('#company_id').append('<option value="<?php echo e($company->id); ?>" <?php echo e($loggedEmployee->company_id == $company->id ? 'selected' : ''); ?>><?php echo e($company->company_name); ?></option>');
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            // Restore original dropdown options for department
            $('#department_id').empty();
            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $('#department_id').append('<option value="<?php echo e($department->id); ?>" <?php echo e($loggedEmployee->department_id == $department->id ? 'selected' : ''); ?>><?php echo e($department->department_name); ?></option>');
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            // Restore original dropdown options for employee
            $('#employee_id').empty();
            $('#employee_id').append('<option value="<?php echo e($loggedEmployee->id); ?>" selected><?php echo e($loggedEmployee->first_name); ?> <?php echo e($loggedEmployee->last_name); ?></option>');
            
            // Restore original dropdown options for leave type
            $('#leave_type').empty();
            <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $('#leave_type').append('<option value="<?php echo e($leave_type->id); ?>"><?php echo e($leave_type->leave_type); ?></option>');
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            // Refresh all selectpickers
            $('#company_id').selectpicker('refresh');
            $('#department_id').selectpicker('refresh');
            $('#employee_id').selectpicker('refresh');
            $('#leave_type').selectpicker('refresh');
            
            // Use setTimeout to ensure selectpicker is fully initialized
            setTimeout(function() {
                // Set the default values for company, department, and employee after reset
                $('#company_id').selectpicker('val', '<?php echo e($loggedEmployee->company_id); ?>');
                $('#department_id').selectpicker('val', '<?php echo e($loggedEmployee->department_id); ?>');
                $('#employee_id').selectpicker('val', '<?php echo e($loggedEmployee->id); ?>');
                
                // Keep company, department, and employee disabled
                $('#company_id').prop('disabled', true).selectpicker('refresh');
                $('#department_id').prop('disabled', true).selectpicker('refresh');
                $('#employee_id').prop('disabled', true).selectpicker('refresh');
            }, 200);
            
            $('.date').datepicker('update');
            $('#leave-table').DataTable().ajax.reload();
            $('#start_date').prop('disabled', false);
        }

        $('#ok_button').on('click', function () {
            let target = "<?php echo e(route('leaves.index')); ?>/" + delete_id + '/delete';
            $.ajax({
                url: target,
                beforeSend: function () {
                    $('#ok_button').text('<?php echo e(trans('file.Deleting...')); ?>');
                },
                success: function (data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    setTimeout(function () {
                        location.reload();
                        $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        $('#confirmModal').modal('hide');
                        $('#leave-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });

        // Company → Department cascade
        $('.dynamic').off('change.dynamic').on('change.dynamic', function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let dependent = $(this).data('dependent');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('dynamic_department')); ?>",
                    method: "POST",
                    data: {value: value, _token: _token, dependent: dependent},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#department_id').html(result);
                        $('select').selectpicker();

                        // After departments load, also refresh employees list for the first department (admin use-case)
                        const firstDeptId = $('#department_id').val();
                        if (firstDeptId) {
                            $.ajax({
                                url: "<?php echo e(route('dynamic_employee_department')); ?>",
                                method: "POST",
                                data: {value: firstDeptId, _token: _token, first_name: 'first_name', last_name: 'last_name'},
                                success: function (empResult) {
                                    $('select').selectpicker("destroy");
                                    $('#employee_id').html(empResult);
                                    $('select').selectpicker();
                                }
                            });
                        }

                    }
                });
            }
        });

        // Department → Employee cascade
        $('#department_id').off('change.dept').on('change.dept', function () {
            let value = $(this).val();
            let _token = $('input[name="_token"]').val();
            if (value) {
                $.ajax({
                    url: "<?php echo e(route('dynamic_employee_department')); ?>",
                    method: "POST",
                    data: {value: value, _token: _token, first_name: 'first_name', last_name: 'last_name'},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#employee_id').html(result);
                        $('select').selectpicker();
                    }
                });
            }
        });



        $('.employee').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let first_name = $(this).data('first_name');
                let last_name = $(this).data('last_name');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('dynamic_employee_department')); ?>",
                    method: "POST",
                    data: {value: value, _token: _token, first_name: first_name, last_name: last_name},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#employee_id').html(result);
                        $('select').selectpicker();

                    }
                });
            }
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/crm/resources/views/timesheet/leave/index.blade.php ENDPATH**/ ?>