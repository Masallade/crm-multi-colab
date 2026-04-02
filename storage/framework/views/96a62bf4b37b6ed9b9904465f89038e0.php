<div class="container-fluid">
    <div class="card mb-0">
        <div class="card-body">           
            <h3 class="card-title"><?php echo e(__('Add Payment Method')); ?></h3>
            <form method="post" id="payment_method_form" class="form-horizontal" >
                <?php echo csrf_field(); ?>
                <div class="input-group">
                    <input type="text" name="method_name" id="method_name"  class="form-control"
                           placeholder="<?php echo e(__('Payment Method')); ?>">
                    <input type="text" name="payment_percentage" id="payment_percentage"  class="form-control"
                           placeholder="<?php echo e(__('Payment Percentage')); ?>">
                    <input type="text" name="account_number" id="account_number"  class="form-control"
                           placeholder="<?php echo e(__('Account Number')); ?>">
                    <input type="submit" name="payment_method_submit" id="payment_method_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="payment_result"></span>
<div class="table-responsive">
    <table id="payment_method-table" class="table ">
        <thead>
        <tr>
            <th><?php echo e(__('Payment Method')); ?></th>
            <th><?php echo e(__('Payment Percentage')); ?></th>
            <th><?php echo e(__('Account Number')); ?></th>
            <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
        </tr>
        </thead>

    </table>
</div>


<div id="PaymentEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="PaymentModalLabel" class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>

                <button type="button" data-dismiss="modal" id="payment_close" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <span class="payment_result_edit"></span>

            <div class="modal-body">
                <form method="post" id="payment_method_form_edit" class="form-horizontal"  >

                    <?php echo csrf_field(); ?>
                    <div class="col-md-4 form-group">
                        <label><?php echo e(__('Payment Method')); ?> *</label>
                        <input type="text" name="method_name_edit" id="method_name_edit"  class="form-control"
                               placeholder="<?php echo e(__('Payment Method')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label><?php echo e(__('Payment Percentage')); ?> </label>
                        <input type="text" name="payment_percentage_edit" id="payment_percentage_edit"  class="form-control"
                               placeholder="<?php echo e(__('Payment Percentage')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <label><?php echo e(__('Account Number')); ?> </label>
                        <input type="text" name="account_number_edit" id="account_number_edit"  class="form-control"
                               placeholder="<?php echo e(__('Account Number')); ?>">
                    </div>
                    <div class="col-md-4 form-group">
                        <input type="hidden" name="hidden_payment_id" id="hidden_payment_id" />
                        <input type="submit" name="payment_method_edit_submit" id="payment_method_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/crm/resources/views/settings/variables_method/partials/payment_method.blade.php ENDPATH**/ ?>