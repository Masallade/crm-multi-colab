
<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo e(route('travel_method.index')); ?>" id="Travel_method-tab" data-toggle="tab" data-target="#Travel_method" role="tab" aria-controls="Travel_method" aria-selected="true"><?php echo e(__('Arrangement Method')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo e(route('payment_method.index')); ?>" id="Payment_method-tab" data-toggle="tab" data-table= "payment" data-target="#Payment_method" role="tab" aria-controls="Payment_method" aria-selected="false"><?php echo e(__('Payment Type')); ?></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('employee_qualification.index')); ?>" id="employee_qualification-tab" data-toggle="tab" data-table= "employee_qualification" data-target="#employee_qualification" role="tab" aria-controls="employee_qualification" aria-selected="false"><?php echo e(trans('file.Qualification')); ?></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('job_categories.index')); ?>" id="Job_category-tab" data-toggle="tab" data-table= "job_category" data-target="#job_category" role="tab" aria-controls="job_category" aria-selected="false"><?php echo e(__('Job Category')); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="Travel_method" role="tab" aria-labelledby="Travel_method-tab">
                <?php echo $__env->make('settings.variables_method.partials.travel_method', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="tab-pane fade " id="Payment_method" role="tab"  aria-labelledby="Payment_method-tab">
               <?php echo $__env->make('settings.variables_method.partials.payment_method', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>


            <div class="tab-pane fade " id="employee_qualification" role="tab"  aria-labelledby="employee_qualification-tab">
                <?php echo $__env->make('settings.variables_method.partials.employee_qualification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="tab-pane fade " id="job_category" role="tab"  aria-labelledby="job_category-tab">
                <?php echo $__env->make('settings.variables_method.partials.job_category', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

        </div>

    </section>


<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        (function($) {
            "use strict";

            let travelLoad = 0;
            $(document).ready(function() {
                if (travelLoad == 0) {
                    <?php echo $__env->make('settings.variables_method.JS_DT.travel_method_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        travelLoad = 1;
                }
            });

            $('[data-table="payment"]').one('click', function (e) {
                <?php echo $__env->make('settings.variables_method.JS_DT.payment_method_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            });

            $('[data-table="employee_qualification"]').one('click', function (e) {
                <?php echo $__env->make('settings.variables_method.JS_DT.employee_qualification_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            });

            $('[data-table="languageSkills"]').one('click', function (e) {
                <?php echo $__env->make('settings.variables_method.JS_DT.language_skills_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            });

            $('[data-table="otherSkills"]').one('click', function (e) {
                <?php echo $__env->make('settings.variables_method.JS_DT.general_skills_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            });

            $('[data-table="job_category"]').one('click', function (e) {
                <?php echo $__env->make('settings.variables_method.JS_DT.job_category_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/crm/resources/views/settings/variables_method/index.blade.php ENDPATH**/ ?>