<!-- Modal -->
<div class="modal fade" id="action-fields" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close-model" data-dismiss="modal">&times;</button>
				<h5 class="">Create Action</h5>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="col-sm-12">
						{!! Form::label('action', 'Action:', ['class' => 'control-label col-sm-2']) !!}
				        <div class="col-sm-10">
				        	{!! Form::text('action', null, ['class' => 'form-control', 'id' => 'action']) !!}
				        </div>
					</div>

				    {!! Form::hidden('module_id', @$module_id, ['id' => 'module_id']) !!}

					{!! Form::hidden('id', @$id, ['id' => 'id']) !!}
				</div>

        		<div class="form-group">
	        		<div class="col-sm-12">
		            	<div class="col-sm-offset-2  col-sm-10">
		            		{!! Form::submit(trans('roles.save'), ['class' => 'btn btn-primary', 'id' => 'save-actions']) !!}
		            		<button type="button" class="btn btn-danger close-model" data-dismiss="modal">Close</button>
	                	</div>
		            </div>
				</div>
			</div>
		</div>
	</div>
</div>