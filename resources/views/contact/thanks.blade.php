<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body>
    <div class="contact-form-container contact-thanks">
        <p class="check-in-messege">送信完了しました。</p>

        <div class="form-item under-line">
            <label>会社名</label>
            <p>{{ $inputs['company'] }}</p>
        </div>

        <div class="form-item under-line">
            <label>氏名</label>
            <p>{{ $inputs['name'] }}</p>
        </div>

        <div class="form-item under-line">
            <label>電話番号</label>
            <p>{{ $inputs['tel'] }}</p>
        </div>

        <div class="form-item under-line">
            <label>メールアドレス</label>
            <p>{{ $inputs['email'] }}</p>
        </div>

        <div class="form-item under-line">
            <label>生年月日</label>
            <p>{{ $inputs['birthday'] }}</p>
        </div>

        <div class="form-item under-line">
            <label>性別</label>
            <p>{{ $genders[$inputs['gender']] }}</p>
        </div>

        <div class="form-item under-line">
            <label>職業</label>
            <p>{{ $professions[$inputs['profession']] }}</p>
        </div>

        <div class="form-item under-line">
            <label class=" ">お問い合わせ内容</label>
            <p>{!! nl2br(e($inputs['body'])) !!}</p>
        </div>

        <a href="{{ route('contact.index') }}"><button type="button" class="form-btn">戻る</button></a>

    </div>
</body>

</html>
