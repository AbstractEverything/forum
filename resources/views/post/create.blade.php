@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li><a href="{{ route('forum.show', $forum->id) }}">{{ $forum->name }}</a></li>
    <li class="active">Create new post</li>
</ol>

@include('post.forms.create')

@endsection
