<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <title>Login</title>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="{{ route('user.authenticate') }}">
            @csrf
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            @if ($errors->has('email'))
                <div class="error-messages">
                    <ul>
                        <li>{{ $errors->first('email') }}</li>
                    </ul>
                </div>
            @endif
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            @if ($errors->has('password'))
                <div class="error-messages">
                    <ul>
                        <li>{{ $errors->first('password') }}</li>
                    </ul>
                </div>
            @endif
            <button type="submit">Login</button>


            <a href="{{ route('google-auth') }}" class="google-login-button">Login with Google</a>
            <p>Don't have an account?<a href=""> Sign up</a></p>

            @if ($errors->has('message'))
                <div class="error-messages">
                    <ul>
                        <li>{{ $errors->first('message') }}</li>
                    </ul>
                </div>
            @endif

        </form>
    </div>
</body>

</html>
