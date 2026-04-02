<?php
$loggedUser = auth()->user(); 
$loggedEmployee = \App\Models\Employee::find($loggedUser->id);
// dd($loggedUser->id);
// if ($loggedUser->role_users_id == 4) {
// }
?>

@extends('layout.main')
@section('content')
<style>
    /* Ensure disabled textareas are visible and readable */
    textarea#leave_reason:disabled {
        background-color: #f5f5f5 !important;
        opacity: 1 !important;
        color: #495057 !important;
        cursor: not-allowed;
    }
    /* Force description container to always be visible */
    #leave_reason_container {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: auto !important;
        overflow: visible !important;
    }
    /* Force description field to always be visible */
    #leave_reason {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        min-height: 60px !important;
        width: 100% !important;
    }
    /* Force label to always be visible */
    label[for="leave_reason"] {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }
    /* Override any Bootstrap hiding classes */
    #leave_reason_container.d-none,
    #leave_reason_container.hidden,
    #leave_reason.d-none,
    #leave_reason.hidden {
        display: block !important;
        visibility: visible !important;
    }
</style>
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
                    <th>{{ __('Status') }}</th>
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
                                    <option value="pending" selected>{{trans('file.Pending')}}</option>
                                    <option value="1">Approved By Teamlead</option>
                                    <option value="rejected">{{trans('file.Rejected')}}</option>
                                </select>
                                @else
                                <label id="status_heading">{{trans('file.Status')}}</label>
                                <select name="status" id="status" class="form-control selectpicker "
                                        data-live-search="true" data-live-search-style="contains"
                                        title='{{__('Selecting',['key'=>trans('file.Status')])}}...'>
                                    <option value="pending" selected>{{trans('file.Pending')}}</option>
                                    <option value="approved">{{trans('file.Approved')}}</option>
                                    <option value="rejected">{{trans('file.Rejected')}}</option>
                                </select>
                                @endif
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Leave Type')}} *</label>
                                <select id="leave_type" name="leave_type" class="form-control selectpicker" data-live-search="true" data-live-search-style="contains" title='{{__('Leave Type')}}'>
                                    @foreach($leave_types as $leave_type)
                                        <option value="{{$leave_type->id}}" data-day="{{$leave_type->allocated_day ?? 0}}">{{$leave_type->leave_type}}
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
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{ trans('file.Employee') }} *</label>
                                <select name="employee_id" id="employee_id" class="form-control selectpicker"
                                        data-live-search="true" title="Select Employee...">
                                    <option value="{{ $loggedEmployee->id }}" selected>
                                        {{ $loggedEmployee->first_name }} {{ $loggedEmployee->last_name }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>{{__('Start Date')}} *</label>
                                <input type="text" name="start_date" id="start_date" class="form-control date" value="">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{__('End Date')}} *</label>
                                <input type="text" name="end_date" id="end_date" class="form-control test date" value="">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="d-block mb-2">{{__('Total Days')}} *</label>
                                <div class="total-days-group border rounded bg-light px-3 py-2" style="max-width: 320px;">
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
                                <input type="text" readonly id="total_days_readonly" class="form-control" style="display:none;">
                            </div>

                            <div class="col-md-6 form-group" id="leave_reason_container">
                                <label for="leave_reason">{{trans('file.Description')}}</label>
                                <textarea class="form-control" id="leave_reason" name="leave_reason" rows="3" style="width: 100%; display: block !important; visibility: visible !important;"></textarea>
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
        
        // Mirror employee dashboard: single modal reference and getters; Total Days = Days / Hours / Minutes (using one day = minutesPerDay minutes)
        let $formModal = $('#formModal');
        let startDateInput = () => $formModal.find('#start_date');
        let endDateInput = () => $formModal.find('#end_date');
        let totalDaysReadonly = () => $formModal.find('#total_days_readonly');
        var minutesPerDay = {{ $minutes_per_day ?? 480 }};
        if (minutesPerDay <= 0) minutesPerDay = 480;

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

        // getDateResult: set Days (integer only) from start/end; enable Days only when dates present; Hours/Minutes only when Days === 0.
        function getDateResult() {
            let $start = startDateInput();
            let $end = endDateInput();
            let $d = $formModal.find('#total_days_d');
            let $h = $formModal.find('#total_days_h');
            let $m = $formModal.find('#total_days_m');
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

            // No start or end date: disable all Total Days fields; Days dropdown shows only 0
            if (!startDate || !endDate || isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                $d.empty().append($('<option value="0">0</option>')).val(0).prop('disabled', true);
                $h.val(0).prop('disabled', true);
                $m.val(0).prop('disabled', true);
                totalDaysReadonly().hide();
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
            // Days dropdown: same day = [0, 1]; multi-day = only [maxDays-1, maxDays] (e.g. 5 weekdays → 4 and 5). Default = full days so H&M disabled when max selected.
            var dVal = Math.floor(totalMinutes / minutesPerDay);
            var remainder = totalMinutes % minutesPerDay;
            var hrsVal = Math.floor(remainder / 60);
            var minsVal = remainder % 60;

            var maxDays = Math.min(31, dVal);
            var isSameDay = (startDate.getTime() === endDate.getTime());
            var optionsStart, optionsEnd, selectedDays;

            if (isSameDay) {
                optionsStart = 0;
                optionsEnd = 1;
                selectedDays = 0; // Default to 0 days for same date to enable hours/minutes
            } 
            
            else if (maxDays === 0) {
                optionsStart = 0;
                optionsEnd = 0;
                selectedDays = 0;
            } 
            else {
                optionsStart = maxDays - 1;
                optionsEnd = maxDays;
                selectedDays = maxDays;
            }
            $d.empty();
            for (var i = optionsStart; i <= optionsEnd; i++) {
                $d.append($('<option></option>').attr('value', i).text(i));
            }
            $d.val(selectedDays).prop('disabled', false);
            $h.val(Math.min(23, hrsVal));
            $m.val(Math.min(59, minsVal));

            // Apply mutual exclusivity based on selected values
            if (selectedDays === maxDays && maxDays > 0) {
                // Maximum days selected → disable hours/minutes (full days only)
                $h.val(0).prop('disabled', true);
                $m.val(0).prop('disabled', true);
            } else {
                // Partial days (0 or lower option) → enable hours/minutes
                $h.prop('disabled', false);
                $m.prop('disabled', false);
                updateHoursOptionsForEndDate();
                updateMinutesOptionsForHours();
            }
            totalDaysReadonly().hide();
            updateTotalDaysSummary();
        }

        var shiftMaxHours = 0;
        var shiftLastMinutes = 0;

        // Limit Hours dropdown for the end date to the total shift hours of that day,
        // and remember the remaining minutes for minute dropdown constraints.
        function updateHoursOptionsForEndDate() {
            var $h = $formModal.find('#total_days_h');
            var $end = endDateInput();
            if (!$h.length || !$end.length) return;

            var employeeId = $('#employee_id').val();
            var endDateStr = $end.val();

            if (!employeeId || !endDateStr) {
                return;
            }

            $.ajax({
                url: "{{ route('leaves.shift_hours') }}",
                method: 'GET',
                data: {
                    employee_id: employeeId,
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
            var $h = $formModal.find('#total_days_h');
            var $m = $formModal.find('#total_days_m');
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
                // 0 hours: allow 0..59 minutes
                $m.empty();
                for (var i = 0; i <= 59; i++) {
                    $m.append($('<option></option>').attr('value', i).text(i));
                }
                $m.prop('disabled', false);
            }
        }

        // When user changes Days: only disable hours/minutes when selecting the maximum available option
        function applyTotalDaysStateFromDays() {
            var $d = $formModal.find('#total_days_d');
            var $h = $formModal.find('#total_days_h');
            var $m = $formModal.find('#total_days_m');
            if (!$d.length) return;
            var days = parseInt($d.val(), 10) || 0;
            var maxOption = 0;
            $d.find('option').each(function() { var v = parseInt($(this).val(), 10); if (v > maxOption) maxOption = v; });
            
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
            var $h = $formModal.find('#total_days_h');
            if (!$h.length) return;
            // Hours selection doesn't affect days anymore - user can select both
            // Only days selection affects hours/minutes based on max option rule
        }

        // When user changes Minutes: no longer disable days (business rule changed)  
        function applyTotalDaysStateFromMinutes() {
            var $m = $formModal.find('#total_days_m');
            if (!$m.length) return;
            // Minutes selection doesn't affect days anymore - user can select both
            // Only days selection affects hours/minutes based on max option rule
        }

        function updateTotalDaysSummary() {
            var $d = $formModal.find('#total_days_d');
            var $h = $formModal.find('#total_days_h');
            var $m = $formModal.find('#total_days_m');
            var $sum = $formModal.find('#total_days_summary');
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

        $(document).ready(function () {
            var debugPrefix = '[Leave TotalDays]';
            console.log(debugPrefix, 'document.ready: formModal exists=', $formModal.length, 'modal .date count=', $formModal.find('.date').length);

            // Initialize datepicker only on Add Leave modal date inputs (avoid affecting other .date on page)
            $formModal.find('.date').datepicker({
                format: '{{ env('Date_Format_JS')}}',
                autoclose: true,
                todayHighlight: true,
                startDate: new Date(new Date().setDate(new Date().getDate() - 6))
            });
            console.log(debugPrefix, 'datepicker initialized on', $formModal.find('.date').length, 'inputs');

            // Same as employee dashboard: delegated events so Total Days updates when dates/leave type change
            $formModal.on('change', '#start_date, #end_date', function() {
                console.log(debugPrefix, 'event: change on start_date/end_date');
                getDateResult();
            });
            $formModal.on('changeDate', '#start_date, #end_date', function() {
                console.log(debugPrefix, 'event: changeDate on start_date/end_date');
                getDateResult();
            });
            $formModal.on('change', '#leave_type', function() {
                console.log(debugPrefix, 'event: change on leave_type');
                getDateResult();
            });
            $formModal.on('change', '#total_days_d', function() {
                applyTotalDaysStateFromDays();
                updateTotalDaysSummary();
            });
            $formModal.on('change', '#total_days_h', function() {
                updateMinutesOptionsForHours();
                applyTotalDaysStateFromHours();
                updateTotalDaysSummary();
            });
            $formModal.on('change', '#total_days_m', function() {
                applyTotalDaysStateFromMinutes();
                updateTotalDaysSummary();
            });
            console.log(debugPrefix, 'delegated events bound on $formModal');

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
                            $('select:not(.total-days-select)').selectpicker('refresh');
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
                        data: 'leave_type',
                        name: 'leave_type',
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data) {
                            if (data.status === 'rejected') {
                                return "<span class='badge badge-danger'>" + data.status + "</span>";
                            } else if (data.is_tl_action == 1 && data.status !== 'approved') {
                                return "<span class='badge badge-info'>{{ __('Approved By Teamlead') }}</span>";
                            } else if (data.status === 'pending') {
                                return "<span class='badge badge-warning'>" + data.status + "</span>";
                            } else {
                                return "<span class='badge badge-success'>" + data.status + "</span>";
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
        let totalMins = parseInt(data.total_days, 10) || 0;

        // Convert minutes to detailed breakdown
        function formatDetailedDuration(minutes) {
            if (minutes <= 0) return '0 minutes';
            
            let days = Math.floor(minutes / 1440);
            let remainder = minutes % 1440;
            let hours = Math.floor(remainder / 60);
            let mins = remainder % 60;
            
            let parts = [];
            if (days > 0) {
                parts.push(days + ' ' + (days === 1 ? 'day' : 'days'));
            }
            if (hours > 0) {
                parts.push(hours + ' ' + (hours === 1 ? 'hour' : 'hours'));
            }
            if (mins > 0 || parts.length === 0) {
                parts.push(mins + ' ' + (mins === 1 ? 'minute' : 'minutes'));
            }
            
            return parts.join(' ');
        }

        let totalDaysHtml = '';
        if (totalMins === 720) {
            totalDaysHtml = '<div style="background-color: #FFF176; font-size:12px; padding: 3px; border-radius: 5px; display: inline-block; color:black;">' +
                            '{{ __("Half Day") }}' +
                            '</div>';
        } else {
            let detailedDuration = formatDetailedDuration(totalMins);
            totalDaysHtml = '<div style="background-color: #81C784; font-size:12px; padding: 3px; border-radius: 5px; display: inline-block; color:white;">' +
                            detailedDuration +
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
                        // Treat created_at column as string to avoid date parsing errors
                        'type': 'string',
                        'targets': [6] // created_at column index
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
            console.log('[Leave TotalDays] Add Leave button clicked');
            $('.modal-title').text('{{__('Add Leave')}}');
            $('#action_button').val('{{trans('file.Add')}}');
            $('#action').val('{{trans('file.Add')}}');
            $('#sample_form')[0].reset(); // Reset the form for new entry
            
            // Ensure description field is visible and enabled for new entries
            $('#leave_reason_container').show().css({
                'display': 'block !important',
                'visibility': 'visible !important'
            });
            $('#leave_reason').prop('disabled', false).show().val('').css({
                'background-color': '',
                'opacity': '1',
                'cursor': 'text',
                'display': 'block !important',
                'visibility': 'visible !important',
                'min-height': '60px'
            });
            $('label[for="leave_reason"]').show().css({
                'display': 'block !important',
                'visibility': 'visible !important'
            });
            
            // Explicitly enable all fields that might have been disabled in edit mode (Total Days enabled by getDateResult when dates present)
            $('#leave_type').prop('disabled', false);
            $('#start_date').prop('disabled', false);
            $('#end_date').prop('disabled', false);
            $formModal.find('#total_days_d, #total_days_h, #total_days_m').val(0).prop('disabled', true);
            totalDaysReadonly().hide();
            $('#leave_reason').prop('disabled', false);
            $('#is_notify').prop('disabled', false);
            $('#remarks').prop('disabled', false);
            
            const currentRoleId = {{ auth()->user()->role_users_id }};
            
            // Set Status to "pending" and disable it
            $('#status').selectpicker('val', 'pending');
            $('#status').prop('disabled', true).selectpicker('refresh');
            
            // Use setTimeout to ensure selectpicker is fully initialized
            setTimeout(function() {
                // Set the default values for company, department, and employee after reset
                $('#company_id').selectpicker('val', '{{ $loggedEmployee->company_id }}');
                $('#department_id').selectpicker('val', '{{ $loggedEmployee->department_id }}');
                $('#employee_id').selectpicker('val', '{{ $loggedEmployee->id }}');
                
                // Auto-select and disable Company, Department, and Employee for all users
                $('#company_id').prop('disabled', true).selectpicker('refresh');
                $('#department_id').prop('disabled', true).selectpicker('refresh');
                $('#employee_id').prop('disabled', true).selectpicker('refresh');
                
                // Load employee's leave type details with remaining days (like employee form)
                let employeeId = $('#employee_id').val();
                if (employeeId) {
                    $.ajax({
                        url: "{{ route('employee_leave_type_detail.index', ':employeeId') }}".replace(':employeeId', employeeId),
                        method: "GET",
                        dataType: "json",
                        data: {
                            draw: 1,
                            start: 0,
                            length: 1000 // Get all records
                        },
                        success: function(response) {
                            // Clear existing options
                            $('#leave_type').empty();
                            
                            // Handle DataTables response format
                            let leaveTypes = [];
                            if (response.data && Array.isArray(response.data) && response.data.length > 0) {
                                leaveTypes = response.data;
                            }
                            
                            // Populate with employee's leave types showing remaining as Days / Hours / Minutes
                            function decimalDaysToDhm(decimalDays, minPerDay) {
                                if (!minPerDay || minPerDay <= 0) minPerDay = 480;
                                var totalMins = Math.round(decimalDays * minPerDay);
                                var d = Math.floor(totalMins / minPerDay);
                                var remainder = totalMins % minPerDay;
                                var h = Math.floor(remainder / 60);
                                var m = remainder % 60;
                                return { d: d, h: h, m: m };
                            }
                            function formatBalanceDhm(dhm) {
                                var s = dhm.d + ' ' + (dhm.d === 1 ? '{{ __("Day") }}' : '{{ __("Days") }}');
                                if (dhm.h > 0 || dhm.m > 0) {
                                    s += ' ' + dhm.h + ' ' + (dhm.h === 1 ? '{{ __("Hour") }}' : '{{ __("Hours") }}') + ' ' + dhm.m + ' ' + (dhm.m === 1 ? '{{ __("Minute") }}' : '{{ __("Minutes") }}');
                                }
                                return s;
                            }
                            if (leaveTypes.length > 0) {
                                leaveTypes.forEach(function(leave) {
                                    let leaveTypeId = leave.DT_RowId || leave.leave_type_id || leave.id;
                                    let remainingDays = parseFloat(leave.remaining) || parseFloat(leave.remaining_allocated_day) || 0;
                                    let leaveTypeName = leave.leave_type || '';
                                    let dhm = decimalDaysToDhm(remainingDays, minutesPerDay);
                                    let optionText = leaveTypeName + ' (' + formatBalanceDhm(dhm) + ')';
                                    if (leaveTypeId && leaveTypeName) {
                                        $('#leave_type').append(
                                            $('<option></option>')
                                                .attr('value', leaveTypeId)
                                                .attr('data-day', remainingDays)
                                                .text(optionText)
                                        );
                                    }
                                });
                            } else {
                                // Fallback to default leave types if no employee details found (show balance as D/H/M)
                                @foreach($leave_types as $leave_type)
                                    (function() {
                                        var allocated = parseFloat('{{ $leave_type->allocated_day ?? 0 }}') || 0;
                                        var dhm = decimalDaysToDhm(allocated, minutesPerDay);
                                        $('#leave_type').append(
                                            $('<option></option>')
                                                .attr('value', '{{ $leave_type->id }}')
                                                .attr('data-day', allocated)
                                                .text('{{ $leave_type->leave_type }}' + ' (' + formatBalanceDhm(dhm) + ')')
                                        );
                                    })();
                                @endforeach
                            }
                            
                            // Refresh selectpicker and trigger getDateResult
                            $('#leave_type').selectpicker('refresh');
                            console.log('[Leave TotalDays] AJAX success (leave types) – calling getDateResult()');
                            getDateResult();
                        },
                        error: function() {
                            console.log('[Leave TotalDays] AJAX error (leave types) – using fallback, calling getDateResult()');
                            $('#leave_type').empty();
                            @foreach($leave_types as $leave_type)
                                (function() {
                                    var allocated = parseFloat('{{ $leave_type->allocated_day ?? 0 }}') || 0;
                                    var dhm = decimalDaysToDhm(allocated, minutesPerDay);
                                    $('#leave_type').append(
                                        $('<option></option>')
                                            .attr('value', '{{ $leave_type->id }}')
                                            .attr('data-day', allocated)
                                            .text('{{ $leave_type->leave_type }}' + ' (' + formatBalanceDhm(dhm) + ')')
                                    );
                                })();
                            @endforeach
                            $('#leave_type').selectpicker('refresh');
                            getDateResult();
                        }
                    });
                } else {
                    console.log('[Leave TotalDays] No employeeId – calling getDateResult()');
                    // If no employee selected, use default leave types
                    $('#leave_type').selectpicker('refresh');
                    getDateResult();
                }
            }, 100);
            
            console.log('[Leave TotalDays] opening modal (#formModal.modal(show))');
            $('#formModal').modal('show');
        });
        
        // Force description field visibility whenever modal is shown
        $('#formModal').on('shown.bs.modal', function () {
            console.log('[Leave TotalDays] shown.bs.modal fired – calling getDateResult()');
            // Remove any hiding classes
            $('#leave_reason_container').removeClass('d-none hidden').show();
            $('#leave_reason').removeClass('d-none hidden').show();
            $('label[for="leave_reason"]').removeClass('d-none hidden').show();
            
            // Force visibility with inline styles
            $('#leave_reason_container').css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1'
            });
            $('#leave_reason').css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1',
                'min-height': '60px'
            });
            $('label[for="leave_reason"]').css({
                'display': 'block',
                'visibility': 'visible'
            });
            
            // Ensure Status is set to pending and disabled
            $('#status').selectpicker('val', 'pending');
            $('#status').prop('disabled', true).selectpicker('refresh');
            
            // Ensure Company, Department, and Employee are disabled
            $('#company_id').prop('disabled', true).selectpicker('refresh');
            $('#department_id').prop('disabled', true).selectpicker('refresh');
            $('#employee_id').prop('disabled', true).selectpicker('refresh');
            
            // Populate Total Days when modal is shown (same as employee dashboard)
            getDateResult();
            console.log('[Leave TotalDays] getDateResult() completed after modal shown');

            console.log('Modal shown - Description field check:', {
                containerVisible: $('#leave_reason_container').is(':visible'),
                fieldVisible: $('#leave_reason').is(':visible'),
                containerDisplay: $('#leave_reason_container').css('display'),
                fieldDisplay: $('#leave_reason').css('display'),
                fieldValue: $('#leave_reason').val()
            });
        });

        $('#sample_form').on('submit', function (event) {
       event.preventDefault();

    // Remove any previously added hidden fields to prevent duplicates
    $('#temp_company_id, #temp_department_id, #temp_employee_id, #temp_status, #temp_leave_type, #temp_start_date, #temp_end_date, #temp_leave_reason').remove();

    // Capture the current status value ONCE before anything else
    let currentStatus = $('#status').val() || 'pending'; // Default to 'pending' if not set
    console.log('🟡 Status captured on submit:', currentStatus);

    // Always inject status as hidden field (selectpicker disabled fields get lost)
    // For new leave entries, always use 'pending'
    if ($('#action').val() == '{{trans('file.Add')}}') {
        currentStatus = 'pending';
    }
    $('#sample_form').append('<input type="hidden" name="status" id="temp_status" value="' + currentStatus + '">');

    // Other disabled fields
    if ($('#company_id').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="company_id" id="temp_company_id" value="' + $('#company_id').val() + '">');
    }
    if ($('#department_id').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="department_id" id="temp_department_id" value="' + $('#department_id').val() + '">');
    }
    if ($('#employee_id').prop('disabled')) {
        $('#sample_form').append('<input type="hidden" name="employee_id" id="temp_employee_id" value="' + $('#employee_id').val() + '">');
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
    if ($('#leave_reason').prop('disabled')) {
        let leaveReasonValue = $('#leave_reason').val() || '';
        let encodedValue = $('<div>').text(leaveReasonValue).html();
        $('#sample_form').append('<input type="hidden" name="leave_reason" id="temp_leave_reason" value="' + encodedValue + '">');
    }

    if ($('#action').val() == '{{trans('file.Add')}}') {

        var days = parseInt($('#total_days_d').val(), 10) || 0;
        var hours = parseInt($('#total_days_h').val(), 10) || 0;
        var minutes = parseInt($('#total_days_m').val(), 10) || 0;
        var totalMinutes = days * minutesPerDay + hours * 60 + minutes;


        console.log('=== TOTAL DAYS CALCULATION DEBUG ===');
        console.log('Days from dropdown:', days);
        console.log('Hours from dropdown:', hours);
        console.log('Minutes from dropdown:', minutes);
        console.log('minutesPerDay constant:', minutesPerDay);
        console.log('totalMinutes:', totalMinutes);


        $('#diff_date_hidden').val(totalMinutes);
        $('#total_days_hidden').val(totalMinutes);

        var allocatedDay = parseFloat($('#leave_type option:selected').data('day')) || 0;
        var allocatedMinutes = Math.round(allocatedDay * minutesPerDay);
        if (totalMinutes <= 0) {
            var html = '<div class="alert alert-danger"><p>Please select total days (Days/Hours/Minutes).</p></div>';
            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            return false;
        }
        if (totalMinutes > allocatedMinutes) {
            var requestedDays = (totalMinutes / minutesPerDay).toFixed(2);
            var html = '<div class="alert alert-danger"><p>Insufficient leave balance. Available: ' + allocatedDay.toFixed(2) + ' days, Requested: ' + requestedDays + ' days.</p></div>';
            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            return false;
        }

        var formDataAdd = new FormData(this);
        var debugDataAdd = {};
        formDataAdd.forEach(function (value, key) { debugDataAdd[key] = value; });
        console.log('Leave form submit (Add) – data being sent:', debugDataAdd);

        $.ajax({
            url: "{{ route('leaves.update') }}",
            method: "POST",
            data: formDataAdd,
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
                if (data.limit) { html = '<div class="alert alert-danger">' + data.limit + '</div>'; }
                if (data.remaining_leave) { html = '<div class="alert alert-danger">' + data.remaining_leave + '</div>'; }
                if (data.error) { html = '<div class="alert alert-danger">' + data.error + '</div>'; }
                if (data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('select:not(.total-days-select)').selectpicker('refresh');
                    $('.date').datepicker('update');
                    $('#leave-table').DataTable().ajax.reload();
                }
                location.reload();
                $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            }
        });
    }

    if ($('#action').val() == '{{trans('file.Edit')}}') {

        var totalMinutes = $('#total_days_readonly').val();
        if (totalMinutes === '' || totalMinutes === undefined) {
            var ed = parseInt($('#total_days_d').val(), 10) || 0;
            var eh = parseInt($('#total_days_h').val(), 10) || 0;
            var em = parseInt($('#total_days_m').val(), 10) || 0;
            totalMinutes = ed * minutesPerDay + eh * 60 + em;
        } else {
            totalMinutes = parseInt(totalMinutes, 10) || 0;
        }
        $('#diff_date_hidden').val(totalMinutes);

        var formDataEdit = new FormData(this);
        var debugDataEdit = {};
        formDataEdit.forEach(function (value, key) { debugDataEdit[key] = value; });
        console.log('Leave form submit (Edit) – data being sent:', debugDataEdit);
        console.log('🔵 Status in FormData:', debugDataEdit['status']);

        $.ajax({
            url: "{{ route('leaves.update') }}",
            method: "POST",
            data: formDataEdit,
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
                if (data.limit) { html = '<div class="alert alert-danger">' + data.limit + '</div>'; }
                if (data.remaining_leave) { html = '<div class="alert alert-danger">' + data.remaining_leave + '</div>'; }
                if (data.error) { html = '<div class="alert alert-danger">' + data.error + '</div>'; }
                if (data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    setTimeout(function () {
                        $('#formModal').modal('hide');
                        $('.date').datepicker('update');
                        $('select:not(.total-days-select)').selectpicker('refresh');
                        $('#leave-table').DataTable().ajax.reload();
                        $('#sample_form')[0].reset();
                    }, 2000);
                }
                location.reload();
                $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
            },
            complete: function () {
                $('#temp_company_id, #temp_department_id, #temp_employee_id, #temp_status, #temp_leave_type, #temp_start_date, #temp_end_date, #temp_leave_reason').remove();
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
                    $('#applied_date_id').html(result.data.created_at_formatted || result.data.created_at);
                    $('#total_days_id').html(result.data.shift_based_display || result.data.total_days_display || result.data.total_days);
                    $('#status_id').html(result.data.status);
                    $('#leave_reason_id').html(result.data.leave_reason);
                    $('#remarks_id').html(result.data.remarks);

                    // Check if half day (720 minutes = 0.5 day)
                    let totalMins = parseInt(result.data.total_days, 10) || 0;
                    if (totalMins === 720 || result.data.is_half == 1) {
                        $('#is_half_id').html('Yes');
                    } else {
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

            // IMMEDIATELY ensure description field is visible before any AJAX call
            $('#leave_reason_container').show().removeClass('d-none hidden').css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1'
            });
            $('#leave_reason').show().removeClass('d-none hidden').css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1'
            });
            $('label[for="leave_reason"]').show().removeClass('d-none hidden');

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
                    // Status dropdown is always editable when editing/approving leave
                    // (will be explicitly enabled again later, but set here for consistency)
                    $('#status').prop('disabled', false);

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
                    $('#remarks').val(html.data.remarks || '');
                    
                    // Ensure description field is visible FIRST
                    $('#leave_reason_container').show().css({
                        'display': 'block',
                        'visibility': 'visible'
                    });
                    $('#leave_reason').show().css({
                        'display': 'block',
                        'visibility': 'visible',
                        'opacity': '1',
                        'min-height': '60px'
                    });
                    $('label[for="leave_reason"]').show().css({
                        'display': 'block',
                        'visibility': 'visible'
                    });
                    
                    // Get leave_reason value - check multiple possible locations
                    let leaveReason = html.data.leave_reason || 
                                    html.data.leaveReason || 
                                    html.leave_reason || 
                                    '';
                    
                    console.log('=== LEAVE REASON DEBUG ===');
                    console.log('html.data:', html.data);
                    console.log('html.data.leave_reason:', html.data.leave_reason);
                    console.log('leaveReason variable:', leaveReason);
                    console.log('Type of leaveReason:', typeof leaveReason);
                    
                    // Set the value using multiple methods
                    if (leaveReason) {
                        // Method 1: jQuery val()
                        $('#leave_reason').val(leaveReason);
                        
                        // Method 2: Direct DOM property
                        var textareaElement = document.getElementById('leave_reason');
                        if (textareaElement) {
                            textareaElement.value = leaveReason;
                            // Also set innerHTML as fallback
                            textareaElement.innerHTML = leaveReason;
                        }
                        
                        // Method 3: jQuery text() for textarea
                        $('#leave_reason').text(leaveReason);
                        
                        console.log('Value set using multiple methods');
                    } else {
                        console.warn('leaveReason is empty or undefined!');
                    }
                    
                    // Verify immediately
                    console.log('Immediate check - jQuery val():', $('#leave_reason').val());
                    console.log('Immediate check - DOM value:', document.getElementById('leave_reason')?.value);
                    
                    // Verify after a short delay
                    setTimeout(function() {
                        console.log('Delayed check - jQuery val():', $('#leave_reason').val());
                        console.log('Delayed check - DOM value:', document.getElementById('leave_reason')?.value);
                        console.log('Field visible:', $('#leave_reason').is(':visible'));
                    }, 200);
                    
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

                    // total_days is stored in minutes
                    var totalMinutes = parseInt(html.data.total_days, 10) || 0;
                    console.log('=== EDIT FORM DEBUG ===');
                    console.log('Stored total_days (minutes):', totalMinutes);
                    
                    var dVal = Math.min(31, Math.floor(totalMinutes / minutesPerDay));
                    var remainder = totalMinutes % minutesPerDay;
                    var hVal = Math.floor(remainder / 60);
                    var mVal = remainder % 60;
                    
                    console.log('Calculated breakdown:');
                    console.log('- Days:', dVal);
                    console.log('- Hours:', hVal);
                    console.log('- Minutes:', mVal);
                    console.log('- Remainder after days:', remainder);
                    
                    var $daysSelect = $('#total_days_d');
                    var optStart = dVal <= 1 ? 0 : dVal - 1;
                    var optEnd = dVal;
                    
                    console.log('Dropdown options:');
                    console.log('- optStart:', optStart);
                    console.log('- optEnd:', optEnd);
                    
                    $daysSelect.empty();
                    for (var i = optStart; i <= optEnd; i++) {
                        $daysSelect.append($('<option></option>').attr('value', i).text(i));
                        console.log('- Added option:', i);
                    }
                    
                    var selectedValue = dVal > optEnd ? optEnd : dVal;
                    console.log('Setting dropdown to:', selectedValue);
                    $daysSelect.val(selectedValue).prop('disabled', true);
                    
                    $('#total_days_h').val(Math.min(23, hVal)).prop('disabled', true);
                    $('#total_days_m').val(Math.min(59, mVal)).prop('disabled', true);
                    $('#total_days_readonly').val(totalMinutes).hide();

                    // Disable all fields except remarks and status
                    $('#leave_type').prop('disabled', true).selectpicker('refresh');
                    $('#company_id').prop('disabled', true).selectpicker('refresh');
                    $('#department_id').prop('disabled', true).selectpicker('refresh');
                    $('#employee_id').prop('disabled', true).selectpicker('refresh');
                    $('#start_date').prop('disabled', true);
                    $('#end_date').prop('disabled', true);
                    $('#total_days_d, #total_days_h, #total_days_m').prop('disabled', true);
                    $('#total_days_readonly').prop('disabled', true);
                    // Keep description field visible but disabled (read-only) so user can see the content
                    $('#leave_reason_container').show().css({
                        'display': 'block !important',
                        'visibility': 'visible !important'
                    });
                    $('#leave_reason').prop('disabled', true).css({
                        'background-color': '#f5f5f5',
                        'opacity': '1',
                        'cursor': 'not-allowed',
                        'display': 'block !important',
                        'visibility': 'visible !important',
                        'min-height': '60px'
                    });
                    $('label[for="leave_reason"]').show().css({
                        'display': 'block !important',
                        'visibility': 'visible !important'
                    });
                    $('#is_notify').prop('disabled', true);

                    // Keep remarks and status enabled
                    $('#remarks').prop('disabled', false);
                    $('#status').prop('disabled', false).selectpicker('refresh');

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
                    
                    // Store leave_reason value for later use
                    let storedLeaveReason = html.data.leave_reason || '';
                    
                    // Final check to ensure description field is visible and value is set before showing modal
                    setTimeout(function() {
                        // Re-set the value in case it was cleared
                        $('#leave_reason').val(storedLeaveReason);
                        var textareaEl = document.getElementById('leave_reason');
                        if (textareaEl) {
                            textareaEl.value = storedLeaveReason;
                        }
                        
                        $('#leave_reason_container').css({
                            'display': 'block',
                            'visibility': 'visible',
                            'opacity': '1'
                        });
                        $('#leave_reason').css({
                            'display': 'block',
                            'visibility': 'visible',
                            'opacity': '1',
                            'min-height': '60px'
                        });
                        $('label[for="leave_reason"]').css({
                            'display': 'block',
                            'visibility': 'visible'
                        });
                        console.log('Before modal show - Description field check:', {
                            container: $('#leave_reason_container').is(':visible'),
                            field: $('#leave_reason').is(':visible'),
                            value: $('#leave_reason').val(),
                            storedValue: storedLeaveReason
                        });
                    }, 100);
                    
                    $('#formModal').modal('show');
                    
                    // One more check after modal is fully shown - use one() to prevent multiple bindings
                    $('#formModal').off('shown.bs.modal').on('shown.bs.modal', function() {
                        // Re-set the value after modal is fully rendered
                        $('#leave_reason').val(storedLeaveReason);
                        var textareaEl = document.getElementById('leave_reason');
                        if (textareaEl) {
                            textareaEl.value = storedLeaveReason;
                            // Force a re-render
                            textareaEl.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                        console.log('After modal shown - Setting leave_reason to:', storedLeaveReason);
                        console.log('After modal shown - Current value:', $('#leave_reason').val());
                        
                        // One more check after a delay
                        setTimeout(function() {
                            $('#leave_reason').val(storedLeaveReason);
                            console.log('Final check - leave_reason value:', $('#leave_reason').val());
                        }, 300);
                    });
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
            // Ensure description field is visible before reset
            $('#leave_reason_container').show().css({
                'display': 'block',
                'visibility': 'visible'
            });
            $('#leave_reason').show().css({
                'display': 'block',
                'visibility': 'visible'
            });
            $('label[for="leave_reason"]').show();
            
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
            
            // Set Status to pending and disable it
            $('#status').selectpicker('val', 'pending');
            $('#status').prop('disabled', true).selectpicker('refresh');
            
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
            
            // Reset total days (Days / Hours / Minutes) – disabled until start/end date entered; Days dropdown shows only 0
            var $daysSelect = $('#total_days_d');
            $daysSelect.empty().append($('<option value="0">0</option>')).val(0).prop('disabled', true);
            $('#total_days_h, #total_days_m').val(0).prop('disabled', true);
            $('#total_days_hidden').val('');
            totalDaysReadonly().hide();
            updateTotalDaysSummary();
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
                        $('select:not(.total-days-select)').selectpicker("destroy");
                        $('#department_id').html(result);
                        $('select:not(.total-days-select)').selectpicker();

                        // After departments load, also refresh employees list for the first department (admin use-case)
                        const firstDeptId = $('#department_id').val();
                        if (firstDeptId) {
                            $.ajax({
                                url: "{{ route('dynamic_employee_department') }}",
                                method: "POST",
                                data: {value: firstDeptId, _token: _token, first_name: 'first_name', last_name: 'last_name'},
                                success: function (empResult) {
                                    $('select:not(.total-days-select)').selectpicker("destroy");
                                    $('#employee_id').html(empResult);
                                    $('select:not(.total-days-select)').selectpicker();
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
                        $('select:not(.total-days-select)').selectpicker("destroy");
                        $('#employee_id').html(result);
                        $('select:not(.total-days-select)').selectpicker();
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
                        $('select:not(.total-days-select)').selectpicker("destroy");
                        $('#employee_id').html(result);
                        $('select:not(.total-days-select)').selectpicker();

                    }
                });
            }
        });
    })(jQuery);
</script>
@endpush
