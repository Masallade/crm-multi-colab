<?php $general_setting = DB::table('general_settings')->find(1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$general_setting->site_title}}</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- Theme Stylesheet -->
    <link rel="stylesheet" href="<?php echo asset('css/dawood-login-page.css') ?>" type="text/css">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="<?php echo asset('css/custom-' . $general_setting->theme) ?>" type="text/css">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico">
</head>
<body>

<div class="login-page common-basic">
    <div class="form-container common-basic-row">
        <div class="logo-image">
            <img src="{{asset('/images/logo/'.$general_setting->site_logo)}}" alt="Logo">
        </div>

        <h2 class="text-center">{{ __('Forgot Your Password?') }}</h2>
        <p class="text-center">Enter your email and we'll send you a link to reset your password.</p>

        @include('shared.errors')
        @include('shared.flash_message')

        <form class="common-basic-column" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group-material">
                <label for="email" class="label-material">{{ __('E-Mail Address') }}</label>
                <div class="input-container common-basic-row">
                    <i class="fas fa-envelope prefix-icon"></i>
                    <input id="email" type="email" class="input-field @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <br>

            <button type="submit" class="button">
                {{ __('Send Password Reset Link') }}
            </button>

            <br><br>
            <a href="{{ route('login') }}" class="forgot-pass">
                {{ __('Back to Login') }}
            </a>
        </form>

        @php
            $general_settings = \App\Models\GeneralSetting::latest()->first();
        @endphp
        <br><br>

        <div class="developed-by">
            <p>{{ __('Developed by')}} 
                <a href="{{$general_settings->footer_link}}" class="external">{{$general_settings->footer}}</a>
            </p>
        </div>
    </div>

    <div class="lottie-container">
        <div id="lottie-forgot-password" style="height: 60%"></div>
    </div>
</div>

<!-- Scripts -->
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.4/lottie.min.js"></script>
<script>
    var lottieInstance = lottie.loadAnimation({
        container: document.getElementById('lottie-forgot-password'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: "{{ asset('assets/lotties/forgot_pass.json') }}"
    });
</script>

</body>
</html>