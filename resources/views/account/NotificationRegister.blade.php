@extends('layouts.app')

@section('title')
    新規お知らせ登録
@endsection

@section('content')
    <p class="page-title">
        新規お知らせ登録</p>

        <form method="POST" action="{{ route('notification.store') }}">
            @csrf

            <div>
                <label for="title">タイトル</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>

                @error('title')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description">内容</label>
                <textarea id="description" name="description" required>{{ old('description') }}</textarea>

                @error('description')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit">作成</button>
            </div>
        </form>
    
@endsection