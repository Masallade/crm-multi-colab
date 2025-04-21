<?php //dd($leaveTypes); ?>

<div class="container-fluid">    
    <div class="card mb-0">
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
</div>
<span class="leave_result"></span>



<div class="table-responsive">
    <table id="addLeave_employee-table" class="mt-0 table">
        <thead>
        <tr>
            <th>Employee name</th>
            <th>Leave Type</th>
            <th>Days Per Year</th>
            <th>Remaining</th>
           
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
                        <input type="text" name="allocated_day_edit" id="allocated_day_edit"  class="form-control"
                               placeholder="<?php echo e(__('Days Per Year')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_leave_id" id="hidden_leave_id" />
                        <input type="submit" name="addLeave_employee_edit_submit" id="addLeave_employee_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/settings/variables/partials/addLeave_employee.blade.php ENDPATH**/ ?>