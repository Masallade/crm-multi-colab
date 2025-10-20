<div class="section-container" data-section-id="{{ $section['id'] }}">
    <!-- Hidden JSON Input -->
    <input type="hidden" name="id" value="{{ $section['id'] }}">
    <input type="hidden" name="name" value="{{ $section['company_id'] }}" class="section-title-input" required>
    <!-- Section Header -->
    <div class="section-header">
        <div class="section-title-wrapper">
            <i class="bi bi-folder section-icon"></i>
            
            <!-- Editable Section Name -->
            <div>
             <label for="">Section Name</label>
             <input type="text" name="name" value="{{ $section['name'] }}" class="section-title-input" required>
             </div>
            <!-- Evaluate By Dropdown -->
            <div>
           <label for="">Evalute by</label>
           @php
                $evaluatorOptions = [
                    '4' => 'Manager/TeamLead',
                    '20' => 'Director',
                    '6' => 'HR'
                ];
                $selectedEvaluator = $evaluatorOptions[$section['evaluate_by']] ?? $section['evaluate_by'];
            @endphp
            <select name="evaluate_by" class="form-select" style="max-width: 200px; margin-left: 10px;">
                @foreach($evaluatorOptions as $key => $value)
                    <option value="{{ $key }}" {{ $section['evaluate_by'] == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
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
                @foreach($section["performance_indicator"] as $index => $indicator)
                    <div class="indicator-item" data-indicator-id="{{ $indicator['id'] }}">
                        <div class="indicator-header">
                            <h5 class="indicator-name">Indicator {{ $loop->iteration }}</h5>
                            <button type="button" class="btn btn-sm btn-danger delete-indicator-btn" onclick="deleteIndicator(this)" data-indicator-id="{{ $indicator['id'] }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                        <!-- Editable Indicator Name -->
                        <input type="text" name="performance_indicator[{{ $loop->index }}][name]" value="{{ $indicator['name'] }}" class="indicator-input" required>
                        <!-- Hidden Indicator ID -->
                        <input type="hidden" name="performance_indicator[{{ $loop->index }}][id]" value="{{ $indicator['id'] }}">
                        <!-- Original index for reference during reordering -->
                        <input type="hidden" class="original-indicator-id" value="{{ $indicator['id'] }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
// Function to delete an indicator
function deleteIndicator(button) {
    if (confirm('Are you sure you want to delete this indicator?')) {
        // Get the indicator item element
        const indicatorItem = button.closest('.indicator-item');
        const indicatorId = button.getAttribute('data-indicator-id');
        
        // If this is a server-stored indicator, track it for deletion on submit
        if (indicatorId && !indicatorId.startsWith('-')) {
            // Add a hidden input to track deleted indicators
            const sectionContainer = button.closest('.section-container');
            const sectionId = sectionContainer.getAttribute('data-section-id');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_indicators[]';
            hiddenInput.value = indicatorId;
            sectionContainer.appendChild(hiddenInput);
        }
        
        // Remove the indicator item from the DOM
        indicatorItem.remove();
        
        // Update indicator numbers and reindex form fields
        updateIndicatorFields();
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
            <!-- These field names will be updated by updateIndicatorFields() -->
            <input type="text" name="temp_name" value="" class="indicator-input" required>
            <input type="hidden" name="temp_id" value="${tempId}">
            <input type="hidden" name="temp_section_id" value="${sectionId}">
            <input type="hidden" class="original-indicator-id" value="${tempId}">
        </div>
    `;
    
    // Add the new indicator to the list
    indicatorList.insertAdjacentHTML('beforeend', newIndicatorHTML);
    
    // Update all form field names to be sequential
    updateIndicatorFields();
}

// Function to update all indicator form fields to maintain sequential order
function updateIndicatorFields() {
    const sections = document.querySelectorAll('.section-container');
    
    sections.forEach(section => {
        const indicatorList = section.querySelector('.indicator-list');
        const indicators = indicatorList.querySelectorAll('.indicator-item');
        
        // Update each indicator's fields and numbering
        indicators.forEach((indicator, index) => {
            // Update the indicator number display
            const indicatorName = indicator.querySelector('.indicator-name');
            indicatorName.textContent = `Indicator ${index + 1}`;
            
            // Update input field names to use sequential index
            const nameInput = indicator.querySelector('.indicator-input');
            const idInput = indicator.querySelector('input[name$="[id]"], input[name="temp_id"]');
            const sectionIdInput = indicator.querySelector('input[name$="[section_id]"], input[name="temp_section_id"]');
            
            // Set the name attribute with sequential index
            nameInput.name = `performance_indicator[${index}][name]`;
            idInput.name = `performance_indicator[${index}][id]`;
            
            // Only include section_id for new indicators
            if (sectionIdInput) {
                sectionIdInput.name = `performance_indicator[${index}][section_id]`;
            }
        });
    });
    
    // Add a form submit handler if it doesn't exist yet
    if (!window.formSubmitHandlerAdded) {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                // Final update of all fields before submit
                updateIndicatorFields();
            });
        });
        window.formSubmitHandlerAdded = true;
    }
}

// Initialize the form when the page loads
document.addEventListener('DOMContentLoaded', function() {
    updateIndicatorFields();
});
</script>