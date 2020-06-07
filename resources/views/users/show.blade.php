<?php
/**
 * @var \App\User $user
 */
?>
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-4">
        @include('users.card')
    </div>
    <div class="col-sm-8">
        @include('users.navtabs')

        @if (Auth::id() === $user->id)
            @include('microposts.form')
        @endif

        {{-- 投稿一覧 --}}
        @include('microposts.microposts')
    </div>
</div>
@endsection
