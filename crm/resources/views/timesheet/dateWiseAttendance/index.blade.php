@extends('layout.main')
@section('content')

    <section>
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header with-border">
                    <h3 class="card-title text-center"> {{__('Date Wise Attendance')}} </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" id="filter_form" class="form-horizontal">
                                @csrf
                                <div class="row">


                                    @if ((Auth::user()->can('date-wise-attendances')))
                                    {{-- @if (Auth::user()->role_users_id==1) --}}

                                    @php
                                        $hideCard = in_array(auth()->user()->role_users_id, [2, 4]) ? 'd-none' : '';
                                        $class = in_array(auth()->user()->role_users_id, [2, 4]) ? 'col-md-6' : 'col-md-4';
                                    @endphp

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{trans('file.Company')}} *</label>
                                                <select name="company_id" id="company_id"  class="form-control selectpicker dynamic" required
                                                        data-live-search="true" data-live-search-style="contains"  data-first_name="first_name" data-last_name="last_name" data-dependent="department_name"
                                                        title='{{__('Selecting',['key'=>trans('file.Company')])}}...'>
                                                    @foreach($companies as $company)
                                                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        

                                        <!-- <div class="col-md-4 form-group {{$hideCard}}">
                                            <label>{{trans('file.Department')}}</label>
                                            <select name="department_id" id="department_id"
                                                    class="selectpicker form-control department_wise_employees"
                                                    data-live-search="true" data-live-search-style="contains"
                                                    data-first_name="first_name" data-last_name="last_name"
                                                    title="{{__('Selecting',['key'=>trans('file.Department')])}}...">
                                            </select>
                                        </div> -->

                                        <div class="col-md-3 form-group">
                                            <!-- <label>{{trans('file.Employee')}} </label>
                                            <select name="employee_id" id="employee_id"  class="selectpicker form-control"
                                                    data-live-search="true" data-live-search-style="contains"
                                                    title='{{__('Selecting',['key'=>trans('file.Employee')])}}...'>
                                            </select> -->
                                            <label>{{trans('file.Employee')}}</label><small id="clearAllButton" >Clear All <i class="fa fa-times"></i> </small>
                                            <select name="employee_id[]" id="employee_id" class="selectpicker form-control"
                                                multiple data-live-search="true" data-live-search-style="contains"
                                                title='{{__('Selecting',['key'=>trans('file.Employee')])}}...'>
                                                <option value="all">Select All</option> <!-- Select All option -->
                                            </select>
                                        </div>

                                    @else
                                        <input type="hidden" name="employee_id" id="employee_id" value="{{Auth::user()->id}}"> {{-- users.id == employees.id  are same in this system--}}
                                    @endif

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="start_date">{{__('Start Date')}}</label>
                                                    <input class="form-control month_year date"
                                                        placeholder="Select Date" readonly=""
                                                        id="start_date" name="start_date" type="text" required
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="start_date">{{__('End Date')}}</label>
                                                    <input class="form-control month_year date"
                                                        placeholder="Select Date" readonly=""
                                                        id="end_date" name="end_date" type="text" required
                                                        value="">
                                                </div>
                                            </div>

                                            <div class="col-md-2 d-flex form-actions align-items-end">
                                                <button type="submit" class="filtering btn btn-primary"><i class="fa fa-search"></i> {{trans('file.Search')}}
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

        <div class="table-responsive">
            <table id="date_wise_attendance-table" class="table ">
                <thead>
                    <tr>
                        <th></th>
                        <th>{{trans('file.Employee')}}</th>
                        <th>{{trans('file.Company')}}</th>
                        <th>{{trans('file.Date')}}</th>
                        <th>{{trans('file.status')}}</th>
                        <th>{{__('Clock In')}}</th>
                        <th>{{__('Clock Out')}}</th>
                        <th>{{trans('file.Late')}}</th>
                        <th>{{__('Early Leaving')}}</th>
                        <th>{{trans('file.Overtime')}}</th>
                        <th>{{__('Total Work')}}</th>
                        <th>Productivity(%)</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>{{trans('file.Total')}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </section>
    {{-- https://stackoverflow.com/questions/27997269/addition-of-hours-in-hhmm-using-jquery --}}
    {{-- first_date = 29.03.2021 && 30.03.2021 --}}

@endsection


@push('scripts')
    <script type="text/javascript">
        (function($) {
            "use strict";
            $(document).ready(function () {

                let date = $('.date');
                date.datepicker({
                    format: '{{ env('Date_Format_JS')}}',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date()
                });

            });

            fill_datatable();

            function fill_datatable(filter_start_date = '', filter_end_date = '', company_id = '', department_id = '',  employee_ids = []) {

                let table_table = $('#date_wise_attendance-table').DataTable({
                    responsive: true,
                    scrollY: "500px", // Set scrollable height
                    scrollX: true, // Enable horizontal scrolling
                    scrollCollapse: true, // Allow collapse of the scroll area
                    fixedHeader: {
                        header: true,
                        footer: false
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('date_wise_attendances.index') }}",
                        data: {
                            filter_start_date: filter_start_date,
                            filter_end_date: filter_end_date,
                            company_id: company_id,
                            department_id: department_id,
                            // employee_id: employee_id,
                            employee_ids: employee_ids.join(','), // Pass as a comma-separated string
                            "_token": "{{ csrf_token()}}"
                        }
                    },

                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'employee_name',
                            name: 'employee_name'
                        },
                        {
                            data: 'company',
                            name: 'company'
                        },
                        {
                            data: 'attendance_date',
                            name: 'attendance_date',
                        },
                        {
                            data: 'attendance_status',
                            name: 'attendance_status'
                        },
                        {
                            data: 'clock_in',
                            name: 'clock_in',
                        },
                        {
                            data: 'clock_out',
                            name: 'clock_out',
                        },
                        {
                            data: 'time_late',
                            name: 'time_late',
                        },
                        {
                            data: 'early_leaving',
                            name: 'early_leaving',
                        },
                        {
                            data: 'overtime',
                            name: 'overtime',
                        },
                        {
                            data: 'total_work',
                            name: 'total_work'
                        },
                        {
                            data: 'percentage',
                            name: 'percentage'
                        },
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

                            "orderable": true,
                            'targets': [0, 10],
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
                            footer:true
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer:true
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer:true
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                    drawCallback: function () {
                        var api = this.api();
                        for (let i = 7; i <12; i++) {
                            datatable_sum(api, i);
                        }

                    },
                    rowCallback: function (row, data) {
                        if (data.attendance_status === "Absent") {
                            $('td:eq(4)', row).css('color', 'red'); // Set font color to red for attendance_status column
                        }
                    }
                });
                // new $.fn.dataTable.FixedHeader(table_table);
            }

            function datatable_sum(dt_selector, columnNo) {
                var rows = dt_selector.rows().indexes();
                var rowsdataCol = dt_selector.cells( rows, columnNo, { page: 'current' } ).data();

                var totalSeconds = 0;
                for (let i = 0; i < rowsdataCol.length; i++) {
                    if (rowsdataCol[i] != "---") {
                        var timeArray = rowsdataCol[i].split(":");
                        // Add seconds, minutes, and hours to totalSeconds
                        totalSeconds += (parseInt(timeArray[0]) * 3600) + (parseInt(timeArray[1]) * 60) + parseInt(timeArray[2]);
                    }
                }

                var hours = Math.trunc(totalSeconds / 3600);
                var minutes = Math.trunc((totalSeconds % 3600) / 60);
                var seconds = totalSeconds % 60;

                var result = digitCheck(hours) + ':' + digitCheck(minutes) + ':' + digitCheck(seconds);
                $(dt_selector.column(columnNo).footer()).html(result);
            }

            function digitCheck(data) {
                if (data < 10) {
                    return '0' + data;
                }
                return data;
            }

            $('#filter_form').on('submit',function (e) {
                e.preventDefault();
                var filter_start_date = $('#start_date').val();
                var filter_end_date = $('#end_date').val();
                let company_id = $('#company_id').val();
                let department_id = $('#department_id').val();
                let employee_id = $('#employee_id').val();
                if (filter_start_date !== '' && filter_end_date !== '' && company_id !== '') {
                    $('#date_wise_attendance-table').DataTable().destroy();
                    fill_datatable(filter_start_date, filter_end_date, company_id, department_id, employee_id);
                } else {
                    alert('{{__('Select Both filter option')}}');
                }
            });


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

            $('.dynamic').change(function () {
                if ($(this).val() !== '') {
                    let value = $(this).val();
                    let first_name = $(this).data('first_name');
                    let last_name = $(this).data('last_name');
                    let _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: "{{ route('dynamic_employee') }}",
                        method: "POST",
                        data: { value: value, _token: _token, first_name: first_name, last_name: last_name },
                        success: function (result) {
                            $('#employee_id').html('<option value="all">Select All</option>' + result);
                            $('#employee_id').selectpicker('refresh');
                        }
                    });
                }
            });

            // $('.dynamic').change(function() {
            //     if ($(this).val() !== '') {
            //         let value = $(this).val();
            //         let first_name = $(this).data('first_name');
            //         let last_name = $(this).data('last_name');
            //         let _token = $('input[name="_token"]').val();
            //         $.ajax({
            //             url:"{{ route('dynamic_employee') }}",
            //             method:"POST",
            //             data:{ value:value, _token:_token, first_name:first_name,last_name:last_name},
            //             success:function(result)
            //             {
            //                 $('select').selectpicker("destroy");
            //                 $('#employee_id').html(result);
            //                 $('select').selectpicker();

            //             }
            //         });
            //     }
            // });

            $('.dynamic').change(function () {
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

                        }
                    });
                }
            });

            $('.department_wise_employees').change(function () {
                if ($(this).val() !== '') {
                    let value = $(this).val();
                    let first_name = $(this).data('first_name');
                    let last_name = $(this).data('last_name');
                    let _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('dynamic_employee_department') }}",
                        method: "POST",
                        data: {value: value, _token: _token, first_name:first_name,last_name:last_name},
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
@endpush



