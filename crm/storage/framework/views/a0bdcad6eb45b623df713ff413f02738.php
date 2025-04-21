<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="icon" type="image/png" href="<?php echo e(asset('/images/logo/'.$general_settings->site_logo)); ?>"/>
    <title><?php echo e($general_settings->site_title ?? "NO Title"); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    


    <!-- Dawood css -->
     <link rel="stylesheet" href="<?php echo asset('css/dawood-dashboard-sidebar.css') ?>" type="text/css">

    <!-- Bootstrap CSS-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap/css/bootstrap.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap/css/bootstrap.min.css')); ?>"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css')); ?>"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css')); ?>"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap/css/bootstrap-datepicker.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap/css/bootstrap-datepicker.min.css')); ?>"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/jquery-clockpicker/bootstrap-clockpicker.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/jquery-clockpicker/bootstrap-clockpicker.min.css')); ?>"></noscript>

    <!-- Boostrap Tag Inputs-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/Tag_input/tagsinput.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/Tag_input/tagsinput.css')); ?>"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap/css/bootstrap-select.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/bootstrap/css/bootstrap-select.min.css')); ?>"></noscript>

    <!-- Font Awesome CSS-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/font-awesome/css/font-awesome.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/font-awesome/css/font-awesome.min.css')); ?>"></noscript>

    <!-- Dripicons icon font-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/dripicons/webfont.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/dripicons/webfont.css')); ?>"></noscript>

    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">

    <!-- jQuery Circle-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('css/grasp_mobile_progress_circle-1.0.0.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('css/grasp_mobile_progress_circle-1.0.0.min.css')); ?>"></noscript>

    <!-- Custom Scrollbar-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')); ?>"></noscript>

    <!-- date range stylesheet-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/daterange/css/daterangepicker.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('vendor/daterange/css/daterangepicker.min.css')); ?>"></noscript>

    <!-- datatable stylesheet start-->
    <?php if(isset($isDataTableExist) && $isDataTableExist): ?>
        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/dataTables.bootstrap4.min.css')); ?>">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/dataTables.bootstrap4.min.css')); ?>"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/buttons.bootstrap4.min.css')); ?>">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/buttons.bootstrap4.min.css')); ?>"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/select.bootstrap4.min.css')); ?>">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/select.bootstrap4.min.css')); ?>"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/dataTables.checkboxes.css')); ?>">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/dataTables.checkboxes.css')); ?>"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/datatables.flexheader.boostrap.min.css')); ?>">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/datatables.flexheader.boostrap.min.css')); ?>"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/datatable.responsive.boostrap.min.css')); ?>">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/datatable/datatable.responsive.boostrap.min.css')); ?>"></noscript>
    <?php endif; ?>
    <!-- datatable stylesheet End-->


    <?php echo $__env->yieldPushContent('css'); ?>


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/select2/dist/css/select2.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/select2/dist/css/select2.min.css')); ?>"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/RangeSlider/ion.rangeSlider.min.css')); ?>">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/RangeSlider/ion.rangeSlider.min.css')); ?>"></noscript>


    <!-- theme stylesheet-->


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('css/style.default.css')); ?>" id="theme-stylesheet" >
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="<?php echo e(asset('css/style.default.css')); ?>" id="theme-stylesheet" ></noscript>




    <?php if(env('RTL_LAYOUT')!=NULL): ?>
        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/bootstrap/css/bootstrap-rtl.min.css')); ?>">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('vendor/bootstrap/css/bootstrap-rtl.min.css')); ?>"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('css/custom-rtl.css')); ?>">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="<?php echo e(asset('css/custom-rtl.css')); ?>"></noscript>
    <?php endif; ?>


    <?php if((request()->is('admin/dashboard*')) || (request()->is('calendar*')) ): ?>
        <?php echo $__env->make('calendarable.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

</head>


<body>
<div id="loader"></div>

<?php echo $__env->make('layout.main_partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php if($isCrmModuleExist): ?>
    <?php echo $__env->make('crm::layouts.partials.admin_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('layout.main_partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>


<section id="content" class="page animate-bottom d-none dashboard-background">
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('layout.main_partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</section>




<script type="text/javascript" src="<?php echo e(asset('vendor/jquery/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/jquery/jquery-ui.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/jquery/bootstrap-datepicker.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/jquery-clockpicker/bootstrap-clockpicker.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/popper.js/umd/popper.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/bootstrap/js/bootstrap-select.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/grasp_mobile_progress_circle-1.0.0.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/chart.js/Chart.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/jquery-validation/jquery.validate.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/charts-custom.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/front.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/daterange/js/moment.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/daterange/js/knockout-3.4.2.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/daterange/js/daterangepicker.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/tinymce/js/tinymce/tinymce.min.js')); ?>"></script>

<!-- JS for Boostrap Tag Inputs-->
<script type="text/javascript" src="<?php echo e(asset('vendor/Tag_input/tagsinput.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('vendor/RangeSlider/ion.rangeSlider.min.js')); ?>"></script>

<!-- table sorter js-->

<!-- datatable Script Start-->
<?php if(isset($isDataTableExist) && $isDataTableExist): ?>

    <?php if(Config::get('app.locale') == 'Arabic'): ?>
        <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/pdfmake_arabic.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/vfs_fonts_arabic.js')); ?>"></script>
    <?php else: ?>
        <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/pdfmake.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/vfs_fonts.js')); ?>"></script>
    <?php endif; ?>

    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/dataTables.bootstrap4.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/dataTables.buttons.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/buttons.bootstrap4.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/buttons.colVis.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/buttons.html5.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/buttons.print.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/dataTables.select.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/sum().js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/dataTables.checkboxes.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/datatable.fixedheader.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/datatable.responsive.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('vendor/datatable/datatable.responsive.boostrap.min.js')); ?>"></script>
<?php endif; ?>
<!-- datatable Script End-->


<script type="text/javascript" src="<?php echo e(asset('vendor/select2/dist/js/select2.min.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if((request()->is('admin/dashboard*')) || (request()->is('calendar*')) ): ?>
    <?php echo $__env->make('calendarable.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>




<script type="text/javascript">
    (function ($) {
        "use strict";

        $(document).ready(function () {
            if (window.location.href.indexOf('#formModal') != -1) {
                $('#formModal').modal('show');
            }
            else if(window.location.href.indexOf('#createModal') != -1) {
                $('#createModal').modal('show');
            }
        });

        $('#empty_database').on('click', function () {
            if (confirm('<?php echo e(__('Delete Selection',['key'=>__('Empty Database')])); ?>')) {
                let url = '<?php echo e(route('empty_database')); ?>';
                document.location.href = url;
            } else {

            }
        });


        $('#notify-btn').on('click', function () {
            $.ajax({
                url: '<?php echo e(route('markAsRead')); ?>',
                dataType: "json",
                success: function (result) {
                },
            });
        })

    })(jQuery);
</script>
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js";
  import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-messaging.js";

  const firebaseConfig = {
    apiKey: "AIzaSyAt-UM6sfQa2NXMNrBUWrw2YRbJGExDvpw",
    authDomain: "mydemo-8a477.firebaseapp.com",
    projectId: "mydemo-8a477",
    storageBucket: "mydemo-8a477.appspot.com",
    messagingSenderId: "386016084099",
    appId: "1:386016084099:web:3da6dabc3db173e78adbb6",
    measurementId: "G-97ZT9B2612"
  };

  const app = initializeApp(firebaseConfig);
  const messaging = getMessaging(app);

  // Register the service worker
  navigator.serviceWorker.register("<?php echo e(asset('vendor/firebase-messaging-sw.js')); ?>")
    .then((registration) => {
        console.log('✅ Service worker registered.');

        // Get Firebase token
        getToken(messaging, {
          vapidKey: "BCwTFT97d8JJuNOKgzaSBJJumNdx8hxZj63EuD1y1rzR4lqFRlXTGTDTewf0U_uAU_uQdUDL8gWFU05t8O5Df1w",
          serviceWorkerRegistration: registration,
        }).then((currentToken) => {
          if (currentToken) {
            console.log('📌 Token:', currentToken);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Save the token on your server
            fetch("/v2/crm/save-token", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
              },
              body: JSON.stringify({ token: currentToken })
            });
          } else {
            console.warn('⚠️ No token found. Permission may not be granted.');
          }
        }).catch((err) => {
          console.error('❌ Token error:', err);
        });
    }).catch((err) => {
      console.error('❌ Service Worker registration failed:', err);
    });

  // Listen for foreground messages
  onMessage(messaging, (payload) => {
    console.log('📩 Foreground message received:', payload);

    // Show notification if permission is granted
    if (Notification.permission === "granted") {
      const { title, body } = payload.notification;
      new Notification(title, {
        body: body,
        icon: 'https://teamspace.baselinepracticesupport.co.uk/v2/crm/images/logo/logo.png', // Optional icon for the notification
      });
    } else {
      console.warn("⚠️ Notification permission not granted.");
    }
  });
</script>


<?php echo $__env->yieldPushContent('scripts'); ?>


</body>
</html><?php /**PATH D:\Xampp\htdocs\crm_latest_backup_13_04_2025\crm\resources\views/layout/main.blade.php ENDPATH**/ ?>