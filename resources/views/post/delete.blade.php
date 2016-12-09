@extends('layouts.app')

@section('content')

<h3>Delete confirmation</h3>

<p>You are about to delete the post <strong>{{ $post->title }}</strong> - this will also delete all replies in this post, are you sure?</p>

@include('post.forms.delete')

@endsection
