@extends('layout.main')
@section('content')
    <section>
    @include('shared.errors')
    <!-- Content -->
        <div class="container-fluid">
            <div class="row">

                <div class="col-3 col-md-2 mb-3">
                    <img src={{ URL::to('/uploads/profile_photos')}}/{{$user->profile_photo ?? 'avatar.jpg'}}  width='150'
                         class='rounded-circle'>
                </div>

                <div class="col-9 col-md-10 mb-3">
                    <h4 class="font-weight-bold">{{$employee->full_name}} <span class="text-muted font-weight-normal"> ({{$user->username}})</span>
                    </h4>
                    <div class="text-muted mb-2">{{$employee->designation->designation_name ?? ''}}, {{$employee->department->department_name ?? ''}}</div>
                    <p class="text-muted">{{__('Last Login')}}: {{$user->last_login_date}}</p>
                    <p class="text-muted">{{__('My Office Shift')}}:
                    @if(!$shift_in)
                        {{__('No Shift Today')}}
                    @else
                        {{$shift_in}} To {{$shift_out}}
                    @endif
                    ({{$shift_name}})</p>
                    <a class="btn btn-default btn-sm" id="my_profile" href="{{route('profile')}}">
                        <i class="dripicons-user"></i> {{trans('file.Profile')}}
                    </a>
                    @if (env('ENABLE_CLOCKIN_CLOCKOUT')!=NULL)
                        <form class="d-inline m1-2" action="{{route('employee_attendance.post',$employee->id)}}" name="set_clocking"
                            id="set_clocking" autocomplete="off" class="form" method="post" accept-charset="utf-8">
                            @csrf

                            <input type="hidden" value="{{$shift_in}}" name="office_shift_in" id="shift_in">
                            <input type="hidden" value="{{$shift_out}}" name="office_shift_out" id="shift_out">
                            <input type="hidden" value="" name="in_out_value" id="in_out">

                            @if(!$employee_attendance || $employee_attendance->clock_in_out== 0)
                                <button class="btn btn-success btn-sm" @if($employee->attendance_type=='ip_based' && $ipCheck!=true) disabled @endif type="submit" id="clock_in_btn"><i class="dripicons-enter"></i> {{__('Clock IN')}}</button>
                            @else
                                <button class="btn btn-danger btn-sm" @if($employee->attendance_type=='ip_based' && $ipCheck!=true) disabled @endif type="submit" id="clock_out_btn"><i class="dripicons-exit"></i> {{__('Clock OUT')}}</button>
                            @endif
                            {{-- <br> --}}
                            @if($employee->attendance_type=='ip_based' && $ipCheck!=true) <small class="text-danger"><i>[Please login with your office's internet to clock in or clock out]</i></small> @endif
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
            @if (Auth::user()->role_users_id != 2)
            @if($leaveCountPending > 0)
<div class="col-md-12 mt-4">
    <a href="{{ url('timesheet/leaves') }}" class="text-decoration-none">
        <div class="alert alert-warning d-flex align-items-center justify-content-between shadow-sm rounded-3" style="background-color: brown; color: white;" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <!-- Bootstrap Icon -->
                <strong>Pending Leaves:</strong> You have <span class="badge bg-white ms-2 text-dark m-1"> {{ $leaveCountPending }} </span> pending leave requests.
            </div>
            <i class="bi bi-arrow-right-circle-fill text-dark fs-5"></i>
        </div>
    </a>
</div>
@endif
@endif
                <div class="col-md-3 mt-4">
                    <div class="d-flex wrapper count-title">
                        <div class="icon blue-text ml-2 mr-3">
                            <i class="dripicons-wallet display-5"></i>
                        </div>
                        <a href="{{route('profile').'#Employee_Payslip'}}">
                            <div class="name"><h4>{{__('Payslip')}}</h4></div>
                            <p>{{ __('View Details') }}</p>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 mt-4">
                    <div class="d-flex wrapper count-title">
                        <div class="icon purple-text ml-2 mr-3">
                            <i class="dripicons-trophy"></i>
                        </div>
                        <a href="{{route('profile').'#Employee_Core_hr'}}">
                            <div class="name"><h4>{{$employee_award_count}} {{__('Award')}}</h4></div>
                            <p>{{ __('View Details') }}</p>
                        </a>
                    </div>
                </div>


                <div class="col-md-3 mt-4">
                    <div class="d-flex wrapper count-title">
                        <div class="icon orange-text ml-2 mr-3">
                            <i class="dripicons-feed"></i>
                        </div>
                        <a href="{{route('announcements.index')}}">
                            <div class="text-center"><h4>{{ count($announcements) }} {{trans('file.Announcement')}}</h4>
                            </div>
                            <p>{{ __('View Details') }}</p>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 mt-4">
                    <div class="d-flex wrapper count-title">
                        <div class="icon green-text ml-2 mr-3">
                            <i class="dripicons-gaming"></i>
                        </div>
                        @if(count($holidays) > 0)
                        <div id="holiday" class="">
                        @else
                        <div class="">
                        @endif
                            <h4>{{ count($holidays) }} {{__('Upcoming Holidays')}}</h4>
                            <p>{{ __('View Details') }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Leave</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-link btn-block" href="{{route('profile').'#Leave'}}">
                                {{__(' View Leave Info')}}
                            </a>
                            <button class="btn btn-light btn-block mt-0" id="leave_request">{{__('Request Leave')}}</button>
                        </div>
                    </div>
                </div>

                {{-- HIDE TRAVEL SECTION --}}
                {{--
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Travel</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-link btn-block" href="{{route('profile').'#Employee_travel'}}">
                            {{__('View Travel Info')}}
                        </a>
                            <button class="btn btn-light btn-block mt-0" id="travel_request">{{__('Request Travel')}}</button>
                        </div>
                    </div>
                </div>
                --}}

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">{{__('Ticket')}}</h3>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-link btn-block"  href="{{route('profile').'#Employee_ticket'}}">
                                {{__('Ticket Info')}}
                            </a>
                            <button class="btn btn-light btn-block mt-0" id="ticket_request">{{__('Open A Ticket')}}</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="container-fluid">
            <div class="row">
                {{-- HIDE ASSIGNED PROJECTS IF COUNT IS 0 --}}
                @if($assigned_projects_count > 0)
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Assigned Projects')}} ({{$assigned_projects_count}})</h4>
                        </div>
                        <div class="card-body list pt-0">
                            <table class="table">
                                <tbody>
                                    @foreach($assigned_projects as $project)
                                        @if (count($project->assignedProjects)!=0)
                                            <tr>
                                                <td>
                                                    <a href="{{route('projects.show',$project->assignedProjects[0]->id)}}"><h5>{{$project->assignedProjects[0]->title}}</h5></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                {{-- HIDE ASSIGNED TASKS IF COUNT IS 0 --}}
                @if($assigned_tasks_count > 0)
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Assigned Tasks')}} ({{$assigned_tasks_count}})</h4>
                        </div>
                        <div class="card-body list pt-0">
                            <table class="table">
                                <tbody>
                                    @foreach($assigned_tasks as $task)
                                        @if (count($task->assignedTasks)!=0)
                                            <tr>
                                                <td>
                                                    <a href="{{route('tasks.show',$task->assignedTasks[0]->id)}}"><h5>{{$task->assignedTasks[0]->task_name}}</h5></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Assigned Tickets')}} ({{$assigned_tickets_count}})</h4>
                        </div>
                        <div class="card-body list pt-0">
                            <table class="table">
                                <tbody>
                                    @foreach($assigned_tickets as $ticket)
                                        @if (count($ticket->assignedTickets)!=0)
                                            <tr>
                                                <td>
                                                    <a href="{{route('tickets.show',$ticket->assignedTickets[0]->ticket_code)}}"><h5>{{$ticket->assignedTickets[0]->subject}}</h5></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="holidayModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{__('Holidays')}}</h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        @foreach($holidays as $holiday)
                            <div><strong class="name blue-text">{{$holiday->event_name}}</strong>{{trans('file.From')}}
                                :{{$holiday->start_date}} {{trans('file.To')}}:{{$holiday->end_date}}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div id="leaveModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{__('Leave Request')}}</h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <span id="leave_form_result"></span>
                        <form method="post" id="leaveSampleForm" class="form-horizontal">

                            @csrf
                            <div class="row">

<div class="col-md-4 form-group">
    <label>{{__('Leave Type')}} *</label>
    <select name="leave_type" id="leave_type" class="form-control selectpicker"
            data-live-search="true" data-live-search-style="contains"
            title='{{__('Leave Type')}}'>
        @foreach($leaveTypeDetails as $leave)
            @php
                $remaining = isset($leave['remaining_allocated_day']) && is_numeric($leave['remaining_allocated_day']) ? (float)$leave['remaining_allocated_day'] : 0;
                $minsPerDay = $minutes_per_day ?? 480;
                if ($minsPerDay <= 0) $minsPerDay = 480;
                $totalMins = round($remaining * $minsPerDay);
                $d = (int)floor($totalMins / $minsPerDay);
                $remainder = $totalMins % $minsPerDay;
                $h = (int)floor($remainder / 60);
                $m = (int)($remainder % 60);
                $balanceText = $d . ' ' . ($d == 1 ? __('Day') : __('Days'));
                if ($h > 0 || $m > 0) {
                    $balanceText .= ' ' . $h . ' ' . ($h == 1 ? __('Hour') : __('Hours')) . ' ' . $m . ' ' . ($m == 1 ? __('Minute') : __('Minutes'));
                }
            @endphp
            <option value="{{ $leave['leave_type_id'] }}" data-day="{{ $remaining }}">
                {{ $leave['leave_type'] }} ({{ $balanceText }})
            </option>
        @endforeach
    </select>
</div>



                                <div class="col-md-4 form-group">
                                    <label>{{__('Start Date')}} *</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control date" value="">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>{{__('End Date')}} *</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control test date" value="">
                                </div>

                                <!-- <div class="col-md-4 form-group">
                                    <label>{{__('Total Days')}}</label>
                                    <input type="text"  id="total_days" class="form-control">
                                </div> -->

                                <div class="col-md-4 form-group">
                                    <label class="d-block mb-2">{{__('Total Days')}} *</label>
                                    <div class="total-days-group border rounded bg-light px-3 py-2">
                                        <div class="row no-gutters align-items-end">
                                            <div class="col-4 pr-2">
                                                <label class="small text-muted mb-1 d-block">{{ __('Days') }}</label>
                                                <select id="total_days_d" name="total_days_d" class="form-control form-control-sm total-days-select" title="{{ __('Days') }}">
                                                    <option value="0" selected>0</option>
                                                </select>
                                            </div>
                                            <div class="col-4 px-1">
                                                <label class="small text-muted mb-1 d-block">{{ __('Hours') }}</label>
                                                <select id="total_days_h" name="total_days_h" class="form-control form-control-sm total-days-select" title="{{ __('Hours') }}">
                                                    @for($i = 0; $i <= 23; $i++) <option value="{{ $i }}" {{ $i === 0 ? 'selected' : '' }}>{{ $i }}</option> @endfor
                                                </select>
                                            </div>
                                            <div class="col-4 pl-2">
                                                <label class="small text-muted mb-1 d-block">{{ __('Minutes') }}</label>
                                                <select id="total_days_m" name="total_days_m" class="form-control form-control-sm total-days-select" title="{{ __('Minutes') }}">
                                                    @for($i = 0; $i <= 59; $i++) <option value="{{ $i }}" {{ $i === 0 ? 'selected' : '' }}>{{ $i }}</option> @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="small text-muted mt-1 pt-1 border-top mt-2 pt-2" id="total_days_summary">{{ __('Duration in days, hours and minutes') }}</div>
                                    </div>
                                    <input type="hidden" name="total_days" id="total_days_hidden" value="">
                                </div>


                                <div class="col-md-8 form-group">
                                    <label for="leave_reason">{{trans('file.Description')}}</label>
                                    <textarea class="form-control" id="leave_reason" name="leave_reason"
                                              rows="3"></textarea>
                                </div>

                                <div class="container">
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="company_id" value="{{$employee->company_id}}"/>
                                        <input type="hidden" name="department_id" value="{{$employee->department_id}}"/>
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
                                        <input type="hidden" name="status" value="pending"/>

                                        <input type="hidden" name="diff_date_hidden" id="diff_date_hidden"/>
                                        <input type="submit" name="action_button" class="btn btn-warning"
                                               value={{trans('file.Add')}} />
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div id="travelModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{__('Travel Request')}}</h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <span id="travel_form_result"></span>
                        <form method="post" id="travel_sample_form" class="form-horizontal">

                            @csrf
                            <div class="row">


                                <div class="col-md-6 form-group">
                                    <label>{{__('Arrangement Type')}}</label>
                                    <select name="travel_type_id" class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='{{__('Selecting',['key'=>trans('file.Arrangement')])}}...'>
                                        @foreach($travel_types as $travel_type)
                                            <option value="{{$travel_type->id}}">{{$travel_type->arrangement_type}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-6 form-group">
                                    <label>{{__('Purpose Of Visit')}} *</label>
                                    <input type="text" name="purpose_of_visit" class="form-control"
                                           placeholder="{{__('Purpose Of Visit')}}">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('Place Of Visit')}} *</label>
                                    <input type="text" name="place_of_visit" class="form-control"
                                           placeholder="{{__('Place Of Visit')}}">
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{trans('file.Description')}}</label>
                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('Start Date')}} *</label>
                                    <input type="text" name="start_date" class="form-control date" autocomplete="off"
                                           value="">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('End Date')}} *</label>
                                    <input type="text" name="end_date" class="form-control date" autocomplete="off"
                                           value="">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('Expected Budget')}}</label>
                                    <input type="text" name="expected_budget" class="form-control">
                                </div>


                                <div class="col-md-6 form-group">
                                    <label>{{__('Travel Mode')}}</label>
                                    <select name="travel_mode" class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='{{__('Travel Mode')}}'>
                                        <option value="By Bus">{{__('By Bus')}}</option>
                                        >
                                        <option value="By Train">{{__('By Train')}}</option>
                                        <option value="By Plane">{{__('By Plane')}}</option>
                                        <option value="By Taxi">{{__('By Taxi')}}</option>
                                        <option value="By Rental Car">{{__('By Rental Car')}}</option>
                                        <option value="By Other">{{__('By Other')}}</option>
                                    </select>
                                </div>


                                <div class="container">
                                    <div class="form-group" align="center">

                                        <input type="hidden" name="company_id" value="{{$employee->company_id}}"/>
                                        <input type="hidden" name="department_id" value="{{$employee->department_id}}"/>
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
                                        <input type="hidden" name="status" value="pending"/>

                                        <input type="submit" name="action_button" class="btn btn-warning"
                                               value={{trans('file.Add')}} />
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div id="ticketModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title">{{__('Open Ticket')}}</h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <span id="ticket_form_result"></span>
                        <form method="post" id="ticket_sample_form" class="form-horizontal"
                              enctype="multipart/form-data">

                            @csrf

                            <div class="row">


                                <div class="col-md-6 form-group">
                                    <label>{{trans('file.Priority')}}</label>
                                    <select name="ticket_priority" id="ticket_priority"
                                            class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='{{__('Selecting',['key'=>trans('file.Priority')])}}...'>
                                        <option value="low">{{trans('file.Low')}}</option>
                                        <option value="medium">{{trans('file.Medium')}}</option>
                                        <option value="high">{{trans('file.High')}}</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{trans('file.Subject')}} *</label>
                                    <input type="text" name="subject" id="subject" class="form-control"
                                           placeholder="{{trans('file.Subject')}}">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>{{__('Ticket Note')}}</label>
                                    <input type="text" name="ticket_note" id="ticket_note" class="form-control"
                                           placeholder="{{trans('file.Optional')}}">
                                </div>

                                <div class="col-md-6 form-group hide_edit">
                                    <label>{{__('Ticket Attachments')}} </label>
                                    <input type="file" name="ticket_attachments" id="ticket_attachments"
                                           class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{trans('file.Description')}}</label>
                                        <textarea class="form-control" id="description" name="description"
                                                  rows="3"></textarea>
                                    </div>
                                </div>


                                <div class="container">
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="company_id" value="{{$employee->company_id}}"/>
                                        <input type="hidden" name="department_id" value="{{$employee->department_id}}"/>
                                        <input type="hidden" name="employee_id" value="{{$employee->id}}"/>
                                        {{-- <input type="hidden" name="ticket_status" value="pending"/> --}}
                                        <input type="hidden" name="ticket_status" value="open"/>

                                        <input type="submit" name="action_button" class="btn btn-warning"
                                               value={{trans('file.Add')}} />

                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


@push('scripts')
<script>
    (function($) {
        "use strict";


        // Scope to Leave Request modal so we always target the correct fields
        let $leaveModal = $('#leaveModal');
        let startDateInput = () => $leaveModal.find('#start_date');
        let endDateInput = () => $leaveModal.find('#end_date');
        let minutesPerDay = {{ $minutes_per_day ?? 480 }};
        let loggedEmployeeId = {{ $employee->id }};
        if (minutesPerDay <= 0) minutesPerDay = 480;
        var shiftMaxHours = 0;
        var shiftLastMinutes = 0;

        // Count weekdays (Mon–Fri) between start and end inclusive; excludes Saturday and Sunday.
        function countWeekdays(startDate, endDate) {
            var d = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
            var end = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
            if (d.getTime() > end.getTime()) return 0;
            var count = 0;
            while (d.getTime() <= end.getTime()) {
                var day = d.getDay();
                if (day !== 0 && day !== 6) count++;
                d.setDate(d.getDate() + 1);
            }
            return count;
        }

        $(document).ready(function () {
            let date = $('.date');
            date.datepicker({
                format: '{{ env('Date_Format_JS')}}',
                autoclose: true,
                todayHighlight: true,
                startDate: new Date(new Date().setDate(new Date().getDate() - 6))
            });

            function updateTotalDaysFromDates() {
                getDateResult();
            }
            $leaveModal.on('change', '#start_date, #end_date', updateTotalDaysFromDates);
            $leaveModal.on('changeDate', '#start_date, #end_date', updateTotalDaysFromDates);
            $leaveModal.on('change', '#leave_type', updateTotalDaysFromDates);
            $leaveModal.on('change', '#total_days_d', function() {
                applyTotalDaysStateFromDays();
                updateTotalDaysSummary();
            });
            $leaveModal.on('change', '#total_days_h', function() {
                updateMinutesOptionsForHours();
                applyTotalDaysStateFromHours();
                updateTotalDaysSummary();
            });
            $leaveModal.on('change', '#total_days_m', function() {
                applyTotalDaysStateFromMinutes();
                updateTotalDaysSummary();
            });
        });

        function getDateResult() {
            let $start = startDateInput();
            let $end = endDateInput();
            let $d = $leaveModal.find('#total_days_d');
            let $h = $leaveModal.find('#total_days_h');
            let $m = $leaveModal.find('#total_days_m');
            if (!$d.length) return;

            let startDate = null;
            let endDate = null;
            try {
                startDate = $start.datepicker('getDate');
                endDate = $end.datepicker('getDate');
            } catch (e) {}
            if (!startDate && $start.val()) startDate = parseDateDMY($start.val());
            if (!endDate && $end.val()) endDate = parseDateDMY($end.val());

            function parseDateDMY(dateStr) {
                if (!dateStr || typeof dateStr !== 'string') return null;
                let parts = dateStr.trim().split("-");
                if (parts.length !== 3) return null;
                let day = parseInt(parts[0], 10);
                let month = parseInt(parts[1], 10) - 1;
                let year = parseInt(parts[2], 10);
                if (isNaN(day) || isNaN(month) || isNaN(year)) return null;
                let d = new Date(year, month, day);
                return isNaN(d.getTime()) ? null : d;
            }

            if (!startDate || !endDate || isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                $d.empty().append($('<option value="0">0</option>')).val(0).prop('disabled', true);
                $h.val(0).prop('disabled', true);
                $m.val(0).prop('disabled', true);
                updateTotalDaysSummary();
                return;
            }

            var totalMinutes = 0;
            if (startDate.getTime() === endDate.getTime()) {
                totalMinutes = Math.round(minutesPerDay * 0.5);
            } else if (startDate.getTime() < endDate.getTime()) {
                var weekdays = countWeekdays(startDate, endDate);
                totalMinutes = weekdays * minutesPerDay;
            }
            var d = Math.floor(totalMinutes / minutesPerDay);
            var remainder = totalMinutes % minutesPerDay;
            var hrs = Math.floor(remainder / 60);
            var mins = remainder % 60;

            var maxDays = Math.min(31, d);
            var isSameDay = (startDate.getTime() === endDate.getTime());
            var optionsStart, optionsEnd, selectedDays;
            if (maxDays === 0) {
                optionsStart = 0;
                optionsEnd = 0;
                selectedDays = 0;
            } else if (isSameDay) {
                optionsStart = 0;
                optionsEnd = 1;
                selectedDays = 0; // Default to 0 days for same date to enable hours/minutes
            } else {
                optionsStart = maxDays - 1;
                optionsEnd = maxDays;
                selectedDays = maxDays;
            }
            $d.empty();
            for (var i = optionsStart; i <= optionsEnd; i++) {
                $d.append($('<option></option>').attr('value', i).text(i));
            }
            $d.val(selectedDays).prop('disabled', false);
            
            // Apply business rule: only disable hours/minutes when maximum days selected
            if (selectedDays === maxDays && maxDays > 0) {
                // Maximum days selected → disable hours/minutes (full days only)
                $h.val(0).prop('disabled', true);
                $m.val(0).prop('disabled', true);
            } else {
                // Partial days (0 or lower option) → enable hours/minutes and set calculated values
                $h.val(Math.min(23, hrs)).prop('disabled', false);
                $m.val(Math.min(59, mins)).prop('disabled', false);
                updateHoursOptionsForEndDate();
                updateMinutesOptionsForHours();
            }

            updateTotalDaysSummary();
        }

        function updateHoursOptionsForEndDate() {
            var $h = $leaveModal.find('#total_days_h');
            var $end = endDateInput();
            if (!$h.length || !$end.length) return;

            var endDateStr = $end.val();
            if (!endDateStr || !loggedEmployeeId) {
                return;
            }

            $.ajax({
                url: "{{ route('leaves.shift_hours') }}",
                method: 'GET',
                data: {
                    employee_id: loggedEmployeeId,
                    date: endDateStr
                },
                success: function (resp) {
                    var maxHours = parseInt(resp.hours, 10);
                    if (isNaN(maxHours) || maxHours < 0) maxHours = 0;
                    if (maxHours > 23) maxHours = 23;
                    var minutesRemainder = parseInt(resp.minutes, 10);
                    if (isNaN(minutesRemainder) || minutesRemainder < 0) minutesRemainder = 0;

                    shiftMaxHours = maxHours;
                    shiftLastMinutes = minutesRemainder;

                    var currentVal = parseInt($h.val(), 10);
                    if (isNaN(currentVal) || currentVal < 0) currentVal = 0;

                    $h.empty();
                    for (var i = 0; i <= maxHours; i++) {
                        $h.append($('<option></option>').attr('value', i).text(i));
                    }

                    if (currentVal > maxHours) {
                        currentVal = maxHours;
                    }
                    $h.val(currentVal);
                    updateMinutesOptionsForHours();
                }
            });
        }

        function updateMinutesOptionsForHours() {
            var $h = $leaveModal.find('#total_days_h');
            var $m = $leaveModal.find('#total_days_m');
            if (!$h.length || !$m.length) return;

            var hVal = parseInt($h.val(), 10) || 0;
            var maxMinutes;

            if (shiftMaxHours > 0 && hVal === shiftMaxHours) {
                maxMinutes = shiftLastMinutes;
                $m.empty();
                if (maxMinutes <= 0) {
                    // Exact whole-hour shift (e.g. 8:00) -> minutes fixed at 0 and disabled
                    $m.append($('<option></option>').attr('value', 0).text(0));
                    $m.val(0).prop('disabled', true);
                } else {
                    // Shift with remainder (e.g. 8:30) -> show only that remainder value
                    $m.append($('<option></option>').attr('value', maxMinutes).text(maxMinutes));
                    $m.val(maxMinutes).prop('disabled', true);
                }
            } else if (hVal > 0) {
                // 1..(maxHours-1): user can select 0..59 minutes (include 0!)
                $m.empty();
                for (var i = 0; i <= 59; i++) {
                    $m.append($('<option></option>').attr('value', i).text(i));
                }
                $m.prop('disabled', false);
            } else {
                $m.empty();
                for (var i = 0; i <= 59; i++) {
                    $m.append($('<option></option>').attr('value', i).text(i));
                }
                $m.prop('disabled', false);
            }
        }

        // When user changes Days: only disable hours/minutes when selecting the maximum available option
        function applyTotalDaysStateFromDays() {
            var $d = $leaveModal.find('#total_days_d');
            var $h = $leaveModal.find('#total_days_h');
            var $m = $leaveModal.find('#total_days_m');
            if (!$d.length) return;
            var days = parseInt($d.val(), 10) || 0;
            var maxOption = 0;
            $d.find('option').each(function() { 
                var v = parseInt($(this).val(), 10); 
                if (v > maxOption) maxOption = v; 
            });
            
            if (days === maxOption && maxOption > 0) {
                // Selected maximum days → disable hours/minutes (full days only)
                $h.val(0).prop('disabled', true);
                $m.val(0).prop('disabled', true);
            } else {
                // Selected partial days (0 or lower option) → enable hours/minutes
                $h.prop('disabled', false);
                $m.prop('disabled', false);
                updateHoursOptionsForEndDate();
                updateMinutesOptionsForHours();
            }
        }

        // When user changes Hours: no longer disable days (business rule changed)
        function applyTotalDaysStateFromHours() {
            var $h = $leaveModal.find('#total_days_h');
            if (!$h.length) return;
            // Hours selection doesn't affect days anymore - user can select both
            // Only days selection affects hours/minutes based on max option rule
        }

        // When user changes Minutes: no longer disable days (business rule changed)
        function applyTotalDaysStateFromMinutes() {
            var $m = $leaveModal.find('#total_days_m');
            if (!$m.length) return;
            // Minutes selection doesn't affect days anymore - user can select both
            // Only days selection affects hours/minutes based on max option rule
        }

        function updateTotalDaysSummary() {
            var $d = $leaveModal.find('#total_days_d');
            var $h = $leaveModal.find('#total_days_h');
            var $m = $leaveModal.find('#total_days_m');
            var $sum = $leaveModal.find('#total_days_summary');
            if (!$d.length || !$sum.length) return;
            var days = parseInt($d.val(), 10) || 0;
            var hours = parseInt($h.val(), 10) || 0;
            var minutes = parseInt($m.val(), 10) || 0;
            var totalMinutes = days * minutesPerDay + hours * 60 + minutes;
            var decimalDays = minutesPerDay > 0 ? (totalMinutes / minutesPerDay) : 0;
            var text = (days === 0 && hours === 0 && minutes === 0)
                ? '{{ __("Duration in days, hours and minutes") }}'
                : ('≈ ' + decimalDays.toFixed(2) + ' {{ __("days") }}');
            $sum.text(text);
        }

        // let date = $('.date');
        // date.datepicker({
        //     format: '{{ env('Date_Format_JS')}}',
        //     autoclose: true,
        //     todayHighlight: true
        // });

        $('#holiday').on('click', function () {
            $('#holidayModal').modal('show');
        });

        $('#leave_request').on('click', function () {
            $('#leaveModal').modal('show');
        });

        $('#leaveModal').on('shown.bs.modal', function () {
            getDateResult();
            updateTotalDaysSummary();
        });
        $('#leaveModal').on('show.bs.modal', function () {
            $leaveModal.find('#total_days_d, #total_days_h, #total_days_m').val(0).prop('disabled', true);
        });

        $('#travel_request').on('click', function () {
            $('#travelModal').modal('show');
        });

        $('#ticket_request').on('click', function () {
            $('#ticketModal').modal('show');
        });


$('#leaveSampleForm').on('submit', function (event) {
    event.preventDefault();
    $(this).find('input[type="submit"]').prop('disabled', true);

    var days = parseInt($('#total_days_d').val(), 10) || 0;
    var hours = parseInt($('#total_days_h').val(), 10) || 0;
    var minutes = parseInt($('#total_days_m').val(), 10) || 0;
    var totalMinutes = days * minutesPerDay + hours * 60 + minutes;
    $('#diff_date_hidden').val(totalMinutes);
    $('#total_days_hidden').val(totalMinutes);

    let allocatedDay = parseFloat($("#leave_type option:selected").data('day')) || 0;
    let allocatedMinutes = Math.round(allocatedDay * minutesPerDay);
    let html = '';

    if (totalMinutes <= 0) {
        html += '<div class="alert alert-danger">' + '<p>Please select total days</p>' + '</div>';
        $('#leaveSampleForm').find('input[type="submit"]').prop('disabled', false);
        return $('#leave_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
    }

    if (totalMinutes > allocatedMinutes) {
        let requestedDays = (totalMinutes / minutesPerDay).toFixed(2);
        html += '<div class="alert alert-danger">' + '<p>Insufficient leave balance. Available: ' + allocatedDay.toFixed(2) + ' days, Requested: ' + requestedDays + ' days.</p>' + '</div>';
        $('#leaveSampleForm').find('input[type="submit"]').prop('disabled', false);
        return $('#leave_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
    }

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
                html += '<div class="alert alert-danger">';
                for (let count = 0; count < data.errors.length; count++) {
                    html += '<p>' + data.errors[count] + '</p>';
                }
                html += '</div>';
                $('#leaveSampleForm').find('input[type="submit"]').prop('disabled', false);
            } else if (data.remaining_leave || data.error) {
                html = '<div class="alert alert-danger">' + (data.remaining_leave || data.error) + '</div>';
                $('#leaveSampleForm').find('input[type="submit"]').prop('disabled', false);
            } else if (data.success) {
                html += '<div class="alert alert-success">' + data.success + '</div>';
                $('#leaveSampleForm')[0].reset();
                $('select:not(.total-days-select)').selectpicker('refresh');
                $('.date').datepicker('update');
            }

            location.reload();
            $('#leave_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
        },
        error: function() {
            $('#leaveSampleForm').find('input[type="submit"]').prop('disabled', false);
        }
    });
});


        $('#travel_sample_form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('travels.store') }}",
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
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#travel_sample_form')[0].reset();
                        $('select:not(.total-days-select)').selectpicker('refresh');
                        $('.date').datepicker('update');
                    }
                    $('#travel_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        });


        $('#ticket_sample_form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('tickets.store') }}",
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
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#ticket_sample_form')[0].reset();
                        $('select:not(.total-days-select)').selectpicker('refresh');
                    }
                    $('#ticket_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        });

    })(jQuery);
</script>
@endpush
