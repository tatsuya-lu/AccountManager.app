@extends('layouts.app')

@section('title')
    お問い合わせ一覧
@endsection

@section('content')
    <div class="table-title">
        <p class="page-title">お問い合わせ一覧</p>

        <div class="search-form">
            <div class="search-form-item">
                <a href="{{ route('inquiry.list', ['sort' => 'newest']) }}"><button class="sort-btn">新しい順</button></a>
            </div>

            <div class="search-form-item">
                <a href="{{ route('inquiry.list', ['sort' => 'oldest']) }}"><button class="sort-btn">古い順</button></a>
            </div>
            <form>
                <div class="search-form-item">
                    <select class=" minimal" name="search_status">
                        <option value="" selected>ステータスを選択</option>
                        <option value="default" {{ request('search_status') == 'default' ? 'selected' : '' }}>未対応</option>
                        <option value="checking" {{ request('search_status') == 'checking' ? 'selected' : '' }}>対応中</option>
                        <option value="checked" {{ request('search_status') == 'checked' ? 'selected' : '' }}>対応済み</option>
                    </select>
                </div>

                <div class="search-form-item">
                    <input type="search" name="search_company" value="{{ request('search_company') }}" placeholder="会社名を入力"
                        aria-label="会社名検索">
                </div>

                <div class="search-form-item">
                    <input type="search" name="search_tel" value="{{ request('search_tel') }}" placeholder="電話番号を入力"
                        aria-label="電話番号検索">
                </div>

                <div class="search-form-item">
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

    <div class="table-container">
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
                    <td class="table-text-center">
                        <a href="{{ route('inquiry.edit', $inquiry->id) }}">
                            <span class="fa-solid fa-pen-to-square"></span>
                        </a>
                    </td>
                    <td>{{ $inquiry->status }}</td>
                    <td>{{ $inquiry->company }}</td>
                    <td>{{ $inquiry->name }}</td>
                    <td>{{ $inquiry->tel }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="pagenation">{{ $inquiries->appends(request()->query())->links() }}</div>
@endsection
