@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li class="active">{{ $forum->name }}</li>
</ol>

@include('forum.forms.edit')

@endsection
