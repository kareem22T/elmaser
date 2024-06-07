@extends('site.layouts.main')

@section('title', "من نحن")

@section('content')
<style>
    .settings_wrapper h2 {
        margin: 16px 0;
        text-align: center;
        font-weight: 600;
    }
    .settings_wrapper img {
        width: 100%;
        max-width: 500px;
        border-radius: 12px;
        margin: 16px auto;
        display: block;
    }
    .settings_wrapper {
        padding: 16px 0
    }
</style>
<div class="container">
    <div class="settings_wrapper">
        {!!(isset($settingsArray['about']) && $settingsArray['about']["value"]) ? $settingsArray['about']["value"] : '' !!}
    </div>
</div>
@endsection
