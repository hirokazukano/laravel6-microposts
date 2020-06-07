<?php
/**
 * プロフィール部分
 * UsersController@index以外全部で使用
 *
 * @var \App\User $user
 */
?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <img class="rounded" src="{{ Gravatar::get($user->email, ['size' => 300]) }}" alt="">
    </div>
</div>

@include('user_follow.follow_button')
