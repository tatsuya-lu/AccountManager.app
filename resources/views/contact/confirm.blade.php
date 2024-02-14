<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body>

    <div class="contact-form-container">

        <form method="POST" action="{{ route('contact.send') }}">
            @csrf

            <div class="form-item under-line">
                <label>会社名</label>
                {{ $inputs['company'] }}
                <input class="form-item-input" name="company" value="{{ $inputs['company'] }}" type="hidden">
            </div>

            <div class="form-item under-line">
                <label>氏名</label>
                {{ $inputs['name'] }}
                <input class="form-item-input" name="name" value="{{ $inputs['name'] }}" type="hidden">
            </div>

            <div class="form-item under-line">
                <label>電話番号</label>
                {{ $inputs['tel'] }}
                <input class="form-item-input" name="tel" value="{{ $inputs['tel'] }}" type="hidden">
            </div>

            <div class="form-item under-line">
                <label>メールアドレス</label>
                {{ $inputs['email'] }}
                <input class="form-item-input" name="email" value="{{ $inputs['email'] }}" type="hidden">
            </div>

            <div class="form-item under-line">
                <label>生年月日</label>
                {{ $inputs['birthday'] }}
                <input class="form-item-input" name="birthday" value="{{ $inputs['birthday'] }}" type="hidden">
            </div>

            <div class="form-item under-line">
                <label>性別</label>
                {{ $genders[$inputs['gender']] }}
                <input class="form-item-input" name="gender" value="{{ $inputs['gender'] }}" type="hidden">
            </div>

            <div class="form-item under-line">
                <label>職業</label>
                {{ $professions[$inputs['profession']] }}
                <input class="form-item-input" name="profession" value="{{ $inputs['profession'] }}" type="hidden">
            </div>

            <div class="form-item">
                <label class=" ">お問い合わせ内容</label>
                {!! nl2br(e($inputs['body'])) !!}
                <input class="form-item-input" name="body" value="{{ $inputs['body'] }}" type="hidden">
            </div>


            <button type="submit" class="form-btn" name="action" value="back">入力内容修正</button>
            <button type="submit" class="form-btn" name="action" value="submit">送信する</button>

    </div>
    </form>
</body>

</html>
