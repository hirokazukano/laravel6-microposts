<?php
/**
 * @var \App\User $user
 */
?>
<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a href="{{ route('users.show', ['user' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
            TimeLine <span class="badge badge-secondary">{{ $user->micropots_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.followings', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.followings') ? 'active' : '' }}">
            Followings <span class="badge badge-secondary">{{ $user->followings_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.followers', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.followers') ? 'active' : '' }}">
            Followers <span class="badge badge-secondary">{{ $user->followers_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('users.favorites', ['id' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.favorites') ? 'active' : '' }}">
            Favorites <span class="badge badge-secondary">{{ $user->favorites_count }}</span>
        </a>
    </li>
</ul>
