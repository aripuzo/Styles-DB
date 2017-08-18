<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <div class="panel-body">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif 
            </div>
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}
                <!-- <input type="hidden" name="token" value="{{ $token }}"> -->
                <input type="email" placeholder="E-Mail Address" name="email" value="{{ $email or old('email') }}" required autofocus/>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif

                <button type="submit" class="btn btn-primary">
                    Send Password Reset Link
                </button>
            </form>
        </div>
    </div>
</body>
</html>
