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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@3.0.0-beta.5/dist/vue.global.prod.js"></script>

    <!-- reset.css ress -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <header>
            <div class="nav-menu-container-left">
                <nav>
                    <ul>
                        <li><span class="fa-solid fa-bars"></span>ロゴ</li>
                        
                            <li><a href="{{ route('dashboard') }}"><span class="fa-solid fa-house"></span>HOME</a></li>
                        
                        
                            <li><a href="{{ route('account.list') }}"><span class="fa-solid fa-envelopes-bulk"></span>アカウント一覧</a></li>
                        
                        
                            <li><a href="{{ route('inquiry.list') }}"><span class="fa-solid fa-envelopes-bulk"></span>お問い合わせ一覧</a></li>
                        
                    </ul>
                </nav>
            </div>

            <div class="nav-menu-container-right">
                <div class="notification-aria" id="app">
                    <nav>
                        <button @click="toggleDropdown">
                            <i class="far fa-bell"></i>
                            <span v-if="notifications.total > 0"
                                class="notification-badge">@{{ notifications.total }}</span>
                        </button>
                        <!-- お知らせメニュー -->
                        <ul class="notification-menu" v-show="showDropdown">
                            <li v-for="item in notifications.data" :key="item.id">
                                <a :href="item.url">
                                    <span>@{{ item.title }}</span>
                                    <span class="notification-date">@{{ item.date }}</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <ul class="user-aria">
                    <li class="logged-in-user-text">ログイン中： {{ Auth::guard('admin')->user()->name }}</li>
                    <li><span class="logout-btn"><a href="{{ route('logout') }}">ログアウト</a></span></li>
                </ul>
            </div>
        </header>
        <div class="main-container">
            <main>
                @yield('content')
            </main>
        </div>
    </div>



    <script>
        const app = Vue.createApp({
            data() {
                return {
                    notifications: {},
                    showDropdown: false
                }
            },
            methods: {
                toggleDropdown() {
                    this.showDropdown = !this.showDropdown;
                },
                fetchNotifications() {
                    const url = '{{ route('notification.list') }}';
                    axios.get(url)
                        .then(response => {
                            this.notifications = response.data;
                        })
                        .catch(error => {
                            console.error('Error fetching notifications:', error);
                        });
                }
            },
            mounted() {
                this.fetchNotifications();
            }
        });

        app.mount('#app');
    </script>
</body>

</html>
