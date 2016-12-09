@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li class="active">{{ $forum->name }}</li>
</ol>

@can('create', $forum)
    <p><a href="{{ route('post.create', $forum->id) }}" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;Create a new post</a></p>
@endcan

<table class="table table-hover">
    <thead>
        <tr>
            <th>Post title</th>
            <th class="text-center">Views</th>
            <th class="text-center">Replies</th>
            <th>Latest reply</th>
        </tr>
    </thead>
    <tbody>
        @include('forum.partials.pinned')
        @include('forum.partials.posts')
    </tbody>
</table>

@can('create', $forum)
    <p><a href="{{ route('post.create', $forum->id) }}" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;Create a new post</a></p>
@endcan

{!! $posts->render() !!}

@endsection
