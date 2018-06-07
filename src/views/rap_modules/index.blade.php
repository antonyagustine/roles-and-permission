@extends('rap::layouts.index', [
    'title' => 'Modules',
    'module' => 'rapModules'
])

@section('table')
	<div class="form-group">
		<div class="col-sm-12">
			<div class="table-responsive">          
				<table class="table">
					<thead>
						<tr>
							<th>{{ trans('roles.action') }}</th>
							<th>{{ trans('roles.name') }}</th>
						</tr>
					</thead>
					<tbody>
						@if (!empty($data))
							@foreach ($data as $value)
								<tr>
									<td>@include('rap::rap_modules.datatables_actions', ['id' => $value->id])</td>
									<td>{!! trans('rap_modules.'.$value->name) !!}</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>

				<div class="pull-right">
					{{ @$data->links() }}	
				</div>
			</div>
		</div>
	</div>
@endsection