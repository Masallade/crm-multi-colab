@extends('layouts.master')
@section('title') @lang('appraisal.appraisal.sections.edit') @endsection
@section('content')

@component('components.breadcrumb')
@slot('li_1') @lang('appraisal.dashboard.title') @endslot
@slot('title') @lang('appraisal.appraisal.sections.edit') @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('appraisal.update-edit-section') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $section->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">@lang('appraisal.appraisal.sections.name')</label>
                                <input name="name" type="text" class="form-control" value="{{ $section->name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">@lang('appraisal.appraisal.sections.weightage')</label>
                                <input name="weightage" type="number" class="form-control" min="1" max="100" value="{{ $section->weightage }}">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="form-label">@lang('appraisal.appraisal.sections.department_evaluator_mapping')</h5>
                            <p class="text-muted">Assign specific evaluators to departments for this section</p>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered" id="department-evaluator-table">
                                    <thead>
                                        <tr>
                                            <th width="40%">Department</th>
                                            <th width="40%">Evaluator</th>
                                            <th width="20%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $mappings = json_decode($section->department_evaluator_mapping, true) ?? [];
                                        @endphp
                                        
                                        @if(count($mappings) > 0)
                                            @foreach($mappings as $departmentId => $evaluatorId)
                                                <tr>
                                                    <td>
                                                        <select name="departments[]" class="form-select department-select">
                                                            <option value="">Select Department</option>
                                                            @foreach($departments as $department)
                                                                <option value="{{ $department->id }}" {{ $departmentId == $department->id ? 'selected' : '' }}>
                                                                    {{ $department->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="evaluators[]" class="form-select evaluator-select">
                                                            <option value="">Select Evaluator</option>
                                                            @foreach($employees as $employee)
                                                                <option value="{{ $employee->id }}" {{ $evaluatorId == $employee->id ? 'selected' : '' }}>
                                                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                                            <i class="bx bx-trash"></i> Remove
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <select name="departments[]" class="form-select department-select">
                                                        <option value="">Select Department</option>
                                                        @foreach($departments as $department)
                                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="evaluators[]" class="form-select evaluator-select">
                                                        <option value="">Select Evaluator</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-row">
                                                        <i class="bx bx-trash"></i> Remove
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
                                                <button type="button" class="btn btn-success btn-sm" id="add-department-evaluator-row">
                                                    <i class="bx bx-plus"></i> Add Department-Evaluator Pair
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">@lang('appraisal.appraisal.sections.performance_indicators')</h5>
                                    <div class="row" id="indicators-area">
                                        @if($indicators)
                                            @foreach($indicators as $index => $indicator)
                                                <div class="col-md-12 mb-3 indicator-row">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <input type="hidden" name="performance_indicator[{{ $index }}][id]" value="{{ $indicator->id }}">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="performance_indicator[{{ $index }}][name]"
                                                                    value="{{ $indicator->name }}" placeholder="Performance Indicator">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="d-flex">
                                                                <div class="input-group">
                                                                    <div class="input-group-text">
                                                                        <span>Weight %</span>
                                                                    </div>
                                                                    <input type="number" min="1" max="100" class="form-control" name="performance_indicator[{{ $index }}][weightage]"
                                                                        value="{{ $indicator->weightage }}" placeholder="Weight %">
                                                                </div>
                                                                <button type="button" class="btn btn-danger ms-2 remove-indicator">
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <button type="button" class="btn btn-success" id="add-indicator">
                                                <i class="bx bx-plus"></i> @lang('appraisal.appraisal.sections.add_indicator')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button class="btn btn-primary" type="submit">@lang('appraisal.settings.update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        let indicatorIndex = {{ count($indicators ?? []) }};
        
        // Add new performance indicator
        $('#add-indicator').on('click', function() {
            const html = `
                <div class="col-md-12 mb-3 indicator-row">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="hidden" name="performance_indicator[${indicatorIndex}][id]" value="0">
                            <div class="input-group">
                                <input type="text" class="form-control" name="performance_indicator[${indicatorIndex}][name]"
                                    placeholder="Performance Indicator">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex">
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span>Weight %</span>
                                    </div>
                                    <input type="number" min="1" max="100" class="form-control" name="performance_indicator[${indicatorIndex}][weightage]"
                                        placeholder="Weight %">
                                </div>
                                <button type="button" class="btn btn-danger ms-2 remove-indicator">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#indicators-area').append(html);
            indicatorIndex++;
        });
        
        // Remove performance indicator
        $(document).on('click', '.remove-indicator', function() {
            $(this).closest('.indicator-row').remove();
        });
        
        // Add department-evaluator row
        $('#add-department-evaluator-row').on('click', function() {
            const newRow = `
                <tr>
                    <td>
                        <select name="departments[]" class="form-select department-select">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="evaluators[]" class="form-select evaluator-select">
                            <option value="">Select Evaluator</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                            <i class="bx bx-trash"></i> Remove
                        </button>
                    </td>
                </tr>
            `;
            
            $('#department-evaluator-table tbody').append(newRow);
        });
        
        // Remove department-evaluator row
        $(document).on('click', '.remove-row', function() {
            if ($('#department-evaluator-table tbody tr').length > 1) {
                $(this).closest('tr').remove();
            } else {
                alert('You must have at least one department-evaluator pair');
            }
        });
        
        // Form validation before submit
        $('form').on('submit', function(e) {
            let valid = true;
            
            // Check if at least one indicator is present
            if ($('.indicator-row').length === 0) {
                alert('Please add at least one performance indicator');
                valid = false;
            }
            
            // Check if all department-evaluator pairs are valid
            $('#department-evaluator-table tbody tr').each(function() {
                const department = $(this).find('.department-select').val();
                const evaluator = $(this).find('.evaluator-select').val();
                
                if (!department || !evaluator) {
                    alert('Please select both department and evaluator for all rows');
                    valid = false;
                    return false;
                }
            });
            
            if (!valid) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection 