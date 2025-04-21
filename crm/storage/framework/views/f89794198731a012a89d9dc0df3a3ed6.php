<div class="card-body">
    <div class="button-group">
        <!-- Button to Show First Section -->
        <button type="button" class="btn btn-primary" id="btn-addappraisal">
            Add Appraisal Section
        </button>

        <!-- Button to Show Second Section -->
        <button type="button" class="btn btn-primary" id="btn-viewappraisal">
            View Appraisal
        </button>
    </div>

    <!-- First Section to Toggle -->
    <div id="addappraisal" class="hidden">
        <?php echo $__env->make('settings.variables.partials.add_appraisal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <!-- Second Section to Toggle -->
    <div id="viewappraisal" class="hidden">
        <!-- This section will be dynamically updated with AJAX -->
    </div>
</div>

<style>
    .hidden {
        display: none;
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
                        section.classList.toggle('hidden');
                    } else {
                        section.classList.add('hidden');
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
<?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/settings/variables/partials/appraisal_type.blade.php ENDPATH**/ ?>