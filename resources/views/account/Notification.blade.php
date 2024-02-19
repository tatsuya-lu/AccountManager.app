@extends('layouts.app')

@section('title')
    お知らせ
@endsection

@section('content')
    <div class="form-title">
        <p class="page-title">お知らせ情報</p>
    </div>

    <div>
        <h2>{{ $notification->title }}</h2>
        <p>{{ $notification->description }}</p>
    </div>
@endsection
