<?php $__env->startSection('content'); ?>
    <style>
        /* Fix tab link colors - override any CSS conflicts */
        .nav-tabs .nav-link {
            color: #007bff !important;
            border: 1px solid transparent !important;
            border-top-left-radius: 0.25rem !important;
            border-top-right-radius: 0.25rem !important;
            padding: 0.5rem 1rem !important;
            cursor: pointer !important;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6 !important;
            color: #0056b3 !important;
        }
        
        .nav-tabs .nav-link.active {
            color: #495057 !important;
            background-color: #fff !important;
            border-color: #dee2e6 #dee2e6 #fff !important;
        }
        
        .nav-tabs {
            border-bottom: 1px solid #dee2e6 !important;
        }
        
        /* Alert styling for better visibility */
        #success-alert, #error-alert {
            position: relative;
            z-index: 1050;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 6px;
            font-size: 1rem;
            padding: 15px 20px;
            animation: slideDown 0.5s ease-out;
        }
        
        #success-alert {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        #error-alert {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        #success-alert strong, #error-alert strong {
            font-size: 1.1rem;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    
    <section>
    <!-- Display alerts OUTSIDE tab content so they're always visible -->
    <?php if(session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert">
            <strong><i class="fa fa-check-circle"></i> Success!</strong> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    
    <?php if(session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" id="error-alert" role="alert">
            <strong><i class="fa fa-exclamation-circle"></i> Error!</strong> <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <!-- rest of your tab content -->
        <div class="container-fluid">
            <div class="card">
                <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo e(route('leave_type.index')); ?>" id="Leave_type-tab" data-toggle="tab" data-table= "leave" data-target="#Leave_type" role="tab" aria-controls="Leave_type" aria-selected="true"><?php echo e(__('Leave Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo e(route('addLeave_employee.index')); ?>" id="addLeave_employee-tab" data-toggle="tab" data-table= "addLeave_employee" data-target="#addLeave_employee" role="tab" aria-controls="addLeave_employee" aria-selected="true">Add Employee Leave</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo e(route('award_type.index')); ?>" id="Award_type-tab" data-toggle="tab" data-table= "award" data-target="#Award_type" role="tab" aria-controls="Award_type" aria-selected="false"><?php echo e(__('Award Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('warning_type.index')); ?>" id="Warning_type-tab" data-toggle="tab" data-table= "warning" data-target="#Warning_type" role="tab" aria-controls="Warning_type" aria-selected="false"><?php echo e(__('Warning Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('termination_type.index')); ?>" id="Termination_type-tab" data-toggle="tab" data-table= "termination" data-target="#Termination_type" role="tab" aria-controls="Termination_type" aria-selected="false"><?php echo e(__('Termination Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('expense_type.index')); ?>" id="Expense_type-tab" data-toggle="tab" data-table= "expense" data-target="#Expense_type" role="tab" aria-controls="Expense_type" aria-selected="false"><?php echo e(__('Expense Type')); ?></a>
                    </li>
<!-- updated dawood add: appraisal type -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('expense_type.index')); ?>" id="appraisal_type-tab" data-toggle="tab" data-table= "appraisal" data-target="#Appraisal_type" role="tab" aria-controls="Appraisal_type" aria-selected="false"><?php echo e(__('Appraisal Type')); ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('status_type.index')); ?>" id="Status_type-tab" data-toggle="tab" data-table= "status" data-target="#Status_type" role="tab" aria-controls="Status_type" aria-selected="false"><?php echo e(__('Employee Status')); ?></a>
                    </li>
                </ul>
                <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo e(route('document_type.index')); ?>" id="Document_type-tab" data-toggle="tab" data-table= "document" data-target="#Document_type" role="tab" aria-controls="Document_type" aria-selected="false"><?php echo e(__('Document Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="Company_type-tab" data-toggle="tab" data-table="company_type" data-target="#Company_type" role="tab" aria-controls="Company_type" aria-selected="false"><?php echo e(__('Company Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="Relation_type-tab" data-toggle="tab" data-table="relation_type" data-target="#Relation_type" role="tab" aria-controls="Relation_type" aria-selected="false"><?php echo e(__('Relation Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="Loan_type-tab" data-toggle="tab" data-table="loan_type" data-target="#Loan_type" role="tab" aria-controls="Loan_type" aria-selected="false"><?php echo e(__('Loan Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="Deduction_type-tab" data-toggle="tab" data-table="deduction_type" data-target="#Deduction_type" role="tab" aria-controls="Deduction_type" aria-selected="false"><?php echo e(__('Deduction Type')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="depositCategory-tab" data-toggle="tab" data-table="deposit_category" data-target="#depositCategory" role="tab" aria-controls="depositCategory" aria-selected="false"><?php echo e(__('Deposit Category')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#" id="jobExperience-tab" data-toggle="tab" data-table="job_experience" data-target="#jobExperience" role="tab" aria-controls="jobExperience" aria-selected="false"><?php echo e(__('Job Experience Type')); ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">

            <div class="pt-0 tab-pane fade show active" id="Leave_type" role="tab" aria-labelledby="Leave_type-tab">
              <?php echo $__env->make('settings.variables.partials.leave_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="pt-0 tab-pane fade" id="addLeave_employee" role="tab" aria-labelledby="addLeave_employee-tab">
              <?php echo $__env->make('settings.variables.partials.addLeave_employee', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="pt-0 tab-pane fade " id="Award_type" role="tab"  aria-labelledby="Award_type-tab">
               <?php echo $__env->make('settings.variables.partials.award_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Warning_type" role="tab"  aria-labelledby="Warning_type-tab">
                <?php echo $__env->make('settings.variables.partials.warning_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Termination_type" role="tab"  aria-labelledby="Termination_type-tab">
                <?php echo $__env->make('settings.variables.partials.termination_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Expense_type" role="tab"  aria-labelledby="Expense_type-tab">
                <?php echo $__env->make('settings.variables.partials.expense_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Status_type" role="tab"  aria-labelledby="Status_type-tab">
                <?php echo $__env->make('settings.variables.partials.status_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Document_type" role="tab"  aria-labelledby="Document_type-tab">
                <?php echo $__env->make('settings.variables.partials.document_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Company_type" role="tab"  aria-labelledby="Company_type-tab">
                <?php echo $__env->make('settings.variables.partials.company_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Relation_type" role="tab"  aria-labelledby="Relation_type-tab">
                <?php echo $__env->make('settings.variables.partials.relation_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Loan_type" role="tab"  aria-labelledby="Loan_type-tab">
                <?php echo $__env->make('settings.variables.partials.loan_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="Deduction_type" role="tab"  aria-labelledby="Deduction_type-tab">
                <?php echo $__env->make('settings.variables.partials.deduction_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="depositCategory" role="tab"  aria-labelledby="depositCategory-tab">
                <?php echo $__env->make('settings.variables.partials.deposit_category', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="pt-0 tab-pane fade " id="jobExperience" role="tab"  aria-labelledby="jobExperience-tab">
                <?php echo $__env->make('settings.variables.partials.job_experience', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

<!-- updated by dawood  -->
            <div class="pt-0 tab-pane fade " id="Appraisal_type" role="tab"  aria-labelledby="appraisal_type-tab">
            <?php echo $__env->make('settings.variables.partials.appraisal_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </section>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    (function($) {
        "use strict";

        let leaveLoad = 0;
        $(document).ready(function() {
            if (leaveLoad == 0) {
                // leave_type_js
                <?php echo $__env->make('settings.variables.JS_DT.leave_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
                    leaveLoad = 1;
            }
        });

      

        $('[data-table="addLeave_employee"]').one('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.addEmployee_leave_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="award"]').one('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.award_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="warning"]').one('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.warning_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="termination"]').one('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.termination_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="expense"]').one('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.expense_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="status"]').one('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.status_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="document"]').on('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.document_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="company_type"]').on('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.company_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="relation_type"]').on('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.relation_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="loan_type"]').on('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.loan_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="deduction_type"]').on('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.deduction_type_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="deposit_category"]').on('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.deposit_category_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });

        $('[data-table="job_experience"]').on('click', function (e) {
            <?php echo $__env->make('settings.variables.JS_DT.job_experience_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        });


    })(jQuery);

    // Auto hide alerts after some time
    document.addEventListener('DOMContentLoaded', function() {
        // For success alert - show for 6 seconds
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            // Scroll to alert so user sees it
            successAlert.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            setTimeout(function() {
                successAlert.style.transition = 'opacity 1s';
                successAlert.style.opacity = '0';
                
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 1000);
            }, 6000); // Changed from 3000 to 6000
        }
        
        // For error alert - show for 8 seconds
        var errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            // Scroll to alert so user sees it
            errorAlert.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            setTimeout(function() {
                errorAlert.style.transition = 'opacity 1s';
                errorAlert.style.opacity = '0';
                
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 1000);
            }, 8000); // Changed from 5000 to 8000
        }
    });

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\project\Laravel\crm-multi-colab-Dawood\resources\views/settings/variables/index.blade.php ENDPATH**/ ?>