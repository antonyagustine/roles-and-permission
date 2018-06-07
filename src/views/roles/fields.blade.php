<div class="form-group">
	<div class="col-sm-6">
		{!! Form::label('name', 'Name:', ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
        	{!! Form::text('name', @$role->name, ['class' => 'form-control']) !!}
        </div>
	</div>
	@if(!empty(@$roles))
		<div class="col-sm-6">
			{!! Form::label('existing_role', 'Existing Roles:', ['class' => 'control-label col-sm-2']) !!}
	        <div class="col-sm-10">
	        	{!! Form::select('existing_role', @$roles, @$role->existing_role,['class' => 'form-control', "placeholder" => "--Select--"]) !!}
	        </div>
		</div>
	@endif
</div>