
<nav class="bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center pt-2 pb-2">
            <div>
                <div class="navbar-brand"><?php if($general_settings->site_logo ?? "no"): ?><img src="<?php echo e(asset('/images/logo/'.$general_settings->site_logo)); ?>" width="50">&nbsp; &nbsp;<?php endif; ?><?php echo e($general_settings->site_title ?? "AvantcoreTechnologiesCRM"); ?></div>
            </div>

            <div class="collapse navbar-collapse show" id="navbarTogglerDemo03">
                <nav class="my-2 my-md-0 mr-md-3 text-right">
                    
                    <a class="p-2 text-dark" href="<?php echo e(route('jobs')); ?>"><?php echo e(trans('file.Jobs')); ?></a>
                    
                    
                </nav>
            </div>
        </div>
    </div>
</nav>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/crm/resources/views/frontend/Layout/navigation.blade.php ENDPATH**/ ?>