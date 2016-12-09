{!! Form::open(['route' => ['forum.destroy', $forum->id], 'method' => 'delete']) !!}
    {!! Form::hidden('id', $forum->id) !!}
    <button type="submit" name="delete-forum" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
{!! Form::close() !!}