{!! Form::open(['route' => ['forum.update', $forum->id], 'method' => 'PATCH']) !!}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        {!! Form::text('name', $forum->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Forum name...']) !!}
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        {!! Form::textarea('description', $forum->description, ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Description of the forum...']) !!}
        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>

    <div class="checkbox">
        <label>
            <input type="hidden" name="closed" value="0">
            <input type="checkbox" name="closed" value="1" @if (old('closed', $forum->closed) == '1') checked @endif>Closed
        </label>
    </div>
    
    <hr />

    <button type="submit" name="update-forum" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Save changes</button>

{!! Form::close() !!}