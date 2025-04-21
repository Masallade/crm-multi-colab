
<?php $__env->startSection('content'); ?>


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="container-fluid mb-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-meeting')): ?>
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> <?php echo e(__('Add Meeting')); ?></button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-meeting')): ?>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table id="meeting-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(__('Meeting Title')); ?></th>
                    <th><?php echo e(__('Meeting Date')); ?></th>
                    <th><?php echo e(__('Meeting Time')); ?></th>
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
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Meeting')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal">
                    <div class="modal-body">

                            <?php echo csrf_field(); ?>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo e(trans('file.Company')); ?> *</label>
                                        <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                                data-live-search="true" data-live-search-style="contains"
                                                data-first_name="first_name" data-last_name="last_name"
                                                title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>...'>
                                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label><?php echo e(trans('file.Employee')); ?> *</label>
                                    <select name="employee_id[]" id="employee_id" class="selectpicker form-control"
                                            data-live-search="true" data-live-search-style="contains" multiple
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>...'>
                                    </select>
                                </div>


                                <div class="col-md-6 form-group">
                                    <label><?php echo e(__('Meeting Title')); ?> *</label>
                                    <input type="text" name="meeting_title" id="meeting_title" required class="form-control"
                                           placeholder="<?php echo e(__('Meeting Title')); ?>">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label><?php echo e(__('Meeting Date')); ?> *</label>
                                    <input type="text" name="meeting_date" id="meeting_date" autocomplete="off" required
                                           class="form-control date"
                                           value="">
                                </div>

                                <div class="col-md-6">
                                    <label><?php echo e(__('Meeting Time')); ?></label>
                                    <input type="text" name="meeting_time" id="meeting_time" required class="form-control time" autocomplete="off" value="" placeholder="Meeting Time">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label><?php echo e(trans('file.Status')); ?></label>
                                    <select name="status" id="status" class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...'>
                                        <option value="pending"><?php echo e(trans('file.Pending')); ?></option>
                                        <option value="ongoing"><?php echo e(trans('file.Ongoing')); ?></option>
                                        <option value="completed"><?php echo e(trans('file.Completed')); ?></option>
                                        <option value="postponed"><?php echo e(trans('file.Postponed')); ?></option>
                                    </select>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="meeting_note"><strong><?php echo e(__('Meeting Note')); ?></strong></label>
                                    <textarea class="form-control" id="meeting_note" name="meeting_note"
                                              rows="3"></textarea>
                                </div>

                                <div class="col-md-6 form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="is_notify" id="is_notify"
                                               value="1">
                                        <label class="custom-control-label"
                                               for="is_notify"><?php echo e(trans('file.Notification')); ?></label>
                                    </div>
                                </div>


                                <div class="container">
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="action" id="action"/>
                                        <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning btn-block btn-lg" value=<?php echo e(trans('file.Add')); ?>>
                </form>
            </div>
        </div>
    </div>





    <div class="modal fade" id="meeting_model" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true"
        >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Meeting Info')); ?></h4>
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
                                        <th><?php echo e(__('Meeting Title')); ?></th>
                                        <td id="meeting_title_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Meeting Date')); ?></th>
                                        <td id="meeting_date_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Meeting Time')); ?></th>
                                        <td id="meeting_time_show"></td>
                                    </tr>


                                    <tr>
                                        <th><?php echo e(__('Meeting Note')); ?></th>
                                        <td id="meeting_note_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Status')); ?></th>
                                        <td id="status_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Notification')); ?></th>
                                        <td id="notification_show"></td>
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


            let table_table = $('#meeting-table').DataTable({
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
                    url: "<?php echo e(route('meetings.index')); ?>",
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
                            return data.company + "<br><td><div class = 'badge badge-success'>" + data.status + "</div></td><br>";

                        }
                    },
                    {
                        data: 'employee',
                        render: function (data) {
                            return data.join("<br>");
                        }
                    },
                    {
                        data: 'meeting_title',
                        name: 'meeting_title',
                    },
                    {
                        data: 'meeting_date',
                        name: 'meeting_date',
                    },
                    {
                        data: 'meeting_time',
                        name: 'meeting_time',
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
                        'targets': [0, 6],
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

            $('.modal-title').text('<?php echo e(__('Add Meeting')); ?>');
            $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
            $('#action').val('<?php echo e(trans("file.Add")); ?>');
            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function (event) {
            event.preventDefault();
            if ($('#action').val() == '<?php echo e(trans('file.Add')); ?>') {


                $.ajax({
                    url: "<?php echo e(route('meetings.store')); ?>",
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
                            $('#meeting-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            }

            if ($('#action').val() == '<?php echo e(trans('file.Edit')); ?>') {


                $.ajax({
                    url: "<?php echo e(route('meetings.update')); ?>",
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
                            setTimeout(function () {
                                $('#formModal').modal('hide');
                                $('.date').datepicker('update');
                                $('select').selectpicker('refresh');
                                $('#meeting-table').DataTable().ajax.reload();
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

            let target = '<?php echo e(route('meetings.index')); ?>/' + id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (result) {

                    $('#meeting_title_show').html(result.data.meeting_title);
                    $('#company_id_show').html(result.company_name);
                    $('#meeting_date_show').html(result.meeting_date_name);
                    $('#meeting_time_show').html(result.data.meeting_time);
                    $('#meeting_note_show').html(result.data.meeting_title);
                    $('#employee_id_show').html(result.employee_name);
                    $('#status_show').html(result.data.status);

                    if (result.data.is_notify == 1)
                        $('#notification_show').html('On');
                    else {
                        $('#notification_show').html('Off');
                    }

                    $('#meeting_model').modal('show');
                    $('.modal-title').text("<?php echo e(__('Meeting Info')); ?>");
                }
            });
        });


        $(document).on('click', '.edit', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');


            let target = "<?php echo e(route('meetings.index')); ?>/" + id + '/edit';

            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {


                    $('#meeting_title').val(html.data.meeting_title);
                    $('#meeting_note').val(html.data.meeting_note);
                    $('#company_id').selectpicker('val', html.data.company_id);
                    let all_employees = '';
                    $.each(html.employees, function (index, value) {
                        all_employees += '<option value=' + value['id'] + '>' + value['first_name'] + ' ' + value['last_name'] + '</option>';
                    });
                    $('#employee_id').empty().append(all_employees);
                    $('#employee_id').selectpicker('refresh');
                    $('#employee_id').selectpicker('val', html.selected_employee);
                    $('#employee_id').selectpicker('refresh');
                    $('#meeting_time').val(html.data.meeting_time);
                    $('#meeting_date').val(html.data.meeting_date);
                    $('#status').selectpicker('val', html.data.status);

                    if (html.data.is_notify == 1) {
                        $('#is_notify').prop('checked', true);
                    } else {
                        $('#is_notify').prop('checked', false);
                    }

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
            let table = $('#meeting-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Meeting')])); ?>')) {
                    $.ajax({
                        url: '<?php echo e(route('mass_delete_meetings')); ?>',
                        method: 'POST',
                        data: {
                            meetingIdArray: id
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
                alert('<?php echo e(__('Please select atleast one checkbox')); ?>');
            }
        });


        $('.close').on('click', function () {
            $('#sample_form')[0].reset();
            $('select').selectpicker('refresh');
            $('.date').datepicker('update');
            $('#meeting-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "<?php echo e(route('meetings.index')); ?>/" + delete_id + '/delete';
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
                        $('#confirmModal').modal('hide');
                        $('#meeting-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });

        $('.dynamic').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let first_name = $(this).data('first_name');
                let last_name = $(this).data('last_name');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('dynamic_employee')); ?>",
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

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/event and meeting/meeting/index.blade.php ENDPATH**/ ?>