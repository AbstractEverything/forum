{!! Form::open(['route' => ['user.ban', $user->id], 'method' => 'PATCH']) !!}
    <hr />
    @if ($user->banned)
        <button type="submit" name="ban-user" class="btn btn-danger"><i class="fa fa-ban"></i>
&nbsp;Unban user</button>
    @else
        <button type="submit" name="ban-user" class="btn btn-danger"><i class="fa fa-ban"></i>
&nbsp;Ban user</button>
    @endif
{!! Form::close() !!}