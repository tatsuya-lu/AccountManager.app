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
    <div class="inquiry-edit-container">

        <div class="inquiry-form-content">
            <form method="POST" action="{{ route('inquiry.update', $inquiry->id) }}">
                @csrf
                @method('PUT')

                <div class="form-item">
                    <label for="status">ステータス</label>
                    <select name="status" id="status" class="form-item-input minimal">
                        @foreach ($statusOptions as $statusKey => $statusLabel)
                            <option value="{{ $statusKey }}" {{ $inquiry->status === $statusKey ? 'selected' : '' }}>
                                {{ $statusLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-item">
                    <label for="body">お問い合わせ内容</label>
                    <p class="form-item-input form-item-textarea">{{ $inquiry->body }}</p>
                </div>

                <div class="form-item">
                    <label for="comment">備考欄</label>
                    <textarea name="comment" id="comment" class="form-item-input form-item-textarea">{{ $inquiry->comment }}</textarea>
                </div>

                <button type="submit" class="form-btn">更新する</button>
            </form>
        </div>

        <div class="inquiry-info-content">
            <p class="sub-title">お問い合わせ情報</p>

            <div class="info-item">
                <label for="company">会社名</label>
                <p>{{ $inquiry->company }}</p>
            </div>

            <div class="info-item">
                <label for="name">氏名</label>
                <p>{{ $inquiry->name }}</p>
            </div>

            <div class="info-item">
                <label for="tel">電話番号</label>
                <p>{{ $inquiry->tel }}</p>
            </div>

            <div class="info-item">
                <label for="email">メールアドレス</label>
                <p>{{ $inquiry->email }}</p>
            </div>

            <div class="info-item">
                <label for="birthday">生年月日</label>
                <p>{{ $inquiry->birthday }}</p>
            </div>

            <div class="info-item">
                <label for="gender">性別</label>
                <p>{{ $inquiry->gender }}</p>
            </div>

            <div class="info-item">
                <label for="profession">職業</label>
                <p>{{ $inquiry->profession }}</p>
            </div>
        </div>
    </div>
@endsection
