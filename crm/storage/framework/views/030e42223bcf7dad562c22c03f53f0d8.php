
<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <?php echo e(__('Filter Employee')); ?> </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" id="filter_form" class="form-horizontal">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="company_id"><?php echo e(trans('file.Company')); ?></label>
                                                        <select class="form-control selectpicker dynamic" name="filter_company" id="company_id" data-dependent="department_name" data-placeholder="Company" data-column="1" required="" tabindex="-1" aria-hidden="true">
                                                            <option value="0"><?php echo e(trans('file.All')); ?></option>
                                                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="department_id"><?php echo e(trans('file.Department')); ?></label>
                                                        <select class="form-control selectpicker designation default_dept" name="filter_department" data-designation_name="designation_name" id="department_id" data-placeholder="Department" required="" tabindex="-1" aria-hidden="true">
                                                            <option value="0"><?php echo e(trans('file.All')); ?></option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="designation_id"><?php echo e(trans('file.Designation')); ?></label>
                                                        <select class="form-control selectpicker default_desig" name="filter_designation"  id="designation_id" data-placeholder="Designation" required="" tabindex="-1" aria-hidden="true">
                                                            <option value="0"><?php echo e(trans('file.All')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-actions">
                                                            <button type="submit" class="filtering btn btn-primary"><i
                                                                        class="fa fa-check-square-o"></i> <?php echo e(trans('file.Search')); ?>

                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title text-center"><h3><?php echo e(__('Employee Info')); ?> <span
                                        id="employee_info"></span></h3></div>

                        <div class="table-responsive">
                            <table id="employee_report-table" class="table ">
                                <thead>
                                <tr>
                                    <th class="not-exported"></th>
                                    <th><?php echo e(trans('file.Username')); ?></th>
                                    <th><?php echo e(trans('file.Name')); ?></th>
                                    <th><?php echo e(trans('file.Company')); ?></th>
                                    <th><?php echo e(trans('file.Email')); ?></th>
                                    <th><?php echo e(trans('file.Department')); ?></th>
                                    <th><?php echo e(trans('file.Designation')); ?></th>
                                    <th><?php echo e(trans('file.Status')); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    (function($) {
        "use strict";

        fill_datatable();

        function fill_datatable(company_id = '', department_id = '',designation_id= '') {

            let table_table = $('#employee_report-table').DataTable({
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
                    url: "<?php echo e(route('report.employees')); ?>",
                    data: {
                        company_id: company_id,
                        department_id: department_id,
                        designation_id: designation_id,
                        "_token": "<?php echo e(csrf_token()); ?>"
                    }
                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'username',
                        name: 'username',
                    },

                    {
                        data: 'name',
                        name: 'name',
                    },

                    {
                        data: 'company',
                        name: 'company',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'department',
                        name: 'department',
                    },
                    {
                        data: 'designation',
                        name: 'designation',
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        render: function(data) {
                            if (data == 1) {
                                return "<td><div class = 'badge badge-success'><?php echo e(trans('file.Active')); ?></div>"
                            } else {
                                return "<td><div class = 'badge badge-danger'><?php echo e(trans('file.Inactive')); ?></div>"
                            }
                        }
                    },
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

                        "orderable": true,
                        'targets': [0],
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
        }

        $('#filter_form').on('submit',function (e) {
            e.preventDefault();

            let company_id = $('#company_id').val();
            let department_id = $('#department_id').val();
            let designation_id = $('#designation_id').val();
            $('#employee_report-table').DataTable().destroy();
            fill_datatable(company_id, department_id,designation_id);
        });


        $('.dynamic').change(function() {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let dependent = $(this).data('dependent');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"<?php echo e(route('dynamic_department')); ?>",
                    method:"POST",
                    data:{ value:value, _token:_token, dependent:dependent},
                    success:function(result)
                    {
                        $('select').selectpicker("destroy");
                        $('#department_id').html(result);
                        $('.default_dept').prepend('<option value="0" selected><?php echo e(trans('file.All')); ?></option>');
                        $('select').selectpicker();
                    }
                });
            }
        });

        $('.designation').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let designation_name = $(this).data('designation_name');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('dynamic_designation_department')); ?>",
                    method: "POST",
                    data: {value: value, _token: _token, designation_name: designation_name},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#designation_id').html(result);
                        $('.default_desig').prepend('<option value="0" selected><?php echo e(trans('file.All')); ?></option>');
                        $('select').selectpicker();

                    }
                });
            }
        });
    })(jQuery);

</script>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/report/employees_report.blade.php ENDPATH**/ ?>