
@extends('rap::layouts.index', [
    'route' => route('rap', 'roles.create'),
    'title' => trans('roles.title'),
    'module' => 'roles'
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
									<td>@include('rap::layouts.datatables_actions', ['id' => $value->id])</td>
									<td>{!! @$value->name !!}</td>
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