{!! Form::open(['route' => 'user.update-profile', 'method' => 'patch']) !!}

    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
        <label for="first_name">First name:</label>
        {!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'id' => 'first_name']) !!}
        @if ($errors->has('first_name'))
            <span class="help-block">
                <strong>{{ $errors->first('first_name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
        <label for="first_name">Last name:</label>
        {!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'id' => 'last_name']) !!}
        @if ($errors->has('last_name'))
            <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
    </div>

    <button type="submit" name="save-profile-changes" class="btn btn-primary">Save profile changes</button>

{!! Form::close() !!}