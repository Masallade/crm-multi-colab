
<?php $__env->startSection('content'); ?>


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="container-fluid mb-3">

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-award')): ?>
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> <?php echo e(__('Add Award')); ?></button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-award')): ?>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            <?php endif; ?>
        </div>


        <div class="table-responsive">
            <table id="award-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(__('Award name')); ?></th>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Department')); ?></th>
                    <th><?php echo e(__('Award Date')); ?></th>
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
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Award')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Company')); ?></label>
                                    <select name="company_id" id="company_id" required
                                            class="form-control selectpicker dynamic"
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
                                    <select name="department_id" id="department_id" required
                                            class="selectpicker form-control employee"
                                            data-live-search="true" data-live-search-style="contains"
                                            data-first_name="first_name" data-last_name="last_name"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Department')])); ?>...'>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(trans('file.Employee')); ?></label>
                                    <select name="employee_id" id="employee_id" required
                                            class="selectpicker form-control"
                                            data-live-search="true" data-live-search-style="contains"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>...'>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Award Type')); ?></label>
                                <select name="award_type_id" id="award_type_id" required
                                        class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Award Type')); ?>'>
                                    <?php $__currentLoopData = $award_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($award_type->id); ?>"><?php echo e($award_type->award_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>


                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Gift')); ?> *</label>
                                <input type="text" name="gift" id="gift" class="form-control"
                                       placeholder="<?php echo e(trans('file.Gift')); ?>">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Cash')); ?> *</label>
                                <input type="text" name="cash" id="cash" class="form-control"
                                       placeholder="<?php echo e(trans('file.Cash')); ?>">
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo e(__('Award Information')); ?></label>
                                    <textarea class="form-control" id="award_information" name="award_information"
                                              rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Award Date')); ?></label>
                                <input type="text" name="award_date" id="award_date" class="form-control date" value="">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Award Photo')); ?> </label>
                                <input type="file" name="award_photo" id="award_photo" class="form-control"
                                       placeholder=<?php echo e(trans("file.Optional")); ?>>
                                <span id="store_award_photo"></span>
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

    <div class="modal fade" id="award_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"
        >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Award Information')); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <span id="award_photo_id"></span>

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
                                        <th><?php echo e(__('Award Type')); ?></th>
                                        <td id="award_type_id_show"></td>
                                    </tr>


                                    <tr>
                                        <th><?php echo e(__('Award Information')); ?></th>
                                        <td id="award_information_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Gift')); ?></th>
                                        <td id="award_gift_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(trans('file.Cash')); ?></th>
                                        <td id="award_cash_id"></td>
                                    </tr>

                                    <tr>
                                        <th><?php echo e(__('Award Date')); ?></th>
                                        <td id="award_date_id"></td>
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

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">Award Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Award Image" style="max-width: 100%; max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

function showImagePreview(imageSrc) {
    $('#modalImage').attr('src', imageSrc);
    $('#imagePreviewModal').modal('show');
}

(function($) {
    "use strict";

    $(document).ready(function () {

        let date = $('.date');
        date.datepicker({
            format: '<?php echo e(env('Date_Format_JS')); ?>',
            autoclose: true,
            todayHighlight: true
        });


        let table_table = $('#award-table').DataTable({
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
                url: "<?php echo e(route('awards.index')); ?>",
            },

            columns: [
                {
                    data: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'awardType',
                    name: 'awardType',
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
                    data: 'award_date',
                    name: 'award_date',

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
                    extend: 'pdfHtml5',
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

        $('.modal-title').text('<?php echo e(__('Add Award')); ?>');
        $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
        $('#action').val('<?php echo e(trans("file.Add")); ?>');
        $('#store_award_photo').html('');
        $('#formModal').modal('show');
    });

    $('#sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#action').val() == '<?php echo e(trans('file.Add')); ?>') {

            $.ajax({
                url: "<?php echo e(route('awards.store')); ?>",
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
                        $('#award-table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        }

        if ($('#action').val() == '<?php echo e(trans('file.Edit')); ?>') {

            $.ajax({
                url: "<?php echo e(route('awards.update')); ?>",
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
                            $('#award-table').DataTable().ajax.reload();
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

        let target = '<?php echo e(route('awards.index')); ?>/' + id;

        $.ajax({
            url: target,
            dataType: "json",
            success: function (result) {

                $('#award_information_id').html(result.data.award_information);
                $('#company_id_show').html(result.company_name);
                $('#employee_id_show').html(result.employee_name);
                $('#department_id_show').html(result.department);
                $('#award_type_id_show').html(result.award_name);
                $('#award_date_id').html(result.data.award_date);
                $('#award_gift_id').html(result.data.gift);
                $('#award_cash_id').html(result.data.cash);

                let photoHtml = "<img src='<?php echo e(URL::to('/public')); ?>/uploads/award_photos/" + result.data.award_photo + "' width='70' class='img-thumbnail' style='cursor: pointer;' onclick='showImagePreview(this.src)'>";
                photoHtml += "<input type='hidden' name='hidden_image' value='" + result.data.award_photo + "'>";
                $('#award_photo_id').html(photoHtml);

                $('#award_modal').modal('show');
                $('.modal-title').text("<?php echo e(__('Award Info')); ?>");
            }
        });
    });


    $(document).on('click', '.edit', function () {

        let id = $(this).attr('id');
        $('#form_result').html('');

        let target = "<?php echo e(route('awards.index')); ?>/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                $('#award_information').val(html.data.award_information);
                $('#award_date').val(html.data.award_date);
                $('#gift').val(html.data.gift);
                $('#cash').val(html.data.cash);
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


                $('#award_type_id').selectpicker('val', html.data.award_type_id);

                award_photo(id);

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
        let table = $('#award-table').DataTable();
        id = table.rows({selected: true}).ids().toArray();
        if (id.length > 0) {
            if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Award')])); ?>')) {
                $.ajax({
                    url: '<?php echo e(route('mass_delete_awards')); ?>',
                    method: 'POST',
                    data: {
                        ticketIdArray: id
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
        $('#store_award_photo').html('');
        $('#award-table').DataTable().ajax.reload();
    });

    $('#ok_button').on('click', function () {
        let target = "<?php echo e(route('awards.index')); ?>/" + delete_id + '/delete';
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
                    $('#award-table').DataTable().ajax.reload();
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

    function award_photo(id) {
        $.ajax({
            url: "<?php echo e(route('awards.index')); ?>/" + id + "/photo",
            dataType: "json",
            success: function (data) {
                let html = '';
                if (data.award_photo) {
                    html = `<img src="<?php echo e(URL::to('/public')); ?>/uploads/award_photos/` + data.award_photo + `" width="70" class="img-thumbnail" style="cursor: pointer;" onclick="showImagePreview(this.src)">`;
                } else {
                    html = `<img src="<?php echo e(asset('assets/images/default_photo.jpg')); ?>" width="70" class="img-thumbnail" style="cursor: pointer;" onclick="showImagePreview(this.src)">`;
                }
                $('#award_photo_id').html(html);
            }
        });
    }
})(jQuery);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/core_hr/award/index.blade.php ENDPATH**/ ?>