<!-- This is the individual section.blade.php partial -->
<div class="section-container" data-section-id="<?php echo e($section['id']); ?>">
    <!-- Hidden JSON Input -->
    <input type="hidden" name="sections[<?php echo e($section['id']); ?>][id]" value="<?php echo e($section['id']); ?>">
    <input type="hidden" name="sections[<?php echo e($section['id']); ?>][company_id]" value="<?php echo e($section['company_id']); ?>" class="section-title-input" required>

    <!-- Section Header -->
    <div class="section-header">
        <div class="section-title-wrapper">
            <i class="bi bi-folder section-icon"></i>
            
            <!-- Editable Section Name -->
            <div>
                <label for="">Section Name</label>
                <input type="text" name="sections[<?php echo e($section['id']); ?>][name]" value="<?php echo e($section['name']); ?>" class="section-title-input" required>
            </div>

            <div>
                <label for="">Section Weightage (%)</label>
                <input type="number" name="sections[<?php echo e($section['id']); ?>][weightage]" value="<?php echo e($section['weightage']); ?>" min="0" max="100" class="section-title-input section-weightage" onchange="validateWeightage()" required>
            </div>
        </div>
    </div>

    <!-- Section Content --> 
    <div class="section-content">
        <!-- Performance Indicators -->
        <div class="indicators-section">
            <h4 class="indicators-title">
                <i class="bi bi-list-check"></i>
                Performance Indicators
                <button type="button" class="btn btn-sm btn-primary add-indicator-btn" onclick="addNewIndicator(this)">
                    <i class="bi bi-plus"></i> Add Indicator
                </button>
            </h4>

            <!-- Evaluation Matrix - Keep only this one -->
            <div class="evaluation-matrix mt-3">
                <label for="" class="fw-bold">Evaluation Matrix</label>
                <div class="department-evaluator-container">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 45%;">Department</th>
                                    <th style="width: 45%;">Evaluator</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="evaluationMatrixBody_<?php echo e($section['id']); ?>">
                                <!-- Initial departments - either from existing data or empty row -->
                                <?php
                                    // Get department IDs and evaluator IDs from the section
                                    $departmentIds = isset($section['department_id']) ? 
                                        (is_array($section['department_id']) ? $section['department_id'] : json_decode($section['department_id'], true)) : [];
                                    $evaluatorIds = isset($section['evaluate_by']) ? 
                                        (is_array($section['evaluate_by']) ? $section['evaluate_by'] : json_decode($section['evaluate_by'], true)) : [];
                                    
                                    // Create a mapping between departments and evaluators
                                    $departmentEvaluatorMapping = [];
                                    if (isset($section['department_names']) && isset($section['evaluator_names'])) {
                                        foreach ($section['department_names'] as $index => $deptName) {
                                            // Find department ID for this name
                                            foreach ($departments as $dept) {
                                                if ($dept->department_name == $deptName) {
                                                    $deptId = $dept->id;
                                                    // Find evaluator ID for this name
                                                    $evaluatorName = $section['evaluator_names'][$index] ?? 'N/A';
                                                    $evalId = null;
                                                    foreach ($employees as $emp) {
                                                        $empFullName = $emp->first_name . ' ' . $emp->last_name;
                                                        if ($empFullName == $evaluatorName) {
                                                            $evalId = $emp->id;
                                                            break;
                                                        }
                                                    }
                                                    $departmentEvaluatorMapping[$deptId] = $evalId;
                                                    break;
                                                }
                                            }
                                        }
                                    } elseif (!empty($departmentIds) && !empty($evaluatorIds)) {
                                        // If we just have IDs but no names, try to map them
                                        if (is_array($departmentIds) && is_array($evaluatorIds)) {
                                            for ($i = 0; $i < count($departmentIds); $i++) {
                                                if (isset($evaluatorIds[$i])) {
                                                    $departmentEvaluatorMapping[$departmentIds[$i]] = $evaluatorIds[$i];
                                                }
                                            }
                                        }
                                    }
                                ?>
                                
                                <?php if(!empty($departmentEvaluatorMapping)): ?>
                                    <?php $__currentLoopData = $departmentEvaluatorMapping; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deptId => $evalId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="department-evaluator-row">
                                            <td>
                                                <select name="sections[<?php echo e($section['id']); ?>][departments][]" class="form-select department-dropdown">
                                                    <option value="">Select Department</option>
                                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($department->id); ?>" <?php echo e($deptId == $department->id ? 'selected' : ''); ?>>
                                                            <?php echo e($department->department_name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="sections[<?php echo e($section['id']); ?>][evaluators][]" class="form-select evaluator-dropdown">
                                                    <option value="">Select Evaluator</option>
                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($employee->id); ?>" <?php echo e($evalId == $employee->id ? 'selected' : ''); ?>>
                                                            <?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger remove-pair-btn" onclick="removeDepartmentEvaluatorPair(this)">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <!-- Empty starter row when no data exists -->
                                    <tr class="department-evaluator-row">
                                        <td>
                                            <select name="sections[<?php echo e($section['id']); ?>][departments][]" class="form-select department-dropdown">
                                                <option value="">Select Department</option>
                                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($department->id); ?>"><?php echo e($department->department_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="sections[<?php echo e($section['id']); ?>][evaluators][]" class="form-select evaluator-dropdown">
                                                <option value="">Select Evaluator</option>
                                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger remove-pair-btn" onclick="removeDepartmentEvaluatorPair(this)">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-2 d-flex">
                        <button type="button" class="btn btn-sm btn-primary me-2" onclick="addDepartmentEvaluatorRow('<?php echo e($section['id']); ?>')">
                            <i class="bi bi-plus-circle"></i> Add Department-Evaluator Pair
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLastDepartmentEvaluatorPair('<?php echo e($section['id']); ?>')">
                            <i class="bi bi-dash-circle"></i> Remove Last Pair
                        </button>
                    </div>
                    
                    <!-- Hidden field to store the final department-evaluator mapping -->
                    <input type="hidden" id="departmentEvaluatorMapping_<?php echo e($section['id']); ?>" 
                           name="sections[<?php echo e($section['id']); ?>][department_evaluator_mapping]" value="">
                </div>
            </div>

            <!-- This div will contain all the indicators -->
            <div class="indicator-list">
                <?php $__currentLoopData = $section["performance_indicator"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="indicator-item" data-indicator-id="<?php echo e($indicator['id']); ?>">
                        <div class="indicator-header">
                            <h5 class="indicator-name">Indicator <?php echo e($loop->iteration); ?></h5>
                            <button type="button" class="btn btn-sm btn-danger delete-indicator-btn" onclick="deleteIndicator(this)" data-indicator-id="<?php echo e($indicator['id']); ?>">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>

                        <!-- Editable Indicator Name -->
                        <input type="text" name="sections[<?php echo e($section['id']); ?>][performance_indicator][<?php echo e($loop->index); ?>][name]" value="<?php echo e($indicator['name']); ?>" class="indicator-input" required>

                        <!-- Hidden Indicator ID -->
                        <input type="hidden" name="sections[<?php echo e($section['id']); ?>][performance_indicator][<?php echo e($loop->index); ?>][id]" value="<?php echo e($indicator['id']); ?>">
                        <input type="hidden" class="original-indicator-id" value="<?php echo e($indicator['id']); ?>">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<!-- This script should be placed in the main template, not in the partial -->
<script>
// Store sections container selector for access across functions
const sectionsContainerSelector = '#appraisal-sections-container'; // Adjust this to match your container ID

// Function to delete an indicator
function deleteIndicator(button) {
    if (confirm('Are you sure you want to delete this indicator?')) {
        // Get the indicator item element
        const indicatorItem = button.closest('.indicator-item');
        const indicatorId = button.getAttribute('data-indicator-id');
        const sectionContainer = button.closest('.section-container');
        const sectionId = sectionContainer.getAttribute('data-section-id');
        
        // If this is a server-stored indicator, track it for deletion on submit
        if (indicatorId && !indicatorId.startsWith('-')) {
            // Add a hidden input to track deleted indicators
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_indicators[]';
            hiddenInput.value = indicatorId;
            sectionContainer.appendChild(hiddenInput);
        }
        
        // Remove the indicator item from the DOM
        indicatorItem.remove();
        
        // Update indicator numbers for this section
        updateIndicatorFields(sectionContainer);
    }
}

// Function to add a new indicator
function addNewIndicator(button) {
    // Find the section container and indicator list
    const sectionContainer = button.closest('.section-container');
    const indicatorList = sectionContainer.querySelector('.indicator-list');
    const sectionId = sectionContainer.getAttribute('data-section-id');
    
    // Get the current number of indicators
    const currentCount = indicatorList.querySelectorAll('.indicator-item').length;
    
    // Create a new unique temporary ID (negative to avoid conflicts with server IDs)
    const tempId = -Date.now();
    
    // Create the HTML for the new indicator
    const newIndicatorHTML = `
        <div class="indicator-item" data-indicator-id="${tempId}">
            <div class="indicator-header">
                <h5 class="indicator-name">Indicator ${currentCount + 1}</h5>
                <button type="button" class="btn btn-sm btn-danger delete-indicator-btn" onclick="deleteIndicator(this)" data-indicator-id="${tempId}">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
            <!-- Editable Indicator Name -->
            <input type="text" name="sections[${sectionId}][performance_indicator][${currentCount}][name]" value="" class="indicator-input" required>
            <!-- Hidden Indicator ID -->
            <input type="hidden" name="sections[${sectionId}][performance_indicator][${currentCount}][id]" value="${tempId}">
            <input type="hidden" class="original-indicator-id" value="${tempId}">
        </div>
    `;
    
    // Add the new indicator to the list
    indicatorList.insertAdjacentHTML('beforeend', newIndicatorHTML);
    
    // Update indicator numbers for this section
    updateIndicatorFields(sectionContainer);
}

// Function to delete a section
function deleteSection(button) {
    if (confirm('Are you sure you want to delete this section? All indicators within this section will also be deleted.')) {
        const sectionContainer = button.closest('.section-container');
        const sectionId = sectionContainer.getAttribute('data-section-id');
        
        // If this is a server-stored section, track it for deletion on submit
        if (sectionId && !sectionId.startsWith('-')) {
            // Add a hidden input to track deleted sections
            const form = sectionContainer.closest('form');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_sections[]';
            hiddenInput.value = sectionId;
            form.appendChild(hiddenInput);
        }
        
        // Remove the section from the DOM
        sectionContainer.remove();
        
        // Recalculate total weightage
        validateWeightage();
    }
}

// Function to add a new section
function addNewSection() {
    // Create a new unique temporary ID (negative to avoid conflicts with server IDs)
    const tempId = -Date.now();
    
    // Create the HTML for the new section (similar to the partial, but with temp ID)
    const newSectionHTML = `
        <div class="section-container" data-section-id="${tempId}">
            <!-- Hidden JSON Input -->
            <input type="hidden" name="sections[${tempId}][id]" value="${tempId}">
            <input type="hidden" name="sections[${tempId}][company_id]" value="<?php echo e(isset($section) ? $section['company_id'] : ''); ?>" class="section-title-input" required>

            <!-- Section Header -->
            <div class="section-header">
                <div class="section-title-wrapper">
                    <i class="bi bi-folder section-icon"></i>
                    
                    <!-- Editable Section Name -->
                    <div>
                        <label for="">Section Name</label>
                        <input type="text" name="sections[${tempId}][name]" value="" class="section-title-input" required>
                    </div>
                    
                    <div>
                        <label for="">Section Weightage (%)</label>
                        <input type="number" name="sections[${tempId}][weightage]" value="0" min="0" max="100" class="section-title-input section-weightage" onchange="validateWeightage()" required>
                    </div>
                    
                    <!-- Delete Section Button -->
                    <div class="section-actions">
                        <button type="button" class="btn btn-sm btn-danger delete-section-btn" onclick="deleteSection(this)">
                            <i class="bi bi-trash"></i> Delete Section
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Section Content --> 
            <div class="section-content">
                <!-- Evaluation Matrix -->
                <div class="evaluation-matrix mt-3">
                    <label for="" class="fw-bold">Evaluation Matrix</label>
                    <div class="department-evaluator-container">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 45%;">Department</th>
                                        <th style="width: 45%;">Evaluator</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="evaluationMatrixBody_${tempId}">
                                    <!-- Empty starter row -->
                                    <tr class="department-evaluator-row">
                                        <td>
                                            <select name="sections[${tempId}][departments][]" class="form-select department-dropdown">
                                                <option value="">Select Department</option>
                                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($department->id); ?>"><?php echo e($department->department_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="sections[${tempId}][evaluators][]" class="form-select evaluator-dropdown">
                                                <option value="">Select Evaluator</option>
                                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger remove-pair-btn" onclick="removeDepartmentEvaluatorPair('${tempId}')">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-2 d-flex">
                            <button type="button" class="btn btn-sm btn-primary me-2" onclick="addDepartmentEvaluatorRow('${tempId}')">
                                <i class="bi bi-plus-circle"></i> Add Department-Evaluator Pair
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLastDepartmentEvaluatorPair('${tempId}')">
                                <i class="bi bi-dash-circle"></i> Remove Last Pair
                            </button>
                        </div>
                        
                        <!-- Hidden field to store the final department-evaluator mapping -->
                        <input type="hidden" id="departmentEvaluatorMapping_${tempId}" 
                               name="sections[${tempId}][department_evaluator_mapping]" value="">
                    </div>
                </div>
                
                <!-- Performance Indicators -->
                <div class="indicators-section">
                    <h4 class="indicators-title">
                        <i class="bi bi-list-check"></i>
                        Performance Indicators
                        <button type="button" class="btn btn-sm btn-primary add-indicator-btn" onclick="addNewIndicator(this)">
                            <i class="bi bi-plus"></i> Add Indicator
                        </button>
                    </h4>
                    
                    <div class="indicator-list">
                        <!-- New sections start with no indicators -->
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Find the container that holds all sections and append the new section at the end
    const sectionsContainer = document.querySelector(sectionsContainerSelector);
    sectionsContainer.insertAdjacentHTML('beforeend', newSectionHTML);
    
    // Initialize select2 for dropdowns if available
    if (typeof $ !== 'undefined') {
        // Initialize any select2 instances in the new row
        $(`#evaluationMatrixBody_${tempId} select`).select2({
            width: '100%',
            placeholder: 'Select...',
            allowClear: true
        });
    }
    
    // Validate weightage after adding new section
    validateWeightage();
}

// Function to update indicator fields within a section
function updateIndicatorFields(sectionContainer) {
    const indicatorList = sectionContainer.querySelector('.indicator-list');
    const indicators = indicatorList.querySelectorAll('.indicator-item');
    const sectionId = sectionContainer.getAttribute('data-section-id');
    
    // Update each indicator's fields and numbering
    indicators.forEach((indicator, index) => {
        // Update the indicator number display
        const indicatorName = indicator.querySelector('.indicator-name');
        indicatorName.textContent = `Indicator ${index + 1}`;
        
        // Update input field names to use sequential index
        const nameInput = indicator.querySelector('.indicator-input');
        const idInput = indicator.querySelector('input[class="original-indicator-id"]').value;
        
        // Set the name attribute with sequential index
        nameInput.name = `sections[${sectionId}][performance_indicator][${index}][name]`;
        
        // Update the hidden ID input
        const hiddenIdInput = indicator.querySelector('input[type="hidden"]:not(.original-indicator-id)');
        hiddenIdInput.name = `sections[${sectionId}][performance_indicator][${index}][id]`;
    });
}

// Function to validate that total weightage equals 100%
function validateWeightage() {
    const weightageInputs = document.querySelectorAll('.section-weightage');
    let totalWeightage = 0;
    
    weightageInputs.forEach(input => {
        totalWeightage += parseFloat(input.value) || 0;
    });
    
    const totalWeightageElement = document.getElementById('total-weightage');
    const weightageWarning = document.getElementById('weightage-warning');
    
    if (totalWeightageElement) {
        totalWeightageElement.textContent = totalWeightage.toFixed(0);
        
        if (totalWeightage !== 100) {
            weightageWarning?.classList.remove('d-none');
            return false;
        } else {
            weightageWarning?.classList.add('d-none');
            return true;
        }
    }
    return false;
}

// Add event delegation for dynamic weightage inputs
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('section-weightage')) {
        validateWeightage();
    }
});

// Initialize the form when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize validation
    validateWeightage();
    
    // Setup form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateWeightage()) {
                e.preventDefault();
                alert('Total weightage must equal exactly 100%. Please adjust section weightages.');
                return false;
            }
        });
    }
    
    // Initialize select2 for existing department-evaluator dropdowns
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('.department-dropdown, .evaluator-dropdown').select2({
            width: '100%',
            placeholder: 'Select...',
            allowClear: true
        });
    }
});

// Function to add a new department-evaluator row to a specific section
function addDepartmentEvaluatorRow(sectionId) {
    const tbody = document.getElementById(`evaluationMatrixBody_${sectionId}`);
    if (!tbody) return;
    
    const newRow = document.createElement('tr');
    newRow.className = 'department-evaluator-row';
    
    // Create department dropdown
    const departmentTd = document.createElement('td');
    const departmentSelect = document.createElement('select');
    departmentSelect.className = 'form-select department-dropdown';
    departmentSelect.name = `sections[${sectionId}][departments][]`;
    
    // Add empty option
    const emptyOption = document.createElement('option');
    emptyOption.value = '';
    emptyOption.textContent = 'Select Department';
    departmentSelect.appendChild(emptyOption);
    
    // Add department options from template
    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        const deptOption<?php echo e($department->id); ?> = document.createElement('option');
        deptOption<?php echo e($department->id); ?>.value = '<?php echo e($department->id); ?>';
        deptOption<?php echo e($department->id); ?>.textContent = '<?php echo e($department->department_name); ?>';
        departmentSelect.appendChild(deptOption<?php echo e($department->id); ?>);
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    departmentTd.appendChild(departmentSelect);
    
    // Create evaluator dropdown
    const evaluatorTd = document.createElement('td');
    const evaluatorSelect = document.createElement('select');
    evaluatorSelect.className = 'form-select evaluator-dropdown';
    evaluatorSelect.name = `sections[${sectionId}][evaluators][]`;
    
    // Add empty option
    const emptyEvalOption = document.createElement('option');
    emptyEvalOption.value = '';
    emptyEvalOption.textContent = 'Select Evaluator';
    evaluatorSelect.appendChild(emptyEvalOption);
    
    // Add evaluator options from template
    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        const empOption<?php echo e($employee->id); ?> = document.createElement('option');
        empOption<?php echo e($employee->id); ?>.value = '<?php echo e($employee->id); ?>';
        empOption<?php echo e($employee->id); ?>.textContent = '<?php echo e($employee->first_name); ?> <?php echo e($employee->last_name); ?>';
        evaluatorSelect.appendChild(empOption<?php echo e($employee->id); ?>);
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    evaluatorTd.appendChild(evaluatorSelect);
    
    // Create delete button cell
    const actionTd = document.createElement('td');
    actionTd.className = 'text-center';
    
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'btn btn-sm btn-danger remove-pair-btn';
    deleteButton.onclick = function() { removeDepartmentEvaluatorPair(this); };
    
    const deleteIcon = document.createElement('i');
    deleteIcon.className = 'bi bi-x';
    
    deleteButton.appendChild(deleteIcon);
    actionTd.appendChild(deleteButton);
    
    // Add cells to row
    newRow.appendChild(departmentTd);
    newRow.appendChild(evaluatorTd);
    newRow.appendChild(actionTd);
    
    // Add row to tbody
    tbody.appendChild(newRow);
    
    // Initialize select2 for dropdowns if available
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $(departmentSelect).select2({
            width: '100%',
            placeholder: 'Select Department',
            allowClear: true
        });
        
        $(evaluatorSelect).select2({
            width: '100%',
            placeholder: 'Select Evaluator',
            allowClear: true
        });
    }
}

// Add event for form submission to prepare department-evaluator mapping
document.addEventListener('DOMContentLoaded', function() {
    // Add to existing DOMContentLoaded handler
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Prepare department-evaluator mappings before submit
            document.querySelectorAll('.section-container').forEach(function(section) {
                const sectionId = section.getAttribute('data-section-id');
                const mappingField = document.getElementById(`departmentEvaluatorMapping_${sectionId}`);
                if (mappingField) {
                    const mapping = {};
                    const rows = section.querySelectorAll('.department-evaluator-row');
                    
                    rows.forEach(function(row) {
                        const departmentSelect = row.querySelector('.department-dropdown');
                        const evaluatorSelect = row.querySelector('.evaluator-dropdown');
                        
                        if (departmentSelect && evaluatorSelect && 
                            departmentSelect.value && evaluatorSelect.value) {
                            mapping[departmentSelect.value] = evaluatorSelect.value;
                        }
                    });
                    
                    // Store as JSON string
                    mappingField.value = JSON.stringify(mapping);
                }
            });
        });
    }
});

// Function to remove a specific department-evaluator pair
function removeDepartmentEvaluatorPair(button) {
    const row = button.closest('.department-evaluator-row');
    const tbody = row.parentElement;
    
    // Only remove if there's more than one row
    if (tbody.querySelectorAll('.department-evaluator-row').length > 1) {
        row.remove();
    } else {
        // If it's the last row, just clear the fields
        const departmentSelect = row.querySelector('.department-dropdown');
        const evaluatorSelect = row.querySelector('.evaluator-dropdown');
        
        if (departmentSelect) {
            departmentSelect.value = '';
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $(departmentSelect).trigger('change');
            }
        }
        
        if (evaluatorSelect) {
            evaluatorSelect.value = '';
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $(evaluatorSelect).trigger('change');
            }
        }
    }
}

// Function to remove the last department-evaluator pair
function removeLastDepartmentEvaluatorPair(sectionId) {
    const tbody = document.getElementById(`evaluationMatrixBody_${sectionId}`);
    if (!tbody) return;
    
    const rows = tbody.querySelectorAll('.department-evaluator-row');
    if (rows.length > 1) {
        rows[rows.length - 1].remove();
    } else {
        // If it's the last row, just clear the fields
        const departmentSelect = rows[0].querySelector('.department-dropdown');
        const evaluatorSelect = rows[0].querySelector('.evaluator-dropdown');
        
        if (departmentSelect) {
            departmentSelect.value = '';
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $(departmentSelect).trigger('change');
            }
        }
        
        if (evaluatorSelect) {
            evaluatorSelect.value = '';
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $(evaluatorSelect).trigger('change');
            }
        }
    }
}
</script><?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/settings/variables/partials/appraisal_partials/sections.blade.php ENDPATH**/ ?>