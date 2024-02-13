<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body>
    <div class="login-container">

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">メールアドレス</label>
                <input type="text" id="email" name="email">

                @if ($errors->has('email'))
                    <p class="error-message">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div>
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password">

                @if ($errors->has('password'))
                    <p class="error-message">{{ $errors->first('password') }}</p>
                @endif
            </div>

            @if ($errors->has('error'))
                <p class="error-message">{{ $errors->first('error') }}</p>
            @endif

            <button type="submit">ログイン</button>
        </form>

    </div>
</body>

</html>
