{!! Form::open(['route' => ['post.move', $post->id], 'method' => 'PATCH']) !!}

    <div class="form-group">
        <label for="forum_id">Move post to forum:</label>
        {!! Form::select('forum_id', $forumDropdown, $post->forum->id, ['class' => 'form-control']) !!}
    </div>

    <button type="submit" name="update-moderator-options" class="btn btn-primary"><i class="fa fa-wrench"></i>&nbsp;Move post</button>

{!! Form::close() !!}