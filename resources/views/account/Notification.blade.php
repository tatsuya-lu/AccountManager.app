@extends('layouts.app')

@section('title')
    お知らせ
@endsection

@section('content')
    <div class="form-title">
        <p class="page-title">お知らせ情報</p>
    </div>

    <div class="form-item">
        <p class="sub-title">{{ $notification->title }}</p>
        <p class="form-item-input form-item-textarea">{{ $notification->description }}</p>
    </div>
@endsection
