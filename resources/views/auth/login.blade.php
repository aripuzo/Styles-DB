<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
</head>

<body>
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
                <button type="submit">create</button>
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
            <form class="login-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <input type="text" placeholder="username" name="username" required>
                @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
                @endif
                <input type="password" placeholder="password" name="password" required>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
                <button type="submit">login</button>
                <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>

            <div class="loginBtn loginBtn--facebook">
                <a href="redirect">Login with Facebook</a>
            </div>
            <a href="{{ route('password.request') }}" style="margin-top: 25px; color: #242124; font-size: 12px;">
                Forgot Your Password?
            </a>
        </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
