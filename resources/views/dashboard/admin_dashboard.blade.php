@extends('layout.main')
@section('content')

<!-- main admin -->
@if (Auth::user()->id===1)
       

    <section>
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb-30px">
                <div><h1 class="thin-text">{{trans('file.Welcome')}} {{auth()->user()->username}}</h1></div>
                <div><h4 class="thin-text">{{__('Today is')}} {{now()->englishDayOfWeek}} {{now()->format(env('Date_Format'))}}</h4></div>
            </div>
            <div class="row">

                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('employees.index')}}">
                            <div class="name"><strong class="purple-text">{{ trans('file.Employees') }}</strong>
                            </div>
                            <div class="count-number employee-count">{{$employees->count()}}</div>
                        </a>
                    </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('attendances.index')}}">
                            <div class="name"><strong class="orange-text">{{trans('file.Attendance')}}</strong></div>
                            <div class="count-number attendance-count">P:{{$attendance_count}}
                                A:{{$employees->count() - $attendance_count}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('leaves.index')}}">
                            <div class="name"><strong class="green-text">{{__('Total Leave')}}</strong></div>
                            <div class="count-number leave-count">{{$leave_count}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('expense.index')}}">
                            <div class="name"><strong class="blue-text">{{__('Total Expense')}}</strong></div>
                            <div class="count-number total_expense"> {{$total_expense}}</div>
                            {{-- <div class="count-number total_expense"> {{number_format((float)$total_expense, 2, '.', '') }}</div> --}}
                        </a>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('deposit.index')}}">
                            <div class="name"><strong class="green-text">{{__('Total Deposit')}}</strong></div>
                            <div class="count-number total_deposit">{{$total_deposit}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('payment_history.index')}}">
                            <div class="name"><strong class="blue-text">{{__('Total Salaries Paid')}}</strong>
                            </div>
                            <div class="count-number total_salaries_paid">{{$total_salaries_paid}}</div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{trans('file.Payment')}} --- {{__('Last 6 Months ')}}</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="payment_last_six" data-last_six_month_payment = "{{json_encode($per_month_payment) ?? ''}}" data-months="{{json_encode($per_month) ?? ''}}"  data-label1="{{trans('file.Payment')}}" ></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Employee Department')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="department_chart" data-dept_bgcolor='@json($dept_bgcolor_array)'
                                    data-hover_dept_bgcolor='@json($dept_hover_bgcolor_array)'
                                    data-dept_emp_count='@json($dept_count_array)'
                                    data-dept_label='@json($dept_name_array)' width="100" height="95"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Employee Designation')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="designation_chart" data-desig_bgcolor='@json($desig_bgcolor_array)'
                                    data-hover_desig_bgcolor='@json($desig_hover_bgcolor_array)'
                                    data-desig_emp_count='@json($desig_count_array)'
                                    data-desig_label='@json($desig_name_array)' width="100" height="95"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Expense Vs Deposit')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="expense_deposit_chart" data-expense_count='{{$total_expense_raw}}'
                                    data-expense_level="{{trans('Expense')}}"
                                    data-deposit_count='{{$total_deposit_raw}}'
                                    data-deposit_level="{{trans('Deposit')}}" width="100" height="95"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Project Status')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="project_chart" data-project_status='@json($project_count_array)'
                                    data-project_label='@json($project_name_array)' width="100" height="95"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon blue-text ml-2 mr-3"><i class="dripicons-volume-medium"></i></div>
                        <a href="{{route('announcements.index')}}">
                            <h3 class="mt-3">{{ count($announcements) }} {{trans('file.Announcement')}}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon green-text ml-2 mr-3"><i class="dripicons-ticket"></i></div>
                        <a href="{{route('tickets.index')}}">
                            <h3 class="mt-3">{{$ticket_count}} {{__('Open Ticket')}}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon orange-text ml-2 mr-3"><i class="dripicons-briefcase"></i></div>
                        <a href="{{route('projects.index')}}">
                            <h3 class="mt-3">{{$completed_projects}} {{__('Completed Projects')}}</h3>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                @include('calendarable.calendar')
            </div>
        </div>

    </section>
    @else
<!-- other admin -->
         

    <section>
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb-30px">
                <div><h1 class="thin-text">{{trans('file.Welcome')}} {{auth()->user()->username}}</h1></div>
                <div><h4 class="thin-text">{{__('Today is')}} {{now()->englishDayOfWeek}} {{now()->format(env('Date_Format'))}}</h4></div>
            </div>
            <div class="row">

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
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('employees.index')}}">
                            <div class="name"><strong class="purple-text">{{ trans('file.Employees') }}</strong>
                            </div>
                            <div class="count-number employee-count">{{$employees->count()}}</div>
                        </a>
                    </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('attendances.index')}}">
                            <div class="name"><strong class="orange-text">{{trans('file.Attendance')}}</strong></div>
                            <div class="count-number attendance-count">P:{{$attendance_count}}
                                A:{{$employees->count() - $attendance_count}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('leaves.index')}}">
                            <div class="name"><strong class="green-text">{{__('Total Leave')}}</strong></div>
                            <div class="count-number leave-count">{{$leave_count}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('expense.index')}}">
                            <div class="name"><strong class="blue-text">{{__('Total Expense')}}</strong></div>
                            <div class="count-number total_expense"> {{$total_expense}}</div>
                            {{-- <div class="count-number total_expense"> {{number_format((float)$total_expense, 2, '.', '') }}</div> --}}
                        </a>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('deposit.index')}}">
                            <div class="name"><strong class="green-text">{{__('Total Deposit')}}</strong></div>
                            <div class="count-number total_deposit">{{$total_deposit}}</div>
                        </a>
                    </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                    <div class="wrapper count-title text-center">
                        <a href="{{route('payment_history.index')}}">
                            <div class="name"><strong class="blue-text">{{__('Total Salaries Paid')}}</strong>
                            </div>
                            <div class="count-number total_salaries_paid">{{$total_salaries_paid}}</div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- <div class="col-md-8 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{trans('file.Payment')}} --- {{__('Last 6 Months ')}}</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="payment_last_six" data-last_six_month_payment = "{{json_encode($per_month_payment) ?? ''}}" data-months="{{json_encode($per_month) ?? ''}}"  data-label1="{{trans('file.Payment')}}" ></canvas>
                        </div>
                    </div>
                </div> -->

                <div class="col-md-12 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Employee Department')}}</h4>
                        </div>

                        <canvas id="departmentChart"></canvas>
                      
                        
                        <!-- <div class="pie-chart mb-2"> -->
                            <!-- <canvas id="department_chart" data-dept_bgcolor='@json($dept_bgcolor_array)'
                                    data-hover_dept_bgcolor='@json($dept_hover_bgcolor_array)'
                                    data-dept_emp_count='@json($dept_count_array)'
                                    data-dept_label='@json($dept_name_array)' width="100" height="95"></canvas> -->
                        <!-- </div> -->
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Employee Designation')}}</h4>
                        </div>
                         <canvas id="designation_chart"></canvas>
                        <!-- <div class="pie-chart mb-2">
                            <canvas id="designation_chart" data-desig_bgcolor='@json($desig_bgcolor_array)'
                                    data-hover_desig_bgcolor='@json($desig_hover_bgcolor_array)'
                                    data-desig_emp_count='@json($desig_count_array)'
                                    data-desig_label='@json($desig_name_array)' width="100" height="95"></canvas>
                        </div> -->
                    </div>
                </div>

                <!-- <div class="col-md-6 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Expense Vs Deposit')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="expense_deposit_chart" data-expense_count='{{$total_expense_raw}}'
                                    data-expense_level="{{trans('Expense')}}"
                                    data-deposit_count='{{$total_deposit_raw}}'
                                    data-deposit_level="{{trans('Deposit')}}" width="100" height="95"></canvas>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="col-md-6 mt-4">
                    <div class="card mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{__('Project Status')}}</h4>
                        </div>
                        <div class="pie-chart mb-2">
                            <canvas id="project_chart" data-project_status='@json($project_count_array)'
                                    data-project_label='@json($project_name_array)' width="100" height="95"></canvas>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="row">
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon blue-text ml-2 mr-3"><i class="dripicons-volume-medium"></i></div>
                        <a href="{{route('announcements.index')}}">
                            <h3 class="mt-3">{{ count($announcements) }} {{trans('file.Announcement')}}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon green-text ml-2 mr-3"><i class="dripicons-ticket"></i></div>
                        <a href="{{route('tickets.index')}}">
                            <h3 class="mt-3">{{$ticket_count}} {{__('Open Ticket')}}</h3>
                        </a>
                    </div>
                </div>
                <div class="col-4 mt-4">
                    <div class="wrapper count-title d-flex">
                        <div class="icon orange-text ml-2 mr-3"><i class="dripicons-briefcase"></i></div>
                        <a href="{{route('projects.index')}}">
                            <h3 class="mt-3">{{$completed_projects}} {{__('Completed Projects')}}</h3>
                        </a>
                    </div>
                </div>
            </div>
            @if (Auth::user()->role_users_id != 6)
            <div class="row">
                @include('calendarable.calendar')
            </div>
            @endif
        </div>

    </section>
    @endif
@endsection

<style>
    /* Limit chart height */
    #departmentChart {
        max-height: 400px; Adjust as needed
    }
    /* Limit chart height */
    #designation_chart {
        max-height: 400px; Adjust as needed
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const dept_hover_bgcolor_array = {!! json_encode($dept_hover_bgcolor_array) !!};
const dept_bgcolor_array = {!! json_encode($dept_bgcolor_array) !!};
const deptCountArray = {!! json_encode($dept_count_array) !!};
const deptNameArray = {!! json_encode($dept_name_array) !!}; 

const formattedDeptNames = deptNameArray.map((_, index) => `Dep ${index + 1}`);

const depctx = document.getElementById('departmentChart').getContext('2d');

const departmentChart = new Chart(depctx, {
    type: 'bar',
    data: {
        labels: formattedDeptNames, 
        datasets: [{
            label: 'Number of Employees',
            data: deptCountArray,
            backgroundColor: dept_hover_bgcolor_array,
            borderColor: dept_bgcolor_array,
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            tooltip: {
                enabled: true,
                callbacks: {
                    title: function(tooltipItems) {
                        const index = tooltipItems[0].dataIndex;
                        return deptNameArray[index]; // Shows full department name
                    },
                    label: function(context) {
                        return `Employees: ${context.raw}`;
                    }
                }
            },
            legend: {
                display: false // Hide legend if needed
            }
        },
        scales: {
            x: {
                display: false // Hide x-axis labels
            },
            y: {
                beginAtZero: true
            }
        }
    }
});


const desig_bgcolor_array = {!! json_encode($desig_bgcolor_array) !!};
const desig_hover_bgcolor_array = {!! json_encode($desig_hover_bgcolor_array) !!};
const desigCountArray = {!! json_encode($desig_count_array) !!};
const desigNameArray = {!! json_encode($desig_name_array) !!}; 

// Generate short designation names: "Desig 1", "Desig 2", ...
const formattedDesigNames = desigNameArray.map((_, index) => `Desig ${index + 1}`);

const desigctx = document.getElementById('designation_chart').getContext('2d');

const designationChart = new Chart(desigctx, {
    type: 'bar',
    data: {
        labels: formattedDesigNames, // Shortened names: "Dep 1", "Dep 2", etc.
        datasets: [{
            label: 'Number of Employees',
            data: desigCountArray,
            backgroundColor: desig_bgcolor_array,
            borderColor: desig_hover_bgcolor_array,
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            tooltip: {
                enabled: true,
                callbacks: {
                    title: function(tooltipItems) {
                        // Get the correct index and return the full department name
                        const index = tooltipItems[0].dataIndex;
                        return desigNameArray[index]; // Shows full department name
                    },
                    label: function(context) {
                        return `Employees: ${context.raw}`; // Show employee count
                    }
                }
            },
            legend: {
                display: false // Hide legend if needed
            }
        },
        scales: {
            x: {
                display: false // Hide x-axis labels
            },
            y: {
                beginAtZero: true
            }
        }
    }

});


</script>
@endpush