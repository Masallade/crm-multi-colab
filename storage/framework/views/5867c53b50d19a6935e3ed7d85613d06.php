<?php //dd($leaveTypes); ?>

<div class="container-fluid">    
    <div class="card mb-3">
        <div class="card-body">
        <h3 class="card-title">Filter by Leave Type:</h3>
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <select id="leaveTypeFilter" class="form-control selectpicker" data-live-search="true">
                        <!-- <option value="">All Leaves</option> -->
                        <?php $__currentLoopData = $leaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($leaveType->id); ?>" <?php echo e($leaveType->id == 2 ? 'selected' : ''); ?>>
                            <?php echo e($leaveType->leave_type); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button id="updateLeaveButton" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>

    <!-- Leave Calculator -->
    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">
                <i class="fa fa-calculator"></i> <?php echo e(__('Leave Calculator')); ?>

                <small class="text-muted">(<?php echo e(__('Convert Work Days to Calendar Days')); ?>)</small>
            </h3>
            <p class="text-muted small"><?php echo e(__('Use this calculator to convert work days (based on employee shift) to calendar days for data entry.')); ?></p>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><?php echo e(__('Employee Shift Time')); ?></label>
                        <div class="d-flex gap-2">
                            <div class="flex-fill">
                                <select id="calc_shift_hours" class="form-control">
                                    <?php for($h = 0; $h <= 12; $h++): ?>
                                        <option value="<?php echo e($h); ?>" <?php echo e($h == 8 ? 'selected' : ''); ?>><?php echo e($h); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <small class="text-muted"><?php echo e(__('Hours')); ?></small>
                            </div>
                            <div class="flex-fill">
                                <select id="calc_shift_minutes" class="form-control">
                                    <?php for($m = 0; $m <= 59; $m += 15): ?>
                                        <option value="<?php echo e($m); ?>"><?php echo e($m); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <small class="text-muted"><?php echo e(__('Minutes')); ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo e(__('Number of Work Days')); ?></label>
                        <input type="number" id="calc_work_days" class="form-control" min="0" max="365" step="0.5" value="12" placeholder="e.g., 12">
                        <small class="text-muted"><?php echo e(__('Work days to allocate')); ?></small>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button id="calculateLeaveBtn" class="btn btn-success btn-block">
                            <i class="fa fa-calculator"></i> <?php echo e(__('Calculate')); ?>

                        </button>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo e(__('Result (Enter in Table)')); ?></label>
                        <div id="calc_result" class="alert alert-info mb-0" style="padding: 0.5rem;">
                            <strong id="calc_result_text"><?php echo e(__('Click Calculate')); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="calc_explanation" class="alert alert-light" style="display: none; font-size: 0.875rem;">
                        <strong><?php echo e(__('Calculation:')); ?></strong>
                        <div id="calc_explanation_text"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="leave_result"></span>



<div class="table-responsive">
    <table id="addLeave_employee-table" class="mt-0 table">
        <thead>
        <tr>
            <th><?php echo e(__('Employee name')); ?></th>
            <th><?php echo e(__('Leave Type')); ?></th>
            <th><?php echo e(__('Days Per Year')); ?> <small class="text-muted">(<?php echo e(__('Days')); ?> / <?php echo e(__('Hours')); ?> / <?php echo e(__('Minutes')); ?>)</small></th>
            <th><?php echo e(__('Remaining')); ?> <small class="text-muted">(<?php echo e(__('Days')); ?> / <?php echo e(__('Hours')); ?> / <?php echo e(__('Minutes')); ?>)</small></th>
        </tr>
        </thead>

    </table>
</div>


<div id="LeaveEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="LeaveModalLabel" class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>

                <button type="button" data-dismiss="modal" id="leave_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="leave_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="addLeave_employee_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                    <?php echo csrf_field(); ?>
                    <div class="col-md-4 form-group">
                        <label><?php echo e(__('Leave Type')); ?> *</label>
                        <input type="text" name="addLeave_employee_edit" id="addLeave_employee_edit"  class="form-control"
                               placeholder="<?php echo e(__('Leave Type')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label><?php echo e(__('Days Per Year')); ?> *</label>
                        <select name="allocated_day_edit" id="allocated_day_edit" class="form-control">
                            <?php for($i = 0.5; $i <= 30.0; $i += 0.5): ?>
                                <option value="<?php echo e(number_format($i, 1, '.', '')); ?>"><?php echo e(number_format($i, 1, '.', '')); ?></option>
                            <?php endfor; ?>
                            <option value="30.05">30.05</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_leave_id" id="hidden_leave_id" />
                        <input type="submit" name="addLeave_employee_edit_submit" id="addLeave_employee_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/urtasker_crm/resources/views/settings/variables/partials/addLeave_employee.blade.php ENDPATH**/ ?>