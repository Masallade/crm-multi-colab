@extends('layout.main')
@section('content')

<section>
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <h3>{{ __('Productivity Hourse Attendances') }}<span id="details_month_year"></span></h3>
                </div>

                <form method="post" id="filter_form" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 offset-md-3 mb-2">
                            <label for="day_month_year">{{ __('Select Date') }}</label>
                            <div class="input-group">
                                <input class="form-control month_year date" placeholder="{{ __('Select Date') }}" readonly
                                    id="day_month_year" name="day_month_year" type="text"
                                    value="{{ now()->format(env('DATE_FORMAT')) }}">
                                <button type="submit" class="filtering btn btn-primary">
                                    <i class="fa fa-search"></i> {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="daily_attendance-table" class="table">
            <thead>
                <tr>
                    <th>{{ __('Employee') }}</th>
                    <th>{{ __('Company') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Clock In') }}</th>
                    <th>{{ __('Clock Out') }}</th>
                    <th>{{ __('Late') }}</th>
                    <th>{{ __('Early Leaving') }}</th>
                    <th>{{ __('Overtime') }}</th>
                    <th>{{ __('Total Work') }}</th>
                    <th>{{ __('Total Rest') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).ready(function() {
            const dateInput = $('.date');

            // Initialize datepicker
            dateInput.datepicker({
                format: '{{ env('DATE_FORMAT_JS') }}',
                autoclose: true,
                todayHighlight: true,
                endDate: new Date(),
            });

            // Initialize DataTable
            const table = $('#daily_attendance-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('attendances.productivity_attendence') }}",
                    data: function(d) {
                        d.filter_month_year = $('#day_month_year').val();
                        d._token = "{{ csrf_token() }}";
                    },
                },
                columns: [
                    { data: 'employee_name', name: 'employee_name' },
                    { data: 'company', name: 'company' },
                    { data: 'attendance_date', name: 'attendance_date' },
                    { data: 'attendance_status', name: 'attendance_status' },
                    { data: 'clock_in', name: 'clock_in' },
                    { data: 'clock_out', name: 'clock_out' },
                    { data: 'time_late', name: 'time_late' },
                    { data: 'early_leaving', name: 'early_leaving' },
                    { data: 'overtime', name: 'overtime' },
                    { data: 'total_work', name: 'total_work' },
                    { data: 'total_rest', name: 'total_rest' },
                ],
                order: [],
                language: {
                    lengthMenu: '_MENU_ {{ __("records per page") }}',
                    info: '{{ __("Showing") }} _START_ - _END_ (_TOTAL_)',
                    search: '{{ __("Search") }}',
                    paginate: {
                        previous: '{{ __("Previous") }}',
                        next: '{{ __("Next") }}',
                    },
                },
                dom: '<"row"lfB>rtip',
                buttons: [
                    {
                        extend: 'pdf',
                        text: '<i title="Export to PDF" class="fa fa-file-pdf-o"></i>',
                        exportOptions: { columns: ':visible:not(.not-exported)' },
                    },
                    {
                        extend: 'csv',
                        text: '<i title="Export to CSV" class="fa fa-file-text-o"></i>',
                        exportOptions: { columns: ':visible:not(.not-exported)' },
                    },
                ],
            });

            // Filter on form submit
            $('#filter_form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });
        });
    })(jQuery);
</script>
@endpush
