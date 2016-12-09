@if ($forumsCount > 0)
    <div class="panel panel-default">
        <div class="panel-heading"><strong><i class="fa fa-bar-chart"></i>&nbsp;Forum statistics</strong></div>
        <div class="panel-body">
            <ul class="naked">
                <li>Members: <strong>{{ $usersCount }}</strong></li>
                <li>Total posts: <strong>{{ $postsCount }}</strong></li>
                <li>Total replies: <strong>{{ $repliesCount }}</strong></li>
                @if ($usersCount > 0)
                    <li>Newest member: <strong><a href="{{ route('user.show', $latestUser->id) }}">{{ $latestUser->username }}</a></strong></li>
                @endif
                @if ($postsCount > 0)
                    <li>Latest post: <strong><a href="{{ route('post.show', $latestPost->id) }}">{{ $latestPost->title }}</a></strong> {{ $latestPost->present()->createdAgo() }} <em>by</em> <strong><a href="{{ route('user.show', $latestPost->user->id) }}">{{ $latestPost->user->username }}</a></strong></li>
                @endif
            </ul>
        </div>
    </div>
@endif