


<?php $__env->startSection('content'); ?>


<?php
// dd(submission_status(auth()->user()->id));
// exit;
?>
<style>
 
    h2 {
        color: #2c3e50;
        font-weight: bold;
    }

    h3 {
        color: #34495e;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3498db;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    label {
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    span i {
        color: #7f8c8d;
        font-size: 0.9em;
    }

    textarea {
        resize: vertical;
    }

    /* Section Styling */
    section {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #3498db;
        border: none;
        padding: 10px 20px;
        font-size: 1.1em;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    /* Row and Column Styling */
    .row {
        margin-bottom: 20px;
    }

    .col-md-12, .col-md-6, .col-md-4, .col-md-2 {
        margin-bottom: 15px;
    }
</style>

<section>
    <div class="container-fluid">
        <h2 class="text-center mb-4">Employee Feedback Form</h2>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('errors')): ?>
    <div class="alert alert-errors">
        <?php echo e(session('errors')); ?>

    </div>
<?php endif; ?>

<?php if(employee_data(auth()->user()->id, 'team_lead_id') == 'CEO'): ?>
            <div class="alert alert-info">
            You don't have access of this form
            </div>
<?php else: ?>
        <?php if(submission_status(auth()->user()->id) == 1): ?>
            <div class="alert alert-info">
            Employee Feedback Form has been submitted.
            </div>
        <?php else: ?>
        <form action="<?php echo e(route('employee.feedback.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Employee Information -->
            <h3><b>Employee Information</b></h3>
            <div class="row">
                <div class="col-md-2 mb-3">
                <label>Full Name</label>
                    <input type="text" name="name" class="form-control" readonly placeholder="Full Name" value="<?php echo e(auth()->user()->first_name.' '. auth()->user()->last_name); ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Department</label>
                    <input type="text" name="department" class="form-control" readonly placeholder="Department" value="<?php echo e(employee_data(auth()->user()->id, 'department')); ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Reporting Manager</label>
                    <input type="text" name="reporting_manager" class="form-control" readonly placeholder="Reporting Manager" value="<?php echo e(employee_data(auth()->user()->id, 'team_lead')); ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Position</label>
                    <input type="text" name="position" class="form-control" readonly placeholder="Position" value="<?php echo e(employee_data(auth()->user()->id, 'position')); ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Duration of Appraisal</label>
                    <input type="text" name="duration_of_appraisal" class="form-control" readonly placeholder="Duration of Appraisal" value="1 Year" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Joining Date</label>
                    <input type="text" name="joining_date" class="form-control" readonly placeholder="Joining Date" value="<?php echo e(employee_data(auth()->user()->id, 'joining_date')); ?>" required>
                </div>
            </div>
            <br><br>

            <!-- Employee Feedback on Performance -->
            <h3><b>Employee Feedback on Performance</b></h3>
            <div class="row">
    <div class="col-md-6 mb-3">
        <label>(a) Clarity of Expectations</label>
        <span><i>To what extent were the performance expectations and standards clearly communicated to you at the
        outset of the appraisal period?</i></span>
        <select name="clarity_expectations" class="form-control" required>
            <option value="">Select Expectations</option>
            <option value="Very Clear">Very Clear</option>
            <option value="Clear">Clear</option>
            <option value="Unclear">Unclear</option>
            <option value="Very Unclear">Very Unclear</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>(b) Feasibility of Goals</label>
        <span><i>Do you believe the goals established for you were realistic and achievable given the available resources,
        support, and workload?</i></span>
        <select name="feasibility_goals" class="form-control" required>
            <option value="">Select Feasibility</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            <option value="Somewhat">Somewhat</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>(c) Fairness of Performance Evaluation</label>
        <span><i>How would you assess the fairness and alignment of the performance metrics with your job
        responsibilities?</i></span>
        <select name="fairness_evaluation" class="form-control" required>
            <option value="">Select Fairness Evaluation</option>
            <option value="Very Fair">Very Fair</option>
            <option value="Fair">Fair</option>
            <option value="Unfair">Unfair</option>
            <option value="Very Unfair">Very Unfair</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>(d) Frequency of Feedback and Progress Review</label>
        <span><i>How regularly did you receive feedback or progress updates regarding your performance against
        established standards?</i></span>
        <select name="feedback_frequency" class="form-control" required>
            <option value="">Select Feedback Frequency</option>
            <option value="Frequently">Frequently</option>
            <option value="Occasionally">Occasionally</option>
            <option value="Rarely">Rarely</option>
            <option value="Never">Never</option>
        </select>
    </div>
</div>
            <br><br>

            <!-- Employee Feedback on Manager -->
            <h3><b>Employee Feedback on Manager/Team Lead</b></h3>
            <div class="row">
    <div class="col-md-6 mb-3">
        <label>(a) Support and Guidance</label>
        <span><i>How would you rate the support and guidance provided by your manager/team lead during the
        appraisal period?</i></span>
        <select name="manager_support" class="form-control" required>
            <option value="">Select Manager Support</option>
            <option value="Excellent">Excellent</option>
            <option value="Good">Good</option>
            <option value="Fair">Fair</option>
            <option value="Poor">Poor</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>(b) Communication Effectiveness</label>
        <span><i>How would you evaluate the communication with your manager/team lead in terms of clarity,
        frequency, and transparency?</i></span>
        <select name="communication_effectiveness" class="form-control" required>
            <option value="">Select Communication Effectiveness</option>
            <option value="Excellent">Excellent</option>
            <option value="Good">Good</option>
            <option value="Adequate">Adequate</option>
            <option value="Needs Improvement">Needs Improvement</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label>(c) Accessibility for Feedback and Discussion</label>
        <span><i>Was your manager/team lead accessible and responsive when you required feedback, clarification, or discussion regarding your performance?</i></span>
        <select name="accessibility" class="form-control" required>
            <option value="">Select Accessibility</option>
            <option value="Always">Always</option>
            <option value="Sometimes">Sometimes</option>
            <option value="Rarely">Rarely</option>
            <option value="Never">Never</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label>(d) Recognition and Acknowledgment</label>
        <span><i>Do you feel that your manager/team lead consistently recognized and acknowledged your contributions and achievements during the appraisal period?</i></span>
        <select name="recognition" class="form-control" required>
            <option value="">Select Recognition</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            <option value="Occasionally">Occasionally</option>
        </select>
    </div>
    <div class="col-md-12 mb-3">
        <label>(e) Constructive Feedback</label>
        <p><i>Did you receive constructive feedback from your manager/team lead that was beneficial for your professional development?</i></p>
        <select name="constructive_feedback" class="form-control" required>
            <option value="">Select Feedback</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            <option value="Occasionally">Occasionally</option>
        </select>
    </div>
</div>

            <br><br>

            <!-- Employee Self Feedback -->
            <h3><b>Employee Self Feedback</b></h3>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>(a) Key Achievements</label>
                    <p><i>What do you consider to be your key achievements and successes during this appraisal period?</i></p>
                    <textarea name="achievements" class="form-control" placeholder="Describe your key achievements"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>(b) Challenges and Obstacles</label>
                    <p><i>What challenges or obstacles did you encounter during the appraisal period, and how do you
                    plan to address these in the future?</i></p>
                    <textarea name="challenges" class="form-control" placeholder="Describe the challenges you faced"></textarea>
                </div>
            </div>
            <div class="row">
    <div class="col-md-4 mb-3">
        <label>(c) Professional Development</label>
        <span><i>Were there sufficient opportunities for you to develop new skills or expand your knowledge?</i></span>
        <select name="professional_development" class="form-control" required>
            <option value="">Select Professional Development</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            <option value="Somewhat">Somewhat</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label>(d) Self-Assessment of Performance</label>
        <span><i>How would you evaluate your overall performance during this appraisal period?</i></span>
        <select name="self_assessment" class="form-control" required>
            <option value="">Select Performance</option>
            <option value="Excellent">Excellent</option>
            <option value="Good">Good</option>
            <option value="Satisfactory">Satisfactory</option>
            <option value="Needs Improvement">Needs Improvement</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label>(e) Support and Resources</label>
        <span><i>Do you feel that you have been provided with the necessary support, resources, and tools to perform your job effectively?</i></span>
        <select name="support_resources" class="form-control" required>
            <option value="">Select Support</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            <option value="Somewhat">Somewhat</option>
        </select>
    </div>
</div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>(f) Any other comment </label>
                    <textarea name="any_comment" class="form-control" placeholder="Any other comment"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit Feedback</button>
        </form>
        <?php endif; ?>
<?php endif; ?>

    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/employee-feedback.blade.php ENDPATH**/ ?>