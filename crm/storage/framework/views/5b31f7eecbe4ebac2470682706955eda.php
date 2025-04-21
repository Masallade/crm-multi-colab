
<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <?php echo e(__('Filter Project')); ?> </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" id="filter_form" class="form-horizontal">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo e(__('Selecting',['key'=>trans('file.Project')])); ?>

                                                            </label>
                                                        <select name="project_id" id="project_id"
                                                                class="form-control selectpicker"
                                                                data-live-search="true" data-live-search-style="contains">
                                                            <option value="0"><?php echo e(trans('file.All')); ?></option>
                                                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($project->id); ?>"><?php echo e($project->title); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label><?php echo e(trans('file.Status')); ?></label>
                                                    <select name="project_status" id="project_status"
                                                            class="form-control selectpicker "
                                                            data-live-search="true" data-live-search-style="contains">
                                                        <option value="0"><?php echo e(trans('file.All')); ?></option>
                                                        <option value="not_started"><?php echo e(__('Not Started')); ?></option>
                                                        <option value="in_progress"><?php echo e(__('In Progress')); ?></option>
                                                        <option value="completed"><?php echo e(trans('file.Completed')); ?></option>
                                                        <option value="deferred"><?php echo e(trans('file.Deferred')); ?></option>
                                                    </select>
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

                        <div class="card-title text-center"><h3><?php echo e(__('Project Info')); ?> <span
                                        id="project_info"></span></h3></div>

                        <div class="table-responsive">
                            <table id="project_report-table" class="table ">
                                <thead>
                                <tr>
                                    <th class="not-exported"></th>
                                    <th><?php echo e(__('Project Summary')); ?></th>
                                    <th><?php echo e(trans('file.Priority')); ?></th>
                                    <th><?php echo e(__('Assigned Employees')); ?></th>
                                    <th><?php echo e(trans('file.Status')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Project Progress')); ?></th>
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
                format: '<?php echo e(env('Date_Format_JS')); ?>',
                autoclose: true,
                todayHighlight: true,
                endDate: new Date()
            });

        });


        fill_datatable();

        function fill_datatable(project_id = '', project_status = '') {

            let table_table = $('#project_report-table').DataTable({
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
                    url: "<?php echo e(route('report.project')); ?>",
                    data: {
                        project_id: project_id,
                        project_status: project_status,
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
                        data: 'summary',
                        name: 'summary'

                    },
                    {
                        data: 'project_priority',
                        name: 'project_priority',
                    },
                    {
                        data: 'assigned_employee',
                        name: 'assigned_employee',
                        render: function (data) {
                            return data.join("<br>");
                        }
                    },
                    {
                        data: 'project_status',
                        name: 'project_status',
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
                        data: 'project_progress',
                        name: 'project_progress',
                        render: function (data) {
                            if (data !== null) {
                                if(data > 70) {
                                    return data + '% complete<div class="progress"><div class="progress-bar green" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                } else if (data > 50) {
                                    return data + '% complete<div class="progress"><div class="progress-bar yellow" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                } else {
                                    return data + '% complete<div class="progress"><div class="progress-bar red" role="progressbar" style="width: '+data+'%" aria-valuenow="'+data+'" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                }
                            } else {
                                return 0 + '% complete'
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

            let project_id = $('#project_id').val();
            let project_status = $('#project_status').val();
            $('#project_report-table').DataTable().destroy();
            fill_datatable(project_id, project_status);
        });
    })(jQuery);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/report/project_report.blade.php ENDPATH**/ ?>