@extends('layouts.app')

@section('content')

<ol class="breadcrumb">
    <li><a href="{{ route('forum.index') }}">Forums</a></li>
    <li class="active">Profile</li>
</ol>

<div class="row">
    <div class="col-md-3">
        <div class="well">
            <img src="{{ Gravatar::src($user->email, 300) }}" class="img-responsive" />
            <h3>{{ $user->present()->fullName() }}</h3>
            <ul class="naked">
                <li>{{ $user->username }}</li>
                <li><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>
                <li>Posts: <strong>{{ $user->present()->postsAndRepliesCount() }}</strong></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">

        <h4>Update profile</h4>

        @include('user.partials.update-profile-form')

        <hr />
        
        <h4>Update password</h4>

        @include('user.partials.update-password-form')

    </div>
</div>

@endsection
