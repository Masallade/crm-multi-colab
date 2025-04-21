<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/ammar.css') }}">
<style>
    .department-info {
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        display: flex;
        align-items: center;
    }

    .department-banner-content {
        padding: 10px 15px;
        background-color: #e9f7fe;
        border-left: 4px solid #17a2b8;
        border-radius: 4px;
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
</style>

<div class="modal fade" id="createModalForm" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="modal-title ml-3">Performance Evaluation</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Section Selector -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <i class="fas fa-list-alt section-icon"></i>
                        <h5>Select Evaluation Type</h5>
                    </div>
                    <div class="section-content">
                        
                        <div class="form-group">
                            <select id="sectionSelect" class="form-control selectpicker" data-live-search="true">
                            @if (!empty($sectionData))
                                @foreach($sectionData as $index => $section)
                                <option value="{{ $index }}">{{ $section['section']['name'] . "  /  " . $section['corresponding_designation_name']."  /  " . $section['corresponding_department_name'] }}</option>                                @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Department Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <i class="fas fa-building section-icon"></i>
                        <h5>Department</h5>
                    </div>
                    <div class="section-content" id="departmentDisplay">
                        <!-- Department name will be displayed here -->
                    </div>
                </div>

                <form action="{{ route('submitEmployeeAppraisal') }}" method="post" id="submitForm">
                    @csrf
                    <input type="hidden" name="section_name" id="sectionName">
                    <input type="hidden" name="weightage" id="sectionWeightage">
                    <input type="hidden" name="department_name" id="departmentName">
                    <input type="hidden" name="evaluator_id" value="{{ Auth::user()->id }}">


                    <div id="formContent">
                        <!-- Content will be loaded dynamically -->
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check mr-2"></i>Submit Evaluation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Template for dynamic content -->
<template id="sectionTemplate">
    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-building section-icon"></i>
            <h5>Company Information</h5>
        </div>
        <div class="section-content">
            <div class="form-group">
                <label for="companyId" class="label-heading">Company Name</label>
                <select name="company_id" id="companyId" class="form-control selectpicker dynamics" 
                    data-live-search="true" data-live-search-style="contains" data-first_name="first_name"
                    data-last_name="last_name" title="{{ __('Selecting', ['key' => trans('file.Company')]) }}">
                    @foreach ($companies as $item)
                        <option value="{{$item->id}}" selected>{{$item->company_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-users section-icon"></i>
            <h5>Evaluation Details</h5>
        </div>
        <div class="section-content">
            <div class="row">
                <!-- <div class="col-md-6">
                    <div class="evaluation-box">
                        <div class="evaluator-label">Evaluated By</div>
                        <div class="evaluator-name">
                            <i class="fas fa-user-tie mr-2"></i>
                            <span id="evaluateBy"></span>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="employeeId" class="label-heading">Select Employee</label>
                        <div class="select-wrapper">
                            <select name="employee_id" id="employeeId" class="form-control selectpicker" data-live-search="true">
                                <!-- Employees will be populated dynamically -->
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-calendar-alt section-icon"></i>
            <h5>Evaluation Period</h5>
        </div>
        <div class="section-content">
            <div class="form-group">
                <label for="date" class="label-heading">Select Date</label>
                <div class="input-group date-picker-wrapper">
                    <input type="text" class="form-control datepicker" name="date" id="date" placeholder="YYYY-MM-DD">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="department-banner mb-3" id="departmentBanner">
        <!-- Department will be displayed here -->
    </div>

    <div class="section-card">
        <div class="section-header">
            <i class="fas fa-star section-icon"></i>
            <h5>Performance Indicators</h5>
        </div>
        <div class="section-content" id="indicatorsContainer">
            <!-- Indicators will be populated dynamically -->
        </div>
    </div>
</template>

@php
// Preload designations data
$designations = \App\Models\Designation::select('id', 'designation_name', 'department_id')
    ->with('department:id,department_name')
    ->get();

// Create a mapping of designation names to arrays of designation IDs
$designationNameToIds = [];
foreach ($designations as $designation) {
    if (!isset($designationNameToIds[$designation->designation_name])) {
        $designationNameToIds[$designation->designation_name] = [];
    }
    $designationNameToIds[$designation->designation_name][] = [
        'id' => $designation->id,
        'department_id' => $designation->department_id
    ];
}
@endphp

<script>
// Store section data globally
@if (!empty($sectionData))
    const sectionData = @json($sectionData);
@endif

// Store employee data globally
const employeeData = @json($employee_data);

// Add designation data to JavaScript
const designationData = @json($designations);
const designationNameToIds = @json($designationNameToIds);

// Debug: Log the loaded designation data
console.log("🔍 DEBUGGING - All loaded designations:", designationData);
console.log("🔍 DEBUGGING - Designation name to IDs mapping:", designationNameToIds);

// Function to create indicator element
function createIndicatorElement(indicator) {
    return `
        <div class="indicator-card">
            <div class="indicator-header">
                <div class="indicator-name">${indicator.name}</div>
                <div class="score-badge">
                    <span class="score-display">0</span>
                    <span class="score-total">/10</span>
                </div>
            </div>
            <div class="rating-container">
                <div class="rating" data-score="0" data-indicator="${indicator.name}">
                    ${Array.from({length: 10}, (_, i) => 
                        `<i class="fa fa-star" data-value="${i + 1}"></i>`
                    ).join('')}
                </div>
            </div>
            <input type="hidden" name="performance_indicators[${indicator.name}]" value="0">
        </div>
    `;
}

// Function to update form content
function updateFormContent(sectionIndex) {
    if (!sectionData || Object.keys(sectionData).length === 0) {
        console.error("Section data is empty or undefined.");
        return;
    }

    if (!sectionData[sectionIndex]) {
        console.error("Invalid section index or missing section data.");
        return;
    }

    const section = sectionData[sectionIndex];
    const template = document.getElementById('sectionTemplate');
    const formContent = document.getElementById('formContent');

    if (!template || !formContent) {
        console.error("Template or form content container not found.");
        return;
    }

    // Clone template content
    formContent.innerHTML = template.innerHTML;

    if (typeof $ !== 'undefined') {
        $('.selectpicker').selectpicker('refresh');
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    }

    // Update hidden inputs
    $('#sectionName').val(section.section?.name || '');
    $('#sectionWeightage').val(section.section?.weightage || '');
    $('#departmentName').val(section.corresponding_department_name || '');

    // Update department display
    $('#departmentDisplay').html(`
        <div class="department-info">
            <i class="fas fa-building mr-2"></i>
            <span class="font-weight-bold">${section.corresponding_department_name || 'No department assigned'}</span>
        </div>
    `);

    // Update department banner
    if (section.corresponding_department_name) {
        $('#departmentBanner').html(`
            <div class="department-banner-content">
                <i class="fas fa-building mr-2"></i>
                <span class="font-weight-bold">Department: ${section.corresponding_department_name}</span>
            </div>
        `);
    } else {
        $('#departmentBanner').html('');
    }

    // UPDATED EVALUATOR DISPLAY CODE
    try {
        // Get evaluate_by data from section
        const evaluateBy = section.section?.evaluate_by;
        console.log("EVALUATOR DATA:", evaluateBy, "TYPE:", typeof evaluateBy);

        // Handle all possible formats of evaluateBy
        let evaluatorIds = [];
        
        // Parse from string if needed
        if (typeof evaluateBy === 'string') {
            try {
                // Try to parse as JSON array first
                const parsed = JSON.parse(evaluateBy);
                
                if (Array.isArray(parsed)) {
                    // It's a simple array like ["218", "179"]
                    evaluatorIds = parsed;
                } else if (parsed && typeof parsed === 'object') {
                    // It's an object like {0: "218", 1: "179"}
                    evaluatorIds = Object.values(parsed);
                } else {
                    // Single value
                    evaluatorIds = [parsed];
                }
            } catch (e) {
                // Not valid JSON, handle as raw string
                if (evaluateBy.includes(',')) {
                    evaluatorIds = evaluateBy.split(',').map(id => id.trim());
                } else {
                    evaluatorIds = [evaluateBy];
                }
            }
        } else if (Array.isArray(evaluateBy)) {
            // Already an array
            evaluatorIds = evaluateBy;
        } else if (evaluateBy && typeof evaluateBy === 'object') {
            // It's an object, use the values
            evaluatorIds = Object.values(evaluateBy);
        } else if (evaluateBy) {
            // Any other non-null value
            evaluatorIds = [evaluateBy];
        }
        
        // Make sure all IDs are strings for comparison
        evaluatorIds = evaluatorIds.map(id => String(id).trim()).filter(id => id);
        console.log("PROCESSED EVALUATOR IDS:", evaluatorIds);
        
        if (evaluatorIds.length > 0) {
            // Get all employee data for these IDs
            const evaluatorNames = evaluatorIds.map(id => {
                // Look up the employee data
                const employee = employeeData.find(emp => String(emp.id) === id);
                
                if (employee) {
                    return `${employee.first_name} ${employee.last_name}`;
                } else {
                    // Fallback if employee not found
                    return `Evaluator ${id}`;
                }
            });
            
            console.log("EVALUATOR NAMES:", evaluatorNames);
            $('#evaluateBy').text(evaluatorNames.join(', '));
        } else {
            $('#evaluateBy').text('Current User');
        }
    } catch (error) {
        console.error("Error displaying evaluators:", error);
        $('#evaluateBy').text('Current User (default)');
    }

    // Update indicators
    if (section.indicators && section.indicators.length > 0) {
        $('#indicatorsContainer').html(
            section.indicators.map(indicator => createIndicatorElement(indicator)).join('')
        );
    }

    // Filter and update employee dropdown
    const departmentId = section.corresponding_department_id;
    console.log("✅ departmentId:", departmentId); // Log the department ID

    // 🔍 Get the list of valid designation IDs from the section
    let designationIds = section.corresponding_designation_ids;
    console.log("✅ designationIds (original):", designationIds); 
    
    // Get designation name from the first designation ID
    const designationId = Array.isArray(designationIds) ? designationIds[0] : designationIds;
    console.log("🔍 DEBUGGING - Using designation ID for lookup:", designationId);
    
    const designation = designationData.find(d => d.id == designationId);
    console.log("🔍 DEBUGGING - Found designation object:", designation);
    
    if (designation) {
        console.log("🔍 DEBUGGING - Searching for matches with name:", designation.designation_name, "in department:", departmentId);
        
        // Find all IDs with the same designation name in this department
        const allMatchingIds = getDesignationIdsByNameAndDepartment(
            designation.designation_name, 
            departmentId
        );
        
        console.log("✅ Matched designation IDs for name:", designation.designation_name, allMatchingIds);
        
        // Use all matching IDs for filtering
        designationIds = allMatchingIds;
    } else {
        console.log("⚠️ WARNING - No designation found with ID:", designationId);
    }

    console.log("✅ Final designationIds for filtering:", designationIds);
    console.log("✅ employeeData to filter:", employeeData);

    const filteredEmployees = employeeData.filter(employee => {
        const departmentMatch = employee.department_id == departmentId;
        const employeeDesignationId = parseInt(employee.designation_id);
        
        console.log("🔍 DEBUGGING - Checking employee:", employee.id, 
            employee.first_name, employee.last_name, 
            "department:", employee.department_id, 
            "designation:", employeeDesignationId);
        
        let designationMatch;
        
        if (Array.isArray(designationIds)) {
            designationMatch = designationIds.includes(employeeDesignationId);
            console.log("🔍 DEBUGGING - Array comparison:", employeeDesignationId, "in", designationIds, "=", designationMatch);
        } else {
            designationMatch = employeeDesignationId == designationIds;
            console.log("🔍 DEBUGGING - Direct comparison:", employeeDesignationId, "==", designationIds, "=", designationMatch);
        }
            
        const finalMatch = departmentMatch && designationMatch;
        console.log("🔍 DEBUGGING - Final match for employee", employee.id, ":", 
            finalMatch, "(dept:", departmentMatch, ", desig:", designationMatch, ")");
            
        return finalMatch;
    });

    console.log("✅ Filtered employees:", filteredEmployees);

    const employeeDropdown = $('#employeeId');
    employeeDropdown.empty();

    if (filteredEmployees.length > 0) {
        filteredEmployees.forEach(employee => {
            employeeDropdown.append(
                $('<option></option>')
                    .val(employee.id)
                    .text(`${employee.first_name} ${employee.last_name}`)
            );
        });
    } else {
        employeeDropdown.append(
            $('<option></option>')
                .val('')
                .text('No employees found in this department')
                .prop('disabled', true)
        );
    }

    // Refresh selectpicker
    if (typeof $ !== 'undefined') {
        $('.selectpicker').selectpicker('refresh');
    }

    // Initialize rating system
    initializeRatingSystem();
}

// Initialize rating system
function initializeRatingSystem() {
    $('.rating i').hover(
        function() {
            $(this).addClass('hover');
            $(this).prevAll().addClass('hover');
        },
        function() {
            $('.rating i').removeClass('hover');
        }
    );

    $('.rating i').on('click', function() {
        const selectedValue = parseInt($(this).data('value'));
        const ratingContainer = $(this).closest('.rating');
        const indicatorName = ratingContainer.data('indicator');
        const indicatorCard = $(this).closest('.indicator-card');
        
        ratingContainer.attr('data-score', selectedValue);
        ratingContainer.find('i').removeClass('selected text-warning');
        $(this).addClass('selected text-warning').prevAll().addClass('selected text-warning');

        indicatorCard.find(`input[name="performance_indicators[${indicatorName}]"]`).val(selectedValue);
        indicatorCard.find('.score-display').text(selectedValue);

        if (selectedValue === 10) {
            launchConfetti();
        }
    });

    $('.rating').on('dblclick', function() {
        const indicatorCard = $(this).closest('.indicator-card');
        const indicatorName = $(this).data('indicator');
        
        $(this).attr('data-score', 0).find('i').removeClass('selected text-warning');
        indicatorCard.find(`input[name="performance_indicators[${indicatorName}]"]`).val(0);
        indicatorCard.find('.score-display').text('0');
    });
}

// Confetti Animation Function
function launchConfetti() {
    confetti({ 
        particleCount: 100, 
        spread: 70, 
        origin: { y: 0.6 },
        colors: ['#1e3c72', '#2a5298', '#ffd700']
    });
    setTimeout(() => {
        confetti({ 
            particleCount: 80, 
            spread: 100, 
            origin: { y: 0.6 },
            colors: ['#1e3c72', '#2a5298', '#ffd700']
        });
    }, 500);
    setTimeout(() => {
        confetti({ 
            particleCount: 50, 
            spread: 120, 
            origin: { y: 0.6 },
            colors: ['#1e3c72', '#2a5298', '#ffd700']
        });
    }, 1000);
}

// Function to get all designation IDs that match a name within a department
function getDesignationIdsByNameAndDepartment(designationName, departmentId) {
    console.log("🔍 DEBUGGING - Looking for designation name:", designationName, "in department:", departmentId);
    
    if (!designationNameToIds[designationName]) {
        console.log("⚠️ WARNING - No designations found with name:", designationName);
        return [];
    }
    
    // Filter by department if departmentId is provided
    const matchingDesignations = departmentId 
        ? designationNameToIds[designationName].filter(d => d.department_id == departmentId)
        : designationNameToIds[designationName];
    
    console.log("🔍 DEBUGGING - Matching designations for", designationName, ":", matchingDesignations);
    
    const resultIds = matchingDesignations.map(d => d.id);
    console.log("🔍 DEBUGGING - Final matched designation IDs:", resultIds);
    
    return resultIds;
}

// Initialize on document ready
$(document).ready(function() {
    // Initialize first section
    updateFormContent(0);
    
    // Handle section selection
    $('#sectionSelect').on('change', function() {
        updateFormContent($(this).val());
    });

    // Form submission handler
    $('#submitForm').on('submit', function(e) {
        e.preventDefault();
        
        const currentSectionIndex = $('#sectionSelect').val();
        const currentSection = sectionData[currentSectionIndex];
        
        $('#sectionName').val(currentSection.section.name);
        $('#sectionWeightage').val(currentSection.section.weightage);
        $('#departmentName').val(currentSection.corresponding_department_name || '');
        
        const companyId = $('#companyId').val();
        const employeeId = $('#employeeId').val();
        const date = $('#date').val();
        
        if (!companyId || !employeeId || !date) {
            alert('Please fill in all required fields');
            return false;
        }
        
        const ratings = {};
        let allRated = true;
        
        $('.rating').each(function() {
            const indicatorName = $(this).data('indicator');
            const score = parseInt($(this).attr('data-score')) || 0;
            
            if (score === 0) {
                allRated = false;
            }
            
            ratings[indicatorName] = score;
        });
        
        if (!allRated && !confirm('Some indicators have not been rated. Do you want to continue?')) {
            return false;
        }
        
        Object.entries(ratings).forEach(([indicator, value]) => {
            $(`input[name="performance_indicators[${indicator}]"]`).val(value);
        });
        
        this.submit();
    });
});
</script>