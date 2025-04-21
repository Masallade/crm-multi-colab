
<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><h3 class="card-title"><?php echo e(__('Add Training Type')); ?></h3></div>
                <div class="card-body">
                    <form method="post" id="training_type_form" class="form-horizontal" >
                        <?php echo csrf_field(); ?>
                        <div class="input-group">
                            <input type="text" name="type" id="type"  required class="form-control required"
                                   placeholder="<?php echo e(__('Training Type')); ?>">
                            <input type="submit" name="training_type_submit" id="training_type_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <span class="training_result"></span>
        <div class="table-responsive">
            <table id="training_type-table" class="table ">
                <thead>
                <tr>
                    <th><?php echo e(__('Training Name')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
                </thead>

            </table>
        </div>


        <div id="TrainingEditModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="TrainingModalLabel" class="modal-title"><?php echo e(trans('file.Edit')); ?></h5>

                        <button type="button" data-dismiss="modal" id="training_close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>
                    <span class="training_result_edit"></span>

                    <div class="modal-body">
                        <form method="post" id="training_type_form_edit" class="form-horizontal" enctype="multipart/form-data" >

                            <?php echo csrf_field(); ?>
                            <div class="col-md-4 form-group">
                                <label><?php echo e(__('Training Type')); ?> *</label>
                                <input type="text" name="type_edit" id="type_edit" required class="form-control"
                                       placeholder="<?php echo e(__('Training Type')); ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="hidden" name="hidden_training_id" id="hidden_training_id" />
                                <input type="submit" name="training_type_edit_submit" id="training_type_edit_submit" class="btn btn-success" value=<?php echo e(trans("file.Edit")); ?> />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>



 <?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function() {
            <?php echo $__env->make('training.training_type.training_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/training/training_type/training_type.blade.php ENDPATH**/ ?>