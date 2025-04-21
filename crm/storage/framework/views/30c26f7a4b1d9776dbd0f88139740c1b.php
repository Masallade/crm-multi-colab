
<div id="confirmDeleteCheckboxModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title"><?php echo e(trans('file.Confirmation')); ?></h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" id="confirmMessage"><?php echo e(__('Are you sure to delete these selected data?')); ?></h4>
            </div>
            <div class="modal-footer">
                <button type="submit" id="deleteCheckboxSubmit" class="btn btn-danger"><?php echo e(trans('file.Yes')); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(trans('file.Cancel')); ?></button>
            </div>
        </div>
    </div>
  </div><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/performance/goal-type/delete-checkbox-confirm-modal.blade.php ENDPATH**/ ?>