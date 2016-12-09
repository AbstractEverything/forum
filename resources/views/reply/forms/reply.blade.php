{!! Form::open(['route' => ['reply.store', $post->id]]) !!}

    {!! Form::hidden('post_id', $post->id) !!}

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        {!! Form::text('title', 'Re: '.$post->title, ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'Reply title...']) !!}
        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        {!! Form::textarea('body', $quote, ['class' => 'form-control', 'id' => 'body', 'placeholder' => 'Write something...']) !!}
        @if ($errors->has('body'))
            <span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif
    </div>

    <hr />

    <button type="submit" name="create-new-reply" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Post reply</button>

{!! Form::close() !!}