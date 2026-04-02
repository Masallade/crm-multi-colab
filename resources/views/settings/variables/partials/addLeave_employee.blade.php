<?php //dd($leaveTypes); ?>

<div class="container-fluid">    
    <div class="card mb-3">
        <div class="card-body">
        <h3 class="card-title">Filter by Leave Type:</h3>
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <select id="leaveTypeFilter" class="form-control selectpicker" data-live-search="true">
                        <!-- <option value="">All Leaves</option> -->
                        @foreach ($leaveTypes as $leaveType)
                        <option value="{{ $leaveType->id }}" {{ $leaveType->id == 2 ? 'selected' : '' }}>
                            {{ $leaveType->leave_type }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button id="updateLeaveButton" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>

    <!-- Leave Calculator -->
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">
                <i class="fa fa-calculator"></i> {{ __('Leave Calculator') }}
                <small class="text-muted">({{ __('Convert Work Days to Calendar Days') }})</small>
            </h3>
            <p class="text-muted small">{{ __('Use this calculator to convert work days (based on employee shift) to calendar days for data entry.') }}</p>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Employee Shift Time') }}</label>
                        <div class="d-flex gap-2">
                            <div class="flex-fill">
                                <select id="calc_shift_hours" class="form-control">
                                    @for($h = 0; $h <= 12; $h++)
                                        <option value="{{ $h }}" {{ $h == 8 ? 'selected' : '' }}>{{ $h }}</option>
                                    @endfor
                                </select>
                                <small class="text-muted">{{ __('Hours') }}</small>
                            </div>
                            <div class="flex-fill">
                                <select id="calc_shift_minutes" class="form-control">
                                    @for($m = 0; $m <= 59; $m += 15)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endfor
                                </select>
                                <small class="text-muted">{{ __('Minutes') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ __('Number of Work Days') }}</label>
                        <input type="number" id="calc_work_days" class="form-control" min="0" max="365" step="0.5" value="12" placeholder="e.g., 12">
                        <small class="text-muted">{{ __('Work days to allocate') }}</small>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button id="calculateLeaveBtn" class="btn btn-success btn-block">
                            <i class="fa fa-calculator"></i> {{ __('Calculate') }}
                        </button>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ __('Result (Enter in Table)') }}</label>
                        <div id="calc_result" class="alert alert-info mb-0" style="padding: 0.5rem;">
                            <strong id="calc_result_text">{{ __('Click Calculate') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="calc_explanation" class="alert alert-light" style="display: none; font-size: 0.875rem;">
                        <strong>{{ __('Calculation:') }}</strong>
                        <div id="calc_explanation_text"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="leave_result"></span>



<div class="table-responsive">
    <table id="addLeave_employee-table" class="mt-0 table">
        <thead>
        <tr>
            <th>{{ __('Employee name') }}</th>
            <th>{{ __('Leave Type') }}</th>
            <th>{{ __('Days Per Year') }} <small class="text-muted">({{ __('Days') }} / {{ __('Hours') }} / {{ __('Minutes') }})</small></th>
            <th>{{ __('Remaining') }} <small class="text-muted">({{ __('Days') }} / {{ __('Hours') }} / {{ __('Minutes') }})</small></th>
        </tr>
        </thead>

    </table>
</div>


<div id="LeaveEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="LeaveModalLabel" class="modal-title">{{trans('file.Edit')}}</h5>

                <button type="button" data-dismiss="modal" id="leave_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="leave_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="addLeave_employee_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                    @csrf
                    <div class="col-md-4 form-group">
                        <label>{{__('Leave Type')}} *</label>
                        <input type="text" name="addLeave_employee_edit" id="addLeave_employee_edit"  class="form-control"
                               placeholder="{{__('Leave Type')}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>{{__('Days Per Year')}} *</label>
                        <select name="allocated_day_edit" id="allocated_day_edit" class="form-control">
                            @for($i = 0.5; $i <= 30.0; $i += 0.5)
                                <option value="{{ number_format($i, 1, '.', '') }}">{{ number_format($i, 1, '.', '') }}</option>
                            @endfor
                            <option value="30.05">30.05</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_leave_id" id="hidden_leave_id" />
                        <input type="submit" name="addLeave_employee_edit_submit" id="addLeave_employee_edit_submit" class="btn btn-success" value={{trans("file.Edit")}} />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>