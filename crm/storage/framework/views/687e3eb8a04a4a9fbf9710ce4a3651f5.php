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

            <!-- Evaluate By Dropdown -->
            
            <!-- Delete Section Button -->
           
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

            <div class="table-responsive mt-3">
                <label for="" class="fw-bold">Evaluation Matrix</label>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Department</th>
                            <th>Evaluator</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($section['department_names'], $section['evaluator_names'])): ?>
                            <?php $__currentLoopData = $section['department_names']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($department); ?></td>
                                    <td><?php echo e($section['evaluator_names'][$index] ?? 'N/A'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No evaluation data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
                    
                    <!-- Evaluate By Dropdown -->
                    <div>
                        <label for="">Evaluate by</label>
                        <select name="sections[${tempId}][evaluate_by]" class="form-select" style="max-width: 200px; margin-left: 10px;">
                            <option value="1">Admin</option>
                            <option value="4">Manager/TeamLead</option>
                            <option value="20">Director</option>
                            <option value="6">HR</option>
                        </select>
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
});
</script><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/settings/variables/partials/appraisal_partials/sections.blade.php ENDPATH**/ ?>