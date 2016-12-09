@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li><a href="{{ route('forum.show', $post->forum->id) }}">{{ $post->forum->name }}</a></li>
    <li><a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a></li>
    <li class="active">Reply to post</li>
</ol>

@include('reply.forms.reply')

@endsection
