<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">
            <h3 class="card-title"><?php echo e(__('Add Deposit Category')); ?></h3>
            <form method="post" id="deposit_category_form" class="form-horizontal" >
                <?php echo csrf_field(); ?>
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="<?php echo e(__('Category Name')); ?>">
                    <input type="submit" id="deposit_category_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                </div>
            </form>
        </div>
    </div>
</div>

<span class="deposit_category_result"></span>
<div class="table-responsive">
    <table id="deposit_category-table" class="table">
        <thead>
        <tr>
            <th><?php echo e(__('Category name')); ?></th>
            <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
        </tr>
        </thead>
    </table>
</div>


<div id="depositCategoryEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>
                <button type="button" data-dismiss="modal" id="deposit_category_close" aria-label="Close" class="close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <span class="deposit_category_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="deposit_category_form_edit" class="form-horizontal" enctype="multipart/form-data" >
                    <?php echo csrf_field(); ?>
                    <div class="col-md-6 form-group">
                        <label><?php echo e(__('Category Type')); ?> *</label>
                        <input type="text" name="name_edit" id="name_edit"  class="form-control" placeholder="<?php echo e(__('Type')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_deposit_category_id" id="hidden_deposit_category_id" />
                        <input type="submit" name="deposit_category_edit_submit" id="deposit_category_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/settings/variables/partials/deposit_category.blade.php ENDPATH**/ ?>