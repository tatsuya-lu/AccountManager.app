<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body>
    <div class="contact-form-container">
        <form method="POST" action="{{ route('contact.confirm') }}">
            @csrf

            <div class="form-item">
                <label><span class="required">必須</span>会社名</label>
                <input class="form-item-input" type="text" name="company" value="{{ old('company') }}"
                    placeholder="例）株式会社令和">

                @if ($errors->has('company'))
                    <p class="error-message">{{ $errors->first('company') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>氏名</label>
                <input class="form-item-input" type="text" name="name" value="{{ old('name') }}"
                    placeholder="例）山田太郎">

                @if ($errors->has('name'))
                    <p class="error-message">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>電話番号</label>
                <input class="form-item-input" type="tel" name="tel" value="{{ old('tel') }}"
                    placeholder="例）000-0000-0000">

                @if ($errors->has('tel'))
                    <p class="error-message">{{ $errors->first('tel') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>メールアドレス</label>
                <input class="form-item-input" type="email" name="email" value="{{ old('email') }}"
                    placeholder="例）example@gmail.com">

                @if ($errors->has('email'))
                    <p class="error-message">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>生年月日</label>
                <input class="form-item-input" type="date" name="birthday" value="{{ old('birthday') }}">

                @if ($errors->has('birthday'))
                    <p class="error-message">{{ $errors->first('birthday') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>性別</label>
                <div class="form-item-check">
                    @foreach ($genders as $value => $label)
                        <input type="radio" name="gender" value="{{ $value }}"
                            {{ old('gender') == $value ? 'checked' : '' }}>
                        <label for="{{ $value }}">{{ $label }}</label>
                    @endforeach
                </div>

                @if ($errors->has('gender'))
                    <p class="error-message">{{ $errors->first('gender') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>職業</label>
                <select name="profession" class="form-item-input">
                    <option value="">職業を選択してください</option>
                    @foreach ($professions as $value => $label)
                        <option value="{{ $value }}" {{ old('profession') == $value ? 'selected' : '' }}>
                            {{ $label }}</option>
                    @endforeach
                </select>

                @if ($errors->has('profession'))
                    <p class="error-message">{{ $errors->first('profession') }}</p>
                @endif
            </div>

            <div class="form-item">
                <label><span class="required">必須</span>お問い合わせ内容</label>
                <textarea class="form-item-input" name="body">{{ old('body') }}</textarea>

                @if ($errors->has('body'))
                    <p class="error-message">{{ $errors->first('body') }}</p>
                @endif
            </div>

            <button type="submit" class="form-btn" value="確認する">確認する</button>
        </form>
    </div>
</body>

</html>
