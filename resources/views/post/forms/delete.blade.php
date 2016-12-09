{!! Form::open(['route' => ['post.destroy', $post->id], 'method' => 'delete']) !!}
    {!! Form::hidden('id', $post->id) !!}
    <button type="submit" name="delete-post" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
{!! Form::close() !!}