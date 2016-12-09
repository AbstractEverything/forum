@extends('layouts.app')

@section('content')

@can('create-forums')
    <p><a href="{{ route('forum.create') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Create a new forum</a></p>
@endcan

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            @can('edit-forums')
                <th>Options</th>
            @endcan
            <th>Forum name</th>
            <th class="text-center">Posts</th>
            <th>Latest post</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($forums as $forum)
        <tr>
            @can('edit-forums')
                <td class="text-middle text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('forum.edit', $forum->id) }}">Edit</a></li>
                            @can('delete-forums')
                                <li><a href="{{ route('forum.confirm-delete', $forum->id) }}">Delete</a></li>
                            @endcan
                        </ul>
                    </div>
                </td>
            @endcan
            <td class="text-middle">
                <h4>
                    @if ($forum->closed)
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-comments-o"></i>
                    @endif
                        <a href="{{ route('forum.show', $forum->id) }}">{{ $forum->name }}</a>
                </h4>
                <span class="text-muted">{{ $forum->description }}</span>
            </td>
            <td class="text-center text-middle">
                {{ $forum->postsCount }}
            </td>
            <td class="text-middle">
                @if ($forum->postsCount > 0)
                    <strong><a href="{{ route('post.show', $forum->latestPost->id) }}">{{ $forum->latestPost->title }}</a></strong>
                    <br />
                    <span class="text-muted">{{ $forum->latestPost->present()->updatedAgo() }} <em>by</em> <strong><a href="{{ route('user.show', $forum->latestPost->user->id) }}">{{ $forum->latestPost->user->username }}</a></strong></span>
                @else
                    <em>No posts</em>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center"><em>No forums yet.</em></td>
        </tr>
    @endforelse
    </tbody>
</table>

@include('forum.partials.stats')
@include('forum.partials.activity')

@endsection
