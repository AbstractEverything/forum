@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li class="active">{{ $user->present()->fullName() }}</li>
</ol>

<div class="row">
    <div class="col-md-3">
        <div class="well">
            <img src="{{ Gravatar::src($user->email, 300) }}" class="img-responsive" />
            <h3>{{ $user->present()->fullName() }}</h3>
            <ul class="naked">
                <li>{{ $user->username }}</li>
                <li><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>
                <li>Posts: <strong>{{ $user->present()->postsAndRepliesCount() }}</strong></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">

        @if ($posts->count())
            <h4>Latest posts by {{ $user->present()->fullName() }}</h4>
            <table class="table table-hover">
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>
                            <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a><br /><span class="text-muted">{{ $post->present()->createdAgo() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if ($replies->count())
            <h4>Latest replies by {{ $user->present()->fullName() }}</h4>
            <table class="table table-hover">
                <tbody>
                    @foreach ($replies as $reply)
                    <tr>
                        <td>
                            <a href="{{ route('post.show', $reply->post_id) }}">{{ $reply->title }}</a><br /><span class="text-muted">{{ $reply->present()->createdAgo() }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @can('update-roles')
            <h4>Roles for this user</h4>
             @include('user.partials.update-roles-form')
        @endcan

        @can('ban-users')
            @include('user.partials.ban-user-form')
        @endcan

    </div>
</div>

@endsection
