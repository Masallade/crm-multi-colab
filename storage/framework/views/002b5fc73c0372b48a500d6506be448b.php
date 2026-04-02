<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title"><?php echo e(__('Add Job Category')); ?></h3>
            <form method="post" id="job_category_form" class="form-horizontal" >
                <?php echo csrf_field(); ?>
                <div class="input-group">
                    <input type="text" name="job_category" id="job_category"  class="form-control"
                           placeholder="<?php echo e(__('Job Category')); ?>">
                    <input type="submit" name="job_category_submit" id="job_category_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="job_category_result"></span>
<div class="table-responsive">
    <table id="job_category-table" class="table ">
        <thead>
        <tr>
            <th><?php echo e(__('Job Category')); ?></th>
            <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
        </tr>
        </thead>

    </table>
</div>

<div id="JobCategoryEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="JobCategoryModalLabel" class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>

                <button type="button" data-dismiss="modal" id="job_category_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="job_category_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="job_category_form_edit" class="form-horizontal" >

                    <?php echo csrf_field(); ?>
                    <div class="col-md-4 form-group">
                        <label><?php echo e(__('Job Category')); ?> *</label>
                        <input type="text" name="job_category_edit" id="job_category_edit"  class="form-control"
                               placeholder="<?php echo e(__('Job Category')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_job_category_id" id="hidden_job_category_id" />
                        <input type="submit" name="job_category_edit_submit" id="job_category_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/crm/resources/views/settings/variables_method/partials/job_category.blade.php ENDPATH**/ ?>