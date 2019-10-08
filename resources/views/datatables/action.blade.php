<a href="{{route('obats.edit', ['id'=>$id])}}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit-user">
    Edit
</a>
{!! Form::open(['method'=>'DELETE', 'route'=>['obats.destroy', $id]]) !!}
<button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-circle btn-danger ">
    <i class="glyphicon glyphicon-remove"></i>Delete
</button>
{!! Form::close() !!}