<div class="form-group">
	<div class="col-sm-6">
		{!! Form::label('name', 'Name', ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
        	{!! Form::text('Name', @$value, ['class' => 'form-control']) !!}
        </div>
	</div>
	<div class="col-sm-6">
		{!! Form::label('name', 'Age', ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
        	{!! Form::text('Age', @$age, ['class' => 'form-control']) !!}
        </div>
	</div>
</div>