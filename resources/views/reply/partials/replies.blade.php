@forelse ($replies as $key => $reply)
    <div class="panel panel-default" id="reply-{{ $reply->id }}">
        <div class="panel-heading"><span class="badge">{{ $key + 2 }}</span>&nbsp;<strong>{{ $reply->present()->createdAgo() }}</strong></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2 col-lg-2 post-profile">
                    <img src="{{ Gravatar::src($reply->user->email, 80) }}" class="img-responsive" />
                    <h4><a href="{{ route('user.show', $reply->user->id) }}">{{ $reply->user->username }}</a></h4>
                    <ul class="naked">
                        <li><small>Member since {{ $reply->user->present()->dateOnly() }}</small></li>
                        <li><small>Posts: {{ $reply->user->present()->postsAndRepliesCount() }}</small></li>
                        @if ($reply->user->banned == true)
                            <li><small>Banned!</small></li>
                        @endif
                    </ul>
                </div>
                <div class="col-sm-10 col-lg-10">
                    <p><strong>{{ $reply->title }}</strong></p>
                    {!! $reply->present()->markdownBody() !!}
                    <hr />
                    <div class="reply-options text-right">
                        @can('reply', $post)
                            <a href="{{ route('reply.create', [$post->id, 'quote_id' => $reply->id, 'type' => 'reply']) }}" class="btn btn-default"><i class="fa fa-quote-right"></i>&nbsp;Reply with quote</a>
                        @endcan
                        @can('edit', $reply)
                            <a href="{{ route('reply.edit', $reply->id) }}" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</a>
                        @endcan
                        @can('delete', $post)
                            <a href="{{ route('reply.confirm-delete', $reply->id) }}" class="btn btn-default"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    @if ($post->closed)
        <p class="text-center"><em><i class="fa fa-lock"></i>&nbsp;This post is closed.</em></p>
    @endif
@endforelse