<?php if(session()->has('message')): ?>
    <div class="alert alert-<?php echo e(session('type')); ?> alert-dismissible fade show text-center" role="alert">
        <strong><?php echo e(session('message')); ?></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" >
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/includes/session_message.blade.php ENDPATH**/ ?>