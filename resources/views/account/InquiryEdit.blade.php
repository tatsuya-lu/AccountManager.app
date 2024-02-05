@extends('layouts.app')

@section('title')
    お問い合わせ編集
@endsection

@section('content')
    <div class="form-title">
        <p class="page-title">お問い合わせ編集</p>
    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.inquiry.update', $inquiry->id) }}">
        @csrf
        @method('PUT')
        <div class="form">

            <div class="Inquiry-Item">
                <label for="status" class=" sub_title">ステータス</label>
                <select name="status" id="status" class="Inquiry-Form-Item-Input">
                    @foreach (config('const.status') as $statusKey => $statusLabel)
                        <option value="{{ $statusKey }}" {{ $inquiry->status === $statusKey ? 'selected' : '' }}>
                            {{ $statusLabel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="Inquiry-Item">
                <label for="body" class=" sub_title">お問い合わせ内容</label>
                <p class="Inquiry-font">{{ $inquiry->body }}</p>
            </div>

            <div class="Inquiry-Item">
                <label for="comment" class=" sub_title">備考欄</label>
                <textarea name="comment" id="comment" class="Inquiry-Form-Item-Textarea">{{ $inquiry->comment }}</textarea>
            </div>

            <div class="Inquiry-Item Inquiry-box">
                <p class="sub_title">お問い合わせ情報</p>
            </div>

            <div class="Inquiry-Item">
                <label for="company" class=" Inquiry-Label">会社名:{{ $inquiry->company }}</label>
            </div>

            <div class="Inquiry-Item">
                <label for="name" class=" Inquiry-Label">氏名:{{ $inquiry->name }}</label>
            </div>

            <div class="Inquiry-Item">
                <label for="tel" class=" Inquiry-Label">電話番号:{{ $inquiry->tel }}</label>
            </div>

            <div class="Inquiry-Item">
                <label for="email" class=" Inquiry-Label">メールアドレス:{{ $inquiry->email }}</label>
            </div>

            <div class="Inquiry-Item">
                <label for="birthday" class=" Inquiry-Label">生年月日:{{ $inquiry->birthday }}</label>
            </div>

            <div class="Inquiry-Item">
                <label for="gender" class=" Inquiry-Label">性別:{{ config('const.gender.' . $inquiry->gender) }}</label>
            </div>

            <div class="Inquiry-Item">
                <label for="profession"
                    class=" Inquiry-Label">職業:{{ config('const.profession.' . $inquiry->profession) }}</label>
            </div>

            <input type="submit" class="form-btn" value="更新">
        </div>
    </form>
@endsection
