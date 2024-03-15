@extends('layouts.app')

@section('title')
    @if ($user->id)
        アカウント編集
    @else
        アカウント登録
    @endif
@endsection

@section('content')
    <p class="page-title">
        @if ($user->id)
            アカウント編集
        @else
            アカウント登録
        @endif
    </p>

    <div class="register-form-container">

        <form method="POST"
            action="{{ $user->id ? route('account.update', ['user' => $user->id]) : route('account.register.form') }}">
            @csrf
            @if ($user->id)
                @method('PUT')
            @endif

            <div class="form-item">
                <label><span class="required">必須</span>会員名</label>
                <input class="form-item-input" type="text" id="name" name="name"
                    value="{{ old('name', $user->name) }}" placeholder="例）山田太郎">

                @if ($errors->has('name'))
                    <p class="error-message">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>フリガナ</label>
                <input class="form-item-input" type="text" id="sub_name" name="sub_name"
                    value="{{ old('sub_name', $user->sub_name) }}" placeholder="例）ヤマダタロウ">

                @if ($errors->has('sub_name'))
                    <p class="error-message">{{ $errors->first('sub_name') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>メールアドレス</label>
                <input class="form-item-input" type="text" id="email" name="email"
                    value="{{ old('email', $user->email) }}" placeholder="例）example@gmail.com">

                @if ($errors->has('email'))
                    <p class="error-message">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>パスワード</label>
                <input class="form-item-input" type="password" id="password" name="password" value="{{ old('password') }}"
                    placeholder="八文字以上で入力してください。" autocomplete="new-password">

                @if ($errors->has('password'))
                    <p class="error-message">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>パスワード(再入力)</label>
                <input class="form-item-input" type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="パスワードを再入力してください。">

                @if ($errors->has('password'))
                    <p class="error-message">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>電話番号</label>
                <input class="form-item-input" type="text" id="tel" name="tel"
                    value="{{ old('tel', $user->tel) }}" placeholder="例）000 0000 0000   注:ハイフン無しで入力してください">

                @if ($errors->has('tel'))
                    <p class="error-message">{{ $errors->first('tel') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>郵便番号</label>
                <input class="form-item-input" type="text" id="post_code" name="post_code"
                    value="{{ old('post_code', $user->post_code) }}" placeholder="例）000 0000   注:ハイフン無しで入力してください">

                @if ($errors->has('post_code'))
                    <p class="error-message">{{ $errors->first('post_code') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>都道府県</label>
                <select class="form-item-input minimal" name="prefecture" id="prefecture">
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


            <div class="form-item">
                <label><span class="required">必須</span>市町村</label>
                <input class="form-item-input" type="text" id="city" name="city"
                    value="{{ old('city', $user->city) }}" placeholder="">

                @if ($errors->has('city'))
                    <p class="error-message">{{ $errors->first('city') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>番地・アパート名</label>
                <input class="form-item-input" type="text" id="street" name="street"
                    value="{{ old('street', $user->street) }}" placeholder="">

                @if ($errors->has('street'))
                    <p class="error-message">{{ $errors->first('street') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label>備考欄</label>
                <textarea class="form-item-input" name="comment">{{ old('comment', $user->comment) }}</textarea>

                @if ($errors->has('comment'))
                    <p class="error-message">{{ $errors->first('comment', '') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>アカウントの種類</label>
                <select class="form-item-input minimal" name="admin_level" id="admin_level">
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


            <button type="submit" class="form-btn">{{ $user->id ? '更新する' : '確認する' }}</button>
        </form>

    </div>
@endsection
