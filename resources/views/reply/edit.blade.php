@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li><a href="{{ route('forum.show', $reply->post->forum->id) }}">{{ $reply->post->forum->name }}</a></li>
    <li><a href="{{ route('post.show', $reply->post->id) }}">{{ $reply->post->title }}</a></li>
    <li class="active">Edit reply</li>
</ol>

@include('reply.forms.edit')

@endsection
