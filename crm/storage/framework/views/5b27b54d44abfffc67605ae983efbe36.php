
<link rel="stylesheet" href="<?php echo asset('css/dawood-dashboard-sidebar.css') ?>" type="text/css">
<nav class="side-navbar side-bar-margin sidebar-background">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled mb-5">

                <?php if(auth()->user()->role_users_id ==1): ?>
                    <li class="<?php echo e((request()->is('admin/dashboard*')) ? 'active' : ''); ?>"><a
                                href="<?php echo e(route('admin.dashboard')); ?>"> <i
                                    class="sidebar-i dripicons-meter sidebar-i"></i><span><?php echo e(trans('file.Dashboard')); ?></span></a>
                    </li>
                <?php else: ?>
                    <li class="<?php echo e((request()->is('employee/dashboard*')) ? 'active' : ''); ?>"><a
                                href="<?php echo e(url('/employee/dashboard')); ?>"> <i
                                    class="sidebar-i dripicons-meter sidebar-i"></i><span><?php echo e(trans('file.Dashboard')); ?></span></a>
                    </li>
                <?php endif; ?>



                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-details-employee')): ?>
                    <li class="has-dropdown <?php echo e((request()->is('staff*')) ? 'active' : ''); ?>">
                        <a href="#employees" aria-expanded="false" data-toggle="collapse"> <i class="dripicons-user-group sidebar-i"></i><span><?php echo e(trans('file.Employees')); ?></span></a>
                        <ul id="employees" class="collapse list-unstyled ">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-details-employee')): ?>
                                <li id="employee_list"><a href="<?php echo e(route('employees.index')); ?>"><?php echo e(__('Employee Lists')); ?></a></li>
                                <li id="employee_tracking"><a href="<?php echo e(route('employee_tracking')); ?>">Employee Tracking</a></li>
                                <?php endif; ?>
                            <?php if(Auth::user()->id===1): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('import-employee')): ?>
                                <li id="user-import"><a href="<?php echo e(route('employees.import')); ?>"><?php echo e(__('Import Employees')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

            
                <li class="has-dropdown <?php echo e((request()->is('organization*')) ? 'active' : ''); ?>"><a href="#Organization" aria-expanded="false" data-toggle="collapse">
                        <i class="dripicons-view-thumb sidebar-i"></i><span><?php echo e(trans('file.Organization')); ?></span></a>
                    <ul id="Organization" class="collapse list-unstyled ">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-location')): ?>
                            <li id="location"><a href="<?php echo e(route('locations.index')); ?>"><?php echo e(trans('file.Location')); ?></a></li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-company')): ?>
                            <li id="company"><a href="<?php echo e(route('companies.index')); ?>"><?php echo e(trans('file.Company')); ?></a></li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-department')): ?>
                            <li id="department"><a
                                        href="<?php echo e(route('departments.index')); ?>"><?php echo e(trans('file.Department')); ?></a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-designation')): ?>
                            <li id="designation"><a
                                        href="<?php echo e(route('designations.index')); ?>"><?php echo e(trans('file.Designation')); ?></a>
                            </li>
                        <?php endif; ?>

                        
                            <li id="announcements"><a href="<?php echo e(route('announcements.index')); ?>"><?php echo e(trans('file.Announcements')); ?></a></li>
                        

                        <?php if(auth()->user()->username == 'admin'): ?>
                        
                            <li id="company_policy"><a href="<?php echo e(route('policy.index')); ?>"><?php echo e(__('Company Policy')); ?></a></li>
                        
                        <?php endif; ?>
                    </ul>
                </li>
 
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('core_hr')): ?>
                <li class="has-dropdown <?php echo e((request()->is('core_hr*')) ? 'active' : ''); ?>">

                    <?php if(auth()->user()->can('view-promotion')||auth()->user()->can('view-award') || auth()->user()->can('view-travel')||auth()->user()->can('view-transfer')||auth()->user()->can('view-resignation')||auth()->user()->can('view-complaint')||auth()->user()->can('view-warning')||auth()->user()->can('view-termination')): ?>
                        <a href="#Core_hr" aria-expanded="false" data-toggle="collapse">
                            <i class="dripicons-briefcase sidebar-i"></i><span><?php echo e(__('HR Operations')); ?></span>
                        </a>
                    <?php endif; ?>

                    <ul id="Core_hr" class="collapse list-unstyled">

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-promotion')): ?>
                            <li id="promotion"><a
                                        href="<?php echo e(route('promotions.index')); ?>"><?php echo e(trans('file.Promotion')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-award')): ?>
                            <li id="award"><a href="<?php echo e(route('awards.index')); ?>"><?php echo e(trans('file.Award')); ?></a></li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-travel')): ?>
                            <li id="travel"><a href="<?php echo e(route('travels.index')); ?>"><?php echo e(trans('file.Travel')); ?></a></li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-transfer')): ?>
                            <li id="transfer"><a href="<?php echo e(route('transfers.index')); ?>"><?php echo e(trans('file.Transfer')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-resignation')): ?>
                            <li id="resignation"><a
                                        href="<?php echo e(route('resignations.index')); ?>"><?php echo e(trans('file.Resignations')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-complaint')): ?>
                            <li id="complaint"><a
                                        href="<?php echo e(route('complaints.index')); ?>"><?php echo e(trans('file.Complaints')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-warning')): ?>
                            <li id="warning"><a href="<?php echo e(route('warnings.index')); ?>"><?php echo e(trans('file.Warnings')); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-termination')): ?>
                            <li id="termination"><a
                                        href="<?php echo e(route('terminations.index')); ?>"><?php echo e(trans('file.Terminations')); ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
            <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('timesheet')): ?>
                    <li class="has-dropdown <?php echo e((request()->is('timesheet*')) ? 'active' : ''); ?>">
                        <a href="#Timesheets" aria-expanded="false" data-toggle="collapse">
                    <i class="dripicons-clock sidebar-i"></i><span><?php echo e(trans('file.Timesheets')); ?></span></a>
                        <ul id="Timesheets" class="collapse list-unstyled ">

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-attendance')): ?>
                                <li id="update_attendance"><a
                                            href="<?php echo e(route('update_attendances.index')); ?>"> <?php echo e(__('Attendances Report')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if(Auth::user()->id===1): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('import-attendance')): ?>
                                <li id="import_attendance"><a
                                            href="<?php echo e(route('attendances.import')); ?>"> <?php echo e(__('Import Attendances')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-office_shift')): ?>
                                <li id="office_shift"><a
                                            href="<?php echo e(route('office_shift.index')); ?>"><?php echo e(__('Office Shift')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-holiday')): ?>
                                <li id="holiday"><a href="<?php echo e(route('holidays.index')); ?>"><?php echo e(__('Manage Holiday')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-leave')): ?>
                                <li id="leave"><a href="<?php echo e(route('leaves.index')); ?>"><?php echo e(__('Manage Leaves')); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment-module')): ?>
                    <li class="has-dropdown <?php echo e((request()->is('payroll*')) ? 'active' : ''); ?>">

                        <?php if(auth()->user()->can('view-payslip') || auth()->user()->can('view-paylist')): ?>
                            <a href="#Payroll" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-wallet sidebar-i"></i><span><?php echo e(trans('file.Payroll')); ?></span>
                            </a>
                        <?php endif; ?>

                        <ul id="Payroll" class="collapse list-unstyled ">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-payslip')): ?>
                                <li><a href="<?php echo e(route('payroll.index')); ?>"><?php echo e(__('New Payment')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-paylist')): ?>
                                <li><a href="<?php echo e(route('payment_history.index')); ?>"><?php echo e(__('Payment History')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('performance')): ?>
                        <li class="has-dropdown <?php echo e((request()->is('performance*')) ? 'active' : ''); ?>">
                            <?php if(auth()->user()->can('view-goal-type') || auth()->user()->can('view-goal-tracking') || auth()->user()->can('view-indicator') || auth()->user()->can('view-appraisal')): ?>
                                <a href="#performance" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-bar-chart sidebar-i"></i>
                                    <span>Performance</span>
                                </a>
                            <?php endif; ?>
                            <ul id="performance" class="collapse list-unstyled ">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-goal-type')): ?>
                                    <li id="goal-type"><a href="<?php echo e(route('performance.goal-type.index')); ?>"><?php echo e(__('Goal type')); ?></a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-goal-tracking')): ?>
                                    <li id="goal-tracking"><a href="<?php echo e(route('performance.goal-tracking.index')); ?>"><?php echo e(__('Goal Tracking')); ?></a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-indicator')): ?>
                                    <li id="indicator"><a href="<?php echo e(route('performance.indicator.index')); ?>"><?php echo e(__('Indicator')); ?></a></li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-appraisal')): ?>
                                    <li id="appraisal"><a href="<?php echo e(route('performance.appraisal.index')); ?>"><?php echo e(__('Appraisal')); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(auth()->user()->role_users_id == 1 || auth()->user()->role_users_id == 6): ?>
                    <li class="<?php echo e((request()->is('check-employee-feedback*')) ? 'active' : ''); ?>"><a
                                href="<?php echo e(route('check_employee_feedback')); ?>"> <i
                                    class="sidebar-i dripicons-message sidebar-i"></i><span>Employee Feedback</span></a>
                    </li>
                <?php endif; ?>


<?php if(in_array(auth()->user()->role_users_id, [2, 4])): ?>
    <li class="<?php echo e(request()->is('employee-feedback*') ? 'active' : ''); ?>">
        <a href="<?php echo e(route('employee_feedback')); ?>">
            <i class="sidebar-i dripicons-message"></i>
            <span>Employee Feedback</span>
        </a>
    </li>
<?php endif; ?>


                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('project-management')): ?>
                        <li class="has-dropdown <?php echo e((request()->is('project-management*')) ? 'active' : ''); ?>">
                            <?php if(auth()->user()->can('view-project') || auth()->user()->can('view-task') || auth()->user()->can('client') || auth()->user()->can('view-invoice')): ?>
                                <a href="#Project_Management" aria-expanded="false" data-toggle="collapse">
                                    <i class="dripicons-checklist sidebar-i"></i><span><?php echo e(__('Project Management')); ?></span>
                                </a>
                            <?php endif; ?>
                            <ul id="Project_Management" class="collapse list-unstyled ">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-project')): ?>
                                    <li id="projects"><a
                                                href="<?php echo e(route('projects.index')); ?>"><?php echo e(trans(('file.Projects'))); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-task')): ?>
                                    <li id="tasks"><a
                                                href="<?php echo e(route('tasks.index')); ?>"><?php echo e(trans(('file.Tasks'))); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('client')): ?>
                                    <li id="clients"><a
                                                href="<?php echo e(route('clients.index')); ?>"><?php echo e(trans(('file.Client'))); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-invoice')): ?>
                                    <li id="invoices"><a
                                                href="<?php echo e(route('invoices.index')); ?>"><?php echo e(trans(('file.Invoice'))); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-variable_type')): ?>
                                    <li id="tax_type"><a
                                                href="<?php echo e(route('tax_type.index')); ?>"><?php echo e(__('Tax Type')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-calendar')): ?>
                    <li class="<?php echo e((request()->is('calendar*')) ? 'active' : ''); ?>"><a
                                href="<?php echo e(route('calendar.index')); ?>"> <i
                                    class="sidebar-i dripicons-calendar sidebar-i"></i><span><?php echo e(__('HR Calendar')); ?></span></a>
                    </li>
                <?php endif; ?>

                    <li class="has-dropdown <?php echo e((request()->is('report*')) ? 'active' : ''); ?>"><a href="#HR_Reports"
                                                                                                 aria-expanded="false"
                                                                                                 data-toggle="collapse">
                            <i class="dripicons-document sidebar-i"></i><span><?php echo e(__('HR Reports')); ?></span></a>
                        <ul id="HR_Reports" class="collapse list-unstyled ">

                            <!--New added-->
                            <li id="attendance"><a href="<?php echo e(route('attendances.index')); ?>"><?php echo e(__('Daily Attendances')); ?></a></li>
                            <li id="date_wise_attendance"><a href="<?php echo e(route('date_wise_attendances.index')); ?>"> <?php echo e(__('Date wise Attendances')); ?></a></li>
                            <li id="monthly_attendance"><a href="<?php echo e(route('monthly_attendances.index')); ?>"> <?php echo e(__('Monthly Attendances')); ?></a></li>
                            <!--New added End-->

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-training')): ?>
                                <li id="training_report"><a
                                            href="<?php echo e(route('report.training')); ?>"><?php echo e(__('Training Report')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-project')): ?>
                                <li id="project_report"><a
                                            href="<?php echo e(route('report.project')); ?>"><?php echo e(__('Project Report')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-task')): ?>
                                <li id="task_report"><a
                                            href="<?php echo e(route('report.task')); ?>"><?php echo e(__('Task Report')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-employee')): ?>
                                <li id="employees_report"><a
                                            href="<?php echo e(route('report.employees')); ?>"><?php echo e(__('Employees Report')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-account')): ?>
                                <li id="account_report"><a
                                            href="<?php echo e(route('report.account')); ?>"><?php echo e(__('Account Report')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-expense')): ?>
                                <li id="expense_report"><a
                                            href="<?php echo e(route('report.expense')); ?>"><?php echo e(__('Expense Report')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-deposit')): ?>
                                <li id="deposit_report"><a
                                            href="<?php echo e(route('report.deposit')); ?>"><?php echo e(__('Deposit Report')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-transaction')): ?>
                                <li id="transaction_report"><a
                                            href="<?php echo e(route('report.transaction')); ?>"><?php echo e(__('Transaction Report')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report-pension')): ?>
                                <li id="pension_report"><a href="<?php echo e(route('report.pension')); ?>"><?php echo e(__('Pension Report')); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('recruitment')): ?>
                    <li class="has-dropdown d-none <?php echo e((request()->is('recruitment*')) ? 'active' : ''); ?>">

                        <?php if(auth()->user()->can('view-job_post') || auth()->user()->can('view-job_candidate')|| auth()->user()->can('view-job_interview') || auth()->user()->can('view-cms')): ?>
                            <a href="#Recruitment" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-user-id sidebar-i"></i><span><?php echo e(trans('file.Recruitment')); ?></span>
                            </a>
                        <?php endif; ?>

                        <ul id="Recruitment" class="collapse list-unstyled ">

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-job_post')): ?>
                                <li id="job_post"><a
                                            href="<?php echo e(route('job_posts.index')); ?>"><?php echo e(__('Job Post')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-job_candidate')): ?>
                                <li id="job_candidate"><a
                                            href="<?php echo e(route('job_candidates.index')); ?>"><?php echo e(__('Job Candidates')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-job_interview')): ?>
                                <li id="job_interview"><a
                                            href="<?php echo e(route('job_interviews.index')); ?>"><?php echo e(__('Job Interview')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-cms')): ?>
                                <li id="cms"><a
                                            href="<?php echo e(route('cms.index')); ?>"><?php echo e(__('CMS')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('training_module')): ?>
                    <li class="has-dropdown <?php if(request()->is('training*')): ?><?php echo e((request()->is('training*')) ? 'active' : ''); ?><?php elseif(request()->is('dynamic_variable/training_type*')): ?><?php echo e((request()->is('dynamic_variable/training_type*')) ? 'active' : ''); ?><?php endif; ?>">
                        <?php if(auth()->user()->can('view-training') || auth()->user()->can('access-variable_type')|| auth()->user()->can('access-trainer')): ?>
                            <a href="#Training" aria-expanded="false" data-toggle="collapse"> <i
                                        class="dripicons-trophy sidebar-i"></i><span><?php echo e(trans('file.Training')); ?></span>
                            </a>
                        <?php endif; ?>
                        <ul id="Training" class="collapse list-unstyled ">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-training')): ?>
                                <li id="training_list"><a
                                            href="<?php echo e(route('training_lists.index')); ?>"><?php echo e(__('Training List')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-variable_type')): ?>
                                <li id="training_type"><a
                                            href="<?php echo e(route('training_type.index')); ?>"><?php echo e(__('Training Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-trainer')): ?>
                                <li id="trainers"><a
                                            href="<?php echo e(route('trainers.index')); ?>"><?php echo e(trans('file.Trainers')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('event-meeting')): ?>
                    <li class="has-dropdown <?php if(request()->is('events*')): ?><?php echo e((request()->is('events*')) ? 'active' : ''); ?><?php elseif(request()->is('meetings*')): ?><?php echo e((request()->is('meetings*')) ? 'active' : ''); ?><?php endif; ?>">

                        <?php if(auth()->user()->can('view-event') || auth()->user()->can('view-meeting')): ?>
                            <a href="#Events_Meetings" aria-expanded="false" data-toggle="collapse"> <i
                                        class="dripicons-to-do sidebar-i"></i><span><?php echo e(trans('file.Events')); ?> & <?php echo e(trans('file.Meetings')); ?></span>
                            </a>
                        <?php endif; ?>
                        <ul id="Events_Meetings" class="collapse list-unstyled ">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-event')): ?>
                                <li id="events"><a
                                            href="<?php echo e(route('events.index')); ?>"><?php echo e(trans('file.Events')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-meeting')): ?>
                                <li id="meetings"><a
                                            href="<?php echo e(route('meetings.index')); ?>"><?php echo e(trans('file.Meetings')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <?php endif; ?>
                    </li>


                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-ticket')): ?>
                        <li class="<?php echo e((request()->is('tickets*')) ? 'active' : ''); ?>">
                                <a href="<?php echo e(route('tickets.index')); ?>"> <i
                                            class="dripicons-ticket sidebar-i"></i><span><?php echo e(__('Support Tickets')); ?></span>
                                </a>
                        </li>
                    <?php endif; ?>

                    <?php if(Auth::user()->id===1): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('finance')): ?>
                        <li class="has-dropdown <?php echo e((request()->is('accounting*')) ? 'active' : ''); ?>">

                            <?php if(auth()->user()->can('view-account') || auth()->user()->can('view-payee') || auth()->user()->can('view-payer') ||auth()->user()->can('view-deposit')||auth()->user()->can('view-expense')||auth()->user()->can('view-transaction')||auth()->user()->can('view-balance_transfer')): ?>
                                <a href="#Finance" aria-expanded="false" data-toggle="collapse">
                                    <i class="dripicons-graph-pie sidebar-i"></i><span><?php echo e(trans('file.Finance')); ?></span>
                                </a>
                            <?php endif; ?>

                            <ul id="Finance" class="collapse list-unstyled ">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-account')): ?>
                                    <li id="accounting_list"><a
                                                href="<?php echo e(route('accounting_list.index')); ?>"><?php echo e(__('Accounts List')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-account')): ?>
                                    <li id="account_balances"><a
                                                href="<?php echo e(route('account_balances')); ?>"><?php echo e(__('Account Balances')); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-payee')): ?>
                                    <li id="payees"><a
                                                href="<?php echo e(route('payees.index')); ?>"><?php echo e(trans(('file.Payee'))); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-payer')): ?>
                                    <li id="payers"><a
                                                href="<?php echo e(route('payers.index')); ?>"><?php echo e(trans(('file.Payer'))); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-deposit')): ?>
                                    <li id="deposit"><a
                                                href="<?php echo e(route('deposit.index')); ?>"><?php echo e(trans(('file.Deposit'))); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-expense')): ?>
                                    <li id="expense"><a
                                                href="<?php echo e(route('expense.index')); ?>"><?php echo e(trans(('file.Expense'))); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-transaction')): ?>
                                    <li id="transactions"><a
                                                href="<?php echo e(route('transactions.index')); ?>"><?php echo e(trans(('file.Transaction'))); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-balance_transfer')): ?>
                                    <li id="finance_transfer"><a
                                                href="<?php echo e(route('finance_transfer.index')); ?>"><?php echo e(trans(('file.Transfer'))); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(Auth::user()->id===1): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assets-and-category')): ?>
                        <li class="has-dropdown <?php if(request()->is('assets*')): ?><?php echo e((request()->is('assets*')) ? 'active' : ''); ?><?php elseif(request()->is('dynamic_variable/assets_category*')): ?><?php echo e((request()->is('dynamic_variable/assets_category*')) ? 'active' : ''); ?><?php endif; ?>">
                            <?php if(auth()->user()->can('category') || auth()->user()->can('assets')): ?>
                                <a href="#assets" aria-expanded="false" data-toggle="collapse"> <i
                                            class="dripicons-box sidebar-i"></i><span><?php echo e(trans(('file.Assets'))); ?></span>
                                </a>
                            <?php endif; ?>
                            <ul id="assets" class="collapse list-unstyled ">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category')): ?>
                                    <li id="assets_category"><a
                                        href="<?php echo e(route('assets_category.index')); ?>"><?php echo e(trans(('file.Category'))); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assets')): ?>
                                    <li id="assets"><a href="<?php echo e(route('assets.index')); ?>"><?php echo e(trans(('file.Assets'))); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(auth()->user()->username == 'admin'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('file_module')): ?>
                        <li class="has-dropdown <?php echo e((request()->is('file_manager*')) ? 'active' : ''); ?>">

                            <?php if(auth()->user()->can('view-file_manager') || auth()->user()->can('view-official_documents')): ?>
                            <a href="#file_manager" aria-expanded="false" data-toggle="collapse" style="display: block; text-align: left;">
    <i class="dripicons-archive sidebar-i"></i>
    <span><?php echo e(__('File Manager')); ?></span>
    <div style="font-size:10px; margin-top: 2px; margin-left: 20px;">This is policy for others</div>
</a>

                            <?php endif; ?>

                            <ul id="file_manager" class="collapse list-unstyled ">

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-file_manager')): ?>
                                    <li id="files"><a
                                                href="<?php echo e(route('files.index')); ?>"><?php echo e(__('File Manager')); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-official_documents')): ?>
                                    <li id="official_documents"><a
                                                href="<?php echo e(route('official_documents.index')); ?>"><?php echo e(__('Official Documents')); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-file_config')): ?>
                                    <li id="file_config"><a
                                                href="<?php echo e(route('file_config.index')); ?>"><?php echo e(__('File Configuration')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if(auth()->user()->username != 'admin'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('file_module')): ?>
                        <li class="has-dropdown <?php echo e((request()->is('file_manager*')) ? 'active' : ''); ?>">

                            <?php if(auth()->user()->can('view-file_manager') || auth()->user()->can('view-official_documents')): ?>
                                <a href="#file_manager" aria-expanded="false" data-toggle="collapse"> <i
                                            class="dripicons-archive sidebar-i"></i><span>Policy</span>
                                </a>
                            <?php endif; ?>

                            <ul id="file_manager" class="collapse list-unstyled ">

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-file_manager')): ?>
                                    <li id="files"><a
                                                href="<?php echo e(route('files.index')); ?>">Company Policy</a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-official_documents')): ?>
                                    <li id="official_documents"><a
                                                href="<?php echo e(route('official_documents.index')); ?>"><?php echo e(__('Official Documents')); ?></a>
                                    </li>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-file_config')): ?>
                                    <li id="file_config"><a
                                                href="<?php echo e(route('file_config.index')); ?>"><?php echo e(__('File Configuration')); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customize-setting')): ?>
                    <li class="has-dropdown <?php echo e((request()->is('settings*')) ? 'active' : ''); ?>">


                        <?php if(auth()->user()->can('view-role')||auth()->user()->can('view-general-setting')||auth()->user()->can('access-language')||auth()->user()->can('access-variable_type')||auth()->user()->can('access-variable_method')||auth()->user()->can('view-general-setting')): ?>
                            <a href="#Customize_settings" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-toggles sidebar-i"></i><span><?php echo e(__('Customize Setting')); ?></span>
                            </a>
                        <?php endif; ?>
                        

                        <ul id="Customize_settings" class="collapse list-unstyled ">
                        <?php if(Auth::user()->id==1): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-role')): ?>
                                <li id="roles"><a href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('Roles and Access')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-general-setting')): ?>
                                <li id="general_settings"><a
                                            href="<?php echo e(route('general_settings.index')); ?>"><?php echo e(__('General Settings')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-mail-setting')): ?>
                                <li id="mail_setting"><a
                                            href="<?php echo e(route('setting.mail')); ?>"><?php echo e(__('Mail Setting')); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-language')): ?>
                                <li id="language_switch"><a
                                            href="<?php echo e(route('languages.translations.index','English')); ?>"><?php echo e(__('Language Settings')); ?></a>
                                </li>
                            <?php endif; ?>

                           

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-variable_method')): ?>
                                <li id="variable_method"><a
                                            href="<?php echo e(route('variables_method.index')); ?>"><?php echo e(__('Variable Method')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-general-setting')): ?>
                                <li id="ip_setting"><a href="<?php echo e(route('ip_setting.index')); ?>"><?php echo e(__('IP Settings')); ?></a></li>
                            <?php endif; ?>
                            <?php else: ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-variable_type')): ?>
                                <li id="variable_type"><a
                                            href="<?php echo e(route('variables.index')); ?>"><?php echo e(__('Variable Type')); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(Auth::user()->id===1): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user')): ?>
                    <li class="has-dropdown <?php if(request()->is('user*')): ?><?php echo e((request()->is('user*')) ? 'active' : ''); ?><?php elseif(request()->is('add-user*')): ?><?php echo e((request()->is('add-user*')) ? 'active' : ''); ?><?php endif; ?>">
                        <?php if(auth()->user()->can('view-user')): ?>
                            <a href="#users" aria-expanded="false" data-toggle="collapse">
                                <i class="dripicons-user sidebar-i"></i>
                                <span><?php echo e(trans('file.User')); ?></span>
                            </a>
                        <?php endif; ?>
                        <ul id="users" class="collapse list-unstyled ">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-user')): ?>
                                <li id="users-menu"><a href="<?php echo e(route('users-list')); ?>"><?php echo e(__('Users List')); ?></a></li>
                            <?php endif; ?>
                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-access-user')): ?>
                                <li id="user-roles"><a
                                            href=<?php echo e(route('user-roles')); ?>><?php echo e(__('Assign Role')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('last-login-user')): ?>
                                <li id="user-last-login"><a
                                            href="<?php echo e(route('login-info')); ?>"><?php echo e(__('Users Last Login')); ?></a>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </li>
                <?php endif; ?>
                <?php endif; ?>

                    <br><br><br>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/layout/main_partials/sidebar.blade.php ENDPATH**/ ?>