<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/ammar.css') }}">


<div class="modal fade" id="setIncrementModal" tabindex="-1" role="dialog" aria-labelledby="setIncrementLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="modal-title ml-3" id="createModalLabel">Set Increment</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="incrementForm" method="POST" action="{{route('appraisal.set-increment')}}">
                    @csrf
                    <div class="table-responsive">
                        <table id="appraisalTable" class="table">
                            <thead>
                                <tr>
                                    <th>{{trans('file.Company')}}</th>
                                    <th>{{trans('file.Employee')}}</th>
                                    <th>{{trans('file.Department')}}</th>
                                    <th>Result</th>
                                    <th>Increment Expected</th>
                                    <th>Set Increment</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($recordToBeIncremented as $key => $result)
                                    <tr>
                                        <td>{{ $result["company_name"]  }}</td>
                                        <td>{{ $result["full_name"]  }}</td>
                                        <td>{{ $result["department_name"] }}</td>
                                        <td>{{ $result["result"] }}%</td>
                                        <td>{{ $result["Increment_expected"] }}</td>
                                        <td>
                                        @php
                                        // Use trim and case-insensitive comparison for more reliable matching
                                        $disabled = trim(strtolower($result["Increment_expected"])) === 'no increment';
                                        $min = null;
                                        $max = null;
                                        $value = null;
                                        $readonly = false;
                                        
                                        if (strpos($result["Increment_expected"], '-') !== false) {
                                            list($min, $max) = explode('-', $result["Increment_expected"]);
                                            $min = trim($min);
                                            $max = trim($max);
                                        } elseif (trim(strtolower($result["Increment_expected"])) !== 'no increment') {
                                            $value = trim($result["Increment_expected"]);
                                            $readonly = true; // Make it readonly for single values
                                        }
                                    @endphp

                                    <input
                                        type="number"
                                        name="increment[{{ $key }}]"
                                        class="form-control increment-input"
                                        @if($min && $max) min="{{ $min }}" max="{{ $max }}" @endif
                                        @if($value) value="{{ $value }}" readonly @endif
                                        @if($disabled) disabled @endif
                                        data-expected="{{ $result['Increment_expected'] }}"
                                        step="0.01"
                                    >
                                            <input type="hidden" name="id[{{ $key }}]" value="{{ $result['id'] ?? '' }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Form validation
    $('#incrementForm').on('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        
        // Validate each increment input
        $('.increment-input').each(function() {
            if (!$(this).prop('disabled')) {
                const value = parseFloat($(this).val());
                const expected = $(this).data('expected');
                
                // Reset validation state
                $(this).removeClass('is-invalid is-valid');
                
                if (expected.includes('-')) {
                    // Range validation
                    const [min, max] = expected.split('-').map(num => parseFloat(num.trim()));
                    if (value < min || value > max) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).addClass('is-valid');
                    }
                } else if (expected !== 'No Increment') {
                    // Single value validation
                    const expectedValue = parseFloat(expected);
                    if (value !== expectedValue) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).addClass('is-valid');
                    }
                }
            }
        });
        
        // Submit if valid
        if (isValid) {
            this.submit();
        } else {
            // Show error message
            alert('Please correct the highlighted increment values');
        }
    });
    
    // Real-time validation on input
    $('.increment-input').on('input', function() {
        const value = parseFloat($(this).val());
        const expected = $(this).data('expected');
        
        $(this).removeClass('is-invalid is-valid');
        
        if (expected.includes('-')) {
            const [min, max] = expected.split('-').map(num => parseFloat(num.trim()));
            if (value < min || value > max) {
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        } else if (expected !== 'No Increment') {
            const expectedValue = parseFloat(expected);
            if (value !== expectedValue) {
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        }
    });
});
</script>