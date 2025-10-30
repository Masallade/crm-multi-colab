@if($employees->isEmpty())
    <div class="col-12 text-center">
        <p>No employees found.</p>
    </div>
@endif
@foreach($employees as $employee)
    <div class="col-md-4 mb-4">
        <div class="monitoring-container">
            <div class="monitoring-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                    <span class="status-badge {{ $employee->is_active ? 'active' : 'inactive' }}">
                        {{ $employee->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="monitoring-body">
                <div class="info-row">
                    <span class="label">Staff ID:</span>
                    <span class="value">{{ $employee->staff_id }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Last Clock Up:</span>
                    <span class="value">
                        @if($employee->clock_up)
                            {{ \Carbon\Carbon::parse($employee->clock_up)->format('Y-m-d H:i:s') }}
                        @else
                            Never
                        @endif
                    </span>
                </div>
                <div class="stream-button-container">
                    <button class="stream-button">
                        Stream
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach 