<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body>
    <div class="login-container">

        @if ($errors->has('error'))
            <p class="error-message">{{ $errors->first('error') }}</p>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">Mail</label>
                <input type="text" id="email" name="email">

                @if ($errors->has('email'))
                    <p class="error-message">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password">

                @if ($errors->has('password'))
                    <p class="error-message">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <button type="submit">Login</button>
        </form>

    </div>
</body>

</html>
