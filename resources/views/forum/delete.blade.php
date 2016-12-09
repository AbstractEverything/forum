@extends('layouts.app')

@section('content')

<h3>Delete confirmation</h3>

<p>You are about to delete the forum <strong>{{ $forum->name }}</strong> - this will also delete all posts and replies, are you sure?</p>

@include('forum.forms.delete')

@endsection
