
<?php $__env->startSection('content'); ?>

    <section>

        <div class="container-fluid"><span id="general_result"></span></div>


        <div class="container-fluid mb-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-event')): ?>
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> <?php echo e(__('Add Event')); ?></button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-event')): ?>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            <?php endif; ?>
        </div>


        <div class="table-responsive">
            <table id="event-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th><?php echo e(__('Event Title')); ?></th>
                    <th><?php echo e(__('Event Date')); ?></th>
                    <th><?php echo e(__('Event Time')); ?></th>
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
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Event')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal">

                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Company')); ?></label>
                                    <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                            data-live-search="true" data-live-search-style="contains"
                                            data-dependent="department_name"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>...'>
                                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Department')); ?></label>
                                    <select name="department_id" id="department_id" class="selectpicker form-control"
                                            data-live-search="true" data-live-search-style="contains"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Department')])); ?>...'>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Event Title')); ?> *</label>
                                <input type="text" name="event_title" id="event_title" required class="form-control"
                                       placeholder="<?php echo e(__('Event Title')); ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Event Date')); ?> *</label>
                                <input type="text" name="event_date" id="event_date" autocomplete="off" required
                                       class="form-control date"
                                       value="">
                            </div>

                            <div class="col-md-6">
                                <label><?php echo e(__('Event Time')); ?></label>
                                <input type="text" name="event_time" id="event_time" required class="form-control time" autocomplete="off" value="" placeholder="Event Time">
                            </div>


                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Status')); ?></label>
                                <select name="status" id="status" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...'>
                                    <option value="pending"><?php echo e(trans('file.Pending')); ?></option>
                                    <option value="approved"><?php echo e(trans('file.Approved')); ?></option>
                                    <option value="postponed"><?php echo e(trans('file.Postponed')); ?></option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="event_note"><strong><?php echo e(__('Event Note')); ?></label>
                                <textarea class="form-control" id="event_note" name="event_note"
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

    <div class="modal fade" id="event_model" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true"
        >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Event Info')); ?></h4>
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
                                        <th><?php echo e(trans('file.Department')); ?></th>
                                        <td id="department_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Event Title')); ?></th>
                                        <td id="event_title_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Event Date')); ?></th>
                                        <td id="event_date_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Event Time')); ?></th>
                                        <td id="event_time_show"></td>
                                    </tr>


                                    <tr>
                                        <th><?php echo e(__('Event Note')); ?></th>
                                        <td id="event_note_show"></td>
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


            let table_table = $('#event-table').DataTable({
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
                    url: "<?php echo e(route('events.index')); ?>",
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
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'event_title',
                        name: 'event_title',
                    },
                    {
                        data: 'event_date',
                        name: 'event_date',

                    },
                    {
                        data: 'event_time',
                        name: 'event_time',
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

            $('.modal-title').text('<?php echo e(__('Add Event')); ?>');
            $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
            $('#action').val('<?php echo e(trans("file.Add")); ?>');
            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function (event) {
            event.preventDefault();
            if ($('#action').val() == '<?php echo e(trans('file.Add')); ?>') {


                $.ajax({
                    url: "<?php echo e(route('events.store')); ?>",
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
                            $('#event-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            }

            if ($('#action').val() == '<?php echo e(trans('file.Edit')); ?>') {


                $.ajax({
                    url: "<?php echo e(route('events.update')); ?>",
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
                                $('#event-table').DataTable().ajax.reload();
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

            let target = '<?php echo e(route('events.index')); ?>/' + id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (result) {

                    $('#event_title_show').html(result.data.event_title);
                    $('#company_id_show').html(result.company_name);
                    $('#event_date_show').html(result.event_date_name);
                    $('#event_time_show').html(result.data.event_time);
                    $('#event_note_show').html(result.data.event_title);
                    $('#department_id_show').html(result.department);
                    $('#status_show').html(result.data.status);

                    if (result.data.is_notify == 1)
                        $('#notification_show').html('On');
                    else {
                        $('#notification_show').html('Off');
                    }


                    $('#event_model').modal('show');
                    $('.modal-title').text("<?php echo e(__('Event Info')); ?>");
                }
            });
        });


        $(document).on('click', '.edit', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');


            let target = "<?php echo e(route('events.index')); ?>/" + id + '/edit';

            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {


                    $('#event_title').val(html.data.event_title);
                    $('#event_note').val(html.data.event_note);
                    $('#company_id').selectpicker('val', html.data.company_id);

                    let all_departments = '';
                    $.each(html.departments, function (index, value) {
                        all_departments += '<option value=' + value['id'] + '>' + value['department_name'] + '</option>';
                    });
                    $('#department_id').empty().append(all_departments);
                    $('#department_id').selectpicker('refresh');
                    $('#department_id').selectpicker('val', html.data.department_id);
                    $('#department_id').selectpicker('refresh');
                    $('#events_type_new').parent().find('.filter-option').html(html.EventType_name);
                    $('#event_time').val(html.data.event_time);
                    $('#event_date').val(html.data.event_date);
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
            let table = $('#event-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Event')])); ?>')) {
                    $.ajax({
                        url: '<?php echo e(route('mass_delete_events')); ?>',
                        method: 'POST',
                        data: {
                            eventIdArray: id
                        },
                        success: function (data) {
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
            $('#event-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "<?php echo e(route('events.index')); ?>/" + delete_id + '/delete';
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
                        $('#event-table').DataTable().ajax.reload();
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
    })(jQuery);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/event and meeting/event/index.blade.php ENDPATH**/ ?>