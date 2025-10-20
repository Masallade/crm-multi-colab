<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Add these if not already present -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="icon" type="image/png" href="{{asset('/images/logo/'.$general_settings->site_logo)}}"/>
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    
     <!--Notification Sound Script -->
    <script type="text/javascript" src="{{ asset('js/notification-sound.js') }}"></script>

     <!--Dawood css -->
     <link rel="stylesheet" href="<?php echo asset('css/dawood-dashboard-sidebar.css') ?>" type="text/css">

     <!--Bootstrap CSS-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap/css/awesome-bootstrap-checkbox.css') }}"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap/css/bootstrap-datepicker.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap/css/bootstrap-datepicker.min.css') }}"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/jquery-clockpicker/bootstrap-clockpicker.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/jquery-clockpicker/bootstrap-clockpicker.min.css') }}"></noscript>

     <!--Boostrap Tag Inputs-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/Tag_input/tagsinput.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/Tag_input/tagsinput.css') }}"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap/css/bootstrap-select.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/bootstrap/css/bootstrap-select.min.css') }}"></noscript>

     <!--Font Awesome CSS-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}"></noscript>

     <!--Dripicons icon font-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/dripicons/webfont.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/dripicons/webfont.css') }}"></noscript>

     <!--Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">

     <!--jQuery Circle-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('css/grasp_mobile_progress_circle-1.0.0.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('css/grasp_mobile_progress_circle-1.0.0.min.css') }}"></noscript>

     <!--Custom Scrollbar-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}"></noscript>

     <!--date range stylesheet-->
    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/daterange/css/daterangepicker.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('vendor/daterange/css/daterangepicker.min.css') }}"></noscript>

     <!--datatable stylesheet start-->
    @if (isset($isDataTableExist) && $isDataTableExist)
        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/dataTables.bootstrap4.min.css') }}">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/dataTables.bootstrap4.min.css') }}"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/buttons.bootstrap4.min.css') }}">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/buttons.bootstrap4.min.css') }}"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/select.bootstrap4.min.css') }}">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/select.bootstrap4.min.css') }}"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/dataTables.checkboxes.css') }}">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/dataTables.checkboxes.css') }}"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/datatables.flexheader.boostrap.min.css') }}">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/datatables.flexheader.boostrap.min.css') }}"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/datatable.responsive.boostrap.min.css') }}">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/datatable/datatable.responsive.boostrap.min.css') }}"></noscript>
    @endif
     <!--datatable stylesheet End-->


    @stack('css')


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/select2/dist/css/select2.min.css') }}"></noscript>

    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/RangeSlider/ion.rangeSlider.min.css') }}">
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/RangeSlider/ion.rangeSlider.min.css') }}"></noscript>


     <!--theme stylesheet-->


    <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet" >
    <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet" ></noscript>




    @if (env('RTL_LAYOUT')!=NULL)
        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/bootstrap/css/bootstrap-rtl.min.css') }}">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('vendor/bootstrap/css/bootstrap-rtl.min.css') }}"></noscript>

        <link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('css/custom-rtl.css') }}">
        <noscript><link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"  href="{{ asset('css/custom-rtl.css') }}"></noscript>
    @endif


    @if((request()->is('admin/dashboard*')) || (request()->is('calendar*')) )
        @include('calendarable.css')
    @endif

</head>


<body>
<div id="loader"></div>

 <!--Audio element for notification sound -->
<audio id="notification-sound" preload="auto">
    <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
</audio>

@include('layout.main_partials.header')


@if ($isCrmModuleExist)
    @include('crm::layouts.partials.admin_sidebar')
@else
    @include('layout.main_partials.sidebar')
@endif


<section id="content" class="page animate-bottom d-none dashboard-background">
    @yield('content')
    @include('layout.main_partials.footer')
</section>



{{-- New Format --}}
<script type="text/javascript" src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery-clockpicker/bootstrap-clockpicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/popper.js/umd/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/grasp_mobile_progress_circle-1.0.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/charts-custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/front.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/daterange/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/daterange/js/knockout-3.4.2.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/daterange/js/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

 <!--JS for Boostrap Tag Inputs-->
<script type="text/javascript" src="{{ asset('vendor/Tag_input/tagsinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/RangeSlider/ion.rangeSlider.min.js') }}"></script>

 <!--table sorter js-->

 datatable Script Start
@if (isset($isDataTableExist) && $isDataTableExist)

    @if(Config::get('app.locale') == 'Arabic')
        <script type="text/javascript" src="{{ asset('vendor/datatable/pdfmake_arabic.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/datatable/vfs_fonts_arabic.js') }}"></script>
    @else
        <script type="text/javascript" src="{{ asset('vendor/datatable/pdfmake.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/datatable/vfs_fonts.js') }}"></script>
    @endif

    <script type="text/javascript" src="{{ asset('vendor/datatable/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/dataTables.select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/sum().js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/dataTables.checkboxes.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatable.fixedheader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatable.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatable.responsive.boostrap.min.js') }}"></script>
@endif
 datatable Script End


<script type="text/javascript" src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if((request()->is('admin/dashboard*')) || (request()->is('calendar*')) )
    @include('calendarable.js')
@endif

{{-- New Format --}}


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
            if (confirm('{{__('Delete Selection',['key'=>__('Empty Database')])}}')) {
                let url = '{{route('empty_database')}}';
                document.location.href = url;
            } else {

            }
        });


        $('#notify-btn').on('click', function () {
            $.ajax({
                url: '{{route('markAsRead')}}',
                dataType: "json",
                success: function (result) {
                },
            });
        })

    })(jQuery);
</script>

<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.9.1/firebase-app.js";
  import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/11.9.1/firebase-messaging.js";

  const firebaseConfig = {
    apiKey: "AIzaSyA_iJ_Nd7X6pepqLpHVNMRaoukHFEjJChA",
    authDomain: "crm-push-notification-ae1b8.firebaseapp.com",
    projectId: "crm-push-notification-ae1b8",
    storageBucket: "crm-push-notification-ae1b8.appspot.com",
    messagingSenderId: "708608062410",
    appId: "1:708608062410:web:d3515e632b2a4d8b39d533"
  };

  const app = initializeApp(firebaseConfig);
  const messaging = getMessaging(app);

  // Register the service worker and use it for FCM
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/v2/crm/firebase-messaging-sw.js')
      .then(function(registration) {
        console.log('Service Worker Registered', registration);
        Notification.requestPermission().then((permission) => {
          if (permission === "granted") {
            getToken(messaging, {
              vapidKey: "BMfGo1OHuizC9QPUH-Z-JOvD-a5XY01p6UVWojTgcUKjwK6CNApMF5oH9ebCdNoSy9dtV0i-uaFuagtsAFTzBU0",
              serviceWorkerRegistration: registration
            })
            .then((currentToken) => {
              if (currentToken) {
                console.log("FCM Token:", currentToken);
                fetch('/v2/crm/save-token', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                  },
                  body: JSON.stringify({ token: currentToken })
                });
              } else {
                console.log("No registration token available. Request permission to generate one.");
              }
            })
            .catch((err) => {
              console.log("An error occurred while retrieving token. ", err);
            });
          } else {
            console.log("Unable to get permission to notify.");
          }
        });
      })
      .catch(function(err) {
        console.error('Service Worker registration failed', err);
      });
  }

  onMessage(messaging, (payload) => {
    console.log("Message received. ", payload);
    if (Notification.permission === 'granted') {
      new Notification(payload.notification.title, {
        body: payload.notification.body,
        icon: payload.notification.icon
      });
    }
  });
</script>


@stack('scripts')


</body>
</html>