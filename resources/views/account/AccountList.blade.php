@extends('layouts.app')

@section('title')
    アカウント一覧
@endsection

@section('content')
    <p class="page-title">アカウント一覧</p>

    <div class="search-form-container">
        <div class="search-form">
            <div class="search-form-item">
                <a href="{{ route('account.list', ['sort' => 'newest']) }}"><button class="sort-btn">新しい順</button></a>
            </div>

            <div class="search-form-item">
                <a href="{{ route('account.list', ['sort' => 'oldest']) }}"><button class="sort-btn">古い順</button></a>
            </div>
            <form>
                <div class="search-form-item">
                    <input type="search" name="search_name" value="{{ request('search_name') }}" placeholder="名前を入力"
                        aria-label="名前を検索...">
                </div>

                <div class="search-form-item">
                    <select class="minimal" name="search_admin_level">
                        <option selected>アカウントの種類を選択</option>
                        <option value="1" {{ request('search_admin_level') == 1 ? 'selected' : '' }}>管理者</option>
                        <option value="2" {{ request('search_admin_level') == 2 ? 'selected' : '' }}>社員</option>
                    </select>
                </div>

                <div class="search-form-item">
                    <input type="search" name="search_email" value="{{ request('search_email') }}" placeholder="メールアドレスを入力"
                        aria-label="メールアドレスを検索...">
                </div>

                <div class="search-form-item">
                    <input type="submit" value="検索">
                </div>
            </form>
        </div>

        <div class="new-register-btn">
            <a href="{{ route('account.register.form') }}"><button><span
                        class="fa-solid fa-circle-plus"></span>新規作成</button></a>
        </div>
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

    <div class="table-container">
        <table>
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
                    <td class="table-text-center">
                        <a href="{{ route('account.edit', $user->id) }}">
                            <span class="fa-solid fa-pen-to-square"></span>
                        </a>
                    </td>
                    <td class="table-text-center">
                        <form method="POST" action="{{ route('account.destroy', $user->id) }}"
                            onsubmit="return confirm('削除します。よろしいですか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <span class="fa-solid fa-trash-can"></span>
                            </button>
                        </form>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->admin_level }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->tel }}</td>
                    <td>{{ $user->prefecture }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->street }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="pagenation">{{ $users->appends(request()->input())->links('vendor.pagination.tailwind') }}</div>
@endsection
