@extends('layouts.app')

@section('title')
    ダッシュボード
@endsection

@section('content')
    <p class="page-title">HOME</p>
    <div class="main-content-aria dashboard">
        <button><a href="{{ route('account.register.form') }}"><span class="regist">アカウント登録</span></a></button>
        <button><a href="{{ route('account.list') }}"><span class="summary">アカウント一覧</span></a></button>
    </div>
@endsection
