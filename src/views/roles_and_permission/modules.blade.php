<div class="container">
  	<div class="row">
  		<div class="panel panel-primary"> 
  			<div class="panel-body">
				<div class="form-group">
					{!! Form::label('name', trans('roles.module'), ['class' => 'control-label col-sm-2']) !!}
				    <div class="col-sm-10">
				    	<div class="input-group">
					    	{!! Form::select('test[]', @$modules, null, ['class' => 'form-control select2 select2-hidden-accessible', 'style' => 'width: 100%;', 'aria-hidden' => true,  "multiple" => true, 'id' => 'rap_modules']) !!}
					    	<span class="input-group-addon" style="padding: 0 12px;">
                                {!! Form::checkbox('select_all', '1', null, ['id' => 'select_all']) !!}    
                            </span>
                        </div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>