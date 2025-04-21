<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">
            <h3 class="card-title"><?php echo e(__('Add Company Type')); ?></h3>
            <form method="post" id="company_type_form" class="form-horizontal" >
                <?php echo csrf_field(); ?>
                <div class="input-group">
                    <input type="text" name="type_name" id="type_name"  class="form-control"
                           placeholder="<?php echo e(__('Company Type')); ?>">

                    <input type="submit" id="company_type_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                </div>
            </form>
        </div>
    </div>
</div>

<span class="company_type_result"></span>
<div class="table-responsive">
    <table id="company_type-table" class="table ">
        <thead>
        <tr>
            <th><?php echo e(__('Type name')); ?></th>
            <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
        </tr>
        </thead>

    </table>
</div>


<div id="CompanyEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="AwardModalLabel" class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>

                <button type="button" data-dismiss="modal" id="company_type_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="company_type_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="company_type_form_edit" class="form-horizontal" enctype="multipart/form-data" >
                    <input type="hidden" name="hidden_company_type_id" id="hidden_company_type_id" />

                    <?php echo csrf_field(); ?>
                    <div class="col-md-6 form-group">
                        <label><?php echo e(__('Company Type')); ?> *</label>
                        <input type="text" name="type_name_edit" id="type_name_edit"  class="form-control"
                               placeholder="<?php echo e(__('Type Type')); ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <input type="submit" name="company_type_edit_submit" id="company_type_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/settings/variables/partials/company_type.blade.php ENDPATH**/ ?>