
<?php $__env->startSection('content'); ?>


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>


        <div class="container-fluid mb-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-travel')): ?>
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> <?php echo e(__('Add Travel')); ?></button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-travel')): ?>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table id="travel-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(__('Place Of Visit')); ?></th>
                    <th><?php echo e(__('Purpose Of Visit')); ?></th>
                    <th><?php echo e(__('Start Date')); ?></th>
                    <th><?php echo e(__('End Date')); ?></th>
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
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Travel')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Company')); ?></label>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Employee')); ?></label>
                                    <select name="employee_id" id="employee_id" class="selectpicker form-control"
                                            data-live-search="true" data-live-search-style="contains"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>...'>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Arrangement Type')); ?></label>
                                <select name="travel_type_id" id="travel_type_id" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Arrangement')])); ?>...'>
                                    <?php $__currentLoopData = $travel_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $travel_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($travel_type->id); ?>"><?php echo e($travel_type->arrangement_type); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>


                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Purpose Of Visit')); ?> *</label>
                                <input type="text" name="purpose_of_visit" id="purpose_of_visit" class="form-control"
                                       placeholder="<?php echo e(__('Purpose Of Visit')); ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Place Of Visit')); ?> *</label>
                                <input type="text" name="place_of_visit" id="place_of_visit" class="form-control"
                                       placeholder="<?php echo e(__('Place Of Visit')); ?>">
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Description')); ?></label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Start Date')); ?> *</label>
                                <input type="text" name="start_date" id="start_date" class="form-control date"
                                       autocomplete="off" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('End Date')); ?> *</label>
                                <input type="text" name="end_date" id="end_date" class="form-control date"
                                       autocomplete="off" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Expected Budget')); ?></label>
                                <input type="text" name="expected_budget" id="expected_budget" class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Actual Budget')); ?></label>
                                <input type="text" name="actual_budget" id="actual_budget" class="form-control">
                            </div>


                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Travel Mode')); ?></label>
                                <select name="travel_mode" id="travel_mode" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Travel Mode')); ?>'>
                                    <option value="By Bus"><?php echo e(__('By Bus')); ?></option>
                                    >
                                    <option value="By Train"><?php echo e(__('By Train')); ?></option>
                                    <option value="By Plane"><?php echo e(__('By Plane')); ?></option>
                                    <option value="By Taxi"><?php echo e(__('By Taxi')); ?></option>
                                    <option value="By Rental Car"><?php echo e(__('By Rental Car')); ?></option>
                                    <option value="By Other"><?php echo e(__('By Other')); ?></option>
                                </select>
                            </div>


                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Status')); ?></label>
                                <select name="status" id="status" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...'>
                                    <option value="pending"><?php echo e(trans('file.Pending')); ?></option>
                                    <option value="first level approval"><?php echo e(__('First Level Approval')); ?></option>
                                    <option value="approved"><?php echo e(trans('file.Approved')); ?></option>
                                    <option value="rejected"><?php echo e(trans('file.Rejected')); ?></option>
                                </select>
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





    <div class="modal fade" id="travel_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Travel Info')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <span id="travel_photo_id"></span>

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
                                        <th><?php echo e(__('Start Date')); ?></th>
                                        <td id="start_date_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('End Date')); ?></th>
                                        <td id="end_date_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Purpose Of Visit')); ?></th>
                                        <td id="purpose_of_visit_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Place Of Visit')); ?></th>
                                        <td id="place_of_visit_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Travel Mode')); ?></th>
                                        <td id="travel_mode_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Arrangement Type')); ?></th>
                                        <td id="travel_type_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Expected Budget')); ?></th>
                                        <td id="expected_budget_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Actual Budget')); ?></th>
                                        <td id="actual_budget_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Status')); ?></th>
                                        <td id="status_show"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Travel Info')); ?></th>
                                        <td id="description_show"></td>
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


            let table_table = $('#travel-table').DataTable({
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
                    url: "<?php echo e(route('travels.index')); ?>",
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
                            return data.employee + "<br><br><td><?php echo e(__('Expected Budget :')); ?>" + data.expected_budget + "</td><br>" +
                                "<td><?php echo e(__('Actual Budget :')); ?>" + data.actual_budget + "</td>"
                                + "<br><td><div class = 'badge badge-success'>" + data.status + "</div></td><br>";
                        }
                    },
                    {
                        data: 'company',
                        name: 'company',
                    },
                    {
                        data: 'place_of_visit',
                        name: 'place_of_visit',
                    },
                    {
                        data: 'purpose_of_visit',
                        name: 'purpose_of_visit',
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
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
                        'targets': [0, 7],
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

            $('.modal-title').text('<?php echo e(__('Add Travel')); ?>');
            $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
            $('#action').val('<?php echo e(trans("file.Add")); ?>');
            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function (event) {
            event.preventDefault();
            if ($('#action').val() == '<?php echo e(trans('file.Add')); ?>') {

                $.ajax({
                    url: "<?php echo e(route('travels.store')); ?>",
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
                            $('#travel-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            }

            if ($('#action').val() == '<?php echo e(trans('file.Edit')); ?>') {
                $.ajax({
                    url: "<?php echo e(route('travels.update')); ?>",
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
                                $('#travel-table').DataTable().ajax.reload();
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

            let target = '<?php echo e(route('travels.index')); ?>/' + id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (result) {

                    $('#description_show').html(result.data.description);
                    $('#company_id_show').html(result.company_name);
                    $('#employee_id_show').html(result.employee_name);
                    $('#travel_type_show').html(result.arrangement_name);
                    $('#start_date_show').html(result.data.start_date);
                    $('#end_date_show').html(result.data.end_date);
                    $('#status_show').html(result.data.status);
                    $('#travel_mode_show').html(result.data.travel_mode);
                    $('#expected_budget_show').html(result.data.expected_budget);
                    $('#actual_budget_show').html(result.data.actual_budget);
                    $('#purpose_of_visit_show').html(result.data.purpose_of_visit);
                    $('#place_of_visit_show').html(result.data.place_of_visit);


                    $('#travel_modal').modal('show');
                    $('.modal-title').text("<?php echo e(__('Travel Info')); ?>");
                }
            });
        });


        $(document).on('click', '.edit', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            let target = "<?php echo e(route('travels.index')); ?>/" + id + '/edit';


            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {

                    $('#description').val(html.data.description);
                    $('#start_date').val(html.data.start_date);
                    $('#end_date').val(html.data.end_date);
                    $('#purpose_of_visit').val(html.data.purpose_of_visit);
                    $('#place_of_visit').val(html.data.place_of_visit);
                    $('#expected_budget').val(html.data.expected_budget);
                    $('#actual_budget').val(html.data.actual_budget);
                    $('#travel_mode').selectpicker('val', html.data.travel_mode);
                    $('#company_id').selectpicker('val', html.data.company_id);

                    let all_employees = '';
                    $.each(html.employees, function (index, value) {
                        all_employees += '<option value=' + value['id'] + '>' + value['first_name'] + ' ' + value['last_name'] + '</option>';
                    });
                    $('#employee_id').empty().append(all_employees);
                    $('#employee_id').selectpicker('refresh');
                    $('#employee_id').selectpicker('val', html.data.employee_id);
                    $('#employee_id').selectpicker('refresh');

                    $('#status').selectpicker('val', html.data.status);
                    $('#travel_type_id').selectpicker('val', html.data.travel_type);


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
            let table = $('#travel-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Travel')])); ?>')) {
                    $.ajax({
                        url: '<?php echo e(route('mass_delete_travels')); ?>',
                        method: 'POST',
                        data: {
                            travelIdArray: id
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
            $('#travel-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "<?php echo e(route('travels.index')); ?>/" + delete_id + '/delete';
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
                        $('#travel-table').DataTable().ajax.reload();
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

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/core_hr/travel/index.blade.php ENDPATH**/ ?>