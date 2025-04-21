<div class="">
    <form method="post" action="<?php echo e(route('getNewAppraisalType')); ?>" id="appraisal_section_form" class="form-horizontal">
        <?php echo csrf_field(); ?>

        <!-- Company Selection -->
        <div class="form-group">
            <label for="company_id"><?php echo e(__('Company')); ?></label>
            <select name="company_id" id="company_id" class="form-control selectpicker company-select" data-live-search="true" 
                    data-live-search-style="contains" title='<?php echo e(__('Select',['key'=>trans('file.Company')])); ?>...'>
                <option value="add_company" class="font-weight-bold text-success"><?php echo e(__('Add New Company')); ?></option>
                <?php
                $companies = App\Models\Company::select('id', 'company_name')->get();
                ?>
                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($company->id); ?>"><?php echo e($company->company_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Designation Selection (New Dropdown) -->
        <div class="form-group">
            <label for="designation_id"><?php echo e(__('Appraisal Designations')); ?></label>
            <select name="designation_ids" id="designation_ids" class="form-control selectpicker designation-select" 
                     data-live-search="true" title='<?php echo e(__('Select Designations')); ?>...' disabled>
                <option value=""><?php echo e(__('Select Company First')); ?></option>
            </select>
        </div>

        <!-- Department Selection (Multiple) -->
        <div class="form-group">
            <label for="department_id"><?php echo e(__('Departments')); ?></label>
            <select name="department_ids[]" id="department_ids" class="form-control selectpicker department-select" 
                    multiple data-live-search="true" title='<?php echo e(__('Select Departments')); ?>...' disabled>
                <option value=""><?php echo e(__('Select Company First')); ?></option>
            </select>
        </div>

        <div id="add-company-section" class="form-group d-none">
            <label for="new_company_name"><?php echo e(__('New Company Name')); ?></label>
            <input type="text" name="new_company_name" id="new_company_name" class="form-control"
                   placeholder="<?php echo e(__('Enter New Company Name')); ?>">
        </div>

        <!-- Appraisal Section -->
        <div id="sections-container"></div>

        <div class="form-group mt-3">
            <p id="weightage-left" class="font-weight-bold text-danger"><?php echo e(__('Weightage Left:')); ?> <span>100%</span></p>
        </div>

        <button type="button" id="add-section" class="btn btn-secondary mt-3"><?php echo e(__('Add Section')); ?></button>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-success" id="submit-form"><?php echo e(__('Submit')); ?></button>
        </div>
    </form>
</div>

<style>
    /* Base styling */
    .form-group label {
        font-weight: bold;
    }

    .section-group {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 8px;
        background-color: #f9f9f9;
        margin-bottom: 20px;
    }

    .bootstrap-select .dropdown-toggle {
        width: 100% !important;
        text-align: left;
    }

    .btn {
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .input-group .form-control {
        border-radius: 4px;
    }

    .font-weight-bold {
        font-size: 1.1rem;
    }

    .section-weightage {
        width: 70px !important;
        text-align: center;
        font-size: 16px;
    }

    select[multiple] {
        height: auto;
    }
    
    .dropdown-container {
        max-width: 300px;
        margin: 0 auto;
    }

    label {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
    }

    select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    select:focus {
        outline: none;
        border-color: #007BFF;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Employee selection styling */
    .selected-indicator {
        color: #007bff;
        font-weight: bold;
        margin-right: 5px;
    }

    .bootstrap-select .dropdown-menu li.selected-elsewhere a {
        background-color: rgba(0, 123, 255, 0.1) !important;
    }

    .bootstrap-select .dropdown-menu li.selected-elsewhere:hover a {
        background-color: rgba(0, 123, 255, 0.2) !important;
    }

    .employee-name {
        display: flex;
        align-items: center;
    }

    /* Designation highlighting styles */
    .designation-option-highlighted {
        background-color: #ffffd0 !important;
        color: #666 !important;
        font-style: italic;
    }
    
    .designation-option-highlighted::after {
        content: " (in use)";
        font-size: 0.9em;
        color: #888;
    }
    
    .bootstrap-select .dropdown-menu li.disabled.designation-option-highlighted a {
        background-color: #ffffd0 !important;
        cursor: not-allowed;
    }
    
    /* Department employee dropdowns */
    .department-employee-dropdowns .form-group {
        border-left: 3px solid #007bff;
        padding-left: 10px;
        margin-bottom: 15px;
    }
    
    .department-employee-dropdowns label {
        color: #007bff;
        font-size: 14px;
    }

    /* Validation styles */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }

    .validation-summary {
        color: #dc3545;
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #dc3545;
        border-radius: 4px;
        background-color: #f8d7da;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Pre-load all data from the server
    <?php
    // Load departments grouped by company
    $allDepartments = App\Models\Department::where('is_active', 1)
                        ->select('id', 'department_name', 'company_id')
                        ->get()
                        ->groupBy('company_id');
    
    // Load ALL active employees
    $allEmployees = App\Models\Employee::where('is_active', 1)
                    ->select('id', 'first_name', 'last_name', 'company_id', 'department_id')
                    ->with('department')
                    ->get();

    // Load designations for company ID 9
    $allDesignations = App\Models\Designation::where('company_id', 9)
                ->select('id', 'designation_name', 'company_id')
                ->get();

    // Get designation IDs from appraisal_sections table that should be highlighted
    $highlightedDesignationIds = App\Models\AppraisalSection::select('designation_ids')
                                ->distinct()
                                ->pluck('designation_ids')
                                ->toArray();

    // Process highlighted designations - flatten the array if stored as JSON
    $flattenedDesignationIds = [];
    foreach ($highlightedDesignationIds as $ids) {
        if (is_string($ids)) {
            $decodedIds = json_decode($ids, true);
            if (is_array($decodedIds)) {
                $flattenedDesignationIds = array_merge($flattenedDesignationIds, $decodedIds);
            } else {
                $flattenedDesignationIds[] = $ids;
            }
        } else {
            $flattenedDesignationIds[] = $ids;
        }
    }
    $highlightedDesignationIds = array_unique($flattenedDesignationIds);
    ?>

    // Convert PHP data to JavaScript variables
    const departmentsByCompany = <?php echo json_encode($allDepartments->toArray(), 15, 512) ?>;
    const allEmployees = <?php echo json_encode($allEmployees->toArray(), 15, 512) ?>;
    const designationsByCompany = <?php echo json_encode($allDesignations->toArray(), 15, 512) ?>;
    const highlightedDesignationIds = <?php echo json_encode($highlightedDesignationIds, 15, 512) ?>;
    
    // Debug logging
    console.log('Designations by Company:', designationsByCompany);
    console.log('Highlighted designation IDs:', highlightedDesignationIds);

    // DOM elements
    const companySelect = document.querySelector('.company-select');
    const departmentSelect = document.getElementById('department_ids');
    const designationSelect = document.getElementById('designation_ids');
    const sectionsContainer = document.getElementById('sections-container');
    const addSectionButton = document.getElementById('add-section');
    const weightageLeftDisplay = document.getElementById('weightage-left').querySelector('span');
    const submitButton = document.getElementById('submit-form');
    const addCompanySection = document.getElementById('add-company-section');
    const form = document.getElementById('appraisal_section_form');

    // Initialize variables
    let sectionIndex = 0;
    let weightageLeft = 100;
    let selectedCompanyId = null;

    // Initialize selectpickers
    $('.selectpicker').selectpicker();

    // Function to populate designation dropdown with highlighting
    function populateDesignationDropdown(designations, targetSelect) {
        if (!designations || designations.length === 0) {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = '<?php echo e(__("No designations available")); ?>';
            targetSelect.appendChild(option);
            return;
        }

        // Filter for unique designation names
        const uniqueDesignations = [];
        const designationNames = new Set();
        
        designations.forEach(designation => {
            if (!designationNames.has(designation.designation_name)) {
                designationNames.add(designation.designation_name);
                uniqueDesignations.push(designation);
            }
        });
        
        // Sort alphabetically
        uniqueDesignations.sort((a, b) => a.designation_name.localeCompare(b.designation_name));

        // Add options to the dropdown
        uniqueDesignations.forEach(designation => {
            const option = document.createElement('option');
            option.value = designation.id;
            option.textContent = designation.designation_name;
            
            // Highlight and disable if this designation is already in use
            if (highlightedDesignationIds.includes(designation.id.toString()) || 
                highlightedDesignationIds.includes(parseInt(designation.id))) {
                option.disabled = true;
                option.classList.add('designation-option-highlighted');
                option.setAttribute('data-content', `<span class="designation-option-highlighted">${designation.designation_name}</span>`);
            }
            
            targetSelect.appendChild(option);
        });
    }

    // Function to validate all evaluator dropdowns
    function validateEvaluatorDropdowns() {
        let isValid = true;
        const errorMessages = [];
        
        // Get all section groups
        const sectionGroups = document.querySelectorAll('.section-group');
        
        if (sectionGroups.length === 0) {
            errorMessages.push("Please add at least one appraisal section");
            isValid = false;
        }
        
        // Check each section
        sectionGroups.forEach(section => {
            const dropdownContainer = section.querySelector('.department-employee-dropdowns');
            
            if (!dropdownContainer) {
                errorMessages.push(`Section "${section.querySelector('input[name="section_name[]"]').value}" has no departments selected`);
                isValid = false;
                return;
            }
            
            // Get all evaluator dropdowns in this section
            const evaluatorDropdowns = dropdownContainer.querySelectorAll('select.employee-dept-select');
            
            evaluatorDropdowns.forEach(dropdown => {
                if (!dropdown.value) {
                    const departmentName = dropdown.getAttribute('title').replace('Select Employee for ', '');
                    errorMessages.push(`Please select an evaluator for ${departmentName} in section "${section.querySelector('input[name="section_name[]"]').value}"`);
                    isValid = false;
                    
                    // Highlight the problematic dropdown
                    dropdown.classList.add('is-invalid');
                    const feedback = document.createElement('div');
                    feedback.classList.add('invalid-feedback');
                    feedback.textContent = 'Evaluator selection is required';
                    dropdown.parentNode.appendChild(feedback);
                } else {
                    dropdown.classList.remove('is-invalid');
                    const existingFeedback = dropdown.parentNode.querySelector('.invalid-feedback');
                    if (existingFeedback) {
                        existingFeedback.remove();
                    }
                }
            });
        });
        
        return { isValid, errorMessages };
    }

    // Company change event handler
    companySelect.addEventListener('change', function() {
        const companyId = this.value;
        selectedCompanyId = companyId;
        
        // Reset dropdowns
        $(departmentSelect).selectpicker('val', []);
        departmentSelect.innerHTML = '';
        departmentSelect.disabled = true;

        $(designationSelect).selectpicker('val', []);
        designationSelect.innerHTML = '';
        designationSelect.disabled = false;

        // Toggle add company section
        if (companyId === 'add_company') {
            addCompanySection.classList.remove('d-none');
        } else {
            addCompanySection.classList.add('d-none');
        }

        if (companyId && companyId !== 'add_company') {
            // Load departments for the selected company
            const departments = departmentsByCompany[companyId];
            if (departments && departments.length > 0) {
                departments.forEach(department => {
                    const option = document.createElement('option');
                    option.value = department.id;
                    option.textContent = department.department_name;
                    departmentSelect.appendChild(option);
                });
                departmentSelect.disabled = false;
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = '<?php echo e(__("No departments available")); ?>';
                departmentSelect.appendChild(option);
            }

            // Load and populate designations
            populateDesignationDropdown(designationsByCompany, designationSelect);
        }

        // Refresh selectpickers
        setTimeout(() => {
            $(departmentSelect).selectpicker('refresh');
            $(designationSelect).selectpicker('refresh');
        }, 0);

        // Update employee dropdowns in sections
        updateEmployeeDropdownsInSections();
    });

    // Department change event handler
    departmentSelect.addEventListener('change', function() {
        updateEmployeeDropdownsInSections();
    });

    // Function to update all employee dropdowns in sections
    function updateEmployeeDropdownsInSections() {
        // Update the employee dropdowns in each section
        document.querySelectorAll('.section-group').forEach(section => {
            updateEmployeeDropdownContainer(section);
        });
    }

    // Function to update the employee dropdown container in a section
    function updateEmployeeDropdownContainer(section) {
        const dropdownContainer = section.querySelector('.department-employee-dropdowns');
        if (!dropdownContainer) {
            return;
        }

        // Clear the current dropdowns
        dropdownContainer.innerHTML = '';

        if (!selectedCompanyId || selectedCompanyId === 'add_company') {
            const placeholder = document.createElement('div');
            placeholder.classList.add('alert', 'alert-info', 'mt-2');
            placeholder.textContent = '<?php echo e(__("Please select a company first")); ?>';
            dropdownContainer.appendChild(placeholder);
            return;
        }

        // Get selected department IDs
        const selectedDepartmentIds = Array.from(departmentSelect.selectedOptions).map(opt => opt.value);
        
        if (selectedDepartmentIds.length === 0) {
            const placeholder = document.createElement('div');
            placeholder.classList.add('alert', 'alert-info', 'mt-2');
            placeholder.textContent = '<?php echo e(__("Please select at least one department")); ?>';
            dropdownContainer.appendChild(placeholder);
            return;
        }

        // Get departments from the selected company
        const departments = departmentsByCompany[selectedCompanyId] || [];
        const selectedDepartments = departments.filter(dept => 
            selectedDepartmentIds.includes(dept.id.toString()) || 
            selectedDepartmentIds.includes(parseInt(dept.id))
        );

        // Get all employees from the selected company for display in each dropdown
        const companyEmployees = allEmployees.filter(emp => emp.company_id == selectedCompanyId)
            .sort((a, b) => {
                const nameA = `${a.first_name} ${a.last_name}`;
                const nameB = `${b.first_name} ${b.last_name}`;
                return nameA.localeCompare(nameB);
            });

        // Create a dropdown for each selected department
        selectedDepartments.forEach(dept => {
            const departmentGroup = document.createElement('div');
            departmentGroup.classList.add('form-group', 'mt-3');
            
            const label = document.createElement('label');
            label.textContent = `<?php echo e(__('Evaluator for')); ?> ${dept.department_name}`;
            departmentGroup.appendChild(label);
            
            const select = document.createElement('select');
            select.name = `employees[${section.dataset.sectionIndex}][${dept.id}]`;
            select.classList.add('form-control', 'selectpicker', 'employee-dept-select');
            select.setAttribute('data-live-search', 'true');
            select.setAttribute('data-department-id', dept.id);
            select.setAttribute('title', `<?php echo e(__('Select Employee for')); ?> ${dept.department_name}...`);
            select.required = true;
            
            // Add empty option for initial state
            const emptyOption = document.createElement('option');
            emptyOption.value = '';
            emptyOption.textContent = `<?php echo e(__('Select an employee')); ?>`;
            select.appendChild(emptyOption);
                
            if (companyEmployees.length > 0) {
                // Show all employees from the company in each dropdown
                companyEmployees.forEach(employee => {
                    const option = document.createElement('option');
                    option.value = employee.id;
                    
                    // Highlight the employee's department if it matches the current dropdown
                    let displayName = `${employee.first_name} ${employee.last_name}`;
                    if (employee.department_id == dept.id) {
                        displayName += ` (${dept.department_name})`;
                        option.classList.add('employee-in-department');
                        option.setAttribute('data-content', `<span class="text-primary font-weight-bold">${displayName}</span>`);
                    } else {
                        // Find the employee's department name
                        const empDept = departments.find(d => d.id == employee.department_id);
                        const deptName = empDept ? empDept.department_name : 'No Department';
                        displayName += ` (${deptName})`;
                        option.textContent = displayName;
                    }
                    
                    option.textContent = displayName;
                    select.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.disabled = true;
                option.textContent = '<?php echo e(__("No employees in this company")); ?>';
                select.appendChild(option);
            }
            
            departmentGroup.appendChild(select);
            dropdownContainer.appendChild(departmentGroup);
        });
        
        // Initialize selectpicker for new dropdowns
        $(dropdownContainer).find('.selectpicker').selectpicker();
    }

    // Add a new appraisal section
    addSectionButton.addEventListener('click', () => {
        if (weightageLeft <= 0) {
            alert("No weightage left to add a new section!");
            return;
        }

        sectionIndex++;
        const sectionGroup = document.createElement('div');
        sectionGroup.classList.add('section-group', 'mb-4');
        sectionGroup.dataset.sectionIndex = sectionIndex;

        sectionGroup.innerHTML = `
            <div class="form-group">
                <label for="section_name_${sectionIndex}"><?php echo e(__('Appraisal Section Name')); ?></label>
                <input type="text" name="section_name[]" id="section_name_${sectionIndex}" class="form-control"
                       placeholder="<?php echo e(__('Enter Appraisal Section Name')); ?>" required>
            </div>

            <div class="form-group d-flex align-items-center align-items-baseline">
                <label class="mr-3"><?php echo e(__('Section Weightage (%)')); ?></label>
                <div class="d-flex align-items-center mr-3">
                    <input type="number" name="section_weightage[]" class="form-control section-weightage w-50"
                     placeholder="0" min="1" max="100" data-prev-value="0" required>
                    <span class="ml-2">%</span>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php echo e(__('Department Employees')); ?></label>
                <div class="department-employee-dropdowns">
                    <div class="alert alert-info mt-2 evaluator-validation-info" style="display: none;">
                        Please select evaluators for all departments
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label><?php echo e(__('Indicators')); ?></label>
                <div class="indicators-container">
                    <div class="input-group mb-2 indicator-group">
                        <input type="text" name="indicators[${sectionIndex}][]" class="form-control" placeholder="<?php echo e(__('Enter Indicator')); ?>" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-indicator"><?php echo e(__('Remove')); ?></button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary add-indicator"><?php echo e(__('Add Indicator')); ?></button>
            </div>
            <button type="button" class="btn btn-danger remove-section"><?php echo e(__('Remove Section')); ?></button>
        `;

        sectionsContainer.appendChild(sectionGroup);
        attachSectionEventListeners(sectionGroup);
        
        // Update employee dropdowns if departments are already selected
        updateEmployeeDropdownContainer(sectionGroup);
    });

    // Attach event listeners to a new section
    function attachSectionEventListeners(section) {
        const weightageInput = section.querySelector('.section-weightage');
        weightageInput.addEventListener('input', handleWeightageChange);

        section.querySelector('.remove-section').addEventListener('click', () => {
            const weightageValue = parseInt(weightageInput.value) || 0;
            weightageLeft += weightageValue;
            updateWeightageDisplay();
            section.remove();
        });

        const addIndicatorButton = section.querySelector('.add-indicator');
        const indicatorsContainer = section.querySelector('.indicators-container');
        addIndicatorButton.addEventListener('click', () => {
            const indicatorGroup = document.createElement('div');
            indicatorGroup.classList.add('input-group', 'mb-2', 'indicator-group');
            
            const sectionIdx = section.dataset.sectionIndex;

            indicatorGroup.innerHTML = `
                <input type="text" name="indicators[${sectionIdx}][]" class="form-control" placeholder="<?php echo e(__('Enter Indicator')); ?>" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-indicator"><?php echo e(__('Remove')); ?></button>
                </div>
            `;

            indicatorsContainer.appendChild(indicatorGroup);
            indicatorGroup.querySelector('.remove-indicator').addEventListener('click', () => {
                indicatorGroup.remove();
            });
        });
    }

    // Handle weightage input changes
    function handleWeightageChange(e) {
        const input = e.target;
        let prevValue = parseInt(input.getAttribute('data-prev-value')) || 0;
        let newValue = parseInt(input.value);

        if (isNaN(newValue) || newValue < 1) {
            alert("Please enter a positive number.");
            newValue = 1;
        } else if (newValue > weightageLeft + prevValue) {
            alert(`Value exceeds available weightage (${weightageLeft + prevValue}%).`);
            newValue = weightageLeft + prevValue;
        }

        // Update weightage calculations
        weightageLeft += prevValue - newValue;
        input.setAttribute('data-prev-value', newValue);
        input.value = newValue;

        updateWeightageDisplay();
    }

    // Update the weightage display
    function updateWeightageDisplay() {
        weightageLeftDisplay.textContent = `${weightageLeft}%`;
        addSectionButton.disabled = weightageLeft <= 0;
    }

    // Form submission handler
    form.addEventListener('submit', function(e) {
        // First check weightage
        if (weightageLeft !== 0) {
            e.preventDefault();
            alert("Remaining weightage must be 0 to submit the form!");
            return;
        }
        
        // Then validate evaluators
        const { isValid, errorMessages } = validateEvaluatorDropdowns();
        
        if (!isValid) {
            e.preventDefault();
            
            // Create validation summary
            let validationSummary = document.querySelector('.validation-summary');
            if (!validationSummary) {
                validationSummary = document.createElement('div');
                validationSummary.classList.add('validation-summary');
                form.insertBefore(validationSummary, form.firstChild);
            }
            
            validationSummary.innerHTML = `
                <strong>Please fix the following errors:</strong>
                <ul>
                    ${errorMessages.map(msg => `<li>${msg}</li>`).join('')}
                </ul>
            `;
            
            // Scroll to the validation summary
            validationSummary.scrollIntoView({ behavior: 'smooth', block: 'start' });
            return;
        }
        
        // If everything is valid, allow form submission
    });

    // Handle Add Company option
    companySelect.addEventListener('change', function() {
        if (this.value === 'add_company') {
            addCompanySection.classList.remove('d-none');
        } else {
            addCompanySection.classList.add('d-none');
        }
    });
    
    // Initialize page - handle designations and existing company selection
    if (companySelect.value) {
        // If company is already selected, trigger change event
        selectedCompanyId = companySelect.value;
        companySelect.dispatchEvent(new Event('change'));
    } else {
        // If no company selected, still load designations for company 9
        designationSelect.innerHTML = '';
        populateDesignationDropdown(designationsByCompany, designationSelect);
        designationSelect.disabled = false;
        
        setTimeout(() => {
            $(designationSelect).selectpicker('refresh');
        }, 0);
    }
});
</script><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/settings/variables/partials/add_appraisal.blade.php ENDPATH**/ ?>