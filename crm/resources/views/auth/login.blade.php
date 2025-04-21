<?php $general_setting = DB::table('general_settings')->latest()->first(); ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('css/dawood-login-page.css') ?>" id="theme-stylesheet"
          type="text/css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('css/custom-' . $general_setting->theme) ?>" type="text/css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>



   
   
    
    
<div class="login-page common-basic">
        <div class="form-container common-basic-row">
            


                <div class="logo-image">
                <img  src="{{asset('/images/logo/'.$general_setting->site_logo)}}">
                </div>




                @include('shared.errors')
                @include('shared.flash_message')
                
                <form class="common-basic-column" method="POST" action="{{ route('login') }}" id="login-form">
                    @csrf
                    <div class="form-group-material ">
                        <label for="username" class="label-material">{{ __('Username') }}</label>

                        <div class="input-container common-basic-row">
                        <i class="fas fa-user prefix-icon"></i>
                        <input id="username" type="text" class="input-field"
                        name="username" value="{{ old('username') }}" required autofocus>
                        </div>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group-material">
                    <label for="password" class="label-material">{{ __('Password') }}</label>
                    <div class="input-container common-basic-row">
                    <i class="fas fa-lock prefix-icon"></i>

                        <input id="password" type="password"
                               class="input-field" name="password" required
                               autocomplete="current-password">
                               </div>


                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                    </div> 
                    <br>
                        <button type="submit" class="button">
                            {{ __('Login') }}
                        </button>
                </form>
                <!-- This three buttons for demo only-->

                <!-- @if (!env('USER_VERIFIED'))
                    <button type="submit" class="btn btn-success btn-sm default admin-btn">LogIn as Admin</button>
                    <button type="submit" class="btn btn-info btn-sm default staff-btn">LogIn as Staff</button>
                    <button type="submit" class="btn btn-warning btn-sm default client-btn">LogIn as Client</button>
                    <p class="text-center mt-4 text-danger font-weight-bold font-italic">[For attendance device related features, Need to purchase attendance device addon.]</p>
                @endif -->

                <br><br>
                @if (Route::has('password.request'))
                    <a class="forgot-pass" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            @php
                $general_settings = \App\Models\GeneralSetting::latest()->first();
            @endphp


            <br><br>

            <div class="developed-by">
                <p>{{ __('Developed by')}} <a href={{$general_settings->footer_link}} class="external">{{$general_settings->footer}}</a></p>
            </div>

        </div>
        
        <div class="lottie-container ">
        <div id="lottie-add" style="height: 60%"></div>
        </div>
</div>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>
</body>
</html>

<script type="text/javascript">
    (function($) {

        "use strict";

        $('.admin-btn').on('click', function () {
            $("input[name='username']").focus().val('admin');
            $("input[name='password']").focus().val('admin');
        });

        $('.staff-btn').on('click', function () {
            $("input[name='username']").focus().val('staff');
            $("input[name='password']").focus().val('staff');
        });
        $('.client-btn').on('click', function () {
            $("input[name='username']").focus().val('client');
            $("input[name='password']").focus().val('client');
        });

        // ------------------------------------------------------- //
        // Material Inputs
        // ------------------------------------------------------ //

        let materialInputs = $('input.input-material');

        // activate labels for prefilled values
        materialInputs.filter(function () {
            return $(this).val() !== "";
        }).siblings('.label-material').addClass('active');

        // move label on focus
        materialInputs.on('focus', function () {
            $(this).siblings('.label-material').addClass('active');
        });

        // remove/keep label on blur
        materialInputs.on('blur', function () {
            $(this).siblings('.label-material').removeClass('active');

            if ($(this).val() !== '') {
                $(this).siblings('.label-material').addClass('active');
            } else {
                $(this).siblings('.label-material').removeClass('active');
            }
        });
    })(jQuery);
</script>



<!-- Include Lottie Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.4/lottie.min.js"></script>
<script>
    // Initialize Lottie Animation
    var lottieInstance = lottie.loadAnimation({
        container: document.getElementById('lottie-add'), // ID of the container div
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: "{{ asset('assets/lotties/logo_page_lottie.json') }}"
    });


//  Add hover event listeners to play the animation
    var lottieAddContainer = document.getElementById('lottie-add');
   
        lottieInstance.play();
 

</script>