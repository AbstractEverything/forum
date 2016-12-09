{!! Form::open(['route' => ['post.options', $post->id], 'method' => 'PATCH']) !!}

    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="hidden" name="pinned" value="0">
                <input type="checkbox" name="pinned" value="1" @if (old('pinned', $post->pinned) == '1') checked @endif>Pinned
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="hidden" name="closed" value="0">
                <input type="checkbox" name="closed" value="1" @if (old('closed', $post->closed) == '1') checked @endif>Closed
            </label>
        </div>
    </div>

    <button type="submit" name="update-moderator-options" class="btn btn-primary"><i class="fa fa-wrench"></i>&nbsp;Update options</button>

{!! Form::close() !!}