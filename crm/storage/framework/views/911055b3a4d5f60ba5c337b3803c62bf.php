
<?php $__env->startSection('content'); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-file_manager')): ?>
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="card-header"><h3 class="card-title"><?php echo e(__('File Manager Configuration')); ?></h3></div>

                        <span id="form_result"></span>

                        <form method="post" id="file_config_form" class="form-horizontal" >
                            <?php echo csrf_field(); ?>
                            <div class="col-md-4 form-group">
                                <label><?php echo e(__('Allowed Extensions')); ?> *</label>
                                <input type="text" name="allowed_extensions" id="allowed_extensions"  data-role="tagsinput" required class="form-control required"
                                     value="<?php echo e($file_config->allowed_extensions ?? 'allowed extensions'); ?>" >
                            </div>

                            <div class="col-md-4 form-group">
                                <label><?php echo e(__('Max file Size')); ?> (mb) *</label>
                                <input type="number" name="max_file_size" id="max_file_size"  max="20" min="1" required class="form-control required"
                                       value="<?php echo e($file_config->max_file_size ?? ''); ?>"
                                       placeholder="">
                            </div>


                            <div class="col-md-4 form-group">
                                <input type="submit" name="file_config_submit" id="file_config_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>



    <script type="text/javascript" >

        $(document).ready(function() {



            $('#file_config_form').on('submit', function (event) {
                event.preventDefault();

                    $.ajax({
                        url: "<?php echo e(route('file_config.store')); ?>",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success: function (data) {
                            let html = '';
                            if (data.errors) {
                                html = '<div class="alert alert-danger">';
                                for (let count = 0; count < data.errors.length; count++) {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                            }
                            $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        }
                    })

            });
        });
    </script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/file_manager/file_config.blade.php ENDPATH**/ ?>