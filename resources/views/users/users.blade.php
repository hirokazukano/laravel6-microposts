<?php
/**
 * ユーザー一覧表示 以下で使用
 * UsersController@index
 * UsersController@followings
 * UsersController@followers
 *
 * @var \Illuminate\Pagination\LengthAwarePaginator $users
 * @var \App\User $user
 */
?>
@if (count($users) > 0)
    <ul class="list-unstyled">
        @foreach ($users as $user)
            <li class="media">
                {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{ $user->name }}
                    </div>
                    <div>
                        {{-- ユーザ詳細ページへのリンク --}}
                        <p>{!! link_to_route('users.show', 'View profile', ['user' => $user->id]) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    {{-- ページネーションのリンク --}}
    {{ $users->links() }}
@else
    <div class="alert alert-info">誰もいません...</div>
@endif
