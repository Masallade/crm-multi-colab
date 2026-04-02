<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">
            <h3 class="card-title"><?php echo e(__('One Day Equals (Hours & Minutes)')); ?></h3>
            <p class="text-muted small"><?php echo e(__('Define how many hours and minutes count as one working day (e.g. for leave or timesheet).')); ?></p>
            <form method="post" id="one_day_hours_form" class="form-horizontal" action="<?php echo e(route('variables.update_one_day_hours')); ?>">
                <?php echo csrf_field(); ?>
                <?php
                    $one_day_hours = (int) (optional($general_settings_data)->one_day_hours ?? 8);
                    $one_day_minutes = (int) (optional($general_settings_data)->one_day_minutes ?? 0);
                ?>
                <div class="row align-items-end">
                    <div class="col-md-3 form-group">
                        <label><?php echo e(__('Hours')); ?> *</label>
                        <select name="one_day_hours" id="one_day_hours" class="form-control selectpicker" data-live-search="false" title="<?php echo e(__('Hours')); ?>">
                            <?php for($h = 0; $h <= 24; $h++): ?>
                                <option value="<?php echo e($h); ?>" <?php echo e($one_day_hours === $h ? 'selected' : ''); ?>><?php echo e($h); ?> <?php echo e($h == 1 ? __('hour') : __('hours')); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label><?php echo e(__('Minutes')); ?> *</label>
                        <select name="one_day_minutes" id="one_day_minutes" class="form-control selectpicker" data-live-search="false" title="<?php echo e(__('Minutes')); ?>">
                            <?php for($m = 0; $m <= 59; $m++): ?>
                                <option value="<?php echo e($m); ?>" <?php echo e($one_day_minutes === $m ? 'selected' : ''); ?>><?php echo e($m); ?> <?php echo e($m == 1 ? __('minute') : __('minutes')); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <input type="submit" name="one_day_hours_submit" id="one_day_hours_submit" class="btn btn-success" value="<?php echo e(trans('file.Save')); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<span id="one_day_hours_result"></span>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/urtasker_crm/resources/views/settings/variables/partials/one_day_hours.blade.php ENDPATH**/ ?>