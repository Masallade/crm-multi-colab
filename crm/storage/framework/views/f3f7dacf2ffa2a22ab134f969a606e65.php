

<?php $__env->startSection('content'); ?>


    <span id="form_result"></span>

    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4><?php echo e(__('General Setting')); ?></h4>
                        </div>
                        <div class="card-body">
                            <p class="italic"><small><?php echo e(__('The field labels marked with * are required input fields')); ?>.</small></p>
                            <form method="POST"  id="general_settings_form" action="<?php echo e(route('general_settings.update',1)); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(__('Site Title')); ?> *</strong></label>
                                            <input type="text" name="site_title" class="form-control" value="<?php echo e($general_settings_data->site_title ?? ''); ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(__('Site Logo')); ?></strong></label>
                                            <input type="file" name="site_logo" class="form-control" value=""/>
                                        </div>
                                        <?php if($errors->has('site_logo')): ?>
                                            <span>
                                       <strong><?php echo e($errors->first('site_logo')); ?></strong>
                                    </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Currency')); ?> *</strong></label>
                                            <input type="text" name="currency" class="form-control" value="<?php echo e($general_settings_data->currency ?? ''); ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(__('Currency Format')); ?> *</strong></label><br>

                                            <?php if($general_settings_data->currency_format == 'prefix'): ?>
                                                <label class="radio-inline">
                                                    <input type="radio" name="currency_format" value="prefix" checked> <?php echo e(trans('file.Prefix')); ?>

                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="currency_format" value="suffix"> <?php echo e(trans('file.Suffix')); ?>

                                                </label>
                                            <?php else: ?>
                                                <label class="radio-inline">
                                                    <input type="radio" name="currency_format" value="prefix"> <?php echo e(trans('file.Prefix')); ?>

                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="currency_format" value="suffix" checked> <?php echo e(trans('file.Suffix')); ?>

                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(__('Time Zone')); ?></strong></label>

                                            <select name="timezone" class="selectpicker form-control" data-live-search="true" title="<?php echo e(__('Time Zone')); ?>...">
                                                <?php $__currentLoopData = $zones_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($zone['zone']); ?>" <?php echo e(($general_settings_data->time_zone == $zone['zone']) ? "selected" : ''); ?> ><?php echo e($zone['diff_from_GMT'] . ' - ' . $zone['zone']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(__('Default Bank')); ?> *</strong></label>
                                            <select name="account_id" id="account_id"  class="form-control selectpicker" required
                                                    data-live-search="true" data-live-search-style="contains"
                                                    title='<?php echo e(__('Selecting',['key'=>trans('file.Account')])); ?>...'>
                                                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($account->id); ?>" <?php echo e(($account->id == $general_settings_data->default_payment_bank) ? 'selected':''); ?>><?php echo e($account->account_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(__('Date Format')); ?> *</strong></label>
                                            <?php if($general_settings_data): ?>
                                                <input type="hidden" id="date_format_hidden"  name="date_format_hidden" value="<?php echo e($general_settings_data->date_format); ?>">
                                            <?php endif; ?>
                                            <select name="date_format" class="selectpicker form-control">
                                                <option value="d-m-Y">dd-mm-yyyy(23-05-2020)</option>
                                                <option value="Y-m-d">yyyy-mm-dd(2020-05-23)</option>

                                                <option value="m/d/Y">mm/dd/yyyy(05/23/2020)</option>
                                                <option value="Y/m/d">yyyy/mm/dd(2020/05/23)</option>

                                                <option value="Y-M-d">yyyy-MM-dd(2020-May-23)</option>
                                                <option value="M-d-Y">MM-dd-yyyy(May-23-2020)</option>
                                                <option value="d-M-Y">dd-MM-yyyy(23-May-2020)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Footer')); ?> </strong></label>
                                            <input type="text" name="footer" class="form-control" value="<?php echo e($general_settings_data->footer ?? ''); ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Footer_Link')); ?> </strong></label>
                                            <input type="text" name="footer_link" placeholder="https://avantcoretech.com" class="form-control" value="<?php echo e($general_settings_data->footer_link ?? ''); ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-4 form-check">
                                            <input type="checkbox" name="rtl_layout" class="form-check-input" value="1" <?php echo e(env('RTL_LAYOUT')!=NULL ? 'checked':''); ?> />
                                            <label class="mr-4 form-check-label"><strong><?php echo e(trans('file.RTL Layout')); ?> </strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-4 form-check">
                                            <input type="checkbox" name="enable_clockin_clockout" class="form-check-input" value="1" <?php echo e(env('ENABLE_CLOCKIN_CLOCKOUT')!=NULL ? 'checked':''); ?>/>
                                            <label class="mr-4 form-check-label"><strong><?php echo e(trans('file.Enable Clock In and Clock Out')); ?> </strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-4 form-check">
                                            <input type="checkbox" name="enable_early_clockin" class="form-check-input" value="1" <?php echo e(env('ENABLE_EARLY_CLOCKIN')!=NULL ? 'checked':''); ?>/>
                                            <label class="mr-4 form-check-label"><strong><?php echo e(trans('file.Enable Early Clock In (Added to Worktime)')); ?> </strong></label>
                                        </div>
                                    </div>
                                    
                                </div>
                                <br><br>
                                <div class="d-flex justify-content-center">
                                    <input type="submit" id="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary btn-lg btn-block">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        (function($) {
            "use strict";

            $("ul#setting").siblings('a').attr('aria-expanded','true');
            $("ul#setting").addClass("show");
            $("ul#setting #general-setting-menu").addClass("active");

            $('select[name=date_format]').val(($('#date_format_hidden')).val());

            if($("input[name='timezone_hidden']").val()){
                $('select[name=timezone]').val($("input[name='timezone_hidden']").val());
                $('.selectpicker').selectpicker('refresh');
            }

            $('.selectpicker').selectpicker({
                style: 'btn-link',
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/settings/general_settings/index.blade.php ENDPATH**/ ?>