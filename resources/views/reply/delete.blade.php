@extends('layouts.app')

@section('content')

<h3>Delete confirmation</h3>

<p>You are about to delete the reply <strong>{{ $reply->title }}</strong> are you sure?</p>

@include('reply.forms.delete')

@endsection
