<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/d8cd936af6.js" crossorigin="anonymous"></script>

    <!-- reset.css ress -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">

        <div class="side-menu-container">
            <aside class="sidebar">
                <div class="side-toggle-btn">
                    <p><span class="fa-solid fa-bars"></span></p>
                    <p><span class="fa-solid fa-xmark"></span></p>
                </div>

                <ul>
                    <a href="{{ route('dashboard') }}">
                        <li><span class="fa-solid fa-house"></span>HOME</li>
                    </a>
                    <a href="{{ route('account.list') }}">
                        <li><span class="fa-solid fa-envelopes-bulk"></span>アカウント一覧</li>
                    </a>
                    <a href="{{ route('inquiry.list') }}">
                        <li><span class="fa-solid fa-envelopes-bulk"></span>お問い合わせ一覧</li>
                    </a>
                </ul>
            </aside>
        </div>

        <div class="main-container">
            <header>
                <p>ログイン中： {{ Auth::guard('admin')->user()->name }}</p>
                <p><a href="{{ route('logout') }}"><span class="logout-btn">ログアウト</span></a></p>
            </header>

            <main>
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
