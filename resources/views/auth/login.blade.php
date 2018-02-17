<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login or Register - {{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/fav/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/fav/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/fav/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/fav/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/fav/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/fav/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/fav/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/fav/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/fav/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('images/fav/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/fav/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/fav/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/fav/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/fav/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/fav/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
</head>

<style type="text/css">
	body {
	  	background:
		    /* top, transparent red, faked with gradient */
		    linear-gradient(
		      rgba(0, 0, 0, 0.45),
		      rgba(0, 0, 0, 0.45)
	    ),
	    /* bottom, image */
	    url(images/login-bg.jpg) center;
	}
</style>

<body class="overlay">
    <div class="login-page">
        <div id="logo" align="middle">
            <a href="{{ url('/') }}" title="{{ config('app.name', 'Laravel') }}" rel="home">
                <img src="images/logo.png" alt="{{ config('app.name', 'Laravel') }}" width="170">
            </a>
        </div>
        <div class="form">
            <form class="register-form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="text" placeholder="username" name="username" required>
                <input type="password" placeholder="password" name="password" required>
                <input type="text" placeholder="email address" name="email" required>
                <select name="sex" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @if(config('settings.reCaptchStatus'))
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                    </div>
                @endif
                <p class="message">By clicking registering register you agree to our <a href="{{ url('/terms') }}">terms</a></p>
                <div class="form-group">
                    <button type="submit">register</button>
                </div>
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
            <form class="login-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="text" placeholder="username" name="username" required>
                <input type="password" placeholder="password" name="password" required>
                <button type="submit">login</button>
                <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>

            <div class="loginBtn loginBtn--facebook">
                <a href="redirect/facebook">Login with Facebook</a>
            </div>
            <div class="loginBtn loginBtn--twitter">
                <a href="redirect/twitter">Login with Twitter</a>
            </div>
            {{-- <a href="{{ route('password.request') }}" style="margin-top: 25px; color: #242124; font-size: 12px;">
                Forgot Your Password?
            </a> --}}
        </div>
    </div>
    <script src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-104789000-1', 'auto');
      ga('send', 'pageview');

    </script>
</body>
</html>
