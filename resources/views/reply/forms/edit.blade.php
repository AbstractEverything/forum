{!! Form::open(['route' => ['reply.update', $reply->id], 'method' => 'PATCH']) !!}

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {!! Form::text('title', $reply->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Reply title...']) !!}
        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        {!! Form::textarea('body', $reply->body, ['class' => 'form-control', 'id' => 'body', 'placeholder' => 'Write something...']) !!}
        @if ($errors->has('body'))
            <span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif
    </div>

    <hr />

    <button type="submit" name="edit-reply" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Save changes</button>

{!! Form::close() !!}