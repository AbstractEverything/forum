@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li><a href="{{ route('forum.show', $post->forum->id) }}">{{ $post->forum->name }}</a></li>
    <li class="active">{{ $post->title }}</li>
</ol>

@if ($post->hasOptions())
    <div class="alert alert-warning" role="alert">
        This post is:
        @if ($post->pinned)
            <span class="badge"><i class="fa fa-thumb-tack"></i>&nbsp;<strong>pinned</strong></span>
        @endif
        @if ($post->closed)
            <span class="badge"><i class="fa fa-lock"></i>&nbsp;<strong>closed</strong></span>
        @endif
    </div>
@endif

@can('moderate-posts')
    @include('post.partials.options')
@endcan

@if ($pageNumber == null || $pageNumber == 1)
    @include('post.partials.post')
@endif

@include('reply.partials.replies')

{!! $replies->render() !!}

<hr />

@can('reply', $post)
    <p><a href="{{ route('reply.create', $post->id) }}" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;Reply to post</a></p>
@endcan

@endsection
