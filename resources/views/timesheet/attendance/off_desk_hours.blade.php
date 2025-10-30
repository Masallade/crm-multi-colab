@extends('layout.main')
@section('content')
<div class="container mt-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Off-Desk Hours Records</h4>          
                        <div class="form-group mb-0">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by employee name...">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-bordered table-striped table-hover">
                            <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                                <tr>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Reason</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="recordsTableBody">
                                @forelse($offDeskRecords as $record)
                                <tr class="record-row">
                                    <td class="employee-name">{{ $record->employee->first_name }} {{ $record->employee->last_name }}</td>
                                    <td>{{ date('Y-m-d', strtotime($record->attendance_date)) }}</td>
                                    <td>{{ $record->clock_in }}</td>
                                    <td>{{ $record->clock_out ?? 'N/A' }}</td>
                                    <td>{{ $record->message }}</td>
                                    <td>
                                        <form action="{{ route('off_desk_hours.destroy', $record->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No off-desk hours records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
    <div class="card">
        <div class="card-header">
                    <h4>Add Off-Desk Hours</h4>
        </div>
        <div class="card-body">
                    <form method="POST" action="{{ route('off_desk_hours.store') }}" id="offDeskForm">
                @csrf
                <div class="form-group">
                    <label for="employee_id">Employee</label>
                    <select name="employee_id" id="employee_id" class="form-control" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" class="form-control" max="{{ date('Y-m-d') }}" min="{{ date('Y-m-d', strtotime('-7 days')) }}" value="{{ date('Y-m-d') }}" required>
                    <small class="form-text text-muted">You can select dates from the last week to today.</small>
                </div>
                <div class="form-group">
                    <label for="time_in">Time Out (The time the employee leave his/her machine and goes for office work e.g. meeting, etc.)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <input type="text" name="time_in" id="time_in" class="form-control clockpicker" placeholder="Select time" required autocomplete="off">
                        <div class="invalid-feedback" id="time_in_error"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="time_out">Time In (The time the employee return to his/her machine)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <input type="text" name="time_out" id="time_out" class="form-control clockpicker" placeholder="Select time" required autocomplete="off">
                        <div class="invalid-feedback" id="time_out_error"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div id="time_diff" class="alert alert-info mt-2" style="margin-bottom: 10px; padding: 10px;"></div>
                </div>
                
                <!-- Shift Information Display -->
                <div id="shift_info" class="form-group" style="display: none;">
                    <div class="alert alert-warning">
                        <h6><i class="fa fa-info-circle"></i> Shift Information</h6>
                        <div id="shift_details"></div>
                        <small class="text-muted">Time Out must be after shift start time, and Time In must be before shift end time.</small>
                    </div>
                </div>
                        <div class="form-group">
                            <label for="message">Reason for Off-Desk Hours</label>
                            <textarea name="message" id="message" class="form-control" rows="3" placeholder="Please provide the reason for off-desk hours" required></textarea>
                            <div class="invalid-feedback" id="message_error"></div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">
<!-- Font Awesome for clock icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    .table-responsive {
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }
    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,.075);
    }
    .record-row {
        transition: background-color 0.2s;
    }
    #searchInput {
        min-width: 250px;
        margin-left: 15px;
    }
    .card-header {
        background-color: #f8f9fa;
    }
    
    /* Ensure date input is properly styled and clickable */
    #date {
        cursor: pointer !important;
        pointer-events: auto !important;
    }
    
    #date::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize clockpicker
        $('.clockpicker').clockpicker({
            autoclose: true,
            twelvehour: true,
            afterDone: function() {
                setTimeout(function() {
                    calculateAndShowDifference();
                }, 100);
            }
        });

        // Fetch shift information when employee is selected
        $('#employee_id').on('change', function() {
            const employeeId = $(this).val();
            const selectedDate = $('#date').val();
            
            if (employeeId && selectedDate) {
                fetchShiftInfo(employeeId, selectedDate);
            }
        });
        
        // Fetch shift information when date is changed
        $('#date').on('change', function() {
            const employeeId = $('#employee_id').val();
            const selectedDate = $(this).val();
            
            if (employeeId && selectedDate) {
                fetchShiftInfo(employeeId, selectedDate);
            }
        });
        
        function fetchShiftInfo(employeeId, date) {
            $.ajax({
                url: '{{ route("get_employee_shift") }}',
                method: 'GET',
                data: {
                    employee_id: employeeId,
                    date: date
                },
                success: function(response) {
                    if (response.success && response.shift) {
                        const dayOfWeek = response.day_of_week;
                        const shiftIn = response.shift[dayOfWeek + '_in'];
                        const shiftOut = response.shift[dayOfWeek + '_out'];
                        
                        if (shiftIn && shiftOut) {
                            $('#shift_details').html(`
                                <strong>Shift Times for ${response.day_name}:</strong><br>
                                Start: ${shiftIn}<br>
                                End: ${shiftOut}
                            `);
                            $('#shift_info').show();
                        } else {
                            $('#shift_info').hide();
                        }
                    } else {
                        $('#shift_info').hide();
                    }
                },
                error: function() {
                    $('#shift_info').hide();
                }
            });
        }

        // Form validation and submission
        $('#offDeskForm').on('submit', function(e) {
            e.preventDefault();
            
            const timeIn = $('#time_in').val();
            const timeOut = $('#time_out').val();

            if (!timeIn || !timeOut) {
                toastr.error('Please select both Time In and Time Out.');
                return false;
            }

            // Format times to ensure space between time and AM/PM
            const formatTime = (time) => {
                if (!time) return '';
                // Remove any existing spaces and add a space before AM/PM
                return time.replace(/\s*/g, '').replace(/(AM|PM)/i, ' $1');
            };

            // Update the form input values with properly formatted times
            $('#time_in').val(formatTime(timeIn));
            $('#time_out').val(formatTime(timeOut));

            // Validate times before submitting
            calculateAndShowDifference();
            if ($('#time_diff').hasClass('alert-danger')) {
                toastr.error('Time Out must be after Time In.');
                return false;
            }

            // Submit the form
            this.submit();
        });

        // Function to calculate and show time difference
        function calculateAndShowDifference() {
            const timeIn = $('#time_in').val();
            const timeOut = $('#time_out').val();
            const $timeDiff = $('#time_diff');

            if (!timeIn || !timeOut) {
                $timeDiff.removeClass('alert-success alert-danger').addClass('alert-info')
                    .html('Please select both Time In and Time Out to see the duration.');
                return;
            }

            // Parse times
            const timeInParts = timeIn.match(/(\d+):(\d+)\s*(AM|PM)/i);
            const timeOutParts = timeOut.match(/(\d+):(\d+)\s*(AM|PM)/i);

            if (!timeInParts || !timeOutParts) {
                $timeDiff.removeClass('alert-success alert-danger').addClass('alert-info')
                    .html('Invalid time format');
                return;
            }

            // Convert to 24 hour format
            let timeInHour = parseInt(timeInParts[1]);
            let timeOutHour = parseInt(timeOutParts[1]);
            const timeInMin = parseInt(timeInParts[2]);
            const timeOutMin = parseInt(timeOutParts[2]);
            const timeInPeriod = timeInParts[3].toUpperCase();
            const timeOutPeriod = timeOutParts[3].toUpperCase();

            // Adjust hours for PM
            if (timeInPeriod === 'PM' && timeInHour !== 12) timeInHour += 12;
            if (timeOutPeriod === 'PM' && timeOutHour !== 12) timeOutHour += 12;
            // Adjust hours for AM 12
            if (timeInPeriod === 'AM' && timeInHour === 12) timeInHour = 0;
            if (timeOutPeriod === 'AM' && timeOutHour === 12) timeOutHour = 0;

            // Calculate total minutes
            const timeInTotal = timeInHour * 60 + timeInMin;
            const timeOutTotal = timeOutHour * 60 + timeOutMin;
            const diffMinutes = timeOutTotal - timeInTotal;

            if (diffMinutes <= 0) {
                $timeDiff.removeClass('alert-info alert-success').addClass('alert-danger')
                    .html('<strong>Invalid:</strong> Time Out must be after Time In');
                return;
            }

            const hours = Math.floor(diffMinutes / 60);
            const minutes = diffMinutes % 60;

            let durationText = '<strong>Duration:</strong> ';
            if (hours > 0) {
                durationText += hours + ' hour' + (hours !== 1 ? 's' : '');
                if (minutes > 0) durationText += ' and ';
            }
            if (minutes > 0 || hours === 0) {
                durationText += minutes + ' minute' + (minutes !== 1 ? 's' : '');
            }

            $timeDiff.removeClass('alert-info alert-danger').addClass('alert-success')
                .html(durationText);
        }

        // Trigger calculation on time input changes
        $('#time_in, #time_out').on('change', calculateAndShowDifference);

        // Initial calculation
        calculateAndShowDifference();

        // Search functionality
        $('#searchInput').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            
            $('.record-row').each(function() {
                const employeeName = $(this).find('.employee-name').text().toLowerCase();
                if (employeeName.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Show "no records" message if no matches
            if ($('.record-row:visible').length === 0) {
                if ($('#noRecordsRow').length === 0) {
                    $('#recordsTableBody').append(
                        '<tr id="noRecordsRow"><td colspan="6" class="text-center">No matching records found.</td></tr>'
                    );
                }
            } else {
                $('#noRecordsRow').remove();
            }
        });

        // Clear search when input is cleared
        $('#searchInput').on('search', function() {
            if ($(this).val() === '') {
                $('.record-row').show();
                $('#noRecordsRow').remove();
            }
        });
    });

    // Remove flatpickr and use native HTML5 date input
    // The min and max attributes in HTML should handle the date constraints
    console.log('Date input initialized with native HTML5 date picker');
    
    // Debug date input
    $('#date').on('focus', function() {
        console.log('Date input focused');
    });
    
    $('#date').on('change', function() {
        console.log('Date changed to:', $(this).val());
    });
    
    // Check if date input is working
    console.log('Date input element:', $('#date')[0]);
    console.log('Date input min:', $('#date').attr('min'));
    console.log('Date input max:', $('#date').attr('max'));

    // Configure toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Show success message
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Show error message
    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    // Show validation errors
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
@endpush