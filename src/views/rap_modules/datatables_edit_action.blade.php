<div class='btn-group'>
    <a data-id="{!! $id !!}" class='btn btn-default btn-sm' title="Assign Roles And Permission" id="edit-action">
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['class' => 'btn btn-danger btn-sm', 'id' => 'delete-action', 'data-id' => $id ]) !!}
</div>