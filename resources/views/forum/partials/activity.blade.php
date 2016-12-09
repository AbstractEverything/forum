<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-users" aria-hidden="true"></i>
<strong>Users online in the last {{ config('forum.last_online_minutes') }} minutes</strong></div>
    <div class="panel-body">
        <p>
            @if ($activity->count() > 0)
                @foreach ($activity as $a)
                    <a href="{{ route('user.show', $a->user->id) }}"><strong>{{ $a->user->username }}</strong></a>
                @endforeach
                <br />
            @endif
            <strong>{{ $guestsCount }}</strong> guests online.
        </p>
    </div>
</div>