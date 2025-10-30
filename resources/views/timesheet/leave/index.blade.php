<?php
$loggedUser = auth()->user(); 
$loggedEmployee = \App\Models\Employee::find($loggedUser->id);
// dd($loggedUser->id);
// if ($loggedUser->role_users_id == 4) {
// }
?>

@extends('layout.main')
@section('content')
    <section>
        <div class="container-fluid"><span id="general_result"></span></div>
        <div class="container-fluid mb-3">
            @can('store-leave')
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i
                            class="fa fa-plus"></i> {{__('Add Leave')}}</button>
            @endcan
            @can('delete-leave')
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> {{__('Bulk delete')}}</button>
            @endcan
        </div>

        <div class="container-fluid mb-3 d-flex align-items-center">
            <label for="status_filter" class="mr-2">{{ __('Filter by Status') }}:</label>
            <select id="status_filter" class="form-control" style="width: 200px; max-width: 100%; display: inline-block;">
                <option value="">{{ __('All') }}</option>
                <option value="pending">{{ __('Pending') }}</option>
                <option value="approved">{{ __('Approved') }}</option>
                <option value="1">{{ __('Approved by Teamlead') }}</option>
                <option value="rejected">{{ __('Rejected') }}</option>
            </select>
        </div>



        <div class="table-responsive">
            <table id="leave-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{__('Leave Type')}}</th>
                    <th>{{trans('file.Employee')}}</th>
                    <th>{{trans('file.Department')}}</th>
                    <th>{{trans('file.Duration')}}</th>
                    <th>{{__('Applied Date')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{__('Add Leave')}}</h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">

                        @csrf
                        <div class="row">

                            <div class="col-md-6 form-group">
                                @if ($loggedUser->role_users_id == 4):
                                    <label id="status_heading">{{trans('file.Status')}}</label>
                                <select name="status" id="status" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='{{__('Selecting',['key'=>trans('file.Status')])}}...'>
                                    <option value="pending">{{trans('file.Pending')}}</option>
                                    <option value="1">Approved By Teamlead</option>
                                    <option value="rejected">{{trans('file.Rejected')}}</option>
                                </select>
                                @else
                                <label id="status_heading">{{trans('file.Status')}}</label>
                                <select name="status" id="status" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='{{__('Selecting',['key'=>trans('file.Status')])}}...'>
                                    <option value="pending">{{trans('file.Pending')}}</option>
                                    <option value="approved">{{trans('file.Approved')}}</option>
                                    <option value="rejected">{{trans('file.Rejected')}}</option>
                                </select>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Leave Type')}} *</label>
                                <select id="leave_type" name="leave_type" class="form-control selectpicker" data-live-search="true" data-live-search-style="contains" title='{{__('Leave Type')}}'>
                                    @foreach($leave_types as $leave_type)
                                        <option value="{{$leave_type->id}}">{{$leave_type->leave_type}}
                                            <!-- ({{$leave_type->allocated_day}} Days) -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6 form-group">
                                <label>{{ trans('file.Company') }} *</label>
                                <select name="company_id" id="company_id" class="form-control selectpicker dynamic"
                                        data-live-search="true" title="Select Company..." data-dependent="department_name">
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $loggedEmployee->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="company_id" value="{{ $loggedEmployee->company_id }}">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{ trans('file.Department') }} *</label>
                                <select name="department_id" id="department_id" class="form-control selectpicker"
                                        data-live-search="true" title="Select Department...">
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $loggedEmployee->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="department_id" value="{{ $loggedEmployee->department_id }}">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{ trans('file.Employee') }} *</label>
                                <select name="employee_id" id="employee_id" class="form-control selectpicker"
                                        data-live-search="true" title="Select Employee...">
                                    <option value="{{ $loggedEmployee->id }}" selected>
                                        {{ $loggedEmployee->first_name }} {{ $loggedEmployee->last_name }}
                                    </option>
                                </select>
                                <input type="hidden" name="employee_id" value="{{ $loggedEmployee->id }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{__('Total Days')}}</label>
                                <input type="text" readonly id="total_days" class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Start Date')}} *</label>
                                <input type="text" name="start_date" id="start_date" class="form-control date" value="">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{__('End Date')}} *</label>
                                <input type="text" name="end_date" id="end_date" class="form-control test date" value="" readonly>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="leave_reason">{{trans('file.Description')}}</label>
                                <textarea class="form-control" id="leave_reason" name="leave_reason" rows="3"></textarea>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="remarks">{{trans('file.Remarks')}}</label>
                                <textarea class="form-control" id="remarks" name="remarks"
                                          rows="3"></textarea>
                            </div>
 
                            
                            {{-- <div class="col-md-6 form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="is_half" id="is_half"
                                           value="1">
                                    <label class="custom-control-label" for="is_half">{{__('Half Day')}}</label>
                                </div>
                            </div> --}}

                            <div class="col-md-6 form-group">
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="is_notify" id="is_notify" value="1" checked>
                                    <label class="custom-control-label"
                                           for="is_notify">{{trans('file.Notification')}}</label>
                                </div>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="hidden" name="diff_date_hidden" id="diff_date_hidden"/>
                                    <input type="hidden" name="employee_id_hidden" id="employee_id_hidden"/>
                                    <input type="hidden" name="leave_type_hidden" id="leave_type_hidden"/>
                                    <input type="hidden" name="ticket_status" value="open"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                           value={{trans('file.Add')}}>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="leave_model" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">{{__('Leave Info')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table  table-bordered">

                                    <tr>
                                        <th>{{trans('file.Company')}}</th>
                                        <td id="company_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Leave For')}}</th>
                                        <td id="employee_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Department')}}</th>
                                        <td id="department_id_show"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Leave Type')}}</th>
                                        <td id="leave_type_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Leave Reason')}}</th>
                                        <td id="leave_reason_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Remarks')}}</th>
                                        <td id="remarks_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Status')}}</th>
                                        <td id="status_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Start Date')}}</th>
                                        <td id="start_date_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('End Date')}}</th>
                                        <td id="end_date_id"></td>
                                    </tr>


                                    <tr>
                                        <th>{{__('Applied Date')}}</th>
                                        <td id="applied_date_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Total Days')}}</th>
                                        <td id="total_days_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{__('Half Day')}}</th>
                                        <td id="is_half_id"></td>
                                    </tr>

                                    <tr>
                                        <th>{{trans('file.Notification')}}</th>
                                        <td id="is_notify_id"></td>
                                    </tr>

                                </table>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.Close')}}</button>
            </div>
        </div>
    </div>


    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{trans('file.Confirmation')}}</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center">{{__('Are you sure you want to remove this data?')}}</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">{{trans('file.OK')}}'
                    </button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal">{{trans('file.Cancel')}}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">

    (function($) {
        "use strict";

        let global_start_date;
        let global_end_date;
        let global_diff;

        $(document).ready(function () {

            let date = $('.date');
            date.datepicker({
                format: '{{ env('Date_Format_JS')}}',
                autoclose: true,
                todayHighlight: true,
                startDate: new Date(new Date().setDate(new Date().getDate() - 6)) // Only allow last 7 days including today
            });
            // .on('change', function(){
            //     let start_date = $("#start_date").datepicker('getDate');
            //     let end_date = $("#end_date").datepicker('getDate');
            //     if (start_date!=null && end_date!=null && end_date>=start_date) {
            //     let dayDiff = Math.ceil((end_date - start_date) / (1000 * 60 * 60 * 24)) + 1;
            //     // console.log(dayDiff);
            //         $('#total_days').val(dayDiff);
            //     }
            //     else if(start_date!=null && end_date!=null && end_date<start_date){
            //         // console.log(987);
            //         $('#total_days').val(0);
            //     }
            // });


            const startDateInput = $('#start_date');
            const endDateInput = $('#end_date');
            const totalDaysInput = $('#total_days');

            startDateInput.on('change', function() {
                getDateResult();
            });

            endDateInput.on('change', function() {
                getDateResult();
            });

            const getDateResult = ()  => {

                // Convert Date formate to YYYY-MM-DD
                if (!startDateInput.val() || !endDateInput.val()) {
                    return;
                }

                let startDateFormat = convertDataFormat(startDateInput.val());
                let endDateFormat = convertDataFormat(endDateInput.val());

                let startDate = new Date(startDateFormat);
                let endDate = new Date(endDateFormat);
                let timeDiff = endDate.getTime() - startDate.getTime();
                // Convert the difference from milliseconds to days and update the totalDays input field
                let totalDays = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                if (totalDays < 0) {
                    totalDaysInput.val(0);
                }else {
                    totalDaysInput.val(totalDays);
                }
            }

            const convertDataFormat = getDateValue => {
                const inputDate = getDateValue;
                const parts = inputDate.split("-");
                const date = new Date(parts[2], parts[1] - 1, parts[0]);
                const outputDate = date.toISOString().substring(0, 10);
                return outputDate;
            }

            var is_tl_action = 'Approved by Teamlead';
            let table_table = $('#leave-table').DataTable({
                
                initComplete: function () {
                    this.api().columns([1]).every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
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
                    url: "{{ route('leaves.index') }}",
                    data: function (d) {
                        d.status = $('#status_filter').val(); // Send selected status to backend
                    }
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
                            
                            if(data.status=='rejected') {
                                return data.leave_type + "<br><td><div class = 'badge badge-danger'> (" + data.status + ")</div></td><br>";
                            }else if(data.is_tl_action==1 && data.status != 'approved') {
                                return data.leave_type + "<br><td><div class = 'badge badge-info'> (" + 'Approved By Teamlead' + ")</div></td><br>";
                            }else if (data.status=='pending') {
                                return data.leave_type + "<br><td><div class = 'badge badge-warning'> " + data.status + "</div></td><br>";
                            }else{
                                return data.leave_type + "<br><td><div class = 'badge badge-success'> (" + data.status + ")</div></td><br>";
                            }
                        }
                    },
                    {
                        data: 'employee',
                        name: 'employee',
                    },
                    {
                        data: 'department',
                        name: 'department',
                    },
                    {
    data: null,
    render: function (data) {
        let startDate = data.start_date;
        let endDate = data.end_date;
        let totalDays = parseFloat(data.total_days);

        let totalDaysHtml = '';
        // Apply background only to total_days text
        if (totalDays === 0.5) {
            totalDaysHtml = '<div style="background-color: #FFF176; font-size:12px; padding: 3px; border-radius: 5px; display: inline-block; color:black;">' +
                            '{{'Half Day'}} ' +
                            '</div>';
        } else {
            totalDaysHtml = '<div style="background-color: #81C784; font-size:12px; padding: 3px; border-radius: 5px; display: inline-block; color:white;">' +
                            '{{trans('file.Total')}} ' + data.total_days + ' {{trans('file.Days')}}' +
                            '</div>';
        }

        return startDate + ' {{trans('file.To')}} ' + endDate + '<br>' + totalDaysHtml;
    }
},

                    {
                        data: 'created_at',
                        name: 'created_at',
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
                        // 'targets': [0, 6],
                        'targets': [0, 5],
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

    // ✅ When Status Filter Changes, Refresh the Table
    $('#status_filter').on('change', function () {
        table_table.ajax.reload(); // Reload table with new filter
    });

            new $.fn.dataTable.FixedHeader(table_table);
        });




        $('#create_record').on('click', function () {
            $('.modal-title').text('{{__('Add Leave')}}');
            $('#action_button').val('{{trans('file.Add')}}');
            $('#action').val('{{trans('file.Add')}}');
            $('#sample_form')[0].reset(); // Reset the form for new entry
            
            // Explicitly enable all fields that might have been disabled in edit mode
            $('#leave_type').prop('disabled', false);
            $('#start_date').prop('disabled', false);
            $('#end_date').prop('disabled', false);
            $('#total_days').prop('disabled', false);
            $('#leave_reason').prop('disabled', false);
            $('#is_notify').prop('disabled', false);
            $('#remarks').prop('disabled', false);
            
            const currentRoleId = {{ auth()->user()->role_users_id }};
            // Use setTimeout to ensure selectpicker is fully initialized
            setTimeout(function() {
                // Set the default values for company, department, and employee after reset
                $('#company_id').selectpicker('val', '{{ $loggedEmployee->company_id }}');
                $('#department_id').selectpicker('val', '{{ $loggedEmployee->department_id }}');
                $('#employee_id').selectpicker('val', '{{ $loggedEmployee->id }}');
                
                // Admin (role 1) should be able to choose any company/department/employee
                if (currentRoleId === 1) {
                    $('#company_id').prop('disabled', false).selectpicker('refresh');
                    $('#department_id').prop('disabled', false).selectpicker('refresh');
                    $('#employee_id').prop('disabled', false).selectpicker('refresh');
                } else {
                    // Non-admins: keep fields locked to their own values
                    $('#company_id').prop('disabled', true).selectpicker('refresh');
                    $('#department_id').prop('disabled', true).selectpicker('refresh');
                    $('#employee_id').prop('disabled', true).selectpicker('refresh');
                }
            }, 100);
            
            // Refresh all selectpickers
            $('#leave_type').selectpicker('refresh');
            
            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function (event) {
            event.preventDefault();

            // Remove any previously added hidden fields to prevent duplicates
            $('#temp_company_id, #temp_department_id, #temp_employee_id, #temp_status, #temp_leave_type, #temp_start_date, #temp_end_date').remove();

            // Only create hidden inputs if the fields are disabled (i.e., in Edit mode)
            if ($('#company_id').prop('disabled')) {
                $('#sample_form').append('<input type="hidden" name="company_id" id="temp_company_id" value="' + $('#company_id').val() + '">');
            }
            if ($('#department_id').prop('disabled')) {
                $('#sample_form').append('<input type="hidden" name="department_id" id="temp_department_id" value="' + $('#department_id').val() + '">');
            }
            if ($('#employee_id').prop('disabled')) {
                $('#sample_form').append('<input type="hidden" name="employee_id" id="temp_employee_id" value="' + $('#employee_id').val() + '">');
            }
            if ($('#status').prop('disabled')) {
                $('#sample_form').append('<input type="hidden" name="status" id="temp_status" value="' + $('#status').val() + '">');
            }
            if ($('#leave_type').prop('disabled')) {
                $('#sample_form').append('<input type="hidden" name="leave_type" id="temp_leave_type" value="' + $('#leave_type').val() + '">');
            }
            if ($('#start_date').prop('disabled')) {
                $('#sample_form').append('<input type="hidden" name="start_date" id="temp_start_date" value="' + $('#start_date').val() + '">');
            }
            if ($('#end_date').prop('disabled')) {
                $('#sample_form').append('<input type="hidden" name="end_date" id="temp_end_date" value="' + $('#end_date').val() + '">');
            }

            if ($('#action').val() == '{{trans('file.Add')}}') {

                let start_date = $("#start_date").datepicker('getDate');
                let end_date = $("#end_date").datepicker('getDate');
                let dayDiff = Math.ceil((end_date - start_date) / (1000 * 60 * 60 * 24)) + 1;
                $('#diff_date_hidden').val(dayDiff);

                //console.log(dayDiff);


                $.ajax({
                    url: "{{ route('leaves.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        let html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (let count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.limit) {
                            html = '<div class="alert alert-danger">' + data.limit + '</div>';
                        }
                        if (data.remaining_leave) {
                            html = '<div class="alert alert-danger">' + data.remaining_leave + '</div>';
                        }
                        if (data.error) {
                            html = '<div class="alert alert-danger">' + data.error + '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#sample_form')[0].reset();
                            $('select').selectpicker('refresh');
                            $('.date').datepicker('update');
                            $('#leave-table').DataTable().ajax.reload();
                        }
                        location.reload();
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })
            }

            if ($('#action').val() == '{{trans('file.Edit')}}') {

                // Keep start_date disabled in edit mode; submit via hidden field when needed
                var totalDays = $('#total_days').val();
                $('#diff_date_hidden').val(totalDays);
                $.ajax({
                    url: "{{ route('leaves.update') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        let html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (let count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.limit) {
                            html = '<div class="alert alert-danger">' + data.limit + '</div>';
                        }
                        if (data.remaining_leave) {
                            html = '<div class="alert alert-danger">' + data.remaining_leave + '</div>';
                        }
                        if (data.error) {
                            html = '<div class="alert alert-danger">' + data.error + '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            setTimeout(function () {
                                $('#formModal').modal('hide');
                                $('.date').datepicker('update');
                                $('select').selectpicker('refresh');
                                $('#leave-table').DataTable().ajax.reload();
                                $('#sample_form')[0].reset();
                            }, 2000);

                        }
                        location.reload();
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    },
                    complete: function() {
                        // Remove temporary hidden fields after AJAX request completes
                        $('#temp_company_id, #temp_department_id, #temp_employee_id, #temp_status').remove();

                        // Restore original disabled states for selectpickers (if they were disabled)
                        $('#company_id').prop('disabled', companyDisabled).selectpicker('refresh');
                        $('#department_id').prop('disabled', departmentDisabled).selectpicker('refresh');
                        $('#employee_id').prop('disabled', employeeDisabled).selectpicker('refresh');
                        $('#status').prop('disabled', statusDisabled).selectpicker('refresh');
                    }
                });
            }
        });

        $(document).on('click', '.show_new', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            let target = '{{route('leaves.index')}}/' + id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (result) {

                    $('#leave_type_id').html(result.leave_type_name);
                    $('#company_id_show').html(result.company_name);
                    $('#employee_id_show').html(result.employee_name);
                    $('#department_id_show').html(result.department);
                    $('#start_date_id').html(result.start_date_name);
                    $('#end_date_id').html(result.end_date_name);
                    $('#applied_date_id').html(result.data.created_at);
                    $('#total_days_id').html(result.data.total_days);
                    $('#status_id').html(result.data.status);
                    $('#leave_reason_id').html(result.data.leave_reason);
                    $('#remarks_id').html(result.data.remarks);

                    if (result.data.is_half == 1)
                        $('#is_half_id').html('Yes');
                    else {
                        $('#is_half_id').html('No');
                    }
                    if (result.data.is_notify == 1)
                        $('#is_notify_id').html('On');
                    else {
                        $('#is_notify_id').html('On');
                    }


                    $('#leave_model').modal('show');
                    $('.modal-title').text("{{__('Leave Info')}}");
                }
            });
        });


        $(document).on('click', '.edit', function () {

            let id = $(this).attr('id');
            $('#form_result').html('');

            let target = "{{ route('leaves.index') }}/" + id + '/edit';

            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {

                    // Always show status field and label at the start
                    $('#status, #status_heading').show();
                    $('#status, #status_heading').parent().show();

                    let currentDate = new Date().toJSON().slice(0, 10);
                    // Do not auto-disable start date for Admin/CEO (role 1)
                    if ("{{ auth()->user()->role_users_id }}" != 1) {
                    if (Date.parse(html.leaveStartDate) < Date.parse(currentDate)) {
                        $('#start_date').prop('disabled', true);
                        }
                    }


                    let roleId = "{{ auth()->user()->role_users_id }}";
                    let loggedUserId = "{{ auth()->user()->id }}";
                    let leaveEmployeeId = html.data.employee_id;
                    let is_tl_action = html.data.is_tl_action;
                    let is_hr_action = html.data.is_hr_action;
                    let status_val = html.data.status;

                    if(is_tl_action == 1){
                        $('#status_heading').text('Approved by Teamlead');
                    }else{
                        $('#status_heading').text('Status');
                    }
                    // Status dropdown can be edited only if current status is 'pending',
                    // except Admin (role 1) who can always edit.
                    let canEditStatus = false;
                    if (roleId == 1) {
                        canEditStatus = true;
                    } else if (status_val === 'pending') {
                        canEditStatus = true;
                    }
                    $('#status').prop('disabled', !canEditStatus);

                 // Change Approved option value if roleId is 2 or 4 and $is_tl_action is 0
if ((roleId == 2 || roleId == 4) && is_tl_action == 0) {
    $('#status option[value="approved"]').val("1"); // Change value to 1
}

// Ensure the Status UI is visible; we only disable, not hide
$('#status, #status_heading').show();
$('#status, #status_heading').css('display', 'block');
$('#status, #status_heading').parent().show();


                    // Preselect current status, handling TL flow where 'approved' value becomes 1
                    (function(){
                        var currentStatus = status_val; // e.g., 'pending' | 'approved' | 'rejected' | '1'
                        // If the option 'approved' has been remapped to value "1", ensure selection matches
                        if (currentStatus === 'approved' && $('#status option[value="approved"]').length === 0 && $('#status option[value="1"]').length > 0) {
                            currentStatus = '1';
                        }
                        $('#status').selectpicker('val', currentStatus);
                    })();

                    // Refresh Selectpicker
                    $('#status').selectpicker('refresh');


                    // Set values for all fields
                    $('#remarks').val(html.data.remarks);
                    $('#leave_reason').val(html.data.leave_reason);
                    $('#leave_type').selectpicker('val', html.data.leave_type_id);

                    // Handle Company dropdown
                    let companyName = html.data.company ? html.data.company.company_name : 'N/A';
                    $('#company_id').empty();
                    $('#company_id').append('<option value="' + html.data.company_id + '" selected>' + companyName + '</option>');
                    $('#company_id').prop('disabled', true);
                    $('#company_id').selectpicker('refresh');

                    // Handle Department dropdown
                    let departmentName = html.data.department ? html.data.department.department_name : 'N/A';
                    console.log('Department Data:', html.data.department); // Log department data

                    $('#department_id').empty();
                    $('#department_id').append('<option value="' + html.data.department_id + '" selected>' + departmentName + '</option>');
                    $('#department_id').prop('disabled', true);
                    $('#department_id').selectpicker('refresh');

                    // Handle Employee dropdown
                    let selectedEmployeeName = 'N/A';
                    if (html.data.employee) {
                        selectedEmployeeName = html.data.employee.first_name + ' ' + html.data.employee.last_name;
                    }
                    console.log('Employee Data:', html.data.employee); // Log employee data

                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="' + html.data.employee_id + '" selected>' + selectedEmployeeName + '</option>');
                    $('#employee_id').prop('disabled', true);
                    $('#employee_id').selectpicker('refresh');

                    $('#start_date').val(html.data.start_date);
                    $('#end_date').val(html.data.end_date);
                    $('#total_days').val(html.data.total_days);

                    // Disable all fields except remarks and status
                    $('#leave_type').prop('disabled', true).selectpicker('refresh');
                    // For Admin/CEO (role 1), keep Start and End Date editable
                    if ("{{ auth()->user()->role_users_id }}" == 1) {
                        $('#start_date').prop('disabled', false);
                        $('#end_date').prop('disabled', false);
                    } else {
                    $('#start_date').prop('disabled', true);
                    $('#end_date').prop('disabled', true);
                    }
                    $('#total_days').prop('disabled', true);
                    $('#leave_reason').prop('disabled', true);
                    $('#is_notify').prop('disabled', true);

                    // Keep remarks and status enabled (status is already handled above)
                    $('#remarks').prop('disabled', false);

                    if (html.data.is_half == 1) {
                        $('#is_half').prop('checked', true);
                    } else {
                        $('#is_half').prop('checked', false);
                    }

                    if (html.data.is_notify == 1) {
                        $('#is_notify').prop('checked', true);
                    } else {
                        $('#is_notify').prop('checked', true);
                    }

                    $('#hidden_id').val(html.data.id);
                    $('#employee_id_hidden').val(html.data.employee_id);
                    $('#leave_type_hidden').val(html.data.leave_type_id);
                    $('.modal-title').text('Submit Leave');
                    $('#action_button').val('Submit');
                    $('#action').val('{{trans('file.Edit')}}');
                    $('#formModal').modal('show');
                }
            })
        });


        let delete_id;

        $(document).on('click', '.delete', function () {
            delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('{{__('DELETE Record')}}');
            $('#ok_button').text('{{trans('file.OK')}}');

        });


        $(document).on('click', '#bulk_delete', function () {

            let id = [];
            let table = $('#leave-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('{{__('Delete Selection',['key'=>trans('file.Leave')])}}')) {
                    $.ajax({
                        url: '{{route('mass_delete_leaves')}}',
                        method: 'POST',
                        data: {
                            leaveIdArray: id
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
                            location.reload();
                            $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);

                        }

                    });
                }
            } else {
                alert('{{__('Please select atleast one checkbox')}}');
            }
        });


        $('#close').on('click', function () {
            resetFormToDefaults();
        });

        // Handle modal hidden event (when modal is closed by any means)
        $('#formModal').on('hidden.bs.modal', function () {
            resetFormToDefaults();
        });

        // Function to reset form to default values
        function resetFormToDefaults() {
            $('#sample_form')[0].reset();
            
            // Restore original dropdown options for company
            $('#company_id').empty();
            @foreach($companies as $company)
                $('#company_id').append('<option value="{{ $company->id }}" {{ $loggedEmployee->company_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>');
            @endforeach
            
            // Restore original dropdown options for department
            $('#department_id').empty();
            @foreach($departments as $department)
                $('#department_id').append('<option value="{{ $department->id }}" {{ $loggedEmployee->department_id == $department->id ? 'selected' : '' }}>{{ $department->department_name }}</option>');
            @endforeach
            
            // Restore original dropdown options for employee
            $('#employee_id').empty();
            $('#employee_id').append('<option value="{{ $loggedEmployee->id }}" selected>{{ $loggedEmployee->first_name }} {{ $loggedEmployee->last_name }}</option>');
            
            // Restore original dropdown options for leave type
            $('#leave_type').empty();
            @foreach($leave_types as $leave_type)
                $('#leave_type').append('<option value="{{$leave_type->id}}">{{$leave_type->leave_type}}</option>');
            @endforeach
            
            // Refresh all selectpickers
            $('#company_id').selectpicker('refresh');
            $('#department_id').selectpicker('refresh');
            $('#employee_id').selectpicker('refresh');
            $('#leave_type').selectpicker('refresh');
            
            // Use setTimeout to ensure selectpicker is fully initialized
            setTimeout(function() {
                // Set the default values for company, department, and employee after reset
                $('#company_id').selectpicker('val', '{{ $loggedEmployee->company_id }}');
                $('#department_id').selectpicker('val', '{{ $loggedEmployee->department_id }}');
                $('#employee_id').selectpicker('val', '{{ $loggedEmployee->id }}');
                
                // Keep company, department, and employee disabled
                $('#company_id').prop('disabled', true).selectpicker('refresh');
                $('#department_id').prop('disabled', true).selectpicker('refresh');
                $('#employee_id').prop('disabled', true).selectpicker('refresh');
            }, 200);
            
            $('.date').datepicker('update');
            $('#leave-table').DataTable().ajax.reload();
            $('#start_date').prop('disabled', false);
        }

        $('#ok_button').on('click', function () {
            let target = "{{ route('leaves.index') }}/" + delete_id + '/delete';
            $.ajax({
                url: target,
                beforeSend: function () {
                    $('#ok_button').text('{{trans('file.Deleting...')}}');
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
                        location.reload();
                        $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        $('#confirmModal').modal('hide');
                        $('#leave-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });

        // Company → Department cascade
        $('.dynamic').off('change.dynamic').on('change.dynamic', function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let dependent = $(this).data('dependent');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('dynamic_department') }}",
                    method: "POST",
                    data: {value: value, _token: _token, dependent: dependent},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#department_id').html(result);
                        $('select').selectpicker();

                        // After departments load, also refresh employees list for the first department (admin use-case)
                        const firstDeptId = $('#department_id').val();
                        if (firstDeptId) {
                            $.ajax({
                                url: "{{ route('dynamic_employee_department') }}",
                                method: "POST",
                                data: {value: firstDeptId, _token: _token, first_name: 'first_name', last_name: 'last_name'},
                                success: function (empResult) {
                                    $('select').selectpicker("destroy");
                                    $('#employee_id').html(empResult);
                                    $('select').selectpicker();
                                }
                            });
                        }

                    }
                });
            }
        });

        // Department → Employee cascade
        $('#department_id').off('change.dept').on('change.dept', function () {
            let value = $(this).val();
            let _token = $('input[name="_token"]').val();
            if (value) {
                $.ajax({
                    url: "{{ route('dynamic_employee_department') }}",
                    method: "POST",
                    data: {value: value, _token: _token, first_name: 'first_name', last_name: 'last_name'},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#employee_id').html(result);
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
                    url: "{{ route('dynamic_employee_department') }}",
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
@endpush
