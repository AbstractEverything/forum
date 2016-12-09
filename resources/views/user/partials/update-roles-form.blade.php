{!! Form::open(['route' => ['user.update', $user->id], 'method' => 'PATCH']) !!}
    @foreach ($roles as $role)
    <div class="checkbox">
        <label>
            {!! Form::checkbox('roles[]', $role->id, $userRoles->contains($role->id)) !!}{{ $role->name }}
        </label>
    </div>
    @endforeach
    <hr />
    <button type="submit" name="update-roles" class="btn btn-primary"><i class="fa fa-wrench"></i>&nbsp;Update roles</button>
{!! Form::close() !!}