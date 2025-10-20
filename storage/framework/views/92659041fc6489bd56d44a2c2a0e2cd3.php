<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('includes.session_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <!-- Employee Resignation Status Section -->
        <?php if(auth()->user()->role_users_id == 2): ?>
            <?php
                $user = auth()->user();
                $resignation = \App\Models\Resignation::where('employee_id', $user->id)
                    ->where('status', '!=', 'deleted')
                    ->orderBy('created_at', 'desc')
                    ->first();
            ?>
            
            <?php if($resignation): ?>
                <div class="container-fluid mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-info-circle"></i> <?php echo e(__('My Resignation Status')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><strong><?php echo e(__('Resignation Details')); ?></strong></h6>
                                    <p><strong><?php echo e(__('Notice Date')); ?>:</strong> <?php echo e($resignation->notice_date); ?></p>
                                    <p><strong><?php echo e(__('Resignation Date')); ?>:</strong> <?php echo e($resignation->resignation_date); ?></p>
                                    <p><strong><?php echo e(__('Description')); ?>:</strong> <?php echo e($resignation->description); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6><strong><?php echo e(__('Approval Status')); ?></strong></h6>
                                    
                                    <!-- Overall Status -->
                                    <div class="mb-3">
                                        <span class="badge badge-<?php echo e($resignation->status == 'approved' ? 'success' : ($resignation->status == 'rejected' ? 'danger' : 'warning')); ?> badge-lg">
                                            <?php echo e(ucfirst($resignation->status)); ?>

                                        </span>
                                    </div>
                                    
                                    <!-- HR Approval Status -->
                                    <div class="mb-2">
                                        <strong><?php echo e(__('HR Approval')); ?>:</strong>
                                        <?php if($resignation->hr_approved): ?>
                                            <span class="badge badge-success"><?php echo e(__('Approved')); ?></span>
                                            <?php if($resignation->hr_approved_at): ?>
                                                <small class="text-muted">(<?php echo e(\Carbon\Carbon::parse($resignation->hr_approved_at)->format('d-m-Y H:i')); ?>)</small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge badge-warning"><?php echo e(__('Pending')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Admin Approval Status -->
                                    <div class="mb-2">
                                        <strong><?php echo e(__('Admin Approval')); ?>:</strong>
                                        <?php if($resignation->admin_approved): ?>
                                            <span class="badge badge-success"><?php echo e(__('Approved')); ?></span>
                                            <?php if($resignation->admin_approved_at): ?>
                                                <small class="text-muted">(<?php echo e(\Carbon\Carbon::parse($resignation->admin_approved_at)->format('d-m-Y H:i')); ?>)</small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge badge-warning"><?php echo e(__('Pending')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Approval Notes -->
                                    <?php if($resignation->hr_approval_notes): ?>
                                        <div class="mt-3">
                                            <strong><?php echo e(__('HR Notes')); ?>:</strong>
                                            <p class="text-muted"><?php echo e($resignation->hr_approval_notes); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if($resignation->admin_approval_notes): ?>
                                        <div class="mt-3">
                                            <strong><?php echo e(__('Admin Notes')); ?>:</strong>
                                            <p class="text-muted"><?php echo e($resignation->admin_approval_notes); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <h6><strong><?php echo e(__('Approval Progress')); ?></strong></h6>
                                <div class="progress" style="height: 25px;">
                                    <?php
                                        $progress = 0;
                                        if($resignation->hr_approved) $progress += 50;
                                        if($resignation->admin_approved) $progress += 50;
                                    ?>
                                    <div class="progress-bar bg-<?php echo e($progress == 100 ? 'success' : ($progress > 0 ? 'info' : 'warning')); ?>" 
                                         role="progressbar" style="width: <?php echo e($progress); ?>%" 
                                         aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo e($progress); ?>% <?php echo e(__('Complete')); ?>

                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <?php if($progress == 100): ?>
                                            <?php echo e(__('Your resignation has been fully approved!')); ?>

                                        <?php elseif($progress == 50): ?>
                                            <?php echo e(__('HR has approved. Waiting for Admin approval.')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Waiting for HR and Admin approval.')); ?>

                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="container-fluid mb-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-resignation')): ?>
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> <?php echo e(__('Add Resignation')); ?></button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-resignation')): ?>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            <?php endif; ?>
        </div>


        <div class="table-responsive">
            <table id="resignation-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th><?php echo e(__('Resignation Date')); ?></th>
                    <th><?php echo e(__('Notice Date')); ?></th>
                    <th><?php echo e(__('Status')); ?></th>
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
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Resignation')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <?php if($employee): ?>
                                <input type="hidden" name="company_id" value="<?php echo e($employee->company_id); ?>">
                                <input type="hidden" name="department_id" value="<?php echo e($employee->department_id); ?>">
                                <input type="hidden" name="employee_id" value="<?php echo e($employee->id); ?>">
                            <?php else: ?>
                                <div class="alert alert-danger">
                                    No employee record found for your user. Please contact admin.
                                </div>
                            <?php endif; ?>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Notice Date')); ?></label>
                                <input type="text" name="notice_date" id="notice_date" class="form-control date"
                                       value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Resignation Date')); ?></label>
                                <input type="text" name="resignation_date" id="resignation_date"
                                       class="form-control date" value="">
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Description')); ?></label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="3"></textarea>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                           value=<?php echo e(trans('file.Add')); ?> />
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="resignation_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Resignation Info')); ?></h4>
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
                                        <th><?php echo e(trans('file.Employee')); ?></th>
                                        <td id="employee_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Department')); ?></th>
                                        <td id="department_id_show"></td>
                                    </tr>


                                    <tr>
                                        <th><?php echo e(trans('file.Description')); ?></th>
                                        <td id="description_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Resignation Date')); ?></th>
                                        <td id="resignation_date_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Notice Date')); ?></th>
                                        <td id="notice_date_id"></td>
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
        $(document).ready(function () {

            let date = $('.date');
            date.datepicker({
                format: '<?php echo e(env('Date_Format_JS')); ?>',
                autoclose: true,
                todayHighlight: true
            });


            let table_table = $('#resignation-table').DataTable({
                initComplete: function () {
                    this.api().columns([1]).every(function () {
                        let column = this;
                        let select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                let val = $.fn.dataTable.util.escapeRegex(
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
                    url: "<?php echo e(route('resignations.index')); ?>",
                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'employee',
                        name: 'employee',
                    },
                    {
                        data: 'company',
                        name: 'company',
                    },
                    {
                        data: 'department',
                        name: 'department',

                    },
                    {
                        data: 'resignation_date',
                        name: 'resignation_date',
                    },
                    {
                        data: 'notice_date',
                        name: 'notice_date',
                    },
                    {
                        data: 'status',
                        name: 'status',
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
            new $.fn.dataTable.FixedHeader(table_table);
        });


        $('#create_record').on('click', function () {

            $('.modal-title').text('<?php echo e(__('Add Resignation')); ?>');
            $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
            $('#action').val('<?php echo e(trans("file.Add")); ?>');
            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function (event) {
            event.preventDefault();
            if ($('#action').val() == '<?php echo e(trans('file.Add')); ?>') {

                $.ajax({
                    url: "<?php echo e(route('resignations.store')); ?>",
                    method: "POST",
                    data: new FormData(this),
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
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#sample_form')[0].reset();
                            $('select').selectpicker('refresh');
                            $('.date').datepicker('update');
                            $('#resignation-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            }

            if ($('#action').val() == '<?php echo e(trans('file.Edit')); ?>') {
                $.ajax({
                    url: "<?php echo e(route('resignations.update')); ?>",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        let html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (let count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            setTimeout(function () {
                                $('#formModal').modal('hide');
                                $('.date').datepicker('update');
                                $('select').selectpicker('refresh');
                                $('#resignation-table').DataTable().ajax.reload();
                                $('#sample_form')[0].reset();
                            }, 2000);

                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                });
            }
        });

        $(document).on('click', '.show_new', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            let target = '<?php echo e(route('resignations.index')); ?>/' + id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (result) {

                    $('#description_id').html(result.data.description);
                    $('#company_id_show').html(result.company_name);
                    $('#employee_id_show').html(result.employee_name);
                    $('#department_id_show').html(result.department);
                    $('#resignation_date_id').html(result.data.resignation_date);
                    $('#notice_date_id').html(result.data.notice_date);

                    $('#resignation_modal').modal('show');
                    $('.modal-title').text("<?php echo e(__('Resignation Info')); ?>");
                }
            });
        });


        $(document).on('click', '.edit', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            let target = "<?php echo e(route('resignations.index')); ?>/" + id + '/edit';


            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {

                    $('#description').val(html.data.description);
                    $('#resignation_date').val(html.data.resignation_date);
                    $('#notice_date').val(html.data.notice_date);
                    $('#company_id').selectpicker('val', html.data.company_id);

                    let all_departments = '';
                    $.each(html.departments, function (index, value) {
                        all_departments += '<option value=' + value['id'] + '>' + value['department_name'] + '</option>';
                    });
                    $('#department_id').empty().append(all_departments);
                    $('#department_id').selectpicker('refresh');
                    $('#department_id').selectpicker('val', html.data.department_id);
                    $('#department_id').selectpicker('refresh');

                    let all_employees = '';
                    $.each(html.employees, function (index, value) {
                        all_employees += '<option value=' + value['id'] + '>' + value['first_name'] + ' ' + value['last_name'] + '</option>';
                    });
                    $('#employee_id').empty().append(all_employees);
                    $('#employee_id').selectpicker('refresh');
                    $('#employee_id').selectpicker('val', html.data.employee_id);
                    $('#employee_id').selectpicker('refresh');

                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text('<?php echo e(trans('file.Edit')); ?>');
                    $('#action_button').val('<?php echo e(trans('file.Edit')); ?>');
                    $('#action').val('<?php echo e(trans('file.Edit')); ?>');
                    $('#formModal').modal('show');
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
            let table = $('#resignation-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Resignation')])); ?>')) {
                    $.ajax({
                        url: '<?php echo e(route('mass_delete_resignations')); ?>',
                        method: 'POST',
                        data: {
                            resignationIdArray: id
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
                            $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);

                        }

                    });
                }
            } else {

            }
        });


        $('#close').on('click', function () {
            $('#sample_form')[0].reset();
            $('select').selectpicker('refresh');
            $('.date').datepicker('update');
            $('#resignation-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "<?php echo e(route('resignations.index')); ?>/" + delete_id + '/delete';
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
                        $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        $('#confirmModal').modal('hide');
                        $('#resignation-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });

        $('.dynamic').change(function () {
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

        // HR Approval functionality
        $(document).on('click', '.hr_approve', function () {
            let resignation_id = $(this).attr('id');
            let notes = prompt('Enter approval notes (optional):');
            
            $.ajax({
                url: "<?php echo e(url('core_hr/resignations')); ?>/" + resignation_id + "/hr-approve",
                method: "POST",
                data: {
                    notes: notes,
                    _token: $('input[name="_token"]').val()
                },
                success: function (data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    $('#resignation-table').DataTable().ajax.reload();
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    let html = '<div class="alert alert-danger">Error: ' + error + '</div>';
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });

        // HR Rejection functionality
        $(document).on('click', '.hr_reject', function () {
            let resignation_id = $(this).attr('id');
            let notes = prompt('Enter rejection reason:');
            
            if (notes === null) return; // User cancelled
            
            $.ajax({
                url: "<?php echo e(url('core_hr/resignations')); ?>/" + resignation_id + "/hr-reject",
                method: "POST",
                data: {
                    notes: notes,
                    _token: $('input[name="_token"]').val()
                },
                success: function (data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    $('#resignation-table').DataTable().ajax.reload();
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    let html = '<div class="alert alert-danger">Error: ' + error + '</div>';
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });

        // Admin Approval functionality
        $(document).on('click', '.admin_approve', function () {
            let resignation_id = $(this).attr('id');
            let notes = prompt('Enter approval notes (optional):');
            
            $.ajax({
                url: "<?php echo e(url('core_hr/resignations')); ?>/" + resignation_id + "/admin-approve",
                method: "POST",
                data: {
                    notes: notes,
                    _token: $('input[name="_token"]').val()
                },
                success: function (data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    $('#resignation-table').DataTable().ajax.reload();
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    let html = '<div class="alert alert-danger">Error: ' + error + '</div>';
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });

        // Admin Rejection functionality
        $(document).on('click', '.admin_reject', function () {
            let resignation_id = $(this).attr('id');
            let notes = prompt('Enter rejection reason:');
            
            if (notes === null) return; // User cancelled
            
            $.ajax({
                url: "<?php echo e(url('core_hr/resignations')); ?>/" + resignation_id + "/admin-reject",
                method: "POST",
                data: {
                    notes: notes,
                    _token: $('input[name="_token"]').val()
                },
                success: function (data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    $('#resignation-table').DataTable().ajax.reload();
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    let html = '<div class="alert alert-danger">Error: ' + error + '</div>';
                    $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        });

    })(jQuery);
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/crm/resources/views/core_hr/resignation/index.blade.php ENDPATH**/ ?>