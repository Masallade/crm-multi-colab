<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.min.js"></script>
<link rel="stylesheet" href="<?php echo e(asset('css/ammar.css')); ?>">


<div class="modal fade" id="setIncrementModal" tabindex="-1" role="dialog" aria-labelledby="setIncrementLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="modal-title ml-3" id="createModalLabel">Set Increment</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="incrementForm" method="POST" action="<?php echo e(route('appraisal.set-increment')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table id="appraisalTable" class="table">
                            <thead>
                                <tr>
                                    <th><?php echo e(trans('file.Company')); ?></th>
                                    <th><?php echo e(trans('file.Employee')); ?></th>
                                    <th><?php echo e(trans('file.Department')); ?></th>
                                    <th>Result</th>
                                    <th>Increment Expected</th>
                                    <th>Set Increment</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $recordToBeIncremented; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($result["company_name"]); ?></td>
                                        <td><?php echo e($result["full_name"]); ?></td>
                                        <td><?php echo e($result["department_name"]); ?></td>
                                        <td><?php echo e($result["result"]); ?>%</td>
                                        <td><?php echo e($result["Increment_expected"]); ?></td>
                                        <td>
                                        <?php
                                        // Use trim and case-insensitive comparison for more reliable matching
                                        $disabled = trim(strtolower($result["Increment_expected"])) === 'no increment';
                                        $min = null;
                                        $max = null;
                                        $value = null;
                                        $readonly = false;
                                        
                                        if (strpos($result["Increment_expected"], '-') !== false) {
                                            list($min, $max) = explode('-', $result["Increment_expected"]);
                                            $min = trim($min);
                                            $max = trim($max);
                                        } elseif (trim(strtolower($result["Increment_expected"])) !== 'no increment') {
                                            $value = trim($result["Increment_expected"]);
                                            $readonly = true; // Make it readonly for single values
                                        }
                                    ?>

                                    <input
                                        type="number"
                                        name="increment[<?php echo e($key); ?>]"
                                        class="form-control increment-input"
                                        <?php if($min && $max): ?> min="<?php echo e($min); ?>" max="<?php echo e($max); ?>" <?php endif; ?>
                                        <?php if($value): ?> value="<?php echo e($value); ?>" readonly <?php endif; ?>
                                        <?php if($disabled): ?> disabled <?php endif; ?>
                                        data-expected="<?php echo e($result['Increment_expected']); ?>"
                                        step="0.01"
                                    >
                                            <input type="hidden" name="id[<?php echo e($key); ?>]" value="<?php echo e($result['id'] ?? ''); ?>">
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Form validation
    $('#incrementForm').on('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        
        // Validate each increment input
        $('.increment-input').each(function() {
            if (!$(this).prop('disabled')) {
                const value = parseFloat($(this).val());
                const expected = $(this).data('expected');
                
                // Reset validation state
                $(this).removeClass('is-invalid is-valid');
                
                if (expected.includes('-')) {
                    // Range validation
                    const [min, max] = expected.split('-').map(num => parseFloat(num.trim()));
                    if (value < min || value > max) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).addClass('is-valid');
                    }
                } else if (expected !== 'No Increment') {
                    // Single value validation
                    const expectedValue = parseFloat(expected);
                    if (value !== expectedValue) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).addClass('is-valid');
                    }
                }
            }
        });
        
        // Submit if valid
        if (isValid) {
            this.submit();
        } else {
            // Show error message
            alert('Please correct the highlighted increment values');
        }
    });
    
    // Real-time validation on input
    $('.increment-input').on('input', function() {
        const value = parseFloat($(this).val());
        const expected = $(this).data('expected');
        
        $(this).removeClass('is-invalid is-valid');
        
        if (expected.includes('-')) {
            const [min, max] = expected.split('-').map(num => parseFloat(num.trim()));
            if (value < min || value > max) {
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        } else if (expected !== 'No Increment') {
            const expectedValue = parseFloat(expected);
            if (value !== expectedValue) {
                $(this).addClass('is-invalid');
            } else {
                $(this).addClass('is-valid');
            }
        }
    });
});
</script><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/performance/appraisal/set-increment.blade.php ENDPATH**/ ?>