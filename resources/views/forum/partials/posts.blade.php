@forelse ($posts as $post)
    <tr>
        <td class="text-middle">
            @if ($post->moved == true)
                <i class="fa fa-arrow-right"></i>
            @endif
            @if ($post->closed == true)
                <i class="fa fa-lock"></i>
            @endif
            @if ( ! $post->closed)
                @if ($post->isHot())
                    <i class="fa fa-files-o"></i>
                @else
                    <i class="fa fa-file-o"></i>
                @endif
            @endif
            <strong><a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a></strong>
            <br />
            <span class="text-muted">Started {{ $post->present()->createdAgo() }} <em>by</em> <strong><a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->username }}</a></strong></span>
        </td>
        <td class="text-center text-middle">{{ $post->views }}</td>
        <td class="text-center text-middle">{{ $post->repliesCount }}</td>
        <td class="text-middle">
            @if ($post->repliesCount > 0)
                <strong><a href="{{ route('user.show', $post->latestReply->user->id) }}">{{ $post->latestReply->user->username }}</a></strong>
                <br />
                <span class="text-muted">{{ $post->latestReply->present()->createdAgo() }}</span>
            @else
                <span class="text-muted"><em>No replies</em></span>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center"><em>No posts yet.</em></td>
    </tr>
@endforelse