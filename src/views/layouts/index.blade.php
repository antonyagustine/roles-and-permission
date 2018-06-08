@extends('rap::layouts.app')

@section('content')
	<div class="form-group">
		<div class="col-sm-2">
			@if (@$route)
				<a href="{!! $route !!}" class="btn btn-primary" id="add_new">{!! trans('roles.add_new') !!}</a>
			@endif
			@if (@$button && @$button_back)
				{!! $button_back !!}
				{!! $button !!}
			@endif
		</div>
		<div class="col-sm-offset-8 col-sm-2">
			<div class="inner-addon right-addon">
			    <i class="glyphicon glyphicon-search"></i>
			    {!! Form::text('search', @$search, ['class' => 'form-control', 'placeholder' => 'Press enter to search', 'id' => 'search', 'autofocus' => 'autofocus']) !!}
			</div>
		</div>
	</div>

	@yield('table')
	
@endsection