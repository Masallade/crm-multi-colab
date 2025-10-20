@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-muted mb-0">Ticket Details</h6>
                                <div class="badge badge-primary p-2">{{$ticket->ticket_status}}</div>
                            </div>
                            <h3 class="mb-4">{{$ticket->subject}}</h3>
                            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                                <div class="text-muted">
                                    <i class="fa fa-user mr-2"></i>
                                    {{__('Assigned To')}}: 
                                    @if($ticket->employee)
                                        {{$ticket->employee->first_name.' '.$ticket->employee->last_name}}
                                    @else
                                        {{__('Not Assigned')}}
                                    @endif
                                </div>
                                <div class="text-muted">
                                    <i class="fa fa-flag mr-2"></i>
                                    {{trans('file.Priority')}}: <span class="badge badge-warning">{{$ticket->ticket_priority}}</span>
                                </div>
                                <div class="text-muted">
                                    <i class="fa fa-calendar mr-2"></i>
                                    {{trans('file.Date')}}: 
                                    @if($ticket->created_at)
                                        {{ \Carbon\Carbon::createFromFormat('d-m-Y--H:i', $ticket->created_at)->format('M d, Y H:i') }}
                                    @else
                                        {{ $ticket->created_at }}
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <!-- <span id="assigned_result"></span>
                            <form method="post" id="assigned_form" class="form-horizontal">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                <div class="row mt-3">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <label>{{__('Assigned to')}} * &nbsp; &nbsp;</label>
                                            <select name="employee_id[]" id="employee_id" class="form-control pre-assigned" multiple="multiple">
                                                @foreach($employees as $emp)
                                                    <option value="{{$emp->id}}">{{$emp->full_name}}</option>
                                                @endforeach
                                            </select>
                                            @can('assign-ticket')
                                                <input type="submit" name="assigned_submit" id="assigned_submit" class="btn btn-success" value={{trans("file.Save")}}>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </form> -->
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
                                       aria-selected="true">{{trans('file.Details')}}</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="comments-tab" data-toggle="tab" href="#Comments" role="tab"
                                       aria-controls="Comments" data-table="comment"
                                       aria-selected="false">{{trans('file.Comments')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#Notes" role="tab"
                                       aria-controls="Notes" aria-selected="false">{{trans('file.Notes')}}</a>
                                </li> -->
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Details" role="tabpanel"
                                     aria-labelledby="details-tab">
                                    <!--Contents for Details starts here-->
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">{{trans('file.Description')}}</label>
                                                    <div class="card bg-light p-3">
                                                        {!! html_entity_decode($ticket->description) !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <span id="details_result"></span>
                                            <form method="post" id="details_form" class="form-horizontal row" action="{{ route('ticket_details.store', $ticket->ticket_code) }}">
                                                @csrf
                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                <div class="col-md-6 form-group">
                                                    <label class="font-weight-bold">{{trans('file.Status')}} <span class="text-danger">*</span></label>
                                                    <select name="ticket_status" id="ticket_status"
                                                            class="form-control selectpicker"
                                                            data-live-search="true" data-live-search-style="contains"
                                                            title='{{__('Select Status')}}' required>
                                                        <option value="open">Select Status</option>
                                                        <option value="open" class="text-success">Open</option>
                                                        <option value="closed" class="text-danger">Closed</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select either Open or Closed status
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">{{trans('file.Remarks')}} *</label>
                                                        <textarea class="form-control" id="ticket_remarks"
                                                                  name="ticket_remarks" rows="3" required
                                                                  placeholder="Enter your remarks here..."></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <button type="submit" name="details_submit" id="details_submit"
                                                           class="btn btn-success btn-lg">
                                                           <i class="fa fa-save mr-2"></i>{{trans('file.Save')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Comments" role="tabpanel" aria-labelledby="comments-tab">
                                    <span id="comments_result"></span>
                                    <form method="post" id="comments_form" class="form-horizontal">
                                        @csrf
                                        <div class="form-group">
                                            <label>{{trans('file.Comments')}}</label>
                                            <textarea required class="form-control" id="ticket_comments"
                                                      name="ticket_comments" rows="3"></textarea>
                                        </div>

                                        <input type="submit" name="comments_submit" id="comments_submit"
                                               class="btn btn-success" value={{"asdasdsadasd"}}>
                                    </form>
                                    <div class="row mt-5">
                                        <div class="table-responsive">
                                            <table id="comments-table" class="table ">
                                                <thead>
                                                <tr>
                                                    <th>{{trans('file.User')}}</th>
                                                    <th>{{trans('file.Comments')}}</th>
                                                    <th class="not-exported">{{trans('file.action')}}</th>
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
                                                @csrf
                                                <div class="col-md-6 form-group">
                                                    <label>{{__('Ticket Note')}} *</label>
                                                    <input type="text" name="ticket_note" id="ticket_note"
                                                           placeholder="{{__('Ticket Note')}}"
                                                           value="{{$ticket->ticket_note ?? ""}}"
                                                           required class="form-control">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="submit" name="ticket_note_submit"
                                                           id="ticket_note_submit"
                                                           class="btn btn-success" value={{trans("file.Save")}}>
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
 
            // Initialize selectpicker
            $('.selectpicker').selectpicker();

            // Set initial values
            if (ticket_status) {
                $('#ticket_status').val(ticket_status);
                $('.selectpicker').selectpicker('refresh');
            }
            $('#ticket_remarks').html(ticket_remarks);

            $(document).ready(function () {

                $('#employee_id').select2({
                    placeholder: '{{__('Assign Employee...')}}',
                });
                $('#employee_id').val(assigned);
                $('#employee_id').trigger('change');

                $('#assigned_form').on('submit', function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: "{{ route('ticket.assign') }}",
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
                
                // Reset validation state
                $('#ticket_status').removeClass('is-invalid');
                
                // Get the selected value
                let selectedStatus = $('#ticket_status').val();
                
                // Validate status
                if (!selectedStatus || selectedStatus === '') {
                    $('#ticket_status').addClass('is-invalid');
                    $('#details_result').html('<div class="alert alert-danger">Please select a status before submitting</div>').slideDown(300).delay(5000).slideUp(300);
                    return false;
                }

                // Only proceed if status is either 'open' or 'closed'
                if (selectedStatus !== 'open' && selectedStatus !== 'closed') {
                    $('#ticket_status').addClass('is-invalid');
                    $('#details_result').html('<div class="alert alert-danger">Please select either Open or Closed status</div>').slideDown(300).delay(5000).slideUp(300);
                    return false;
                }

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('ticket_details.store', $ticket->ticket_code) }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            $('#details_result').html('<div class="alert alert-success">' + response.success + '</div>').slideDown(300).delay(5000).slideUp(300);
                        }
                    },
                    error: function(xhr, status, error) {
                        let html = '<div class="alert alert-danger">';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            for (let count = 0; count < xhr.responseJSON.errors.length; count++) {
                                html += '<p>' + xhr.responseJSON.errors[count] + '</p>';
                            }
                        } else {
                            html += '<p>An error occurred while updating the ticket.</p>';
                        }
                        html += '</div>';
                        $('#details_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                });
            });

            // Remove validation class when a valid status is selected
            $('#ticket_status').on('change', function() {
                let selectedStatus = $(this).val();
                if (selectedStatus === 'open' || selectedStatus === 'closed') {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }
            });

            // Prevent form submission on enter key
            $('#details_form').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    return false;
                }
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
                        url: "{{ route('ticket_comments.index',$ticket) }}",
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
                        'lengthMenu': '_MENU_ {{__("records per page")}}',
                        "info": '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                        "search": '{{trans("file.Search")}}',
                        'paginate': {
                            'previous': '{{trans("file.Previous")}}',
                            'next': '{{trans("file.Next")}}'
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
                    url: "{{ route('ticket_comments.store',$ticket) }}",
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
                    url: "{{ route('ticket_notes.store',$ticket) }}",
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

                if (confirm('{{__('Delete Selection',['key'=>trans('file.Comments')])}}')) {

                    let delete_id = $(this).attr('id');
                    let target = "{{ route('tickets.index') }}/" + delete_id + '/delete_comments';
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


@endsection