@extends('layouts.app')

@section('title')
    ダッシュボード
@endsection

@section('content')
    <p class="page-title">
        HOME</p>
    <div class="main-content-aria dashboard">
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
                    <li class="notification-title-date">{{ \Carbon\Carbon::parse($notification->created_at)->format('m月d日') }}</li>
                    <li class="notification-content"><a href="{{ route('notification.show', ['notification' => $notification->id]) }}">{{ $notification->description }}</a></li>

                </ul>
            @endforeach
            <div class="pagenation">{{ $notifications->links() }}</div>
        </div>
        <button><a href="{{ route('account.register.form') }}"><span class="regist">アカウント登録</span></a></button>
        <button><a href="{{ route('account.list') }}"><span class="summary">アカウント一覧</span></a></button>
    </div>
@endsection
