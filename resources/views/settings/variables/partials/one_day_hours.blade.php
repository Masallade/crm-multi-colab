<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">
            <h3 class="card-title">{{ __('One Day Equals (Hours & Minutes)') }}</h3>
            <p class="text-muted small">{{ __('Define how many hours and minutes count as one working day (e.g. for leave or timesheet).') }}</p>
            <form method="post" id="one_day_hours_form" class="form-horizontal" action="{{ route('variables.update_one_day_hours') }}">
                @csrf
                @php
                    $one_day_hours = (int) (optional($general_settings_data)->one_day_hours ?? 8);
                    $one_day_minutes = (int) (optional($general_settings_data)->one_day_minutes ?? 0);
                @endphp
                <div class="row align-items-end">
                    <div class="col-md-3 form-group">
                        <label>{{ __('Hours') }} *</label>
                        <select name="one_day_hours" id="one_day_hours" class="form-control selectpicker" data-live-search="false" title="{{ __('Hours') }}">
                            @for($h = 0; $h <= 24; $h++)
                                <option value="{{ $h }}" {{ $one_day_hours === $h ? 'selected' : '' }}>{{ $h }} {{ $h == 1 ? __('hour') : __('hours') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>{{ __('Minutes') }} *</label>
                        <select name="one_day_minutes" id="one_day_minutes" class="form-control selectpicker" data-live-search="false" title="{{ __('Minutes') }}">
                            @for($m = 0; $m <= 59; $m++)
                                <option value="{{ $m }}" {{ $one_day_minutes === $m ? 'selected' : '' }}>{{ $m }} {{ $m == 1 ? __('minute') : __('minutes') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="submit" name="one_day_hours_submit" id="one_day_hours_submit" class="btn btn-success" value="{{ trans('file.Save') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<span id="one_day_hours_result"></span>
