<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <script src="https://kit.fontawesome.com/d8cd936af6.js" crossorigin="anonymous"></script>

    <!-- reset.css ress -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="container">
        <div class="menu-toggle" id="mobile-menu">
            <span class="fa-solid fa-bars"></span>
        </div>

        <aside class="sidebar">
            <a href="{{ route('dashboard') }}">
                <p><span class="fa-solid fa-house"></span>HOME</p>
            </a>
            <a href="{{ route('account.list') }}">
                <p><span class="fa-solid fa-envelopes-bulk"></span>アカウント一覧</p>
            </a>
            <a href="{{ route('inquiry.list') }}">
                <p><span class="fa-solid fa-envelopes-bulk"></span>お問い合わせ一覧</p>
            </a>
        </aside>

        <main>
            <p>ログイン中：管理者 {{ Auth::guard('admin')->user()->name }}</p>
            <p><a href="{{ route('logout') }}"><span class="logout-btn">ログアウト</span></a></p>
            <div class="main-aria">
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>
