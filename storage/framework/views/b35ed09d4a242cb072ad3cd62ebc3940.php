<div class="card-body">
    <div class="button-group">
        <!-- Button to Show First Section -->
        <button type="button" class="btn btn-primary appraisal-action-btn" id="btn-addappraisal">
            Add Appraisal Section
        </button>

        <!-- Button to Show Second Section -->
        <button type="button" class="btn btn-primary appraisal-action-btn" id="btn-viewappraisal">
            View Appraisal
        </button>
    </div>

    <!-- First Section to Toggle -->
    <div id="addappraisal" class="appraisal-hidden">
        <?php echo $__env->make('settings.variables.partials.add_appraisal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <!-- Second Section to Toggle -->
    <div id="viewappraisal" class="appraisal-hidden">
        <!-- This section will be dynamically updated with AJAX -->
    </div>
</div>

<style>
    .appraisal-hidden {
        display: none;
    }
    
    /* Force button colors to override any CSS conflicts */
    .appraisal-action-btn {
        background-color: #007bff !important;
        border-color: #007bff !important;
        color: #ffffff !important;
        padding: 8px 16px !important;
        border-radius: 4px !important;
        font-weight: 500 !important;
        border: 1px solid transparent !important;
        cursor: pointer !important;
        display: inline-block !important;
        text-align: center !important;
        transition: all 0.15s ease-in-out !important;
    }
    
    .appraisal-action-btn:hover {
        background-color: #0056b3 !important;
        border-color: #0056b3 !important;
        color: #ffffff !important;
    }
    
    .appraisal-action-btn:focus {
        outline: none !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }
    
    .appraisal-action-btn:active {
        background-color: #004085 !important;
        border-color: #004085 !important;
    }
    
    .button-group {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to toggle section visibility
        function toggleSection(sectionId) {
            const sections = ['addappraisal', 'viewappraisal'];
            sections.forEach(id => {
                const section = document.getElementById(id);
                if (section) {
                    if (id === sectionId) {
                        section.classList.toggle('appraisal-hidden');
                    } else {
                        section.classList.add('appraisal-hidden');
                    }
                }
            });
        }

        // Load Add Appraisal Section
        document.getElementById('btn-addappraisal').addEventListener('click', function() {
            toggleSection('addappraisal');
        });

        // Load View Appraisal Section with AJAX
        document.getElementById('btn-viewappraisal').addEventListener('click', function() {
            toggleSection('viewappraisal');

            // Make an AJAX request to fetch viewAppraisal content
            fetch("<?php echo e(route('view.appraisal')); ?>")
                .then(response => response.text())
                .then(data => {
                    document.getElementById('viewappraisal').innerHTML = data;
                })
                .catch(error => console.error('Error fetching appraisal:', error));
        });
    });
</script>
<?php /**PATH D:\project\Laravel\crm-multi-colab-Dawood\resources\views/settings/variables/partials/appraisal_type.blade.php ENDPATH**/ ?>