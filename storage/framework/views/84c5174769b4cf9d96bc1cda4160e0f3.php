<?php
    // Pre-load required data directly in the template
    $allDesignations = \App\Models\Designation::all();
    
    // Create array to track unique designation names
    $uniqueDesignationNames = [];
    $designations = [];
    
    // Filter to only include unique designation names
    foreach ($allDesignations as $designation) {
        if (!in_array($designation->designation_name, $uniqueDesignationNames)) {
            $uniqueDesignationNames[] = $designation->designation_name;
            $designations[] = $designation;
        }
    }
    
    $employees = \App\Models\Employee::all();
    
    // Get existing designation IDs from appraisal_sections table
    $existingDesignationIds = [];
    $appraisalSections = \App\Models\AppraisalSection::all();
    foreach ($appraisalSections as $section) {
        // The designation_ids field might be a string or an integer
        $designationId = $section->designation_ids;
        
        // Handle various formats (single value, array, JSON string)
        if (is_numeric($designationId)) {
            $existingDesignationIds[] = (int)$designationId;
        } elseif (is_string($designationId) && is_numeric($designationId)) {
            $existingDesignationIds[] = (int)$designationId;
        } elseif (is_string($designationId)) {
            // Try to decode as JSON
            $decoded = json_decode($designationId, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $existingDesignationIds = array_merge($existingDesignationIds, array_map('intval', $decoded));
            } else {
                // Assume comma-separated string
                $ids = explode(',', $designationId);
                $existingDesignationIds = array_merge($existingDesignationIds, array_map('intval', $ids));
            }
        }
    }
    
    // Remove duplicates
    $existingDesignationIds = array_unique($existingDesignationIds);
    
    // Get departments grouped by company
    $departmentsByCompany = [];
    $departments = \App\Models\Department::all();
    foreach ($departments as $department) {
        if (!isset($departmentsByCompany[$department->company_id])) {
            $departmentsByCompany[$department->company_id] = [];
        }
        $departmentsByCompany[$department->company_id][] = [
            'id' => $department->id,
            'department_name' => $department->department_name
        ];
    }
?>

<!-- Add Appraisal Type Form -->
<div class="card">
    <div class="card-header">
        <h4><?php echo e(__('Add Appraisal Type')); ?></h4>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('getNewAppraisalType')); ?>">
            <?php echo csrf_field(); ?>
            
            <!-- Hidden input for company -->
            <input type="hidden" name="company_id" id="company_id" value="9">

            <!-- Step Navigation -->
            <div class="text-center mb-4">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary active" id="step1-tab"><?php echo e(__('Step 1: Define Sections')); ?></button>
                    <button type="button" class="btn btn-secondary" id="step2-tab" disabled><?php echo e(__('Step 2: Assign Evaluators')); ?></button>
                </div>
            </div>

            <!-- Weightage Progress -->
            <div class="progress mb-4">
                <div id="weightage-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
            </div>
            <div class="text-right mb-4">
                <span id="weightage-display"><?php echo e(__('Weightage Left')); ?>: <strong id="weightage-left">100</strong>%</span>
            </div>

            <!-- Step 1: Sections and Indicators -->
            <div id="step1-container">
                <div class="mb-4">
                    <button type="button" id="add-section-btn" class="btn btn-success">
                        <i class="fa fa-plus"></i> <?php echo e(__('Add Section')); ?>

                    </button>
                </div>

                <div id="sections-container">
                    <!-- Sections will be added here dynamically -->
                </div>

                <div class="mt-4 text-right">
                    <button type="button" id="go-to-step2-btn" class="btn btn-primary" disabled>
                        <?php echo e(__('Next: Assign Evaluators')); ?> <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Designations, Departments and Evaluators -->
            <div id="step2-container" style="display: none;">
                <!-- Inline Wizard Progress Indicator -->
                <div class="wizard-progress-inline mb-4">
                    <div class="wizard-steps-inline">
                        <div class="wizard-step-inline">
                            <div class="step-number-inline" id="inline-step-1">1</div>
                            <div class="step-label-inline"><?php echo e(__('Select Designations')); ?></div>
                        </div>
                        <div class="wizard-connector-inline"></div>
                        <div class="wizard-step-inline">
                            <div class="step-number-inline" id="inline-step-2">2</div>
                            <div class="step-label-inline"><?php echo e(__('Select Departments')); ?></div>
                        </div>
                        <div class="wizard-connector-inline"></div>
                        <div class="wizard-step-inline">
                            <div class="step-number-inline" id="inline-step-3">3</div>
                            <div class="step-label-inline"><?php echo e(__('Assign Evaluators')); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Hidden fields to store wizard data -->
                <div id="wizard-data-container"></div>

                <div class="mt-4">
                    <button type="button" id="back-to-step1-btn" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> <?php echo e(__('Back to Sections')); ?>

                    </button>
                    <button type="submit" id="submit-btn" class="btn btn-success float-right" style="display: none;">
                        <i class="fa fa-check"></i> <?php echo e(__('Finish & Submit')); ?>

                    </button>
                    <button type="button" id="start-wizard-btn" class="btn btn-primary float-right">
                        <?php echo e(__('Start: Select Designations')); ?> <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Wizard Modal Dialogs -->
<!-- Step 1: Select Designations Modal -->
<div class="modal fade" id="designations-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 85%; margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-users"></i> <?php echo e(__('Step 1: Select Designations')); ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo e(__('Choose which designations will be evaluated')); ?></p>
                <div class="mb-2">
                    <button type="button" class="btn btn-success btn-sm" id="select-all-designations">
                        <i class="fa fa-check-square"></i> <?php echo e(__('Select All')); ?>

                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="deselect-all-designations">
                        <i class="fa fa-square"></i> <?php echo e(__('Deselect All')); ?>

                    </button>
                </div>
                <div id="designations-checkboxes" class="row">
                    <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isUsed = in_array($designation->id, $existingDesignationIds);
                        ?>
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input designation-checkbox" type="checkbox" 
                                       value="<?php echo e($designation->id); ?>" id="desig-<?php echo e($designation->id); ?>"
                                       <?php echo e($isUsed ? 'disabled' : ''); ?>>
                                <label class="form-check-label" for="desig-<?php echo e($designation->id); ?>">
                                    <?php echo e($designation->designation_name); ?>

                                    <?php if($isUsed): ?>
                                        <span class="badge badge-danger"><?php echo e(__('Already assigned')); ?></span>
                                    <?php endif; ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="alert alert-info mt-2">
                    <i class="fa fa-info-circle"></i> <?php echo e(__('Designations that are already assigned in other appraisal types are not selectable.')); ?>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                <button type="button" class="btn btn-primary" id="next-to-departments">
                    <?php echo e(__('Next: Select Departments')); ?> <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Step 2: Select Departments Modal -->
<div class="modal fade" id="departments-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 85%; margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-building"></i> <?php echo e(__('Step 2: Select Departments')); ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="departments-modal-body">
                <!-- Will be populated dynamically -->
                <div id="departments-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="back-to-designations">
                    <i class="fa fa-arrow-left"></i> <?php echo e(__('Previous')); ?>

                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                <button type="button" class="btn btn-primary" id="next-to-evaluators">
                    <?php echo e(__('Next: Assign Evaluators')); ?> <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Step 3: Assign Evaluators Modal -->
<div class="modal fade" id="evaluators-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 85%; margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-user-plus"></i> <?php echo e(__('Step 3: Assign Evaluators')); ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="evaluators-modal-body">
                <!-- Will be populated dynamically -->
                <div id="evaluators-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="back-to-departments-from-evaluators">
                    <i class="fa fa-arrow-left"></i> <?php echo e(__('Previous')); ?>

                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                <button type="button" class="btn btn-success" id="finish-wizard">
                    <i class="fa fa-check"></i> <?php echo e(__('Finish')); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<!-- Indicator Selection Modal (Popup when employee is selected) -->
<div class="modal fade" id="indicator-selection-modal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 95%; margin: 1.75rem auto;">
        <div class="modal-content" style="border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
            <div class="modal-header bg-info text-white" style="border-radius: 10px 10px 0 0;">
                <h5 class="modal-title">
                    <i class="fa fa-check-square"></i> 
                    <span id="indicator-modal-title"><?php echo e(__('Select Indicators')); ?></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="indicator-selection-body" style="max-height: 70vh; overflow-y: auto; padding: 30px;">
                <!-- Will be populated dynamically with checkboxes -->
            </div>
            <div class="modal-footer" style="background-color: #f8f9fa; border-radius: 0 0 10px 10px; padding: 15px 30px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> <?php echo e(__('Cancel')); ?>

                </button>
                <button type="button" class="btn btn-primary" id="save-indicator-selection">
                    <i class="fa fa-save"></i> <?php echo e(__('Save Selection')); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    let sections = [];
    let sectionIndex = 0;
    let weightageLeft = 100;
    
    // DOM Elements
    const sectionsContainer = document.getElementById('sections-container');
    const designationsContainer = document.getElementById('designations-container');
    const addSectionButton = document.getElementById('add-section-btn');
    const goToStep2Button = document.getElementById('go-to-step2-btn');
    const backToStep1Button = document.getElementById('back-to-step1-btn');
    const submitButton = document.getElementById('submit-btn');
    const step1Container = document.getElementById('step1-container');
    const step2Container = document.getElementById('step2-container');
    const step1Tab = document.getElementById('step1-tab');
    const step2Tab = document.getElementById('step2-tab');
    const weightageLeftDisplay = document.getElementById('weightage-left');
    const weightageProgress = document.getElementById('weightage-progress');
    const designationIdsSelect = document.getElementById('designation_ids');
    
    // Data from PHP
    const departmentsByCompany = <?php echo json_encode($departmentsByCompany, 15, 512) ?>;
    const allEmployees = <?php echo json_encode($employees, 15, 512) ?>;
    const allDesignations = <?php echo json_encode($designations, 15, 512) ?>;
    const allDesignationsRaw = <?php echo json_encode($allDesignations, 15, 512) ?>; // All designation records including duplicates
    
    // Pre-select company ID 9
    const selectedCompanyId = 9;
    
    // Initialize selectpicker
    $('.selectpicker').selectpicker();
    
    // Add Section Button Click Handler
    addSectionButton.addEventListener('click', function() {
        addSection();
        checkWeightage();
    });
    
    // Function to add a new section
    function addSection() {
        sectionIndex++;
        
        // Create section container
        const sectionGroup = document.createElement('div');
        sectionGroup.classList.add('section-group', 'card', 'mb-4');
        sectionGroup.dataset.sectionIndex = sectionIndex;
        
        // Section header
        const sectionHeader = document.createElement('div');
        sectionHeader.classList.add('card-header', 'd-flex', 'justify-content-between', 'align-items-center');
        sectionHeader.innerHTML = `
            <div class="input-group" style="width: 80%;">
                <div class="input-group-prepend">
                    <span class="input-group-text"><?php echo e(__('Section')); ?></span>
                </div>
                <input type="text" class="form-control section-name" name="section_name[]" 
                       placeholder="<?php echo e(__('Section Name')); ?>" required>
            </div>
            <div class="input-group" style="width: 20%;">
                <input type="number" class="form-control section-weightage" name="section_weightage[]" 
                       placeholder="%" min="1" max="${weightageLeft}" required>
                <div class="input-group-append">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        `;
        
        // Section body
        const sectionBody = document.createElement('div');
        sectionBody.classList.add('card-body');
        
        // Indicators container
        const indicatorsContainer = document.createElement('div');
        indicatorsContainer.classList.add('indicators-container');
        
        // Add indicator button
        const addIndicatorButton = document.createElement('button');
        addIndicatorButton.type = 'button';
        addIndicatorButton.classList.add('btn', 'btn-info', 'btn-sm', 'add-indicator-btn', 'mb-3');
        addIndicatorButton.innerHTML = `<i class="fa fa-plus"></i> <?php echo e(__('Add Indicator')); ?>`;
        
        // Add indicator click handler
        addIndicatorButton.addEventListener('click', function() {
            addIndicator(indicatorsContainer, sectionIndex);
        });
        
        // Delete section button
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'float-right');
        deleteButton.innerHTML = `<i class="fa fa-trash"></i> <?php echo e(__('Delete Section')); ?>`;
        
        // Delete section click handler
        deleteButton.addEventListener('click', function() {
            sectionGroup.remove();
            checkWeightage();
        });
        
        // Assemble section
        sectionBody.appendChild(addIndicatorButton);
        sectionBody.appendChild(deleteButton);
        sectionBody.appendChild(indicatorsContainer);
        
        sectionGroup.appendChild(sectionHeader);
        sectionGroup.appendChild(sectionBody);
        
        // Add to container
        sectionsContainer.appendChild(sectionGroup);
        
        // Add default indicator
        addIndicator(indicatorsContainer, sectionIndex);
        
        // Add event listener for weightage change
        const weightageInput = sectionGroup.querySelector('.section-weightage');
        weightageInput.addEventListener('input', function() {
            checkWeightage();
        });
        
        // Add this section to our sections array
        sections.push({
            index: sectionIndex,
            name: '',
            weightage: 0,
            indicators: []
        });
        
        // Return the section
        return {
            element: sectionGroup,
            index: sectionIndex
        };
    }
    
    // Function to add an indicator to a section
    function addIndicator(container, sectionIdx) {
        const indicatorGroup = document.createElement('div');
        indicatorGroup.classList.add('indicator-group', 'input-group', 'mb-2');
        
        indicatorGroup.innerHTML = `
            <div class="input-group-prepend">
                <span class="input-group-text"><?php echo e(__('Indicator')); ?></span>
            </div>
            <input type="text" class="form-control" name="indicators[${sectionIdx}][]" 
                   placeholder="<?php echo e(__('Indicator Description')); ?>" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger delete-indicator-btn">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        `;
        
        // Delete indicator click handler
        const deleteButton = indicatorGroup.querySelector('.delete-indicator-btn');
        deleteButton.addEventListener('click', function() {
            indicatorGroup.remove();
        });
        
        // Add to container
        container.appendChild(indicatorGroup);
    }
    
    // Function to check weightage and update UI
    function checkWeightage() {
        // Calculate total weightage
        let totalWeightage = 0;
        document.querySelectorAll('.section-weightage').forEach(input => {
            totalWeightage += parseInt(input.value) || 0;
        });
        
        // Update weightage left
        weightageLeft = 100 - totalWeightage;
        weightageLeftDisplay.textContent = weightageLeft;
        
        // Update progress bar
        weightageProgress.style.width = `${totalWeightage}%`;
        
        // Update max values for all weightage inputs
        document.querySelectorAll('.section-weightage').forEach(input => {
            const currentValue = parseInt(input.value) || 0;
            input.max = currentValue + weightageLeft;
        });
        
        // Enable/disable next button
        goToStep2Button.disabled = weightageLeft !== 0;
        step2Tab.disabled = weightageLeft !== 0;
        
        // Change progress bar color based on value
        if (totalWeightage === 100) {
            weightageProgress.classList.remove('bg-warning');
            weightageProgress.classList.add('bg-success');
        } else if (totalWeightage > 100) {
            weightageProgress.classList.remove('bg-success');
            weightageProgress.classList.add('bg-danger');
        } else {
            weightageProgress.classList.remove('bg-success', 'bg-danger');
            weightageProgress.classList.add('bg-warning');
        }
        
        return {
            total: totalWeightage,
            left: weightageLeft
        };
    }

    // Handle navigation between steps
    goToStep2Button.addEventListener('click', () => {
        if (weightageLeft === 0) {
            step1Container.style.display = 'none';
            step2Container.style.display = 'block';
            step1Tab.classList.remove('active');
            step1Tab.classList.add('btn-secondary');
            step1Tab.classList.remove('btn-primary');
            step2Tab.classList.add('active');
            step2Tab.classList.add('btn-primary');
            step2Tab.classList.remove('btn-secondary');
            step2Tab.disabled = false;
            
            // Update sections array with current values
            updateSectionsData();
        }
    });
    
    backToStep1Button.addEventListener('click', () => {
        step1Container.style.display = 'block';
        step2Container.style.display = 'none';
        step2Tab.classList.remove('active');
        step2Tab.classList.add('btn-secondary');
        step2Tab.classList.remove('btn-primary');
        step1Tab.classList.add('active');
        step1Tab.classList.add('btn-primary');
        step1Tab.classList.remove('btn-secondary');
    });
    
    // Tab navigation
    step1Tab.addEventListener('click', () => {
        if (!step1Tab.disabled) {
            backToStep1Button.click();
        }
    });
    
    step2Tab.addEventListener('click', () => {
        if (!step2Tab.disabled) {
            goToStep2Button.click();
        }
    });
    
    // Function to update sections data from the DOM
    function updateSectionsData() {
        sections = [];
        document.querySelectorAll('.section-group').forEach(sectionEl => {
            const index = sectionEl.dataset.sectionIndex;
            const name = sectionEl.querySelector('.section-name').value;
            const weightage = parseInt(sectionEl.querySelector('.section-weightage').value) || 0;
            
            const indicators = [];
            sectionEl.querySelectorAll(`[name="indicators[${index}][]"]`).forEach(input => {
                if (input.value.trim()) {
                    indicators.push(input.value);
                }
            });
            
            sections.push({
                index: index,
                name: name,
                weightage: weightage,
                indicators: indicators
            });
        });
        
        return sections;
    }
    
    // Form submission handler
    submitButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Update sections data
        updateSectionsData();
        
        // Check if weightage is 100%
        if (weightageLeft !== 0) {
            alert("<?php echo e(__('Remaining weightage must be 0 to submit the form!')); ?>");
            return;
        }
        
        // Collect form data
        const designationData = [];
        
        // Process each designation group
        document.querySelectorAll('.designation-group').forEach(group => {
            const designationId = group.dataset.designationId;
            const designationLabel = group.querySelector('label');
            const designationName = designationLabel ? designationLabel.textContent.split(' - ')[0] : '<?php echo e(__("Unknown Designation")); ?>';
            const departmentSelect = group.querySelector('.department-select');
            
            if (!departmentSelect) return;
            
            // Get selected departments
            const selectedDepartments = $(departmentSelect).val() || [];
            if (selectedDepartments.length === 0) return;
            
            // Format department data
            const departmentData = selectedDepartments.map(deptId => {
                const dept = departmentsByCompany[selectedCompanyId]?.find(d => d.id == deptId);
                return {
                    id: deptId,
                    name: dept ? dept.department_name : '<?php echo e(__("Unknown Department")); ?>'
                };
            });
            
            // Collect evaluator selections
            const employeeSelections = {};
            sections.forEach(section => {
                employeeSelections[section.index] = {};
                
                selectedDepartments.forEach(deptId => {
                    const select = document.querySelector(`select[name="section_evaluators[${section.index}][${designationId}][${deptId}]"]`);
                    if (select && select.value) {
                        if (!employeeSelections[section.index][deptId]) {
                            employeeSelections[section.index][deptId] = select.value;
                        }
                    }
                });
            });
            
            // Add to designation data
            designationData.push({
                designation_id: designationId,
                designation_name: designationName,
                departments: departmentData,
                employees: employeeSelections
            });
        });
        
        // Add hidden field with designation data
        const dataInput = document.createElement('input');
        dataInput.type = 'hidden';
        dataInput.name = 'designation_departments';
        dataInput.value = JSON.stringify(designationData);
        
        // Submit the form
        const form = this.closest('form');
        form.appendChild(dataInput);
        form.submit();
    });
    
    // Add initial section
    addSection();
    
    // Add CSS for designation groups
    const style = document.createElement('style');
    style.textContent = `
        /* Designation group styling */
        .designation-group {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 15px;
        }
        
        .designation-group label {
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }
        
        .designation-group .department-select {
            width: 100%;
        }
        
        /* Section styling */
        .section-group {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .section-group .card-header {
            background-color: #f5f5f5;
            padding: 12px 15px;
        }
        
        .section-group .card-body {
            padding: 15px;
        }
        
        .indicator-group {
            background-color: #fff;
        }
        
        /* Step tabs */
        .btn-group .btn.active {
            font-weight: bold;
        }
        
        /* Department container */
        .department-container {
            border-left: 4px solid #007bff;
        }
        
        /* Evaluator section */
        .evaluator-section {
            border-bottom: 1px dotted #ddd;
            padding-bottom: 10px;
        }
        
        .evaluator-section:last-child {
            border-bottom: none;
        }
        
        .evaluator-section-title {
            color: #555;
        }
        
        /* Invalid feedback */
        .is-invalid {
            border-color: #dc3545;
        }
        
        .disabled-option {
            opacity: 0.6;
            background-color: #f8f8f8;
            position: relative;
        }
        
        .disabled-option:hover {
            cursor: not-allowed;
        }
        
        /* Department and Designation checkbox styling */
        #designations-checkboxes .form-check,
        #departments-content .form-check {
            padding: 8px 10px;
            margin-bottom: 4px;
            border: none;
            background: transparent;
        }
        
        #designations-checkboxes .form-check:hover,
        #departments-content .form-check:hover {
            background-color: transparent;
        }
        
        #designations-checkboxes .form-check-input,
        #departments-content .form-check-input {
            margin-top: 3px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        #designations-checkboxes .form-check-label,
        #departments-content .form-check-label {
            cursor: pointer;
            user-select: none;
            margin-left: 8px;
            font-size: 0.95rem;
            color: #4a5568;
            line-height: 1.5;
        }
        
        #designations-checkboxes .form-check-input:disabled ~ .form-check-label,
        #departments-content .form-check-input:disabled ~ .form-check-label {
            color: #a0aec0;
            cursor: not-allowed;
        }
        
        #designations-checkboxes .form-check-label .badge-danger {
            background-color: #fc5c7d;
            color: white;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 6px;
            font-weight: 500;
        }
        
        #designations-checkboxes .col-md-3,
        #departments-content .col-md-3 {
            padding-left: 20px;
            padding-right: 20px;
        }
        
        #designations-checkboxes {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        /* Modal body spacing */
        #designations-modal .modal-body,
        #departments-modal .modal-body,
        #evaluators-modal .modal-body {
            padding: 20px 30px;
            max-height: 75vh;
            overflow-y: auto;
        }
        
        /* Custom scrollbar styling */
        #departments-modal .modal-body::-webkit-scrollbar,
        #evaluators-modal .modal-body::-webkit-scrollbar {
            width: 12px;
        }
        
        #departments-modal .modal-body::-webkit-scrollbar-track,
        #evaluators-modal .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        #departments-modal .modal-body::-webkit-scrollbar-thumb,
        #evaluators-modal .modal-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
        
        #departments-modal .modal-body::-webkit-scrollbar-thumb:hover,
        #evaluators-modal .modal-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b3f8f 100%);
        }
        
        #designations-checkboxes {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        
        #designations-modal .modal-body > p,
        #departments-modal .modal-body > p {
            margin-bottom: 12px;
        }
        
        /* Alert box styling */
        #designations-modal .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-top: 12px;
            margin-bottom: 0;
        }
        
        #designations-modal .alert-info i {
            margin-right: 8px;
        }
        
        /* Modal card styling */
        #departments-modal .card,
        #designations-modal .card,
        #evaluators-modal .card {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        
        #departments-modal .card-header,
        #designations-modal .card-header,
        #evaluators-modal .card-header {
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
            padding: 15px 20px;
        }
        
        /* Department and Evaluator card header with collapse */
        .dept-card-header,
        .evaluator-card-header {
            position: relative;
            user-select: none;
        }
        
        .dept-card-header:hover,
        .evaluator-card-header:hover {
            background-color: #f3f4f6 !important;
        }
        
        .collapse-icon {
            margin-right: 10px;
            transition: transform 0.3s ease;
            display: inline-block;
        }
        
        .collapse-icon.rotated {
            transform: rotate(90deg);
        }
        
        #departments-modal .card-body,
        #evaluators-modal .card-body {
            padding: 20px;
        }
        
        /* Department checkbox row padding */
        .dept-checkbox-row {
            padding-left: 25px;
            padding-right: 15px;
        }
        
        #departments-content .col-md-3 {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        #departments-content .badge-secondary {
            background-color: #6c757d;
            font-size: 0.7rem;
            padding: 3px 6px;
            border-radius: 4px;
            margin-left: 6px;
            font-weight: 500;
        }
        
        #departments-content .badge-info,
        #evaluators-content .badge-info {
            background-color: #17a2b8;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 4px;
        }
        
        #evaluators-content .badge-secondary {
            background-color: #6c757d;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        
        /* Department OK button styling */
        .dept-ok-btn {
            margin-top: 10px;
            padding: 6px 20px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .dept-ok-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }
        
        /* Step 3: Evaluators modal styling */
        #evaluators-content .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        #evaluators-content .card-header {
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
            padding: 15px 20px;
        }
        
        #evaluators-content .card-body {
            padding: 20px;
        }
        
        .evaluator-sections {
            padding-left: 10px;
        }
        
        #evaluators-content .form-group {
            margin-bottom: 20px;
        }
        
        #evaluators-content .form-group:last-child {
            margin-bottom: 0;
        }
        
        #evaluators-content .form-group label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        #evaluators-content .form-group label i {
            font-size: 0.9rem;
        }
        
        #evaluators-content .form-group label .badge {
            font-size: 0.7rem;
            padding: 3px 8px;
            margin-left: auto;
        }
        
        #evaluators-content select.form-control {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 0.95rem;
            color: #1a202c;
            font-weight: 400;
        }
        
        #evaluators-content select.form-control option {
            color: #1a202c;
            padding: 8px 12px;
            font-weight: 400;
        }
        
        #evaluators-content select.form-control option:first-child {
            color: #6b7280;
            font-style: italic;
        }
        
        #evaluators-content select.form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        #evaluators-content .form-text {
            font-size: 0.8rem;
            margin-top: 5px;
        }
        
        /* ===== INLINE WIZARD PROGRESS INDICATOR ===== */
        .wizard-progress-inline {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .wizard-steps-inline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 900px;
            margin: 0 auto;
        }
        
        .wizard-step-inline {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .wizard-step-inline:hover .step-number-inline {
            transform: scale(1.1);
        }
        
        .step-number-inline {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .step-number-inline.active {
            background-color: #fff;
            color: #667eea;
            transform: scale(1.1);
        }
        
        .step-number-inline.completed {
            background-color: #28a745;
            color: #fff;
        }
        
        .step-number-inline.completed::before {
            content: "✓";
        }
        
        .step-label-inline {
            font-size: 0.9rem;
            color: #fff;
            font-weight: 500;
            text-align: center;
        }
        
        .wizard-connector-inline {
            flex: 0.5;
            height: 3px;
            background-color: rgba(255, 255, 255, 0.3);
            margin: 0 10px;
            margin-bottom: 35px;
        }
        
        .wizard-connector-inline.completed {
            background-color: #28a745;
        }
        /* ===== END INLINE WIZARD PROGRESS INDICATOR ===== */
        
        /* ===== NOTIFICATION ANIMATIONS ===== */
        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
            }
        }
        
        .pulse-animation {
            animation: pulse 1s ease-in-out infinite;
        }
        /* ===== END NOTIFICATION ANIMATIONS ===== */
        
        /* ===== BOOTSTRAP 4 MODAL FIXES ===== */
        /* Ensure modals display properly with Bootstrap 4 */
        .modal-dialog.modal-lg {
            max-width: 900px;
        }
        
        .modal-dialog.modal-xl {
            max-width: 85%;
            width: 85%;
        }
        
        .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 1.5rem;
        }
        
        .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 1rem 1.5rem;
        }
        
        .modal-content {
            border-radius: 0.3rem;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }
        
        .modal-header .close {
            padding: 0.5rem 1rem;
            margin: -1rem -1rem -1rem auto;
            opacity: 0.8;
            font-size: 1.5rem;
        }
        
        .modal-header .close:hover {
            opacity: 1;
        }
        
        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 1.5rem;
            overflow-y: auto;
        }
        
        .modal-footer {
            padding: 1rem 1.5rem;
        }
        
        .modal-footer .btn {
            margin-left: 0.5rem;
        }
        
        /* Make checkboxes more visible and spaced */
        #designations-checkboxes .col-md-3 {
            margin-bottom: 0.75rem;
        }
        
        #designations-checkboxes .form-check {
            min-height: 32px;
            display: flex;
            align-items: center;
        }
        
        #designations-checkboxes .row {
            margin-left: 0;
            margin-right: 0;
        }
        
        /* ===== EMPLOYEE CARD STYLING ===== */
        .employee-card {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            background: white;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .employee-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0,123,255,0.2);
            transform: translateY(-2px);
        }
        
        .employee-card.employee-assigned {
            border-color: #28a745;
            background: #f0f9f4;
        }
        
        .employee-card.employee-assigned:hover {
            border-color: #28a745;
            box-shadow: 0 4px 12px rgba(40,167,69,0.3);
        }
        
        .employee-name {
            color: #333;
            font-size: 1rem;
            font-weight: 600;
        }
        
        .employee-info {
            text-align: left;
        }
        
        .employee-card-wrapper {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        /* ===== SEARCH BOX STYLING ===== */
        #employee-search-input {
            border-radius: 4px 0 0 4px;
            font-size: 0.95rem;
            border: 2px solid #ced4da;
        }
        
        #employee-search-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            outline: none;
        }
        
        #clear-search-btn {
            border: 2px solid #ced4da;
            border-left: none;
            background-color: white;
            color: #6c757d;
            transition: all 0.2s ease;
        }
        
        #clear-search-btn:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        
        #clear-search-btn:active {
            background-color: #c82333;
            border-color: #c82333;
        }
        
        #employee-count-display {
            font-weight: 600;
            color: #007bff;
        }
        
        .input-group-prepend .input-group-text {
            border: 2px solid #ced4da;
            border-right: none;
            background-color: #f8f9fa;
            color: #495057;
        }
        
        #employee-search-input:focus ~ .input-group-prepend .input-group-text {
            border-color: #007bff;
        }
        
        /* Search input group wrapper */
        .input-group {
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-radius: 6px;
        }
        
        .input-group:focus-within {
            box-shadow: 0 2px 8px rgba(0,123,255,0.15);
        }
        
        /* Clear button icon */
        #clear-search-btn .fa {
            font-size: 0.9rem;
        }
        
        /* Filter dropdown styling */
        #employee-filter-select {
            border: 2px solid #ced4da;
            font-size: 0.95rem;
            height: calc(2.5rem + 4px);
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        #employee-filter-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            outline: none;
        }
        
        #employee-filter-select option {
            padding: 8px;
            font-size: 0.95rem;
        }
        
        /* Responsive adjustments for search and filter */
        @media (max-width: 768px) {
            #employee-filter-select {
                margin-top: 10px;
            }
        }
        
        /* ===== INDICATOR CHECKBOX STYLING ===== */
        .indicator-checkboxes .form-check {
            transition: all 0.2s ease;
        }
        
        .indicator-checkboxes .form-check:hover {
            background-color: #f8f9fa !important;
            border-color: #007bff !important;
        }
        
        .indicator-checkboxes .form-check-input {
            width: 20px;
            height: 20px;
            margin-top: 0.25rem;
            cursor: pointer;
        }
        
        .indicator-checkboxes .form-check-label {
            cursor: pointer;
            margin-left: 10px;
            font-size: 1rem;
        }
        
        /* ===== INDICATOR SECTION STYLING ===== */
        .indicator-sections {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .indicator-section-item {
            transition: all 0.2s ease;
            background: white;
            border: 2px solid #e0e0e0 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .indicator-section-item:hover {
            border-color: #007bff !important;
            box-shadow: 0 4px 8px rgba(0,123,255,0.15);
        }
        
        .indicator-section-item.bg-light {
            background: #f8f9fa !important;
            border-color: #17a2b8 !important;
        }
        
        .indicator-section-item.fully-assigned {
            background: #f8d7da !important;
            border-color: #dc3545 !important;
            opacity: 0.7;
        }
        
        .section-main-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            margin-top: 0.25rem;
        }
        
        .indicator-section-item .form-check-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            cursor: pointer;
        }
        
        .indicator-section-item .badge {
            font-size: 0.85rem;
            padding: 5px 10px;
        }
        
        /* Modal backdrop enhancement for layered modals */
        #indicator-selection-modal .modal-dialog {
            z-index: 1060;
        }
        
        #indicator-selection-modal.show {
            z-index: 1055;
        }
        
        .modal-backdrop.show {
            opacity: 0.7;
        }
        
        /* Info message styling in indicator modal */
        #indicator-selection-body p.lead {
            background: #e7f3ff;
            padding: 15px 20px;
            border-left: 4px solid #17a2b8;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        
        /* Scrollbar styling for modal body */
        #indicator-selection-body::-webkit-scrollbar {
            width: 10px;
        }
        
        #indicator-selection-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        #indicator-selection-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        #indicator-selection-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        .desig-dept-combos {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
        }
        
        .desig-dept-combos .form-check {
            background: white;
            padding: 10px 15px;
            margin-bottom: 8px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }
        
        .desig-dept-combos .form-check:hover {
            border-color: #007bff;
            background-color: #f0f7ff;
        }
        
        .combo-checkbox {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        
        /* Fully assigned indicator styling */
        .fully-assigned {
            background-color: #ffe5e5 !important;
            border-color: #dc3545 !important;
            opacity: 0.7;
        }
        
        .fully-assigned .section-main-checkbox:disabled {
            cursor: not-allowed;
        }
        
        .fully-assigned label {
            color: #6c757d;
        }
        
        /* Assigned combo styling */
        .combo-assigned {
            background-color: #f8f9fa;
            border: 1px dashed #dc3545;
            padding: 8px;
            border-radius: 4px;
            opacity: 0.6;
        }
        
        .combo-assigned input:disabled {
            cursor: not-allowed;
        }
        
        .combo-assigned label {
            cursor: not-allowed;
        }
        
        /* Badge styling for assignment status */
        .badge-danger {
            background-color: #dc3545;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        
        /* Select All/Deselect All buttons */
        .select-all-combos, .deselect-all-combos, .ok-section-btn {
            font-size: 0.75rem;
            padding: 4px 10px;
            transition: all 0.2s ease;
        }
        
        .select-all-combos:hover {
            background-color: #007bff;
            color: white !important;
            border-color: #007bff;
        }
        
        .deselect-all-combos:hover {
            background-color: #6c757d;
            color: white !important;
            border-color: #6c757d;
        }
        
        .ok-section-btn {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 6px 20px;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 4px;
        }
        
        .ok-section-btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
            transform: translateY(-1px);
        }
        
        .ok-section-btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        /* Custom notification styling */
        .custom-notification {
            animation: slideInRight 0.5s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        /* ===== END BOOTSTRAP 4 MODAL FIXES ===== */
    `;
    document.head.appendChild(style);

    // Apply styling to disabled options in designation dropdown
    $('.selectpicker').on('loaded.bs.select', function() {
        $(this).closest('.bootstrap-select').find('.dropdown-menu li.disabled').addClass('disabled-option');
    });
    
    // ===== NOTIFICATION SYSTEM =====
    function showNotification(type, title, message, duration = 5000) {
        // Check if toastr is available
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: duration,
                extendedTimeOut: 2000
            };
            
            switch(type) {
                case 'success':
                    toastr.success(message, title);
                    break;
                case 'error':
                    toastr.error(message, title);
                    break;
                case 'warning':
                    toastr.warning(message, title);
                    break;
                case 'info':
                    toastr.info(message, title);
                    break;
            }
        } else {
            // Fallback to custom notification
            const alertClass = type === 'error' ? 'alert-danger' : 
                             type === 'warning' ? 'alert-warning' : 
                             type === 'success' ? 'alert-success' : 'alert-info';
            
            const notification = $(`
                <div class="alert ${alertClass} alert-dismissible fade show custom-notification" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 500px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <strong>${title}</strong><br>${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `);
            
            $('body').append(notification);
            
            setTimeout(() => {
                notification.fadeOut(500, function() {
                    $(this).remove();
                });
            }, duration);
        }
    }
    
    // ===== WIZARD MODAL FUNCTIONALITY =====
    const wizardData = {
        designations: [],
        departments: {},
        evaluators: {}
    };
    
    let currentWizardStep = 0; // Track current step: 0=not started, 1=designations, 2=departments, 3=evaluators
    
    const startWizardBtn = document.getElementById('start-wizard-btn');
    const submitBtn = document.getElementById('submit-btn');
    const wizardDataContainer = document.getElementById('wizard-data-container');
    
    // Update progress indicator
    function updateWizardProgress(step) {
        currentWizardStep = step;
        
        for (let i = 1; i <= 3; i++) {
            const stepEl = document.getElementById(`inline-step-${i}`);
            const connectors = document.querySelectorAll('.wizard-connector-inline');
            
            stepEl.classList.remove('active', 'completed');
            if (connectors[i-1]) connectors[i-1].classList.remove('completed');
            
            if (i < step) {
                stepEl.classList.add('completed');
                if (connectors[i-1]) connectors[i-1].classList.add('completed');
            } else if (i === step) {
                stepEl.classList.add('active');
            }
        }
    }
    
    // Add click handlers to progress bar steps
    function addProgressBarClickHandlers() {
        const wizardSteps = document.querySelectorAll('.wizard-step-inline');
        
        wizardSteps.forEach((step, index) => {
            step.addEventListener('click', function() {
                const targetStep = index + 1;
                
                // Can't go to a step that hasn't been unlocked
                if (targetStep > currentWizardStep && currentWizardStep < 4) {
                    return;
                }
                
                // Navigate to the selected step
                if (targetStep === 1 && wizardData.designations.length === 0 && currentWizardStep === 0) {
                    // First time clicking step 1
                    startWizardBtn.click();
                } else if (targetStep === 1) {
                    $('#designations-modal').modal('show');
                    updateWizardProgress(1);
                } else if (targetStep === 2 && wizardData.designations.length > 0) {
                    showDepartmentsModal();
                    $('#departments-modal').modal('show');
                    updateWizardProgress(2);
                } else if (targetStep === 3 && Object.keys(wizardData.departments).length > 0) {
                    updateSectionsData();
                    showEvaluatorsModal();
                    $('#evaluators-modal').modal('show');
                    updateWizardProgress(3);
                }
            });
        });
    }
    
    // Initialize click handlers after DOM is ready
    addProgressBarClickHandlers();
    
    // Start wizard
    startWizardBtn.addEventListener('click', function() {
        updateWizardProgress(1);
        $('#designations-modal').modal('show');
    });
    
    // Select/Deselect All Designations
    document.getElementById('select-all-designations').addEventListener('click', function() {
        document.querySelectorAll('.designation-checkbox:not(:disabled)').forEach(cb => cb.checked = true);
    });
    
    document.getElementById('deselect-all-designations').addEventListener('click', function() {
        document.querySelectorAll('.designation-checkbox').forEach(cb => cb.checked = false);
    });
    
    // Next to Departments
    document.getElementById('next-to-departments').addEventListener('click', function() {
        const selected = Array.from(document.querySelectorAll('.designation-checkbox:checked')).map(cb => ({
            id: cb.value,
            name: cb.parentElement.querySelector('label').textContent.trim()
        }));
        
        if (selected.length === 0) {
            showNotification('error', '<?php echo e(__("No Designation Selected")); ?>', 
                '<?php echo e(__("Please select at least one designation")); ?>');
            return;
        }
        
        wizardData.designations = selected;
        updateWizardProgress(2);
        showDepartmentsModal();
        $('#designations-modal').modal('hide');
        $('#departments-modal').modal('show');
    });
    
    // Show Departments Modal
    function showDepartmentsModal() {
        const body = document.getElementById('departments-content');
        let html = '<p><?php echo e(__("Choose departments for each selected designation")); ?></p>';
        
        wizardData.designations.forEach(desig => {
            const allDepartments = departmentsByCompany[selectedCompanyId] || [];
            
            // Find all designation records that match the selected designation name
            const matchingDesignations = allDesignationsRaw.filter(d => 
                d.designation_name === desig.name && 
                d.company_id == selectedCompanyId
            );
            
            // Get unique department IDs from those designations
            const relevantDepartmentIds = [...new Set(
                matchingDesignations
                    .map(d => d.department_id)
                    .filter(id => id != null && id != '')
            )];
            
            // Filter departments to only show those associated with this designation
            const relevantDepartments = allDepartments.filter(dept => 
                relevantDepartmentIds.includes(dept.id)
            );
            
            if (relevantDepartments.length === 0) {
                html += `
                    <div class="alert alert-warning mb-3">
                        <i class="fa fa-exclamation-triangle"></i> <?php echo e(__("No departments found for")); ?> <strong>${desig.name}</strong>
                    </div>
                `;
                return;
            }
            
            html += `
                <div class="card mb-3">
                    <div class="card-header dept-card-header" data-toggle="collapse" data-target="#collapse-${desig.id}" style="cursor: pointer;">
                        <i class="fa fa-chevron-right collapse-icon"></i>
                        <strong>${desig.name}</strong> - <?php echo e(__("Choose Departments")); ?>

                        <span class="badge badge-secondary dept-count-${desig.id}">
                            <?php echo e(__("Selected")); ?>: <span class="selected-count">0</span> / 
                            <?php echo e(__("Available")); ?>: ${relevantDepartments.length} / 
                            <?php echo e(__("Remaining")); ?>: <span class="remaining-count">${relevantDepartments.length}</span>
                        </span>
                        <div class="float-right dept-actions" style="display: inline-block;">
                            <button type="button" class="btn btn-success btn-sm select-all-dept" data-desig-id="${desig.id}" onclick="event.stopPropagation();">
                                <i class="fa fa-check-square"></i> <?php echo e(__("Select All")); ?>

                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm deselect-all-dept" data-desig-id="${desig.id}" onclick="event.stopPropagation();">
                                <i class="fa fa-square"></i> <?php echo e(__("Deselect All")); ?>

                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="collapse-${desig.id}">
                        <div class="card-body">
                            <div class="row dept-checkbox-row" id="dept-checkboxes-${desig.id}">
                                ${relevantDepartments.map(dept => {
                                // Find all designation IDs that match this designation name and department
                                const matchingDesigIds = matchingDesignations
                                    .filter(d => d.department_id == dept.id)
                                    .map(d => d.id);
                                
                                // Count employees in this department with any of these designation IDs
                                const employeeCount = allEmployees.filter(emp => 
                                    matchingDesigIds.includes(emp.designation_id) && 
                                    emp.department_id == dept.id &&
                                    emp.company_id == selectedCompanyId
                                ).length;
                                
                                return `
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input dept-checkbox dept-checkbox-${desig.id}" type="checkbox" 
                                                   value="${dept.id}" id="dept-${desig.id}-${dept.id}"
                                                   data-desig-id="${desig.id}">
                                            <label class="form-check-label" for="dept-${desig.id}-${dept.id}">
                                                ${dept.department_name}
                                                ${employeeCount > 0 ? `<span class="badge badge-secondary">${employeeCount} emp${employeeCount > 1 ? 's' : ''}</span>` : ''}
                                            </label>
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                            </div>
                            <div class="text-right mt-3">
                                <button type="button" class="btn btn-primary btn-sm dept-ok-btn" data-desig-id="${desig.id}" data-target="#collapse-${desig.id}" style="display: none;">
                                    <i class="fa fa-check"></i> <?php echo e(__("OK")); ?>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        body.innerHTML = html;
        
        // Add collapse icon rotation
        document.querySelectorAll('.dept-card-header').forEach(header => {
            header.addEventListener('click', function() {
                const icon = this.querySelector('.collapse-icon');
                icon.classList.toggle('rotated');
            });
        });
        
        // Add Select All/Deselect All handlers
        document.querySelectorAll('.select-all-dept').forEach(btn => {
            btn.addEventListener('click', function() {
                const desigId = this.getAttribute('data-desig-id');
                document.querySelectorAll(`.dept-checkbox-${desigId}`).forEach(cb => cb.checked = true);
                updateDeptOkButton(desigId);
            });
        });
        
        document.querySelectorAll('.deselect-all-dept').forEach(btn => {
            btn.addEventListener('click', function() {
                const desigId = this.getAttribute('data-desig-id');
                document.querySelectorAll(`.dept-checkbox-${desigId}`).forEach(cb => cb.checked = false);
                updateDeptOkButton(desigId);
            });
        });
        
        // Add change listeners to department checkboxes to show/hide OK button
        document.querySelectorAll('.dept-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const desigId = this.getAttribute('data-desig-id');
                updateDeptOkButton(desigId);
            });
        });
        
        // Function to update OK button visibility and count display
        function updateDeptOkButton(desigId) {
            const checkboxes = document.querySelectorAll(`.dept-checkbox-${desigId}`);
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            const okBtn = document.querySelector(`.dept-ok-btn[data-desig-id="${desigId}"]`);
            if (okBtn) {
                okBtn.style.display = anyChecked ? 'inline-block' : 'none';
            }
            
            // Update count display
            const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const totalCount = checkboxes.length;
            const remainingCount = totalCount - selectedCount;
            
            const countBadge = document.querySelector(`.dept-count-${desigId}`);
            if (countBadge) {
                const selectedSpan = countBadge.querySelector('.selected-count');
                const remainingSpan = countBadge.querySelector('.remaining-count');
                
                if (selectedSpan) selectedSpan.textContent = selectedCount;
                if (remainingSpan) remainingSpan.textContent = remainingCount;
                
                // Change badge color based on selection
                countBadge.classList.remove('badge-secondary', 'badge-success', 'badge-warning');
                if (selectedCount === 0) {
                    countBadge.classList.add('badge-secondary');
                } else if (selectedCount === totalCount) {
                    countBadge.classList.add('badge-success');
                } else {
                    countBadge.classList.add('badge-warning');
                }
            }
        }
        
        // Add OK button click handlers
        document.querySelectorAll('.dept-ok-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                $(target).collapse('hide');
                const header = document.querySelector(`.dept-card-header[data-target="${target}"]`);
                if (header) {
                    const icon = header.querySelector('.collapse-icon');
                    icon.classList.remove('rotated');
                }
            });
        });
        
        // Restore previous department selections from wizardData
        wizardData.designations.forEach(desig => {
            const selectedDepts = wizardData.departments[desig.id] || [];
            selectedDepts.forEach(deptId => {
                const checkbox = document.getElementById(`dept-${desig.id}-${deptId}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
            // Update count display for this designation
            updateDeptOkButton(desig.id);
        });
    }
    
    // Back to Designations
    document.getElementById('back-to-designations').addEventListener('click', function() {
        updateWizardProgress(1);
        $('#departments-modal').modal('hide');
        $('#designations-modal').modal('show');
    });
    
    // Next to Evaluators
    document.getElementById('next-to-evaluators').addEventListener('click', function() {
        // Collect department selections
        wizardData.departments = {};
        let hasSelection = false;
        let missingDesignations = [];
        
        wizardData.designations.forEach(desig => {
            const checked = Array.from(document.querySelectorAll(`.dept-checkbox-${desig.id}:checked`)).map(cb => cb.value);
            if (checked.length > 0) {
                wizardData.departments[desig.id] = checked;
                hasSelection = true;
            } else {
                // Track designations without department selection
                missingDesignations.push(desig.name);
            }
        });
        
        // Validate that EACH designation has at least one department
        if (missingDesignations.length > 0) {
            showNotification('error', '<?php echo e(__("Missing Department Selection")); ?>', 
                '<?php echo e(__("Please select at least one department for:")); ?> ' + missingDesignations.join(', '));
            return;
        }
        
        if (!hasSelection) {
            showNotification('error', '<?php echo e(__("No Selection")); ?>', '<?php echo e(__("Please select at least one department")); ?>');
            return;
        }
        
        updateSectionsData();
        updateWizardProgress(3);
        showEvaluatorsModal();
        $('#departments-modal').modal('hide');
        $('#evaluators-modal').modal('show');
    });
    
    // Store evaluator assignments: { employeeId: { sectionIndex: [{desigId, deptId}] } }
    let evaluatorAssignments = {};
    
    // Show Evaluators Modal - Show ALL employees (not grouped)
    function showEvaluatorsModal() {
        const body = document.getElementById('evaluators-content');
        
        // Get ALL active employees from the company (exclude ex-employees)
        const employees = allEmployees.filter(e => {
            if (e.company_id != selectedCompanyId) return false;
            
            // Filter out if is_active field is false/0
            if (e.is_active === false || e.is_active === 0 || e.is_active === '0') {
                return false;
            }
            
            // Filter out ex-employees (those with exit_date in the past)
            if (e.exit_date && e.exit_date !== '' && e.exit_date !== '0000-00-00') {
                const exitDate = new Date(e.exit_date);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                // Exclude if exit_date is in the past
                if (!isNaN(exitDate.getTime()) && exitDate < today) {
                    return false;
                }
            }
            
            // Get designation and department names to check for ex-employee
            const empDesig = allDesignationsRaw.find(d => d.id == e.designation_id);
            const desigName = empDesig ? empDesig.designation_name : '';
            
            const empDept = departmentsByCompany[selectedCompanyId]?.find(d => d.id == e.department_id);
            const deptName = empDept ? empDept.department_name : '';
            
            // Filter out if designation or department contains "ex-employee" or "ex employee"
            const desigLower = desigName.toLowerCase();
            const deptLower = deptName.toLowerCase();
            
            if (desigLower.includes('ex-employee') || desigLower.includes('ex employee') ||
                deptLower.includes('ex-employee') || deptLower.includes('ex employee')) {
                return false;
            }
            
            return true;
        });
        
        // Sort alphabetically
        employees.sort((a, b) => {
            const nameA = `${a.first_name} ${a.last_name}`;
            const nameB = `${b.first_name} ${b.last_name}`;
            return nameA.localeCompare(nameB);
        });
        
        let html = `
            <div class="mb-3">
                <p class="lead">
                    <i class="fa fa-info-circle text-info"></i> 
                    <?php echo e(__("Click on an employee to assign indicators and designation-department combinations")); ?>

                </p>
            </div>
            
            <!-- Search and Filter Box -->
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" id="employee-search-input" class="form-control" 
                                   placeholder="<?php echo e(__("Search...")); ?>">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" id="clear-search-btn">
                                    <i class="fa fa-times"></i> <?php echo e(__("Clear")); ?>

                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select id="employee-filter-select" class="form-control">
                            <option value="all"><?php echo e(__("Search All")); ?></option>
                            <option value="name"><?php echo e(__("By Name")); ?></option>
                            <option value="designation"><?php echo e(__("By Designation")); ?></option>
                            <option value="department"><?php echo e(__("By Department")); ?></option>
                        </select>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted">
                        <span id="employee-count-display">${employees.length}</span> <?php echo e(__("employee(s) found")); ?>

                    </small>
                </div>
            </div>
            
            <div class="employee-list">
                <div class="row" id="employee-cards-container">
        `;
        
        employees.forEach(emp => {
            const empDesig = allDesignationsRaw.find(d => d.id == emp.designation_id);
            const desigName = empDesig ? empDesig.designation_name : '<?php echo e(__("No Designation")); ?>';
            
            const empDept = departmentsByCompany[selectedCompanyId]?.find(d => d.id == emp.department_id);
            const deptName = empDept ? empDept.department_name : '<?php echo e(__("No Department")); ?>';
            
            // Calculate total assignments for this employee
            let totalAssignments = 0;
            if (evaluatorAssignments[emp.id]) {
                Object.keys(evaluatorAssignments[emp.id]).forEach(sectionIndex => {
                    totalAssignments += evaluatorAssignments[emp.id][sectionIndex].length;
                });
            }
            const isAssigned = totalAssignments > 0;
            
            html += `
                <div class="col-md-4 col-lg-3 mb-3 employee-card-wrapper" 
                     data-employee-name="${emp.first_name} ${emp.last_name}"
                     data-designation="${desigName}"
                     data-department="${deptName}">
                    <div class="employee-card ${isAssigned ? 'employee-assigned' : ''}" 
                         data-employee-id="${emp.id}"
                         style="cursor: pointer;">
                        <div class="employee-info">
                            <h6 class="employee-name mb-1">
                                <i class="fa fa-user-circle"></i> 
                                ${emp.first_name} ${emp.last_name}
                            </h6>
                            <small class="text-muted d-block">${desigName}</small>
                            <small class="text-muted"><i class="fa fa-building"></i> ${deptName}</small>
                            ${isAssigned ? `
                                <div class="mt-2">
                                    <span class="badge badge-success">
                                        <i class="fa fa-check"></i> ${totalAssignments} assignment(s)
                                    </span>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += `
                </div>
            </div>
        `;
        
        body.innerHTML = html;
        
        // Add click handlers to employee cards
        document.querySelectorAll('.employee-card').forEach(card => {
            card.addEventListener('click', function() {
                const employeeId = this.getAttribute('data-employee-id');
                openIndicatorSelectionModal(employeeId);
            });
        });
        
        // Add search and filter functionality
        const searchInput = document.getElementById('employee-search-input');
        const filterSelect = document.getElementById('employee-filter-select');
        const clearBtn = document.getElementById('clear-search-btn');
        const countDisplay = document.getElementById('employee-count-display');
        
        function filterEmployees() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const searchBy = filterSelect.value;
            const employeeWrappers = document.querySelectorAll('.employee-card-wrapper');
            let visibleCount = 0;
            
            employeeWrappers.forEach(wrapper => {
                const name = wrapper.getAttribute('data-employee-name').toLowerCase();
                const designation = wrapper.getAttribute('data-designation').toLowerCase();
                const department = wrapper.getAttribute('data-department').toLowerCase();
                
                let matches = false;
                
                if (!searchTerm) {
                    // If no search term, show all employees
                    matches = true;
                } else {
                    // Search based on selected field
                    switch (searchBy) {
                        case 'name':
                            // Search only in name
                            matches = name.includes(searchTerm);
                            break;
                        case 'designation':
                            // Search only in designation
                            matches = designation.includes(searchTerm);
                            break;
                        case 'department':
                            // Search only in department
                            matches = department.includes(searchTerm);
                            break;
                        default:
                            // 'all' - Search in name, designation, and department
                            matches = name.includes(searchTerm) || 
                                     designation.includes(searchTerm) || 
                                     department.includes(searchTerm);
                            break;
                    }
                }
                
                if (matches) {
                    wrapper.style.display = '';
                    visibleCount++;
                } else {
                    wrapper.style.display = 'none';
                }
            });
            
            countDisplay.textContent = visibleCount;
        }
        
        searchInput.addEventListener('input', filterEmployees);
        filterSelect.addEventListener('change', filterEmployees);
        
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            filterSelect.value = 'all';
            filterEmployees();
            searchInput.focus();
        });
        
        // Check assignment completeness when modal is shown
        setTimeout(() => checkAssignmentCompleteness(), 100);
    }
    
    // Open indicator selection modal for an employee
    function openIndicatorSelectionModal(employeeId) {
        const employee = allEmployees.find(e => e.id == employeeId);
        if (!employee) return;
        
        // Update modal title
        const modalTitle = document.getElementById('indicator-modal-title');
        modalTitle.innerHTML = `<?php echo e(__('Assign Indicators for')); ?> <strong>${employee.first_name} ${employee.last_name}</strong>`;
        
        // Get current assignments for this employee
        const currentAssignments = evaluatorAssignments[employeeId] || {};
        
        // Build all designation-department combinations
        let desigDeptCombos = [];
        wizardData.designations.forEach(desig => {
            const depts = wizardData.departments[desig.id] || [];
            depts.forEach(deptId => {
                const dept = departmentsByCompany[selectedCompanyId]?.find(d => d.id == deptId);
                if (dept) {
                    desigDeptCombos.push({
                        desigId: desig.id,
                        desigName: desig.name,
                        deptId: deptId,
                        deptName: dept.department_name
                    });
                }
            });
        });
        
        // Check which section-combo pairs are already assigned to OTHER employees
        function isComboAssignedToOther(sectionIndex, desigId, deptId) {
            for (const [otherEmpId, assignments] of Object.entries(evaluatorAssignments)) {
                // Skip current employee
                if (otherEmpId == employeeId) continue;
                
                // Check if this employee has this section
                if (assignments[sectionIndex]) {
                    // Check if they have this specific combo
                    const hasCombo = assignments[sectionIndex].some(c => 
                        c.desigId == desigId && c.deptId == deptId
                    );
                    
                    if (hasCombo) {
                        const otherEmp = allEmployees.find(e => e.id == otherEmpId);
                        return otherEmp ? `${otherEmp.first_name} ${otherEmp.last_name}` : 'Another employee';
                    }
                }
            }
            return null;
        }
        
        // Build indicator selection UI
        let html = `
            <p class="lead">
                <i class="fa fa-info-circle"></i> 
                <?php echo e(__('Select indicators and choose which designation-department combinations to evaluate')); ?>

            </p>
            <div class="indicator-sections">
        `;
        
        sections.forEach(section => {
            // Check if this section is assigned and get its combos
            const assignedCombos = currentAssignments[section.index] || [];
            const isChecked = assignedCombos.length > 0;
            
            // Check how many combos are available (not assigned to others)
            const availableCombos = desigDeptCombos.filter(combo => 
                !isComboAssignedToOther(section.index, combo.desigId, combo.deptId)
            );
            
            const allCombosAssigned = availableCombos.length === 0;
            const someAssigned = availableCombos.length < desigDeptCombos.length;
            
            html += `
                <div class="indicator-section-item border rounded p-3 ${isChecked ? 'bg-light' : ''} ${allCombosAssigned ? 'fully-assigned' : ''}">
                    <div class="form-check mb-2">
                        <input class="form-check-input section-main-checkbox" type="checkbox" 
                               value="${section.index}" id="section-main-${section.index}"
                               data-section-index="${section.index}"
                               ${isChecked ? 'checked' : ''}
                               ${allCombosAssigned ? 'disabled' : ''}>
                        <label class="form-check-label font-weight-bold ml-2" for="section-main-${section.index}">
                            ${section.name}
                            <span class="badge badge-secondary ml-2">${section.weightage}%</span>
                            ${allCombosAssigned ? '<span class="badge badge-danger ml-2"><i class="fa fa-lock"></i> Fully Assigned</span>' : ''}
                            ${someAssigned && !allCombosAssigned ? '<span class="badge badge-warning ml-2"><i class="fa fa-info-circle"></i> Partially Assigned</span>' : ''}
                        </label>
                    </div>
                    
                    <div class="desig-dept-combos ml-4 ${isChecked ? '' : 'd-none'}" id="combos-${section.index}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">
                                <i class="fa fa-arrow-right"></i> <?php echo e(__('Select designation-department combinations:')); ?>

                            </small>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-primary btn-sm select-all-combos" data-section-index="${section.index}" ${allCombosAssigned ? 'disabled' : ''}>
                                    <i class="fa fa-check-square"></i> <?php echo e(__('Select All')); ?>

                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm deselect-all-combos" data-section-index="${section.index}">
                                    <i class="fa fa-square"></i> <?php echo e(__('Deselect All')); ?>

                                </button>
                            </div>
                        </div>
                        <div>
                            ${desigDeptCombos.map(combo => {
                                const comboKey = `${combo.desigId}_${combo.deptId}`;
                                const isComboChecked = assignedCombos.some(c => c.desigId == combo.desigId && c.deptId == combo.deptId);
                                const assignedTo = isComboAssignedToOther(section.index, combo.desigId, combo.deptId);
                                const isDisabled = assignedTo !== null;
                                
                                return `
                                    <div class="form-check form-check-inline mr-3 mb-2 ${isDisabled ? 'combo-assigned' : ''}">
                                        <input class="form-check-input combo-checkbox" type="checkbox" 
                                               value="${comboKey}" 
                                               id="combo-${section.index}-${comboKey}"
                                               data-section-index="${section.index}"
                                               data-desig-id="${combo.desigId}"
                                               data-dept-id="${combo.deptId}"
                                               ${isComboChecked ? 'checked' : ''}
                                               ${isDisabled ? 'disabled' : ''}>
                                        <label class="form-check-label ${isDisabled ? 'text-muted' : ''}" for="combo-${section.index}-${comboKey}">
                                            <small>
                                                ${combo.desigName} - ${combo.deptName}
                                                ${isDisabled ? `<br><span class="text-danger" style="font-size: 0.75rem;"><i class="fa fa-user"></i> Assigned to: ${assignedTo}</span>` : ''}
                                            </small>
                                        </label>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                        <div class="text-right mt-2">
                            <button type="button" class="btn btn-primary btn-sm ok-section-btn" data-section-index="${section.index}">
                                <i class="fa fa-check"></i> <?php echo e(__('OK')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        
        document.getElementById('indicator-selection-body').innerHTML = html;
        
        // Add event listeners for main checkboxes
        document.querySelectorAll('.section-main-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const sectionIndex = this.getAttribute('data-section-index');
                const combosDiv = document.getElementById(`combos-${sectionIndex}`);
                
                if (this.checked) {
                    combosDiv.classList.remove('d-none');
                } else {
                    combosDiv.classList.add('d-none');
                    // Uncheck all combo checkboxes
                    combosDiv.querySelectorAll('.combo-checkbox').forEach(cb => cb.checked = false);
                }
            });
        });
        
        // Add event listeners for Select All buttons
        document.querySelectorAll('.select-all-combos').forEach(btn => {
            btn.addEventListener('click', function() {
                const sectionIndex = this.getAttribute('data-section-index');
                const combosDiv = document.getElementById(`combos-${sectionIndex}`);
                // Only select non-disabled checkboxes
                combosDiv.querySelectorAll('.combo-checkbox:not(:disabled)').forEach(cb => cb.checked = true);
            });
        });
        
        // Add event listeners for Deselect All buttons
        document.querySelectorAll('.deselect-all-combos').forEach(btn => {
            btn.addEventListener('click', function() {
                const sectionIndex = this.getAttribute('data-section-index');
                const combosDiv = document.getElementById(`combos-${sectionIndex}`);
                combosDiv.querySelectorAll('.combo-checkbox').forEach(cb => cb.checked = false);
            });
        });
        
        // Add event listeners for OK buttons to collapse sections
        document.querySelectorAll('.ok-section-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const sectionIndex = this.getAttribute('data-section-index');
                const combosDiv = document.getElementById(`combos-${sectionIndex}`);
                
                // Check if any combos are selected
                const anySelected = Array.from(combosDiv.querySelectorAll('.combo-checkbox')).some(cb => cb.checked);
                
                if (anySelected) {
                    // Collapse the section
                    combosDiv.classList.add('d-none');
                    
                    // Show a brief animation
                    const parentSection = combosDiv.closest('.indicator-section-item');
                    if (parentSection) {
                        parentSection.style.transition = 'all 0.3s ease';
                        parentSection.style.backgroundColor = '#e8f5e9';
                        setTimeout(() => {
                            parentSection.style.backgroundColor = '';
                        }, 500);
                    }
                } else {
                    // Show warning if nothing selected
                    showNotification('warning', '<?php echo e(__("No Selection")); ?>', 
                        '<?php echo e(__("Please select at least one designation-department combination before closing.")); ?>', 3000);
                }
            });
        });
        
        // Store context for save button
        window.currentIndicatorSelection = {
            employeeId
        };
        
        // Show the modal
        $('#indicator-selection-modal').modal('show');
    }
    
    // Function to check if all assignments are complete
    function checkAssignmentCompleteness() {
        // Build the evaluators object
        const tempEvaluators = {};
        Object.keys(evaluatorAssignments).forEach(empId => {
            const employeeAssignments = evaluatorAssignments[empId];
            Object.keys(employeeAssignments).forEach(sectionIndex => {
                const combos = employeeAssignments[sectionIndex];
                combos.forEach(combo => {
                    const key = `${sectionIndex}_${combo.desigId}_${combo.deptId}`;
                    tempEvaluators[key] = empId;
                });
            });
        });
        
        // Check for missing assignments
        let missingCount = 0;
        wizardData.designations.forEach(desig => {
            const depts = wizardData.departments[desig.id] || [];
            depts.forEach(deptId => {
                sections.forEach(section => {
                    const key = `${section.index}_${desig.id}_${deptId}`;
                    if (!tempEvaluators[key]) {
                        missingCount++;
                    }
                });
            });
        });
        
        // Update finish button state
        const finishBtn = document.getElementById('finish-wizard');
        if (finishBtn) {
            if (missingCount > 0) {
                finishBtn.classList.remove('btn-success');
                finishBtn.classList.add('btn-secondary');
                finishBtn.title = `<?php echo e(__("Cannot finish - ")); ?>${missingCount}<?php echo e(__(" assignment(s) missing")); ?>`;
            } else {
                finishBtn.classList.remove('btn-secondary');
                finishBtn.classList.add('btn-success');
                finishBtn.title = '<?php echo e(__("All assignments complete - Click to finish")); ?>';
            }
        }
        
        return missingCount === 0;
    }
    
    // Save indicator selection
    document.getElementById('save-indicator-selection').addEventListener('click', function() {
        const { employeeId } = window.currentIndicatorSelection;
        
        // Initialize employee assignments
        evaluatorAssignments[employeeId] = {};
        
        // Process each section
        document.querySelectorAll('.section-main-checkbox:checked').forEach(sectionCheckbox => {
            const sectionIndex = sectionCheckbox.getAttribute('data-section-index');
            
            // Get all selected combos for this section
            const selectedCombos = [];
            document.querySelectorAll(`.combo-checkbox[data-section-index="${sectionIndex}"]:checked`).forEach(comboCheckbox => {
                const desigId = comboCheckbox.getAttribute('data-desig-id');
                const deptId = comboCheckbox.getAttribute('data-dept-id');
                
                selectedCombos.push({
                    desigId: parseInt(desigId),
                    deptId: parseInt(deptId)
                });
            });
            
            // Only save if there are combos selected
            if (selectedCombos.length > 0) {
                evaluatorAssignments[employeeId][sectionIndex] = selectedCombos;
            }
        });
        
        // Remove employee from assignments if no sections selected
        if (Object.keys(evaluatorAssignments[employeeId]).length === 0) {
            delete evaluatorAssignments[employeeId];
        }
        
        // Get employee name for notification
        const employee = allEmployees.find(e => e.id == employeeId);
        const employeeName = employee ? `${employee.first_name} ${employee.last_name}` : 'Employee';
        
        // Close modal and refresh display
        $('#indicator-selection-modal').modal('hide');
        showEvaluatorsModal();
        
        // Check assignment completeness and update finish button
        checkAssignmentCompleteness();
        
        // Show success notification
        const assignmentCount = Object.keys(evaluatorAssignments[employeeId] || {}).length;
        if (assignmentCount > 0) {
            showNotification('success', '<?php echo e(__("Assignment Saved")); ?>', 
                `<?php echo e(__("Successfully assigned indicators to")); ?> ${employeeName}`, 3000);
        } else {
            showNotification('info', '<?php echo e(__("Assignments Cleared")); ?>', 
                `<?php echo e(__("All assignments removed for")); ?> ${employeeName}`, 3000);
        }
    });
    
    // Back to Departments from Evaluators
    document.getElementById('back-to-departments-from-evaluators').addEventListener('click', function() {
        updateWizardProgress(2);
        $('#evaluators-modal').modal('hide');
        $('#departments-modal').modal('show');
    });
    
    // Finish Wizard
    document.getElementById('finish-wizard').addEventListener('click', function() {
        // Check if there are any assignments
        if (Object.keys(evaluatorAssignments).length === 0) {
            showNotification('warning', '<?php echo e(__("No Evaluators Assigned")); ?>', 
                '<?php echo e(__("Please assign at least one evaluator before finishing")); ?>');
            return;
        }
        
        // Transform evaluatorAssignments to wizardData.evaluators format
        // Structure: evaluatorAssignments[employeeId][sectionIndex] = [{desigId, deptId}]
        // Output: wizardData.evaluators[`${sectionIndex}_${desigId}_${deptId}`] = employeeId
        
        wizardData.evaluators = {};
        
        Object.keys(evaluatorAssignments).forEach(empId => {
            const employeeAssignments = evaluatorAssignments[empId];
            
            Object.keys(employeeAssignments).forEach(sectionIndex => {
                const combos = employeeAssignments[sectionIndex];
                
                combos.forEach(combo => {
                    const key = `${sectionIndex}_${combo.desigId}_${combo.deptId}`;
                    wizardData.evaluators[key] = empId;
                });
            });
        });
        
        // Validate that all required sections have evaluators
        let missingInfo = [];
        wizardData.designations.forEach(desig => {
            const depts = wizardData.departments[desig.id] || [];
            
            depts.forEach(deptId => {
                sections.forEach(section => {
                    const key = `${section.index}_${desig.id}_${deptId}`;
                    if (!wizardData.evaluators[key]) {
                        const dept = departmentsByCompany[selectedCompanyId]?.find(d => d.id == deptId);
                        const deptName = dept ? dept.department_name : 'Unknown';
                        missingInfo.push(`${section.name} - ${desig.name} - ${deptName}`);
                    }
                });
            });
        });
        
        if (missingInfo.length > 0) {
            // Show error notification with detailed missing info and prevent finishing
            const missingList = missingInfo.slice(0, 5).join('<br>');
            const moreCount = missingInfo.length > 5 ? ` (+${missingInfo.length - 5} more)` : '';
            
            showNotification('error', '<?php echo e(__("Cannot Finish - Incomplete Assignments")); ?>', 
                `<?php echo e(__("All sections must have evaluators assigned because each section has a weightage that contributes to 100%.")); ?>

<br><br><strong><?php echo e(__("Missing assignments:")); ?></strong><br>${missingList}${moreCount}
<br><br><?php echo e(__("Please assign evaluators to all sections before finishing.")); ?>`, 10000);
            
            // Do not continue - return early to prevent finishing
            return;
        }
        
        // Create hidden form fields
        createFormFields();
        
        // Update progress - all completed
        updateWizardProgress(4);
        
        // Show submit button
        submitBtn.style.display = 'inline-block';
        startWizardBtn.style.display = 'none';
        
        $('#evaluators-modal').modal('hide');
        
        // Show beautiful success message
        setTimeout(() => {
            // Scroll to submit button
            submitBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Add pulse animation to submit button
            submitBtn.classList.add('pulse-animation');
            setTimeout(() => submitBtn.classList.remove('pulse-animation'), 2000);
            
            // Show toast notification if available, otherwise use subtle alert
            if (typeof toastr !== 'undefined') {
                toastr.success('<?php echo e(__("All steps completed! Click Finish & Submit to save your appraisal.")); ?>', '<?php echo e(__("Wizard Completed")); ?>', {
                    timeOut: 5000,
                    closeButton: true,
                    progressBar: true
                });
            } else {
                // Create custom notification
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    padding: 20px 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
                    z-index: 10000;
                    animation: slideInRight 0.5s ease;
                    max-width: 400px;
                `;
                notification.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="fa fa-check-circle" style="font-size: 2rem;"></i>
                        <div>
                            <h5 style="margin: 0 0 5px 0; color: white;"><?php echo e(__("Wizard Completed!")); ?></h5>
                            <p style="margin: 0; font-size: 0.9rem;"><?php echo e(__("Click Finish & Submit to save your appraisal.")); ?></p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" style="
                            background: none;
                            border: none;
                            color: white;
                            font-size: 1.5rem;
                            cursor: pointer;
                            padding: 0;
                            margin-left: auto;
                        ">&times;</button>
                    </div>
                `;
                document.body.appendChild(notification);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.style.animation = 'slideOutRight 0.5s ease';
                    setTimeout(() => notification.remove(), 500);
                }, 5000);
            }
        }, 500);
    });
    
    // Create hidden form fields for submission
    function createFormFields() {
        wizardDataContainer.innerHTML = '';
        
        // Add designation IDs
        wizardData.designations.forEach(desig => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'designation_ids[]';
            input.value = desig.id;
            wizardDataContainer.appendChild(input);
        });
        
        // Add departments
        Object.keys(wizardData.departments).forEach(desigId => {
            wizardData.departments[desigId].forEach(deptId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `departments[${desigId}][]`;
                input.value = deptId;
                wizardDataContainer.appendChild(input);
            });
        });
        
        // Add evaluators
        Object.keys(wizardData.evaluators).forEach(key => {
            const [sectionId, designationId, departmentId] = key.split('_');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `section_evaluators[${sectionId}][${designationId}][${departmentId}]`;
            input.value = wizardData.evaluators[key];
            wizardDataContainer.appendChild(input);
        });
        
        // Create designation_departments JSON (CRITICAL for backend)
        const designationData = [];
        
        wizardData.designations.forEach(designation => {
            const designationObj = allDesignations.find(d => d.id == designation.id);
            if (!designationObj) return;
            
            const designationId = designation.id;
            const departmentIds = wizardData.departments[designationId] || [];
            
            if (departmentIds.length === 0) return;
            
            const departments = departmentsByCompany[selectedCompanyId] || [];
            const departmentData = departmentIds.map(deptId => {
                const dept = departments.find(d => d.id == deptId);
                return {
                    id: deptId,
                    name: dept ? dept.department_name : 'Unknown Department'
                };
            });
            
            const employeeSelections = {};
            sections.forEach(section => {
                employeeSelections[section.index] = {};
                
                departmentIds.forEach(deptId => {
                    const key = `${section.index}_${designationId}_${deptId}`;
                    const employeeId = wizardData.evaluators[key];
                    if (employeeId) {
                        employeeSelections[section.index][deptId] = employeeId;
                    }
                });
            });
            
            designationData.push({
                designation_id: designationId,
                designation_name: designationObj.designation_name,
                departments: departmentData,
                employees: employeeSelections
            });
        });
        
        const jsonInput = document.createElement('input');
        jsonInput.type = 'hidden';
        jsonInput.name = 'designation_departments';
        jsonInput.value = JSON.stringify(designationData);
        wizardDataContainer.appendChild(jsonInput);
        
        console.log('Form fields created:', designationData);
    }
    // ===== END WIZARD MODAL FUNCTIONALITY =====
});
</script><?php /**PATH D:\project\Laravel\crm-multi-colab-Dawood\resources\views/settings/variables/partials/add_appraisal.blade.php ENDPATH**/ ?>