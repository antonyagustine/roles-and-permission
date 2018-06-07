@extends('rap::layouts.app', ['title' => @$title])

	@section('content')
		<form action="{{ url('processdrive/rap/'.@$route) }}" class="form-horizontal" method="post" accept-charset="utf-8">

			@include(@$fields)

			<div class="form-group">
				<div class="col-sm-12"></div>        
	            <div class="col-sm-6">
		            @if (@$route)
		            	<div class="col-sm-offset-2  col-sm-10">
		            		{!! Form::submit(trans('roles.save'), ['class' => 'btn btn-primary']) !!}
		            		<a href="{!! url()->previous() !!}" class="btn btn-danger">{!! trans('roles.cancel') !!}</a>
	                	</div>
		            @endif
	            </div>
	        </div>

        </form>
	@endsection