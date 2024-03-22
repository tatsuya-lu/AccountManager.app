@extends('layouts.app')

@section('title')
    ダッシュボード
@endsection

@section('content')
    <p class="page-title">HOME</p>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="main-content-aria dashboard">
        <div class="dashboard-content-left">

            <div class="notification-list-aria">
                <p class="sub-title">お知らせ一覧</p>
                @foreach ($notificationData['notifications'] as $notification)
                    <ul>
                        <li class="notification-title">{{ $notification->title }}
                            @if (in_array($notification->id, $notificationData['readNotificationIds']))
                                <div class="notification-read-status">既読済み</div>
                            @else
                                <div class="notification-not-read-status">未読</div>
                            @endif
                        </li>
                        <li class="notification-title-date">
                            {{ \Carbon\Carbon::parse($notification->created_at)->format('m月d日') }}</li>
                        <a href="{{ route('notification.show', ['notification' => $notification->id]) }}">
                            <li class="notification-content">{{ $notification->description }}
                            </li>
                        </a>

                    </ul>
                @endforeach
                <div class="pagenation">
                    {{ $notificationData['notifications']->appends(Request::except('notifications'))->links('') }}
                </div>
            </div>

            <div class="unresolved-inquiry-list-aria">
                <p class="sub-title">未対応のお問い合わせが「 {{ $unresolvedInquiryCount }} 」件あります。</p>
                <ul>
                    @foreach ($unresolvedInquiries as $inquiry)
                        <li class="notification-title">{{ $inquiry->company }} {{ $inquiry->email }} </li>
                        <li class="notification-title-date">
                            {{ \Carbon\Carbon::parse($inquiry->created_at)->format('m月d日') }}</li>
                        <a href="{{ route('inquiry.edit', $inquiry->id) }}">
                            <li class="notification-content">{{ $inquiry->body }}</li>
                        </a>
                    @endforeach
                </ul>
                <div class="pagenation">
                    {{ $unresolvedInquiries->appends(Request::except('page'))->links() }}</div>
            </div>
        </div>

        <div class="dashboard-content-right">
            <div class="button-aria">
                <a href="{{ route('account.register.form') }}"><button><span
                            class="fa-solid fa-circle-plus"></span>新規アカウント登録</button></a>
                <a href="{{ route('account.list') }}"><button><span
                            class="fa-solid fa-envelopes-bulk"></span>アカウント一覧</button></a>
                <a href="{{ route('notification.create') }}"><button><span
                            class="fa-solid fa-circle-plus"></span>新規お知らせの作成</button></a>
                <a href="{{ route('inquiry.list') }}"><button><span
                            class="fa-solid fa-envelopes-bulk"></span>お問い合わせ一覧</button></a>
                <a href="{{ route('contact.index') }}"><button><span
                            class="fa-solid fa-up-right-from-square"></span>お問い合わせの登録へ</button></a>
            </div>

        </div>
    </div>
@endsection
