@extends('layouts.app')

@section('title')
    新規お知らせ登録
@endsection

@section('content')
    <p class="page-title">
        新規お知らせ登録</p>

    <form method="POST" action="{{ route('notification.store') }}">
        @csrf

        <div class="form-item">
            <label for="title"><span class="required">必須</span>タイトル</label>
            <input class="form-item-input" id="title" type="text" name="title" value="{{ old('title') }}">

            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-item">
            <label for="description"><span class="required">必須</span>内容</label>
            <textarea class="form-item-input" id="description" name="description">{{ old('description') }}</textarea>

            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button class="form-btn" type="submit">作成</button>
        </div>
    </form>
@endsection
