<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-1">
                                <h6 class="text-muted">Ticket Details</h6>
                                <div class="badge badge-primary"> <?php echo e($ticket->ticket_status); ?> </div>
                            </div>
                            <h3 class="mb-3"><?php echo e($ticket->subject); ?></h3>
                            <div class="d-flex justify-content-between">
                                <div class="text-muted"><?php echo e(__('Posted by')); ?>

                                    
                                    : <?php echo e($ticket->full_name); ?></div>
                                <div class="text-muted"><?php echo e(trans('file.Priority')); ?> : <?php echo e($ticket->ticket_priority); ?></div>
                                <div class="text-muted"><?php echo e(trans('file.Date')); ?> :<?php echo e($ticket->created_at); ?></div>
                            </div>
                            <hr>
                            <span id="assigned_result"></span>
                            <form method="post" id="assigned_form" class="form-horizontal">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="ticket_id" value="<?php echo e($ticket->id); ?>">
                                <div class="row mt-3">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <label><?php echo e(__('Assigned to')); ?> * &nbsp; &nbsp;</label>
                                            <select name="employee_id[]" id="employee_id" class="form-control pre-assigned" multiple="multiple">
                                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($emp->id); ?>"><?php echo e($emp->full_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assign-ticket')): ?>
                                                <input type="submit" name="assigned_submit" id="assigned_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">

                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#Details"
                                       role="tab" aria-controls="Details"
                                       aria-selected="true"><?php echo e(trans('file.Details')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="comments-tab" data-toggle="tab" href="#Comments" role="tab"
                                       aria-controls="Comments" data-table="comment"
                                       aria-selected="false"><?php echo e(trans('file.Comments')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#Notes" role="tab"
                                       aria-controls="Notes" aria-selected="false"><?php echo e(trans('file.Notes')); ?></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Details" role="tabpanel"
                                     aria-labelledby="details-tab">
                                    <!--Contents for Details starts here-->
                                    <div class="row">
                                        <div class="col-md-10">

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label><b><?php echo e(trans('file.Description')); ?></b></label>
                                                    <br>

                                                    <?php echo html_entity_decode($ticket->description); ?>


                                                </div>
                                            </div>

                                            <hr>
                                            <span id="details_result"></span>
                                            <form method="post" id="details_form" class="form-horizontal row" action="<?php echo e(route('ticket_details.store', $ticket->ticket_code)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="ticket_id" value="<?php echo e($ticket->id); ?>">
                                                <div class="col-md-6 form-group">
                                                    <label><?php echo e(trans('file.Status')); ?></label>
                                                    <select name="ticket_status" id="ticket_status"
                                                            class="form-control selectpicker "
                                                            data-live-search="true" data-live-search-style="contains"
                                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...'>
                                                        <option value="open">Open</option>
                                                        <option value="closed">Closed</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Remarks')); ?> *</label>
                                                        <textarea class="form-control" id="ticket_remarks"
                                                                  name="ticket_remarks" rows="3" required></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <button type="submit" name="details_submit" id="details_submit"
                                                           class="btn btn-success"><?php echo e(trans('file.Save')); ?></button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Comments" role="tabpanel" aria-labelledby="comments-tab">
                                    <span id="comments_result"></span>
                                    <form method="post" id="comments_form" class="form-horizontal">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Comments')); ?></label>
                                            <textarea required class="form-control" id="ticket_comments"
                                                      name="ticket_comments" rows="3"></textarea>
                                        </div>

                                        <input type="submit" name="comments_submit" id="comments_submit"
                                               class="btn btn-success" value=<?php echo e("asdasdsadasd"); ?>>
                                    </form>
                                    <div class="row mt-5">
                                        <div class="table-responsive">
                                            <table id="comments-table" class="table ">
                                                <thead>
                                                <tr>
                                                    <th><?php echo e(trans('file.User')); ?></th>
                                                    <th><?php echo e(trans('file.Comments')); ?></th>
                                                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                                                </tr>
                                                </thead>

                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Notes" role="tabpanel" aria-labelledby="notes-tab">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <span id="note_result"></span>
                                            <form method="post" id="note_form" class="form-horizontal">
                                                <?php echo csrf_field(); ?>
                                                <div class="col-md-6 form-group">
                                                    <label><?php echo e(__('Ticket Note')); ?> *</label>
                                                    <input type="text" name="ticket_note" id="ticket_note"
                                                           placeholder="<?php echo e(__('Ticket Note')); ?>"
                                                           value="<?php echo e($ticket->ticket_note ?? ""); ?>"
                                                           required class="form-control">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="submit" name="ticket_note_submit"
                                                           id="ticket_note_submit"
                                                           class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <script type="text/javascript">
        (function ($) {
            "use strict";

            let ticket_status = <?php echo json_encode($ticket->ticket_status) ?>;
            let ticket_remarks = <?php echo json_encode($ticket->ticket_remarks) ?>;
            let assigned = <?php echo json_encode($name) ?>;



            $('#ticket_status').val(ticket_status);
            $('#ticket_remarks').html(ticket_remarks);


            $(document).ready(function () {

                $('#employee_id').select2({
                    placeholder: '<?php echo e(__('Assign Employee...')); ?>',
                });
                $('#employee_id').val(assigned);
                $('#employee_id').trigger('change');

                $('#assigned_form').on('submit', function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: "<?php echo e(route('ticket.assign')); ?>",
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
                            }
                            $('#assigned_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    })

                });
            });

            $('#details_form').on('submit', function (event) {
                event.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "<?php echo e(route('ticket_details.store', $ticket->ticket_code)); ?>",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            // Store the success message in session storage
                            sessionStorage.setItem('toast_message', data.success);
                            sessionStorage.setItem('toast_type', 'success');
                            // Redirect to index page
                            window.location.href = "<?php echo e(route('tickets.index')); ?>";
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let html = '<div class="alert alert-danger">';
                            for (let count = 0; count < xhr.responseJSON.errors.length; count++) {
                                html += '<p>' + xhr.responseJSON.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#details_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        } else {
                            $('#details_result').html('<div class="alert alert-danger">An error occurred while updating the ticket.</div>').slideDown(300).delay(5000).slideUp(300);
                        }
                    }
                });
            });

            $('[data-table="comment"]').one('click', function (e) {

                $('#comments-table').DataTable().clear().destroy();

                let table_table = $('#comments-table').DataTable({
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
                        url: "<?php echo e(route('ticket_comments.index',$ticket)); ?>",
                        method: "post"
                    },

                    columns: [


                        {
                            data: 'user',
                            name: 'user'
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                return data.ticket_comments + '<br> (' + data.created_at + ')';
                            }

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
                            'targets': [0, 2],
                        },
                    ],

                    'select': {style: 'multi', selector: 'td:first-child'},
                    'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                });
                new $.fn.dataTable.FixedHeader(table_table);
            });

            $('#comments_form').on('submit', function (event) {
                event.preventDefault();

                $.ajax({
                    url: "<?php echo e(route('ticket_comments.store',$ticket)); ?>",
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
                            $('#comments_form')[0].reset();
                            $('#comments-table').DataTable().ajax.reload();
                        }
                        $('#comments_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            });

            $('#note_form').on('submit', function (event) {
                event.preventDefault();

                $.ajax({
                    url: "<?php echo e(route('ticket_notes.store',$ticket)); ?>",
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
                        }
                        $('#note_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        $('#ticket_note').html(data.ticket.ticket_note);
                    }
                })
            });

            $(document).on('click', '.delete-comment', function () {

                if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Comments')])); ?>')) {

                    let delete_id = $(this).attr('id');
                    let target = "<?php echo e(route('tickets.index')); ?>/" + delete_id + '/delete_comments';
                    $.ajax({
                        url: target,
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
                                $('#comments-table').DataTable().ajax.reload();
                            }, 2000);
                        }
                    })
                }

            });




        })(jQuery);

    </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/SupportTicket/details.blade.php ENDPATH**/ ?>