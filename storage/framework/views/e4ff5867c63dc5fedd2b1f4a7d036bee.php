<?php
    $general_settings = \App\Models\GeneralSetting::latest()->first();
?>

<html lang="en">
<head>
    <?php echo $__env->make('frontend.Layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="d-flex flex-column h-100">
	<?php echo $__env->make('frontend.Layout.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div class="frontend">
	    <?php echo $__env->yieldContent('content'); ?>
	</div>
	<footer class="footer mt-auto py-3 bg-dark text-center">
		<div class="container">
			<p class="mb-0 text-light">&copy; <?php echo e($general_settings->footer); ?> <?php echo e(date('Y')); ?></p>
		</div>
	</footer>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/crm/resources/views/frontend/Layout/master.blade.php ENDPATH**/ ?>