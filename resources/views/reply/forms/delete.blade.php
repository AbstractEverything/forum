{!! Form::open(['route' => ['reply.destroy', $reply->id], 'method' => 'delete']) !!}
    {!! Form::hidden('id', $reply->id) !!}
    <button type="submit" name="delete-reply" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
{!! Form::close() !!}