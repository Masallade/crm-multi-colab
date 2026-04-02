<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title"><?php echo e(__('Add Arrangement Method')); ?></h3>
            <form method="post" id="travel_method_form" class="form-horizontal" >
                <?php echo csrf_field(); ?>
                <div class="input-group">
                    <input type="text" name="arrangement_type" id="arrangement_type"  class="form-control"
                           placeholder="<?php echo e(__('Arrangement Method')); ?>">
                    <input type="submit" name="travel_method_submit" id="travel_method_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="travel_result"></span>
<div class="table-responsive">
    <table id="travel_method-table" class="table ">
        <thead>
        <tr>
            <th><?php echo e(trans('file.Arrangement')); ?></th>
            <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
        </tr>
        </thead>

    </table>
</div>


<div id="TravelEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="TravelModalLabel" class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>

                <button type="button" data-dismiss="modal" id="travel_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="travel_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="travel_method_form_edit" class="form-horizontal"  >

                    <?php echo csrf_field(); ?>
                    <div class="col-md-4 form-group">
                        <label><?php echo e(__('Arrangement Method')); ?> *</label>
                        <input type="text" name="arrangement_type_edit" id="arrangement_type_edit"  class="form-control"
                               placeholder="<?php echo e(__('Arrangement Method')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_travel_id" id="hidden_travel_id" />
                        <input type="submit" name="travel_method_edit_submit" id="travel_method_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/crm/resources/views/settings/variables_method/partials/travel_method.blade.php ENDPATH**/ ?>