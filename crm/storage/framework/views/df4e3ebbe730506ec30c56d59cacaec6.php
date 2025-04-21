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
                <!-- Designation Selection -->
                <div class="form-group">
                    <label for="designation_ids"><?php echo e(__('Appraisal Designations')); ?></label>
                    <select name="designation_ids[]" id="designation_ids" class="form-control selectpicker" 
                            multiple data-live-search="true" required>
                        <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isUsed = in_array($designation->id, $existingDesignationIds);
                                $disabled = $isUsed ? 'disabled' : '';
                                $title = $isUsed ? ' - Already assigned' : '';
                            ?>
                            <option value="<?php echo e($designation->id); ?>" <?php echo e($disabled); ?> data-content="<?php echo e($designation->designation_name); ?><?php echo e($title); ?><?php echo e($isUsed ? ' <span class=\'text-danger\'>(Already assigned)</span>' : ''); ?>">
                                <?php echo e($designation->designation_name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="form-text text-muted">Designations that are already assigned in other appraisal types are not selectable.</small>
                </div>

                <!-- Departments and Evaluators -->
                <div id="designations-container" class="mt-4">
                    <!-- Designation groups will be added here dynamically -->
                </div>

                <div class="mt-4">
                    <button type="button" id="back-to-step1-btn" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> <?php echo e(__('Back to Sections')); ?>

                    </button>
                    <button type="submit" id="submit-btn" class="btn btn-primary float-right">
                        <?php echo e(__('Submit')); ?>

                    </button>
                </div>
            </div>
        </form>
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
        weightageInput.addEventListener('change', function() {
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
    
    // Designation selection change handler
    designationIdsSelect.addEventListener('change', function() {
        // Get selected designations
        const selectedDesignations = $(this).val() || [];
        
        // Clear existing designation containers
        designationsContainer.innerHTML = '';
        
        if (selectedDesignations.length === 0) {
            return;
        }
        
        // Create designation groups for each selected designation
        selectedDesignations.forEach(designationId => {
            // Find designation info
            const designation = allDesignations.find(d => d.id == designationId);
            if (!designation) return;
            
            // Create designation group container
            const designationGroup = document.createElement('div');
            designationGroup.classList.add('designation-group');
            designationGroup.dataset.designationId = designationId;
            
            // Create label and department select
            const designationHeader = document.createElement('div');
            designationHeader.innerHTML = `
                <label>${designation.designation_name} - <?php echo e(__('Choose Departments')); ?></label>
                <select name="departments[${designationId}][]" class="form-control selectpicker department-select" 
                        multiple data-live-search="true" 
                        title="<?php echo e(__('Select Departments for')); ?> ${designation.designation_name}...">
                </select>
            `;
            designationGroup.appendChild(designationHeader);
            
            // Create container for departments
            const departmentEvaluatorsContainer = document.createElement('div');
            departmentEvaluatorsContainer.classList.add('department-evaluators-container');
            designationGroup.appendChild(departmentEvaluatorsContainer);
            
            // Add designation group to the container
            designationsContainer.appendChild(designationGroup);
            
            // Get departments for company
            const departments = departmentsByCompany[selectedCompanyId] || [];
            const departmentSelect = designationGroup.querySelector('.department-select');
            
            // Add departments to select
            departments.forEach(dept => {
                const option = document.createElement('option');
                option.value = dept.id;
                option.textContent = dept.department_name;
                departmentSelect.appendChild(option);
            });
            
            // Initialize selectpicker
            $(departmentSelect).selectpicker();
            
            // Handle department selection change
            departmentSelect.addEventListener('change', function() {
                // Get selected departments
                const selectedDepartments = $(this).val() || [];
                
                // Clear existing evaluator containers
                departmentEvaluatorsContainer.innerHTML = '';
                
                if (selectedDepartments.length === 0) {
                    return;
                }
                
                // For each selected department, create evaluator dropdowns for each section
                selectedDepartments.forEach(deptId => {
                    const dept = departments.find(d => d.id == deptId);
                    if (!dept) return;
                    
                    // Create department container
                    const departmentContainer = document.createElement('div');
                    departmentContainer.classList.add('department-container', 'card', 'mb-3', 'p-3');
                    departmentContainer.dataset.departmentId = deptId;
                    
                    // Add department header
                    const departmentHeader = document.createElement('h6');
                    departmentHeader.textContent = dept.department_name;
                    departmentHeader.classList.add('mb-3', 'font-weight-bold', 'border-bottom', 'pb-2');
                    departmentContainer.appendChild(departmentHeader);
                    
                    // Update and get all current sections from the DOM
                    updateSectionsData();
                    
                    // For each section, create an evaluator dropdown
                    sections.forEach(section => {
                        // Create evaluator section container
                        const evaluatorSection = document.createElement('div');
                        evaluatorSection.classList.add('evaluator-section', 'mb-3');
                        
                        // Add section title
                        const sectionTitle = document.createElement('div');
                        sectionTitle.classList.add('evaluator-section-title', 'font-weight-bold');
                        sectionTitle.textContent = section.name || `Section ${section.index}`;
                        evaluatorSection.appendChild(sectionTitle);
                        
                        // Create evaluator select
                        const formGroup = document.createElement('div');
                        formGroup.classList.add('form-group', 'mb-2');
                        
                        const label = document.createElement('label');
                        label.textContent = '<?php echo e(__("Select Evaluator")); ?>';
                        label.classList.add('text-muted', 'small');
                        formGroup.appendChild(label);
                        
                        const select = document.createElement('select');
                        select.name = `section_evaluators[${section.index}][${designationId}][${dept.id}]`;
                        select.classList.add('form-control', 'selectpicker', 'evaluator-select');
                        select.setAttribute('data-live-search', 'true');
                        select.required = true;
                        
                        // Add empty option
                        const emptyOption = document.createElement('option');
                        emptyOption.value = '';
                        emptyOption.textContent = '<?php echo e(__("Select Evaluator")); ?>';
                        select.appendChild(emptyOption);
                        
                        // Get employees for the department and company
                        const employees = allEmployees.filter(e => 
                            e.company_id == selectedCompanyId
                        );
                        
                        // Sort employees alphabetically
                        employees.sort((a, b) => {
                            const nameA = `${a.first_name} ${a.last_name}`;
                            const nameB = `${b.first_name} ${b.last_name}`;
                            return nameA.localeCompare(nameB);
                        });
                        
                        // Add employees to select dropdown
                        employees.forEach(emp => {
                            const option = document.createElement('option');
                            option.value = emp.id;
                            
                            // Format employee name
                            let displayName = `${emp.first_name} ${emp.last_name}`;
                            
                            // Highlight employees from the same department
                            if (emp.department_id == dept.id) {
                                displayName += ` (${dept.department_name})`;
                                option.setAttribute('data-content', `<span class="text-primary font-weight-bold">${displayName}</span>`);
                            } else {
                                // Show department for other employees
                                const empDept = departments.find(d => d.id == emp.department_id);
                                const deptName = empDept ? empDept.department_name : '<?php echo e(__("No Department")); ?>';
                                displayName += ` (${deptName})`;
                            }
                            
                            option.textContent = displayName;
                            select.appendChild(option);
                        });
                        
                        formGroup.appendChild(select);
                        evaluatorSection.appendChild(formGroup);
                        
                        // Add indicators preview
                        const indicators = document.querySelectorAll(`[name="indicators[${section.index}][]"]`);
                        if (indicators.length > 0) {
                            const indicatorsPreview = document.createElement('div');
                            indicatorsPreview.classList.add('indicators-preview', 'small', 'text-muted', 'pl-3', 'border-left');
                            
                            const indicatorsList = document.createElement('ul');
                            indicatorsList.classList.add('mb-0', 'pl-3');
                            
                            indicators.forEach(indicator => {
                                if (indicator.value.trim()) {
                                    const li = document.createElement('li');
                                    li.textContent = indicator.value;
                                    indicatorsList.appendChild(li);
                                }
                            });
                            
                            if (indicatorsList.children.length > 0) {
                                const indicatorsTitle = document.createElement('small');
                                indicatorsTitle.classList.add('font-italic');
                                indicatorsTitle.textContent = '<?php echo e(__("Indicators")); ?>:';
                                
                                indicatorsPreview.appendChild(indicatorsTitle);
                                indicatorsPreview.appendChild(indicatorsList);
                                evaluatorSection.appendChild(indicatorsPreview);
                            }
                        }
                        
                        departmentContainer.appendChild(evaluatorSection);
                    });
                    
                    // Add department container to department evaluators container
                    departmentEvaluatorsContainer.appendChild(departmentContainer);
                });
                
                // Initialize all selectpickers
                $(departmentEvaluatorsContainer).find('.selectpicker').selectpicker();
            });
        });
    });

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
    `;
    document.head.appendChild(style);

    // Apply styling to disabled options in designation dropdown
    $('.selectpicker').on('loaded.bs.select', function() {
        $(this).closest('.bootstrap-select').find('.dropdown-menu li.disabled').addClass('disabled-option');
    });
});
</script><?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/settings/variables/partials/add_appraisal.blade.php ENDPATH**/ ?>