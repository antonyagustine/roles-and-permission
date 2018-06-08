@extends('rap::layouts.index', [
    'title' => 'Actions',
    'module' => 'rapAction'
])

<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            @php
                $button_back = '<a href='.route("rap", "rapModules.index").' class="btn btn-info">'.trans("roles.back").'</a>';
                $button = '<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#action-fields">'.trans("roles.add_new").'</button>';
            @endphp
			
            <form action="" class="form-horizontal" method="post" accept-charset="utf-8" id="rap-actions-form">
				@include('rap::rap_modules.fields')
            </form>
        </div>
    </div>
</div>

@section('table')
    <div class="form-group">
        <div class="col-sm-12">
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{!! trans('roles.action') !!}</th>
                            <th>{!! trans('roles.name') !!}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if (!empty($data))
                            @foreach ($data as $value)
                                <tr>
                                    <td>@include('rap::rap_modules.datatables_edit_action', ['id' => $value->id])</td>
                                    <td>{!! $value->action !!}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pull-right">
            {{ @$data->links() }}   
        </div>
    </div>
@endsection
        

@section('js')
	<script type="text/javascript">
		var save_action_url = '{{ url('processdrive/rap/rapModules/save/actions') }}';
		var edit_action_url = '{{ url('processdrive/rap/rapModules/edit/actions') }}';
        var delete_action_url = '{{ url('processdrive/rap/rapModules/delete/actions') }}';
		var render_action_url = '{{ url('processdrive/rap/rapModules/render/actions/'.@$module_id) }}';
		var module_id = '{!! @$module_id !!}';
	</script>
@endsection