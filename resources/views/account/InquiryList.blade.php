@extends('layouts.app')

@section('title')
    お問い合わせ一覧
@endsection

@section('content')
    <div class="table-title">
        <p class="page-title">お問い合わせ一覧</p>

        <div class="search-form">
            <form>
                <div class="form-group">
                    <input type="search" class="form-control" name="search_name" value="{{ request('search_name') }}"
                        placeholder="名前を入力" aria-label="名前を検索...">
                </div>

                <div class="form-group">
                    <select class="form-control minimal" name="search_admin_level">
                        <option selected>アカウントの種類を選択</option>
                        <option value="off" {{ request('search_admin_level') == 'off' ? 'selected' : '' }}>社員</option>
                        <option value="on" {{ request('search_admin_level') == 'on' ? 'selected' : '' }}>管理者</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="search" class="form-control" name="search_email" value="{{ request('search_email') }}"
                        placeholder="メールアドレスを入力" aria-label="メールアドレスを検索...">
                </div>

                <div class="form-group">
                    <input type="submit" value="検索">
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-list">
        <table>
            <tr>
                <th>編集</th>
                <th>ステータス</th>
                <th>会社名</th>
                <th>氏名</th>
                <th>電話番号</th>
            </tr>
            @foreach ($inquiries as $inquiry)
                <tr>
                    <td class="table-center">
                        <a href="{{ route('admin.inquiry.edit', $inquiry->id) }}">
                            <span class="fa-solid fa-pen-to-square"></span>
                        </a>
                    </td>
                    <td>{{ config('const.status')[$inquiry->status] ?? $inquiry->status }}</td>
                    <td>{{ $inquiry->company }}</td>
                    <td>{{ $inquiry->name }}</td>
                    <td>{{ $inquiry->tel }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="pagenation">{{ $inquiries->appends(request()->query())->links() }}</div>
@endsection
