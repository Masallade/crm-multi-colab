

    $('#loan-table').DataTable().clear().destroy();
    var date = $('.date');
    date.datepicker({
        format: '<?php echo e(env('Date_Format_JS')); ?>',
        autoclose: true,
        todayHighlight: true
    });


    var table_table = $('#loan-table').DataTable({
        initComplete: function () {
            this.api().columns([0]).every(function () {
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
            url: "<?php echo e(route('salary_loan.show',$employee->id)); ?>",
        },

        columns: [
            {
                data: 'month_year',
                name : 'month_year'
            },
            {
                data: null,
                render: function (data, type, row) {
                    return '<?php echo e(trans('file.Title')); ?>:' + row.loan_title + "<br>" + '<?php echo e(__('Loan Type')); ?>:' + row.loan_type
                        + "<br>" + '<?php echo e(trans('file.Reason')); ?>:' + row.reason;
                }
            },
            {
                data: 'loan_amount',
                name: 'loan_amount',
                render: function (data) {
                    if ('<?php echo e(config('variable.currency_format') =='suffix'); ?>') {
                        return data + ' <?php echo e(config('variable.currency')); ?>';
                    } else {
                        return '<?php echo e(config('variable.currency')); ?> ' + data;

                    }
                }
            },
            {
                data: 'loan_time',
                name: 'loan_time',
            },
            {
                data: 'loan_remaining',
                name: 'loan_remaining',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            }
        ],


        "order": [],
        'language': {
            'lengthMenu': '_MENU_ <?php echo e(__('records per page')); ?>',
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


        
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    new $.fn.dataTable.FixedHeader(table_table);


    $('#create_loan_record').click(function () {

        $('.modal-title').text('<?php echo e(__('Add Loan')); ?>');
        $('#loan_action_button').val('<?php echo e(trans('file.Add')); ?>');
        $('#loan_action').val('<?php echo e(trans('file.Add')); ?>');
        $('#LoanformModal').modal('show');
    });

    $('#loan_sample_form').on('submit', function (event) {
        event.preventDefault();
        if ($('#loan_action').val() == '<?php echo e(trans('file.Add')); ?>') {
            $.ajax({
                url: "<?php echo e(route('salary_loan.store',$employee)); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    var html = '';
                    if (data.errors) {html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#loan_sample_form')[0].reset();
                        $('select').selectpicker('refresh');
                        $('.date').datepicker('update');
                        $('#loan-table').DataTable().ajax.reload();
                    }
                    $('#loan_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }

            });
        }

        if ($('#loan_action').val() == '<?php echo e(trans('file.Edit')); ?>') {
            $.ajax({
                url: "<?php echo e(route('salary_loan.update')); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.error) {
                        html = '<div class = "alert alert-danger" > ' + data.error + ' </div>';
                    }

                    if (data.success) {
                        html = '<div class="alert alert-success" >' + data.success + '</div>';
                        setTimeout(function () {
                            $('#LoanformModal').modal('hide');
                            $('select').selectpicker('refresh');
                            $('#loan-table').DataTable().ajax.reload();
                            $('#loan_sample_form')[0].reset();
    $( "#loan_amount" ).prop( "disabled", false );

    }, 2000);

                    }
                    $('#loan_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });
        }
    });


    $(document).on('click', '.loan_edit', function () {

        var id = $(this).attr('id');

        var target = "<?php echo e(route('salary_loan.index')); ?>/" + id + '/edit';


        $.ajax({
            url: target,
            dataType: "json",
            success: function (html) {

                let id = html.data.id;
                $('.month_year').val(html.data.month_year);
                $('#loan_title').val(html.data.loan_title);
                $('#loan_time').val(html.data.loan_time);
                $('#amount_remaining').val(html.data.amount_remaining);
                $('#time_remaining').val(html.data.time_remaining);
                $('#loan_reason').val(html.data.reason);
                $('#loan_type_id').selectpicker('val', html.data.loan_type_id);
                $('#loan_amount').val(html.data.loan_amount);
    $( "#loan_amount" ).prop( "disabled", true );

                $('#loan_hidden_id').val(html.data.id);
                $('.modal-title').text('<?php echo e(trans('file.Edit')); ?>');
                $('#loan_action_button').val('<?php echo e(trans('file.Edit')); ?>');
                $('#loan_action').val('<?php echo e(trans('file.Edit')); ?>');
                $('#LoanformModal').modal('show');
            }
        })
    });




    $('.loan-close').click(function () {
        $('#loan_sample_form')[0].reset();
        $('select').selectpicker('refresh');
        $('.date').datepicker('update');
    $( "#loan_amount" ).prop( "disabled", false );

    $('.confirmModal').modal('hide');
        $('#loan-table').DataTable().ajax.reload();
    });



<?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/employee/salary/loan/index_js.blade.php ENDPATH**/ ?>