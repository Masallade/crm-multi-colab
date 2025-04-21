<!-- navbar-->
<header class="header header-shadow">
<link rel="stylesheet" href="<?php echo e(asset('css/ammar-header.css')); ?>" type="text/css">
    <nav class="navbar">
        <div class="container-fluid">
            
            <div class="ammar-navbar-holder">


                <div class="nav-bar-left-elements">
                <a id="toggle-btn" href="#" class="menu-btn"><i class="dripicons-menu header-i"> </i></a>
                <span class="image-span" id="site_logo_main">
                    <?php if($general_settings->site_logo): ?>
						<img class="logo-pic" src="<?php echo e(asset('/images/logo/'.$general_settings->site_logo)); ?>">
                        &nbsp; &nbsp;
                    <?php endif; ?>
                </span>
                </div>


                <div class="nav-bar-right-elements">
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    
                    
                    <li class="nav-item">
                        <div class="btn-group">
                            
                            <?php if(Auth::user()->id===1): ?>
                            <button class="button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Create">
                                <i class="fa fa-plus-circle header-i"></i>
                            </button>
                            <?php endif; ?>
                            <div class="dropdown-menu">
                                <?php $__currentLoopData = $addFrom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="<?php echo e($item['url']); ?>">Add <?php echo e($item['title']); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                          </div>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-header-name" style="padding-right: 10px" href="<?php echo e(url('/optimize')); ?>" data-toggle="tooltip" title="Clear all cache with refresh"><i class="fa fa-refresh header-i"></i></a>
                    </li>
                    <li class="nav-item"><a id="btnFullscreen" data-toggle="tooltip"
                                            title="<?php echo e(__('Full Screen')); ?>"><i class="dripicons-expand header-i"></i></a></li>
                    <li class="nav-item ">
                        <a rel="nofollow" id="notify-btn" href="#" class="nav-link dropdown-item" data-toggle="tooltip"
                           title="<?php echo e(__('Notifications')); ?>">
                            <i class="dripicons-bell header-i"></i>
                            <?php if(auth()->user()->unreadNotifications->count()): ?>
                                <span class="badge badge-danger">
                                    <?php echo e(auth()->user()->unreadNotifications->count()); ?>

                                </span>
                            <?php endif; ?>
                        </a>
                        <ul class="right-sidebar">
                            <li class="header">
                                <span class="pull-right"><a href="<?php echo e(route('clearAll')); ?>"><?php echo e(__('Clear All')); ?></a></span>
                                <span class="pull-left"><a href="<?php echo e(route('seeAllNoti')); ?>"><?php echo e(__('See All')); ?></a></span>
                            </li>
                            <?php $__currentLoopData = auth()->user()->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a class="unread-notification"
                                       href=<?php echo e($notification->data['link']); ?>><?php echo e($notification->data['data']); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <!-- <li class="nav-item">
                        <a rel="nofollow" href="#" class="nav-link dropdown-item" data-toggle="tooltip"
                           title="<?php echo e(__('Language')); ?>">
                            <i class="dripicons-web"></i>
                        </a>
                        <ul class="right-sidebar">
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(route('language.switch',$lang)); ?>"><?php echo e($lang); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li> -->

                    <li class="nav-item">
                        <a rel="nofollow" href="#" class="nav-link dropdown-item">
                            <?php if(!empty(auth()->user()->profile_photo)): ?>
                                <img class="profile-photo sm mr-1"
                                     src="<?php echo e(asset('uploads/profile_photos/')); ?>/<?php echo e(auth()->user()->profile_photo); ?>">
                            <?php else: ?>
                                <img class="profile-photo sm mr-1"
                                     src="<?php echo e(asset('uploads/profile_photos/avatar.jpg')); ?>">
                            <?php endif; ?>
                            <span> <?php echo e(auth()->user()->username); ?></span>
                        </a>
                        <ul class="right-sidebar">
                            <li>
                                <a href="<?php echo e(route('profile')); ?>">
                                    <i class="dripicons-user header-i"></i>
                                    <?php echo e(trans('file.Profile')); ?>

                                </a>
                            </li>
                            <?php if(Auth::user()->id===1): ?>
                            <?php if(auth()->user()->role_users_id == 1): ?>
                                <li id="empty_database">
                                    <a href="#">
                                        <i class="dripicons-stack header-i"></i>
                                        <?php echo e(__('Empty Database')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(auth()->user()->role_users_id == 1): ?>
                                <li id="export_database">
                                    <a href="<?php echo e(route('export_database')); ?>">
                                        <i class="dripicons-cloud-download header-i"></i>
                                        <?php echo e(__('Export Database')); ?>

                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php endif; ?>
                            <li>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-link" type="submit"><i
                                                class="dripicons-exit"></i> <?php echo e(trans('file.logout')); ?></button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                </div>
            </div>
        </div>
    </nav>
    <?php echo $__env->make('shared.flash_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</header><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/layout/main_partials/header.blade.php ENDPATH**/ ?>