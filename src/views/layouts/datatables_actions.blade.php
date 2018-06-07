@php
    $module = explode(".", \Request::route()->getName())[0];
@endphp

<form action="{{ url('processdrive/rap/'.$module.'/destroy/'.$id) }}" method="delete" accept-charset="utf-8">
    <div class='btn-group'>

        @if($module === 'roles')
            <a href="{!! url('processdrive/rap/'.$module.'/edit/'.$id) !!}" class='btn btn-default btn-xs'>
                <i class="glyphicon glyphicon-edit"></i>
            </a>

            <a href="{!! url('processdrive/rap/roles/assignPermission/'.$id) !!}" class='btn btn-default btn-xs' title="Assign Roles And Permission">
                <i class="glyphicon glyphicon-plus-sign"></i>
            </a>

            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
                'type' => 'submit',
                'class' => 'btn btn-danger btn-xs',
                'onclick' => "return confirm('".trans('behavior.confirmation')."')"
            ]) !!}
        @endif
    </div>
</form>