<div class="panel panel-default" id="post-{{ $post->id }}">
    <div class="panel-heading"><span class="badge">1</span>&nbsp;<strong>{{ $post->present()->createdAgo() }}</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-2 col-lg-2 post-profile">
                <img src="{{ Gravatar::src($post->user->email, 80) }}" class="img-responsive" />
                <h4><a href="{{ route('user.show', $post->user->id) }}">{{ $post->user->username }}</a></h4>
                <ul class="naked">
                    <li><small>Member since {{ $post->user->present()->dateOnly() }}</small></li>
                    <li><small>Posts: {{ $post->user->present()->postsAndRepliesCount() }}</small></li>
                    @if ($post->user->banned == true)
                        <li><small class="label label-danger">Banned!</small></li>
                    @endif
                </ul>
            </div>
            <div class="col-sm-10 col-lg-10">
                <p><strong>{{ $post->title }}</strong></p>
                {!! $post->present()->markdownBody() !!}
                <hr />
                <div class="post-options text-right">
                    @can('reply', $post)
                        <a href="{{ route('reply.create', [$post->id, 'quote_id' => $post->id, 'type' => 'post']) }}" class="btn btn-default"><i class="fa fa-quote-right"></i>&nbsp;Reply with quote</a>&nbsp;
                    @endcan
                    @can('edit', $post)
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</a>
                    @endcan
                    @can('delete', $post)
                        <a href="{{ route('post.confirm-delete', $post->id) }}" class="btn btn-default"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>