
<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid <?php if(auth()->user()->username != 'admin'): ?> <?php echo e('d-none-'); ?> <?php endif; ?>">
            <div class="card <?php if(auth()->user()->username != 'admin'): ?> <?php echo e('d-none'); ?> <?php endif; ?>">
                <div class="card-header with-border">
                    <h3 class="card-title"> <?php echo e(__('Add Attendance')); ?> </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info" id="add_attendance_btn" data-toggle="modal" data-target=".add-modal-data">
                                <span class="fa fa-plus"></span> <?php echo e(__('Add New')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title text-center"> Attendance Report</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label><?php echo e(trans('file.Company')); ?> *</label>
                            <select name="company_id" id="company_id"
                                    class="form-control selectpicker dynamic"
                                    data-live-search="true" data-live-search-style="contains"
                                    data-first_name="first_name" data-last_name="last_name"
                                    title='<?php echo e(__('Selecting',['key'=>trans('file.Company')])); ?>...'>
                                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <!-- <select name="employee_id" id="employee_id"
                                    class="selectpicker form-control"
                                    data-live-search="true" data-live-search-style="contains"
                                    title='<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>...'>
                            </select> -->
                            <!-- New code start -->
                            <label><?php echo e(trans('file.Employee')); ?></label><small id="clearAllButton" >Clear All <i class="fa fa-times"></i> </small>
                            <select name="employee_id[]" id="employee_id" class="selectpicker form-control"
                            multiple data-live-search="true" data-live-search-style="contains"
                            title='<?php echo e(__('Selecting',['key'=>trans('file.Employee')])); ?>...'>
                            <option value="all">Select All</option> <!-- Select All option -->
                            </select>
                            
                            <!-- New code end -->
                        </div>
                            <!-- </div> -->
                            <!-- <div class="row"> -->
                        <div class="col-md-6">
                            <form autocomplete="off" name="update_attendance_from" id="update_attendance_from"
                                method="get" accept-charset="utf-8">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="attendance_date1"><?php echo e(__('Start Date')); ?></label>
                                            <input class="form-control date" placeholder="Start Date" readonly id="attendance_date1" name="attendance_date1" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="attendance_date2"><?php echo e(__('End Date')); ?></label>
                                            <input class="form-control date" placeholder="End Date" readonly id="attendance_date2" name="attendance_date2" type="text">
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa fa-check-square-o"></i> <?php echo e(trans('file.Get')); ?>

                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="update_attendance-table" class="table ">
                <thead>
                <tr>
                    <th><?php echo e(trans('file.Employee')); ?></th>
                    <th><?php echo e(__('In Time')); ?></th>
                    <th><?php echo e(__('Out Time')); ?></th>
                    <th><?php echo e(__('Date')); ?></th>
                    <!-- <th class="not-exported-"></th> -->
                </tr>
                </thead>
            </table>
        </div>

        <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Update')); ?></h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <span id="form_result"></span>
                        <form autocomplete="off" method="post" id="edit_form" class="form-horizontal" >
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div id="att_date_edit_show_hide" class="col-md-6 form-group">
                                    <label for="attendance_date_edit"><strong><?php echo e(__('Attendance Date')); ?> *</strong></label>
                                    <input type="text" name="attendance_date" id="attendance_date_edit" required readonly class="form-control date"
                                           placeholder="<?php echo e(__('Attendance Date')); ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="clock_in_edit"><strong><?php echo e(__('Clock In')); ?></strong></label>
                                    <input type="text" name="clock_in" id="clock_in_edit" class="form-control time" value="" required>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="clock_out_edit"><strong><?php echo e(__('Clock Out')); ?></strong></label>
                                    <input type="text" name="clock_out" id="clock_out_edit" class="form-control time" value="" required>
                                </div>
                                <div class="container">
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <input type="hidden" name="employee_id" id="hidden_employee_id" />
                                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value=<?php echo e(trans('file.Add')); ?> />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
                        <button type="button" name="ok_button" id="ok_button" class="btn btn-danger"><?php echo e(trans('file.OK')); ?>'</button>
                        <button type="button" class="close btn-default" data-dismiss="modal"><?php echo e(trans('file.Cancel')); ?></button>
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
            $('.date').datepicker({
                format: '<?php echo e(env('Date_Format_JS')); ?>',
                autoclose: true,
                todayHighlight: true,
                endDate: new Date()
            }).datepicker("setDate", new Date());
        });


        fill_datatable();

        // function fill_datatable(attendance_date1 = '', attendance_date2 = '', company_id = '', employee_id = '') {

        //     let table_table = $('#update_attendance-table').DataTable({
        //         responsive: true,
        //         fixedHeader: {
        //             header: true,
        //             footer: true
        //         },
        //         processing: true,
        //         serverSide: true,
        //         ajax: {
        //             url: "<?php echo e(route('update_attendances.index')); ?>",
        //             data: {
        //                 attendance_date1: attendance_date1,
        //                 attendance_date2: attendance_date2,
        //                 company_id: company_id,
        //                 employee_id: employee_id,
        //                 "_token": "<?php echo e(csrf_token()); ?>",
        //             }
        //         },


        //         columns: [
        //             {
        //                 data: 'date',
        //                 name: 'date'
        //             },
        //             {
        //                 data: 'clock_in',
        //                 name: 'clock_in'
        //             },
        //             {
        //                 data: 'clock_out',
        //                 name: 'clock_out'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: false
        //             },
        //         ],


        //         "order": [],
        //         'language': {
        //             'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
        //             "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
        //             "search": '<?php echo e(trans("file.Search")); ?>',
        //             'paginate': {
        //                 'previous': '<?php echo e(trans("file.Previous")); ?>',
        //                 'next': '<?php echo e(trans("file.Next")); ?>'
        //             }
        //         },


        //         'select': {style: 'multi', selector: 'td:first-child'},
        //         'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],

        //     });
        //     new $.fn.dataTable.FixedHeader(table_table);

        // }

        // $('#update_attendance_from').on('submit',function (e) {
        //     e.preventDefault();
        //     let attendance_date1 = $('#attendance_date1').val();
        //     let attendance_date2 = $('#attendance_date2').val();
        //     let company_id = $('#company_id').val();
        //     let employee_id = $('#employee_id').val();
        //     if (attendance_date1 !== '' && attendance_date2 !== '' && company_id !== '' && employee_id !== '') {
        //         $('#update_attendance-table').DataTable().destroy();
        //         fill_datatable(attendance_date1, attendance_date2, company_id, employee_id);
        //         $('#hidden_employee_id').val($('#employee_id').val());
        //     } else {
        //         let data_name = '';
        //         if (company_id == '') {
        //             data_name += '<?php echo e(__('Company')); ?>';
        //         }
        //         if (employee_id == '') {
        //             if (data_name != '') {
        //                 data_name += ', ';
        //             }
        //             data_name += '<?php echo e(__('Employee')); ?>';
        //         }
        //         if (attendance_date1 == '') {
        //             if (data_name != '') {
        //                 data_name += ', ';
        //             }
        //             data_name += '<?php echo e(__('Start Date')); ?>';
        //         }
        //         if (attendance_date2 == '') {
        //             if (data_name != '') {
        //                 data_name += ', ';
        //             }
        //             data_name += '<?php echo e(__('End Date')); ?>';
        //         }
        //         alert('<?php echo e(__('Select')); ?> '+ data_name + '.');
        //     }

        // });
        
        // New Code Start
        function fill_datatable(attendance_date1 = '', attendance_date2 = '', company_id = '', employee_ids = []) {
        let table_table = $('#update_attendance-table').DataTable({
            responsive: true,
            fixedHeader: {
                header: true,
                footer: true
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo e(route('update_attendances.index')); ?>",
                data: {
                    attendance_date1: attendance_date1,
                    attendance_date2: attendance_date2,
                    company_id: company_id,
                    employee_ids: employee_ids.join(','), // Pass as a comma-separated string
                    "_token": "<?php echo e(csrf_token()); ?>",
                }
            },
            columns: [
                { data: 'employee_name', name: 'employee_name' },
                { data: 'clock_in', name: 'clock_in' },
                { data: 'clock_out', name: 'clock_out' },
                { data: 'date', name: 'date' },
                // { data: 'action', name: 'action', orderable: false }
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
            'select': {style: 'multi', selector: 'td:first-child'},
            'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });

            new $.fn.dataTable.FixedHeader(table_table);
        }

        $('#update_attendance_from').on('submit', function (e) {
            e.preventDefault();
            let attendance_date1 = $('#attendance_date1').val();
            let attendance_date2 = $('#attendance_date2').val();
            let company_id = $('#company_id').val();
            let employee_ids = $('#employee_id').val();  // Get multiple employee IDs

            if (attendance_date1 !== '' && attendance_date2 !== '' && company_id !== '' && employee_ids.length > 0) {
                $('#update_attendance-table').DataTable().destroy();
                fill_datatable(attendance_date1, attendance_date2, company_id, employee_ids);
                $('#hidden_employee_id').val(employee_ids.join(','));
            } else {
                let data_name = '';
                if (company_id == '') data_name += '<?php echo e(__('Company')); ?>';
                if (employee_ids.length == 0) {
                    if (data_name != '') data_name += ', ';
                    data_name += '<?php echo e(__('Employee')); ?>';
                }
                if (attendance_date1 == '') {
                    if (data_name != '') data_name += ', ';
                    data_name += '<?php echo e(__('Start Date')); ?>';
                }
                if (attendance_date2 == '') {
                    if (data_name != '') data_name += ', ';
                    data_name += '<?php echo e(__('End Date')); ?>';
                }
                alert('<?php echo e(__('Select')); ?> ' + data_name + '.');
            }
        });

        // New Code End 

        $('#add_attendance_btn').on('click', function() {
            $('#att_date_edit_show_hide').show();
            let company_id = $('#company_id').val();
            let employee_id = $('#employee_id').val();
            if (company_id !== '' && employee_id !== '') {
                $('#hidden_employee_id').val($('#employee_id').val());
                $('.modal-title').text('<?php echo e(__('Add Attendance')); ?>');
                $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
                $('#action').val('<?php echo e(trans("file.Add")); ?>');
                $('#editModal').modal('show');
            } else {
                let data_name = '';
                if (company_id == '') {
                    data_name += '<?php echo e(__('Company')); ?>';
                }
                if (employee_id == '') {
                    if (data_name != '') {
                        data_name += ', ';
                    }
                    data_name += '<?php echo e(__('Employee')); ?>';
                }
                alert('<?php echo e(__('Select')); ?> '+ data_name + '.');
            }
        });

        $(document).on('click', '.edit', function() {
            let id = $(this).attr('id');
            let target = "<?php echo e(route('update_attendances.index')); ?>/"+id+'/get';
            $.ajax({
                url:target,
                dataType:"json",
                success:function(html){
                    $('#attendance_date_edit').val(html.data.attendance_date);
                    $('#att_date_edit_show_hide').hide();
                    $('#clock_in_edit').val(html.data.clock_in);
                    $('#clock_out_edit').val(html.data.clock_out);

                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text(html.data.attendance_date);
                    $('#action').val('<?php echo e(trans('file.Edit')); ?>');
                    $('#action_button').val('<?php echo e(trans('file.Edit')); ?>');
                    $('#editModal').modal('show');
                }
            })
        });

        $('#edit_form').on('submit', function(event){
            event.preventDefault();
            if($('#action').val() == '<?php echo e(trans('file.Add')); ?>')
            {
                $.ajax({
                    url:"<?php echo e(route('update_attendances.store')); ?>",
                    method:"POST",
                    data: new FormData(this),
                    contentType: false,
                    cache:false,
                    processData: false,
                    dataType:"json",
                    success:function(data)
                    {
                        console.log(data);
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#edit_form')[0].reset();
                            $('#update_attendance-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            }

            if($('#action').val() == '<?php echo e(trans('file.Edit')); ?>')
            {

                $.ajax({
                    url:"<?php echo e(route('update_attendances.update')); ?>",
                    method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < data.errors.length; count++)
                            {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            setTimeout(function(){
                                $('#editModal').modal('hide');
                                $('#update_attendance-table').DataTable().ajax.reload();
                                $('#edit_form')[0].reset();

                            }, 2000);

                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                });
            }
        });

        let delete_id;
        $(document).on('click', '.delete', function(){
            delete_id = $(this).attr('id');

            $('#confirmModal').modal('show');
            $('.modal-title').text('<?php echo e(__('DELETE Record')); ?>');
            $('#ok_button').text('<?php echo e(trans('file.OK')); ?>');

        });


        $('#ok_button').on('click', function() {
            let target = "<?php echo e(route('update_attendances.index')); ?>/"+delete_id+'/delete';
            $.ajax({
                url:target,
                beforeSend:function(){
                    $('#ok_button').text('<?php echo e(trans('file.Deleting...')); ?>');
                },
                success:function(data)
                {
                    let html = '';
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    setTimeout(function(){
                        $('#confirmModal').modal('hide');
                        $('#update_attendance-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });

        // New code start

        // ✅ Handle "Select All" in Bootstrap Select
        $(document).on('changed.bs.select', '#employee_id', function () {
            let selectedValues = $(this).val();

            if (selectedValues && selectedValues.includes('all')) {
                $('#employee_id option').prop('selected', true);
                $('#employee_id').selectpicker('refresh');
            }
        });
         // Attach the click event to the "Clear All" button
        $('#clearAllButton').on('click', function() {
            $('#employee_id').selectpicker('deselectAll');
            $('#employee_id').selectpicker('refresh');
        });

        // ✅ Dynamic Employee Fetching
        $('.dynamic').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let first_name = $(this).data('first_name');
                let last_name = $(this).data('last_name');
                let _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "<?php echo e(route('dynamic_employee')); ?>",
                    method: "POST",
                    data: { value: value, _token: _token, first_name: first_name, last_name: last_name },
                    success: function (result) {
                        $('#employee_id').html('<option value="all">Select All</option>' + result);
                        $('#employee_id').selectpicker('refresh');
                    }
                });
            }
        });

        // new code end

        // $('.dynamic').change(function () {
        //     if ($(this).val() !== '') {
        //         let value = $(this).val();
        //         let first_name = $(this).data('first_name');
        //         let last_name = $(this).data('last_name');
        //         let _token = $('input[name="_token"]').val();
        //         $.ajax({
        //             url: "<?php echo e(route('dynamic_employee')); ?>",
        //             method: "POST",
        //             data: {value: value, _token: _token, first_name: first_name, last_name: last_name},
        //             success: function (result) {
        //                 $('select').selectpicker("destroy");
        //                 $('#employee_id').html(result);
        //                 $('select').selectpicker();

        //             }
        //         });
        //     }
        // });


        $('#close').on('click', function() {
            $('#edit_form')[0].reset();
            $('#update_attendance-table').DataTable().ajax.reload();

        });
    })(jQuery);
</script>
<style>

#clearAllButton {
    color: red;
    right: 0; /* Align the icon to the right */
    top: 50%;
    transform: translateY(-50%); /* Center the icon vertically */
    margin-left: 15px;
    cursor: pointer;
    font-size: 10px; /* Adjust icon size if needed */
}

</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/timesheet/updateAttendance/index.blade.php ENDPATH**/ ?>