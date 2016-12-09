@foreach ($pinnedPosts as $pinnedPost)
    <tr class="warning">
        <td class="text-middle">
            @if ($pinnedPost->closed == true)
                <i class="fa fa-lock"></i>
            @endif
            <i class="fa fa-thumb-tack"></i>
            Pinned: <strong><a href="{{ route('post.show', $pinnedPost->id) }}">{{ $pinnedPost->title }}</a></strong>
            <br />
            <span class="text-muted">Started {{ $pinnedPost->present()->createdAgo() }} <em>by</em> <a href="{{ route('user.show', $pinnedPost->user_id) }}">{{ $pinnedPost->user->username }}</a></span>
        </td>
        <td class="text-center text-middle">{{ $pinnedPost->views }}</td>
        <td class="text-center text-middle">{{ $pinnedPost->repliesCount }}</td>
        <td class="text-middle">
            @if ($pinnedPost->repliesCount > 0)
                <a href="{{ route('user.show', $pinnedPost->latestReply->user->id) }}">{{ $pinnedPost->latestReply->user->username }}</a>
                <br />
                <span class="text-muted">{{ $pinnedPost->latestReply->present()->createdAgo() }}</span>
            @else
                <span class="text-muted"><em>No replies</em></span>
            @endif
        </td>
    </tr>
@endforeach