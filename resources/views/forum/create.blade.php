@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li class="active">Create new forum</li>
</ol>

@include('forum.forms.create')

@endsection
