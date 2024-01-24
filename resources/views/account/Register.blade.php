@extends('layouts.app')

@section('title')
    アカウント登録
@endsection

@section('content')
    <p class="page-title">アカウント一覧</p>

    <form method="POST"
        action="{{ $user->id ? route('admin.table.update', ['user' => $user->id]) : route('admin.table.register.form') }}">
        @csrf
        @if ($user->id)
            @method('PUT')
        @endif

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>会員名</p>
            <input type="text" id="name" name="name" class="Form-Item-Input" value="{{ old('name', $user->name) }}"
                placeholder="例）山田太郎">

            @if ($errors->has('name'))
                <p class="error-message">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>フリガナ</p>
            <input type="text" id="sub_name" name="sub_name" class="Form-Item-Input"
                value="{{ old('sub_name', $user->sub_name) }}" placeholder="例）ヤマダタロウ">

            @if ($errors->has('sub_name'))
                <p class="error-message">{{ $errors->first('sub_name') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>メールアドレス</p>
            <input type="text" id="email" name="email" class="Form-Item-Input"
                value="{{ old('email', $user->email) }}" placeholder="例）example@gmail.com">

            @if ($errors->has('email'))
                <p class="error-message">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>パスワード</p>
            <input type="password" id="password" name="password" class="Form-Item-Input" value="{{ old('password') }}"
                placeholder="八文字以上で入力してください。">

            @if ($errors->has('password'))
                <p class="error-message">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>パスワード(再入力)</p>
            <input type="password" id="password_confirmation" name="password_confirmation" class="Form-Item-Input"
                placeholder="パスワードを再入力してください。">

            @if ($errors->has('password'))
                <p class="error-message">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>電話番号</p>
            <input type="text" id="tel" name="tel" class="Form-Item-Input"
                value="{{ old('tel', $user->tel) }}" placeholder="例）000 0000 0000   注:ハイフン無しで入力してください">

            @if ($errors->has('tel'))
                <p class="error-message">{{ $errors->first('tel') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>郵便番号</p>
            <input type="text" id="post_code" name="post_code" class="Form-Item-Input"
                value="{{ old('post_code', $user->post_code) }}" placeholder="例）000 0000   注:ハイフン無しで入力してください">

            @if ($errors->has('post_code'))
                <p class="error-message">{{ $errors->first('post_code') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>都道府県</p>
            <select name="prefecture" id="prefecture" class="Form-Item-Input">
                <option value="" selected disabled>都道府県を選択してください</option>
                @foreach ($prefectures as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('prefecture', $user->prefecture) == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('prefecture'))
                <p class="error-message">{{ $errors->first('prefecture') }}</p>
            @endif
        </div>


        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>市町村</p>
            <input type="text" id="city" name="city" class="Form-Item-Input"
                value="{{ old('city', $user->city) }}" placeholder="">

            @if ($errors->has('city'))
                <p class="error-message">{{ $errors->first('city') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>番地・アパート名</p>
            <input type="text" id="street" name="street" class="Form-Item-Input"
                value="{{ old('street', $user->street) }}" placeholder="">

            @if ($errors->has('street'))
                <p class="error-message">{{ $errors->first('street') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <label class="Form-Item-Label isMsg">備考欄</label>
            <textarea class="Form-Item-Textarea" name="body">{{ old('body', $user->body) }}</textarea>

            @if ($errors->has('body'))
                <p class="error-message">{{ $errors->first('body', '') }}</p>
            @endif
        </div>

        <div class="Form-Item">
            <p class="Form-Item-Label"><span class="Form-Item-Label-Required">必須</span>アカウントの種類</p>
            <select name="admin_level" id="admin_level" class="Form-Item-Input">
                <option value="" selected disabled>アカウントの種類を選択してください</option>
                @foreach ($adminLevels as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('admin_level', $user->admin_level) == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            @if ($errors->has('admin_level'))
                <p class="error-message">{{ $errors->first('admin_level') }}</p>
            @endif
        </div>

        <input type="submit" class="Form-Btn" value="{{ $user->id ? '更新する' : '確認する' }}">
    </form>
@endsection
