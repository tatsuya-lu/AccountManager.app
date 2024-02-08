@extends('layouts.app')

@section('title')
    ダッシュボード
@endsection

@section('content')
    <p class="page-title">HOME</p>
    <div class="main-content-aria dashboard">
        <p><a href="{{ route('account.register.form') }}"><span class="regist">アカウント登録</span></a></p>
        <p><a href="{{ route('account.list') }}"><span class="summary">アカウント一覧</span></a></p>

        <div id="app">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                お知らせ機能サンプル
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">

                        <!-- ③ 独自コンポーネントを表示 -->
                        <v-dropdown-nav-item v-model:items="notifications">

                            <!-- 表示するアイコン -->
                            <i class="fa-regular fa-bell"></i>

                            <!-- フッターは任意です -->
                            <template v-slot:footer>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center text-secondary" href="#">
                                    <small>全てのお知らせを見る</small>
                                </a>
                            </template>

                        </v-dropdown-nav-item>

                    </ul>
                </div>
            </nav>
        </div>
    </div>
    
    <script>
        // ① ドロップダウンを表示するVueコンポーネントを定義
        const dropdownNavItemComponent = {
            props: ['items'],
            computed: {
                hasItem() {

                    return (
                        Object.keys(this.items).length > 0 &&
                        this.items.data.length > 0
                    );

                }
            },
            template: `
                    <li class="nav-item dropdown" v-if="hasItem">
                        <a style="position:relative;min-width:40px;" class="nav-link" data-toggle="dropdown" href="#">
                            <slot>
                                <i class="far fa-bell"></i>
                            </slot>
                            <span style="position:absolute;top:0;left:16px;" class="badge badge-danger" v-text="items.total"></span>
                        </a>
                        <div style="width:300px;" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a style="overflow: hidden;text-overflow:ellipsis;" class="dropdown-item" :href="item.url" v-for="item in items.data">
                                <small class="float-right text-muted pl-3" v-text="item.date"></small>
                                <small v-text="item.title"></small>
                            </a>
                            <footer>
                                <slot name="footer"></slot>
                            </footer>
                        </div>
                    </li>
                `
        };

        Vue.createApp({
                data() {
                    return {
                        notifications: {}
                    }
                },
                mounted() {

                    const url = '{{ route('notification.list') }}';
                    axios.get(url)
                        .then(response => {

                            this.notifications = response.data;

                        });

                }
            })
            .component('v-dropdown-nav-item', dropdownNavItemComponent) // ② コンポーネントをセット
            .mount('#app');
    </script>
@endsection
