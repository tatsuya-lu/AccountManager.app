@extends('layouts.app')

@section('title')
    ダッシュボード
@endsection

@section('content')
    <p class="page-title">HOME</p>
    <div class="table-menu">
        <p><a href="{{ route('account.register.form') }}"><span class="regist">アカウント登録</span></a></p>
        <p><a href="{{ route('account.list') }}"><span class="summary">アカウント一覧</span></a></p>
    </div>
@endsection
