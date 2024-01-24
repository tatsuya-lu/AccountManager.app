@extends('layouts.app')

@section('title')
    アカウント一覧
@endsection

@section('content')
    <div class="table-title">
        <p class="page-title">アカウント一覧</p>

        <div class="search-form">
            <form class="">
                <div class="form-group">
                    <input type="search" class="form-control" name="search_name" value="{{ request('search_name') }}"
                        placeholder="名前を入力" aria-label="名前を検索...">
                </div>

                <div class="form-group">
                    <select class="form-control minimal" name="search_admin_level">
                        <option value="" selected>アカウントの種類を選択</option>
                        <option value="1" {{ request('search_admin_level') == 1 ? 'selected' : '' }}>社員</option>
                        <option value="2" {{ request('search_admin_level') == 2 ? 'selected' : '' }}>管理者</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="search" class="form-control" name="search_email" value="{{ request('search_email') }}"
                        placeholder="メールアドレスを入力" aria-label="メールアドレスを検索...">
                </div>
                <input type="submit" value="検索" class="">
            </form>
        </div>

        <a href="{{ route('admin.table.register.form') }}">
            <p class="regist-btn"><span class="fa-solid fa-circle-plus"></span>新規作成</p>
        </a>
    </div>


    @if (session('registered_message'))
        <div class="success">
            {{ session('registered_message') }} {{ session('registered_email') }}
        </div>
    @endif

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table">
        <table class="account">
            <tr>
                <th>編集</th>
                <th>削除</th>
                <th>名前</th>
                <th>アカウントの種類</th>
                <th>メールアドレス</th>
                <th>電話番号</th>
                <th>都道府県</th>
                <th>市町村</th>
                <th>番地・アパート名</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td class="table-center">
                        <a href="{{ route('admin.table.edit', $user->id) }}">
                            <span class="fa-solid fa-pen-to-square"></span>
                        </a>
                    </td>
                    <td class="table-center">
                        <form method="POST" action="{{ route('admin.table.destroy', $user->id) }}"
                            onsubmit="return confirm('削除します。よろしいですか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="no-border">
                                <span class="fa-solid fa-trash-can"></span>
                            </button>
                        </form>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>
                        @if ($user->admin_level == 1)
                            社員
                        @elseif ($user->admin_level == 2)
                            管理者
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->tel }}</td>
                    <td>{{ config('const.prefecture.' . $user->prefecture) }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->street }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="pagenation">{{ $users->appends(request()->input())->links() }}</div>
@endsection
