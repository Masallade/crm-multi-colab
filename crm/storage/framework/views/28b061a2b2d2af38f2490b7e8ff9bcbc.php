
<?php $__env->startSection('content'); ?>

    <section>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <?php echo e(__('Pension Info')); ?> <span id="details_month_year"></span> </h3>
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
                                                        <select class="form-control selectpicker dynamic"
                                                                name="filter_company" id="company_id"
                                                                data-first_name="first_name" data-last_name="last_name"
                                                                data-placeholder="Company" data-column="1" required=""
                                                                tabindex="-1" aria-hidden="true">
                                                            <option value="0"><?php echo e(__('All Companies')); ?></option>
                                                            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="employee_id"><?php echo e(trans('file.Employee')); ?></label>
                                                        <select class="form-control selectpicker default_emp"
                                                                name="filter_employee" id="employee_id"
                                                                data-placeholder="<?php echo e(trans('file.Employee')); ?>" required="" tabindex="-1"
                                                                aria-hidden="true">
                                                            <option value="0"><?php echo e(__('All Employees')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="month_year"><?php echo e(__('Select Month')); ?></label>
                                                        <input class="form-control month_year date"
                                                               placeholder="<?php echo e(__('Select Month')); ?>" readonly=""
                                                               id="month_year" name="month_year" type="text" value="">
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
                        <div class="container-fluid"><span id="general_result"></span></div>
                        <div class="table-responsive">
                            <table id="pension_report-table" class="table ">
                                <thead>
                                <tr>
                                    <th><?php echo e(__('Employee Name')); ?></th>
                                    <th><?php echo e(__('Month-Year')); ?></th>
                                    <th><?php echo e(__('payment Type')); ?></th>
                                    <th><?php echo e(__('Basic Salary')); ?></th>
                                    <th><?php echo e(__('Pension Type')); ?></th>
                                    <th><?php echo e(__('Pension Amount')); ?></th>
                                    <th><?php echo e(__('Remainig Balance')); ?></th>
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

        $(document).ready(function () {

            let date = $('.date');
            date.datepicker({
                format: "MM-yyyy",
                startView: "months",
                minViewMode: 1,
                autoclose: true,
            }).datepicker("setDate", new Date());

            fill_datatable();

            function fill_datatable(filter_company = '', filter_employee = '', filter_month_year = '') {
                $('#details_month_year').html($('#month_year').val());
                let table_table = $('#pension_report-table').DataTable({
                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?php echo e(route('report.pension')); ?>",
                        data: {
                            filter_company: filter_company,
                            filter_employee: filter_employee,
                            filter_month_year: filter_month_year,
                            "_token": "<?php echo e(csrf_token()); ?>"
                        },
                    },

                    columns: [
                        {
                            data: 'employee_name',
                            name: 'employee_name'
                        },
                        {
                            data: 'month_year',
                            name: 'month_year'
                        },
                        {
                            data: 'payment_type',
                            name: 'payment_type'
                        },
                        {
                            data: 'basic_salary',
                            name: 'basic_salary'
                        },
                        {
                            data: 'pension_type',
                            name: 'pension_type'
                        },
                        {
                            data: 'pension_amount',
                            name: 'pension_amount'
                        },
                        {
                            data: 'remaining',
                            name: 'remaining'
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
                            "orderable": false,
                            'targets': [0],
                        },
                    ],

                    'select': {style: 'multi', selector: 'td:first-child'},
                    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    dom: '<"row"lfB>rtip',
                    buttons: [
                        {
                            extend: 'pdf',
                            text: '<?php echo e(trans("file.PDF")); ?>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'csv',
                            text: '<?php echo e(trans("file.CSV")); ?>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },
                        {
                            extend: 'print',
                            text: '<?php echo e(trans("file.Print")); ?>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                        },

                        {
                            extend: 'colvis',
                            text: '<?php echo e(__('Column visibility')); ?>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            }

            new $.fn.dataTable.FixedHeader($('#pension_report-table').DataTable());

            $('#filter_form').on('submit',function (e) {
                e.preventDefault();
                var filter_company = $('#company_id').val();
                var filter_employee = $('#employee_id').val();
                var filter_month_year = $('#month_year').val();
                if (filter_company !== '' && filter_employee !== '' && filter_month_year !== '') {
                    $('#pension_report-table').DataTable().destroy();
                    fill_datatable(filter_company, filter_employee, filter_month_year);
                } else {
                    alert('<?php echo e(__('Select Both filter option')); ?>');
                }
            });
        });

        $('.dynamic').change(function() {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let first_name = $(this).data('first_name');
                let last_name = $(this).data('last_name');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"<?php echo e(route('dynamic_employee')); ?>",
                    method:"POST",
                    data:{ value:value, _token:_token, first_name:first_name,last_name:last_name},
                    success:function(result)
                    {
                        $('select').selectpicker("destroy");
                        $('#employee_id').html(result);
                        $('.default_emp').prepend('<option value="0" selected><?php echo e(__('All Employees')); ?></option>');
                        $('select').selectpicker();

                    }
                });
            }
        });
    })(jQuery);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/report/pension_report.blade.php ENDPATH**/ ?>