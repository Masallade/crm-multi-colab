<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<style>
    @font-face {
        font-family: "kalpurush";
        font-style: normal;
        font-weight: normal;
        src: url('<?php echo e(public_path('fonts/kalpurush.ttf')); ?>') format('truetype');
    }
    body {
        font-family: "kalpurush";
    }
</style>


  </head>
  <body>

    <div class="card">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Employee Info')); ?></h4>
        </div>
        <div class="modal-body">
            <br>
            <div class="row">
                <div class="col-md-7">
                    <div class="table-responsive">

                        <table class="table  table-bordered">
                            <h1>ইরফান</h1>
                            <tr>
                                <th><?php echo e(__('Photo')); ?></th>
                                <?php if($user['profile_photo']!==null): ?>
                                    <td>
                                        <img src="<?php echo e(asset('uploads/profile_photos/' . $user['profile_photo'])); ?>" height="50" width="60">
                                    </td>
                                <?php else: ?>
                                    <td> <img src="<?php echo e(asset('uploads/profile_photos/blank.jpg')); ?>" height="50px" width="60"> </td>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Name')); ?></th>
                                <td><?php echo e($first_name); ?> <?php echo e($last_name); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Username')); ?></th>
                                <td><?php echo e($user['username']); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Gender')); ?></th>
                                <td><?php echo e($gender); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Contact')); ?></th>
                                <td>
                                    Email : <?php echo e($email); ?> <br>
                                    Phone : <?php echo e($contact_no); ?><br>
                                    Facebook : <?php echo e($fb_id); ?> <br>
                                    Skype : <?php echo e($skype_id); ?> <br>
                                    Whats App : <?php echo e($whatsapp_id); ?>

                                </td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Address')); ?></th>
                                <td>
                                    Address : <?php echo e($address); ?> <br>
                                    City : <?php echo e($city); ?><br>
                                    State : <?php echo e($state); ?> <br>
                                    Country : <?php echo e($country); ?> <br>
                                    Zipcode : <?php echo e($zip_code); ?>

                                </td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Role')); ?></th>
                                <td><?php echo e($role['name']); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Company')); ?></th>
                                <td><?php echo e($company['company_name']); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Department')); ?></th>
                                <td><?php echo e($department['department_name']); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Designation')); ?></th>
                                <td><?php echo e($designation['designation_name']); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Office Shift')); ?></th>
                                <td><?php echo e($office_shift['shift_name']); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Payslip Type')); ?></th>
                                <td><?php echo e($payslip_type); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('Salary')); ?></th>
                                <?php if(config('variable.currency_format') =='suffix'): ?>
                                    <td><?php echo e($basic_salary); ?> <?php echo e(config('variable.currency')); ?></td>
                                <?php else: ?>
                                    <td><?php echo e(config('variable.currency')); ?> <?php echo e($basic_salary); ?> </td>
                                <?php endif; ?>
                            </tr>
                        </table>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>


<?php /**PATH /home/baselinepractice/public_html/v2/crm/resources/views/employee/pdf.blade.php ENDPATH**/ ?>