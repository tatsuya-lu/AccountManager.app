@extends('layouts.app')

@section('title')
    ダッシュボード
@endsection

@section('content')
    <p class="page-title">
        HOME</p>
    <div class="main-content-aria dashboard">
        <div class="dashboard-content-left">

            <div class="notification-list-aria">
                <p class="sub-title">お知らせ一覧</p>
                @foreach ($notifications as $notification)
                    <ul>
                        <li class="notification-title">{{ $notification->title }}
                            @if (in_array($notification->id, $readNotificationIds))
                                <div class="notification-read-status">既読済み</div>
                            @else
                                <div class="notification-not-read-status">未読</div>
                            @endif
                        </li>
                        <li class="notification-title-date">
                            {{ \Carbon\Carbon::parse($notification->created_at)->format('m月d日') }}</li>
                        <li class="notification-content"><a
                                href="{{ route('notification.show', ['notification' => $notification->id]) }}">{{ $notification->description }}</a>
                        </li>

                    </ul>
                @endforeach
                <div class="pagenation">
                    {{ $notifications->appends(Request::except('notifications'))->links() }}
                </div>
            </div>

            <div class="unresolved-inquiry-list-aria">
                <p class="sub-title">未対応のお問い合わせが「 {{ $unresolvedInquiryCount }} 」件あります。</p>
                <ul>
                    @foreach ($unresolvedInquiries as $inquiry)
                        <li class="notification-title">{{ $inquiry->company }} {{ $inquiry->email }} </li>
                        <li class="notification-title-date">
                            {{ \Carbon\Carbon::parse($inquiry->created_at)->format('m月d日') }}</li>
                        <li class="notification-content"><a
                                href="{{ route('inquiry.edit', $inquiry->id) }}">{{ $inquiry->body }}</a></li>
                    @endforeach
                </ul>
                <div class="pagenation">
                    {{ $unresolvedInquiries->appends(Request::except('page'))->links() }}</div>
            </div>
        </div>

        <div class="dashboard-content-right">
            <div class="button-aria">
                <button><a href="{{ route('account.register.form') }}"><span
                            class="fa-solid fa-circle-plus"></span>新規アカウント登録</a></button>

                <button><a href="{{ route('account.list') }}">アカウント一覧</a></button>
                <button><a href="{{ route('notification.create') }}">新規お知らせの作成</a></button>
            </div>

        </div>
    </div>
@endsection
