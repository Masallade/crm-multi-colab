<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">
            <h3 class="card-title"><?php echo e(__('Add Job Experience')); ?></h3>
            <form method="post" id="job_experience_form" class="form-horizontal" >
                <?php echo csrf_field(); ?>
                <div class="input-group">
                    <input type="text" name="job_experience_title" class="form-control" placeholder="<?php echo e(__('Job Experience')); ?>">
                    <input type="submit" id="job_experience_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                </div>
            </form>
        </div>
    </div>
</div>

<span class="job_experience_result"></span>
<div class="table-responsive">
    <table id="job_experience-table" class="table ">
        <thead>
        <tr>
            <th><?php echo e(__('Title')); ?></th>
            <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
        </tr>
        </thead>

    </table>
</div>


<div id="jobExperienceEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>

                <button type="button" data-dismiss="modal" id="job_experience_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span>
                </button>
            </div>
            <span class="job_experience_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="job_experience_form_edit" class="form-horizontal" enctype="multipart/form-data" >
                    <?php echo csrf_field(); ?>
                    <div class="col-md-6 form-group">
                        <label><?php echo e(__('Job Experience')); ?> *</label>
                        <input type="text" name="job_experience_title_edit" id="job_experience_title_edit"  class="form-control" placeholder="<?php echo e(__('Type')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_job_experience_id" id="hidden_job_experience_id" />
                        <input type="submit" name="job_experience_edit_submit" id="job_experience_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/settings/variables/partials/job_experience.blade.php ENDPATH**/ ?>