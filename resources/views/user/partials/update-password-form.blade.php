{!! Form::open(['route' => 'user.update_password', 'method' => 'patch']) !!}

    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
        <label for="old_password">Current password:</label>
        {!! Form::password('old_password', ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        @if ($errors->has('old_password'))
            <span class="help-block">
                <strong>{{ $errors->first('old_password') }}</strong>
            </span>
        @endif
    </div>

    <hr />

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password">New password:</label>
        {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password_confirmation">Confirm new password:</label>
        {!! Form::password('password_confirmation', ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>

    <button type="submit" name="update-password" class="btn btn-primary">Update password</button>

{!! Form::close() !!}