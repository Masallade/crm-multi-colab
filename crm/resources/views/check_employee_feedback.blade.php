@extends('layout.main')
@section('content')

<style>
    /* Pagination Styling */
.dataTables_paginate {
    margin-top: 15px;
}

.dataTables_paginate .paginate_button {
    padding: 5px 10px;
    margin-left: 5px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    color: #007bff;
    cursor: pointer;
}

.dataTables_paginate .paginate_button:hover {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.dataTables_paginate .paginate_button.current {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

p{
    margin-bottom: 0px;
}
</style>
<section>
    <div class="container-fluid">
        <h2 class="text-center mb-4">All Employee Appraisal Feedback</h2>

<!-- Search Form -->
<form action="{{ route('check_employee_feedback') }}" method="GET" class="row mb-4">
            <div class="col-md-6">
                <select name="name" id="searchByName" class="form-control">
                    <option value="">Select Employee Name</option>
                    @foreach ($uniqueNames as $name)
                        <option value="{{ $name }}" {{ request('name') == $name ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <input type="date" name="date" class="form-control" placeholder="Search by Date" value="{{ request('date') }}">
            </div>
            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('check_employee_feedback') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if ($feedback->isEmpty())
            <div class="alert alert-info">
                No feedback submissions found.
            </div>
        @else
            <table id="feedbackTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Team Lead</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedback as $index => $entry)
                    <tr data-toggle="collapse" data-target="#details-{{ $entry->id }}" class="clickable black-bg-white-text" data-toggle="tooltip" title="Click here to view feedback details" style="cursor: pointer;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $entry->name }}</td>
                            <td>{{ $entry->department }}</td>
                            <td>{{ $entry->position }}</td>
                            <td>{{ $entry->reporting_manager }}</td>
                            <td>{{ $entry->created_at }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="hiddenRow">
                                <div id="details-{{ $entry->id }}" class="collapse">
                                    <!-- Tabs -->
                                    <ul class="nav nav-tabs" id="feedbackTabs-{{ $entry->id }}">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#employeeInfo-{{ $entry->id }}">Employee Information</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#performanceFeedback-{{ $entry->id }}">Employee Feedback on Performance</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#managerFeedback-{{ $entry->id }}">Employee Feedback on Manager/Team Lead</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#selfFeedback-{{ $entry->id }}">Employee Self Feedback</a>
                                        </li>
                                    </ul>

                                    <!-- Tab Content -->
                                    <div class="tab-content">
                                        <div id="employeeInfo-{{ $entry->id }}" class="tab-pane fade show active">
                                            <h4  class="mt-3 mb-3">Employee Information</h4>
                                            <p><strong>Name:</strong> {{ $entry->name }}</p>
                                            <p><strong>Department:</strong> {{ $entry->department }}</p>
                                            <p><strong>Reporting Manager:</strong> {{ $entry->reporting_manager }}</p>
                                            <p><strong>Position:</strong> {{ $entry->position }}</p>
                                            <p><strong>Joining Date:</strong> {{ $entry->joining_date }}</p>
                                        </div>
                                        <div id="performanceFeedback-{{ $entry->id }}" class="tab-pane fade">
                                            <h4  class="mt-3 mb-3">Employee Feedback on Performance</h4>
                                            <p><strong>Clarity of Expectations:</strong> {{ $entry->clarity_expectations }}</p>
                                            <p><strong>Feasibility of Goals:</strong> {{ $entry->feasibility_goals }}</p>
                                            <p><strong>Fairness of Evaluation:</strong> {{ $entry->fairness_evaluation }}</p>
                                            <p><strong>Feedback Frequency:</strong> {{ $entry->feedback_frequency }}</p>
                                        </div>
                                        <div id="managerFeedback-{{ $entry->id }}" class="tab-pane fade">
                                            <h4  class="mt-3 mb-3">Employee Feedback on Manager/Team Lead</h4>
                                            <p><strong>Manager Support:</strong> {{ $entry->manager_support }}</p>
                                            <p><strong>Communication Effectiveness:</strong> {{ $entry->communication_effectiveness }}</p>
                                            <p><strong>Accessibility:</strong> {{ $entry->accessibility }}</p>
                                            <p><strong>Recognition:</strong> {{ $entry->recognition }}</p>
                                        </div>
                                        <div id="selfFeedback-{{ $entry->id }}" class="tab-pane fade">
                                            <h4  class="mt-3 mb-3">Employee Self Feedback</h4>
                                            <p><strong>Achievements:</strong> {{ $entry->achievements }}</p>
                                            <p><strong>Challenges:</strong> {{ $entry->challenges }}</p>
                                            <p><strong>Professional Development:</strong> {{ $entry->professional_development }}</p>
                                            <p><strong>Self-Assessment:</strong> {{ $entry->self_assessment }}</p>
                                            <p><strong>Support Resources:</strong> {{ $entry->support_resources }}</p>
                                            <p><strong>Any Comment:</strong> {{ $entry->any_comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- DataTables Initialization -->
<script>
    $(document).ready(function() {
        $('#feedbackTable').DataTable({
            "paging": true, // Enable pagination
            "pageLength": 10, // Set number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Dropdown for rows per page
            "order": [[0, 'asc']], // Sort by SN column (ascending)
            "columnDefs": [
                { "orderable": false, "targets": [1, 2] } // Disable sorting for Employee Name and Department columns
            ]
        });

        // Collapse functionality
        $('.clickable').on('click', function() {
            $(this).next('tr').find('.collapse').collapse('toggle');
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

@endsection