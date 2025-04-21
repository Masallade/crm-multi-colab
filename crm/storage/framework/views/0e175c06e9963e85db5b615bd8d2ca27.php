<!--Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
            <div class="modal-body">
                <h4 align="center" style="margin:0;"><?php echo app('translator')->get('file.Are you sure to remove this data'); ?> ?</h4>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteSubmit"><?php echo app('translator')->get('file.Yes'); ?></button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo app('translator')->get('file.Cancel'); ?></button>
        </div>
      </div>
    </div>
  </div>
<?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/performance/indicator/delete-modal.blade.php ENDPATH**/ ?>