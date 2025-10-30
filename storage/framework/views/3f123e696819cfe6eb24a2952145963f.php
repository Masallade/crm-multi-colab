<style>
    :root {
        --primary-color: #1a67d2;
        --accent-color: #0d6efd;
        --border-color: #dee2e6;
        --group-header-bg: #f5f9ff;
        --group-header-border: #d1e3ff;
        --group-header-color: #0a4491;
        --section-header-bg: #f8f9fa;
        --section-bg: #ffffff;
    }

    .page-container {
        max-width: 1000px;
        margin: 30px auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        padding: 30px;
    }
    
    .company-header {
        margin-bottom: 30px;
        padding: 15px 0;
        border-bottom: 2px solid var(--accent-color);
    }
    
    .company-name {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--primary-color);
        margin: 0;
    }
    
    .subtitle {
        font-size: 1rem;
        color: #606060;
        margin-top: 5px;
        margin-bottom: 0;
    }
    
    .designation-group {
        border: 1px solid var(--group-header-border);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    }
    
    .designation-header {
        padding: 16px 20px;
        background-color: var(--group-header-bg);
        cursor: pointer;
        user-select: none;
        transition: background-color 0.2s;
    }
    
    .designation-header:hover {
        background-color: #e8f0fd;
    }
    
    .designation-title {
        font-size: 1.1rem;
        color: var(--group-header-color);
        font-weight: 600;
    }
    
    .section-count {
        font-size: 0.85rem;
        color: #667185;
        font-weight: normal;
    }
    
    .department-container {
        display: flex;
        flex-wrap: wrap;
    }
    
    .department-badge {
        font-size: 0.8rem;
        color: #505a6b;
        background-color: #e9ecef;
        padding: 4px 12px;
        border-radius: 16px;
        display: inline-block;
        border: 1px solid #dee2e6;
    }
    
    .toggle-icon, .section-toggle-icon {
        font-size: 1rem;
        transition: transform 0.3s;
        color: #6c757d;
    }
    
    .designation-sections {
        padding: 15px;
        background-color: #f8f9fa;
    }
    
    .section-container {
        background-color: var(--section-bg);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    
    .section-header {
        padding: 14px 20px;
        background-color: var(--section-header-bg);
        cursor: pointer;
        user-select: none;
        transition: background-color 0.2s;
        border-bottom: 1px solid var(--border-color);
    }
    
    .section-header:hover {
        background-color: #f0f2f5;
    }
    
    .section-title {
        font-size: 1rem;
        color: #444;
        font-weight: 500;
    }
    
    .weightage-display {
        padding: 12px 16px;
        background-color: #f8f9fa;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }
    
    .weightage-label {
        font-weight: 500;
        color: #495057;
        margin-right: 10px;
    }
    
    .weightage-value {
        font-weight: 600;
        color: var(--accent-color);
        background-color: #e9f0fd;
        padding: 2px 8px;
        border-radius: 4px;
    }
    
    .indicators-title {
        font-size: 1rem;
        font-weight: 600;
        color: #495057;
        padding-bottom: 12px;
        margin-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .indicator-item {
        padding: 14px 18px;
        background-color: #ffffff;
        border-left: 3px solid var(--accent-color);
        margin-bottom: 10px;
        border-radius: 0 4px 4px 0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #efefef;
        border-left: 3px solid var(--accent-color);
    }
    
    .indicator-item:hover {
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }
    
    .indicator-name {
        font-size: 0.95rem;
        color: #333;
    }
    
    .indicator-actions {
        display: flex;
        gap: 8px;
    }
    
    .section-content {
        padding: 20px;
    }
    
    @media (max-width: 768px) {
        .designation-header {
            padding: 12px 15px;
        }
        
        .department-container {
            margin-top: 10px;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .section-header > div:last-child {
            margin-top: 10px;
            width: 100%;
            justify-content: flex-end;
        }
    }
    
    @media (max-width: 576px) {
        .indicator-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .indicator-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<div class="page-container">
    <!-- Company Header -->
    <div class="company-header">
        <div class="text-center">
            <h1 class="company-name">Base Practice Support</h1>
            <p class="subtitle">Employee Performance Appraisal</p>
        </div>
    </div>

    <!-- Collapse/Expand Controls -->
    <div class="mb-3 d-flex justify-content-end">
        <button id="collapseAllBtn" class="btn btn-outline-secondary mr-2">
            <i class="fa fa-compress"></i> Collapse All
        </button>
        <button id="expandAllBtn" class="btn btn-outline-secondary">
            <i class="fa fa-expand"></i> Expand All
        </button>
    </div>

        <!-- Designation Groups -->
        <div id="designationGroupsContainer">
            <?php
                $groupedSections = collect($sections)->groupBy('designation_name');
            ?>

        <?php $__currentLoopData = $groupedSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation => $designationSections): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="designation-group mb-4">
                <div class="designation-header" data-toggle="collapse" data-target="#designation-<?php echo e(str_replace(' ', '-', $designation)); ?>" aria-expanded="true">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <div class="d-flex align-items-center">
                                <i class="fa fa-users mr-2"></i>
                                <h2 class="designation-title mb-0">Designation: <?php echo e($designation); ?></h2>
                                <span class="section-count ml-2">(<?php echo e(count($designationSections)); ?> sections)</span>
                            </div>
                            <div class="department-container mt-2">
                                <?php $__currentLoopData = $designationSections[0]['department_names']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departmentName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="department-badge mr-2"><?php echo e($departmentName); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <form action="<?php echo e(route('deleteAppraisal')); ?>" method="post" class="mr-2" onclick="event.stopPropagation();">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="sections" value='<?php echo json_encode($designationSections, JSON_HEX_APOS, 512) ?>'>
                                <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                                    <i class="fa fa-trash mr-1"></i>
                                    <span>Delete</span>
                                </button>
                            </form>

                            <form method="post" action="<?php echo e(route('updateWholeAppraisal')); ?>" onclick="event.stopPropagation();">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="sections" value='<?php echo json_encode($designationSections, JSON_HEX_APOS, 512) ?>'>
                                <button type="submit" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                                    <i class="fa fa-pencil mr-1"></i>
                                    <span>View & Edit</span>
                                </button>
                            </form>
                            <span class="ml-3" onclick="event.stopPropagation();">
                                <i class="fa fa-chevron-down toggle-icon"></i>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div id="designation-<?php echo e(str_replace(' ', '-', $designation)); ?>" class="collapse show">
                        <div class="designation-sections">
                        <?php $__currentLoopData = $designationSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="section-container mb-3">
                                <div class="section-header d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#section-<?php echo e($section['id']); ?>">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-clipboard mr-2"></i>
                                        <h3 class="section-title mb-0"><?php echo e($section['name']); ?></h3>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <form method="post" action="<?php echo e(route('edit.appraisal.section')); ?>" class="m-0 mr-2" onclick="event.stopPropagation();">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="section" value='<?php echo json_encode($section, JSON_HEX_APOS, 512) ?>'>
                                        </form>
                                        <span onclick="event.stopPropagation();">
                                            <i class="fa fa-chevron-down section-toggle-icon"></i>
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="section-<?php echo e($section['id']); ?>" class="collapse">
                                    <div class="section-content p-3">
                                        <div class="weightage-display">
                                            <i class="fa fa-bar-chart mr-2"></i>
                                            <span class="weightage-label">Section Weightage:</span>
                                            <span class="weightage-value"><?php echo e($section['weightage']); ?></span>
                                        </div>
                                        <div class="indicators-section mt-3">
                                            <h4 class="indicators-title">
                                                <i class="fa fa-list-ul mr-2"></i>
                                                Performance Indicators
                                            </h4>
                                            <div class="indicator-list">
                                                <?php $__currentLoopData = $section["performance_indicator"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="indicator-item" data-indicator-id="<?php echo e($indicator['id']); ?>">
                                                        <h5 class="indicator-name mb-0"><?php echo e($indicator["name"]); ?></h5>
                                                        <div class="indicator-actions">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary mr-2">
                                                                <i class="fa fa-pencil"></i>
                                                                <span>Edit</span>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-outline-danger">
                                                                <i class="fa fa-trash"></i>
                                                                <span>Delete</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

<script>
$(document).ready(function() {
    // Update icon on collapse events
    $('.collapse').on('shown.bs.collapse', function() {
        var target = $(this).attr('id');
        var header = $('[data-target="#' + target + '"]');
        header.find('.toggle-icon, .section-toggle-icon').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });
    
    $('.collapse').on('hidden.bs.collapse', function() {
        var target = $(this).attr('id');
        var header = $('[data-target="#' + target + '"]');
        header.find('.toggle-icon, .section-toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });
    
    // Collapse All button
    $('#collapseAllBtn').on('click', function() {
        $('.collapse.show').collapse('hide');
        $('.toggle-icon, .section-toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });
    
    // Expand All button
    $('#expandAllBtn').on('click', function() {
        $('.collapse:not(.show)').collapse('show');
        $('.toggle-icon, .section-toggle-icon').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });
});
</script><?php /**PATH D:\project\Laravel\crm-multi-colab-Dawood\resources\views/settings/variables/partials/view_appraisal.blade.php ENDPATH**/ ?>