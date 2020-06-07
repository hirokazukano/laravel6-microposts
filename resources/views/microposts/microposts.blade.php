<?php
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator $microposts
 * @var \App\Micropost $micropost
 */
?>
@if (count($microposts) > 0)
    <ul class="list-unstyled">
        @foreach ($microposts as $micropost)
            <li class="media mb-3">
                <img class="mr-2 rounded" src="{{ Gravatar::get($micropost->user->email, ['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show', $micropost->user->name, ['user' => $micropost->user->id]) !!}
                        <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                    </div>
                    <div>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                @if (Auth::user()->is_favorite($micropost->id))
                                    {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
                                        {!! Form::submit('UnFavorite', ['class' => 'btn btn-sm btn-success']) !!}
                                    {!! Form::close() !!}
                                @else
                                    {!! Form::open(['route' => ['favorites.favorite', $micropost->id]]) !!}
                                        {!! Form::submit('Favorite', ['class' => 'btn btn-sm btn-light']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </li>
                            <li class="list-inline-item">
                                @if (Auth::id() === $micropost->user_id)
                                    {!! Form::model($micropost, ['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                                        {!! Form::submit('削除', ['class' => 'btn btn-sm btn-danger']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $microposts->links() }}
@else
    <div class="alert alert-info">データがありません...</div>
@endif
