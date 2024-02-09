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
                                    @{{ item.date }}
                                    @{{ item.title }}
                                </a>
                            </li>
                            <li>
                                <button @click="fetchAllNotifications">全てのお知らせを見る</button>
                            </li>
                            <li>
                                <button @click="resetNotifications">元に戻す</button>
                            </li>
                        </ul>
                    </nav>
                </div>
                <p>ログイン中： {{ Auth::guard('admin')->user()->name }}</p>
                <p><a href="{{ route('logout') }}"><span class="logout-btn">ログアウト</span></a></p>
            </header>

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
                },
                fetchAllNotifications() {
                    const url = '{{ route('notification.all') }}';
                    axios.get(url)
                        .then(response => {
                            console.log(response.data); // レスポンスデータをコンソールログに出力
                            this.notifications = response.data;
                            this.showDropdown = true; // Always show dropdown after fetching all notifications
                        })
                        .catch(error => {
                            console.error('Error fetching all notifications:', error);
                        });
                },
                resetNotifications() {
                    this.fetchNotifications(); // 元に戻すために通常のお知らせを再度取得
                    this.showDropdown = false; // ドロップダウンを閉じる
                },
            },
            mounted() {
                this.fetchNotifications();
            }
        });

        app.mount('#app');
    </script>
</body>

</html>
