@extends('rap::layouts.app', ['title' => 'Assign Roles And Permission', 'module' => 'roles'])

@section('content')
        <div class="box box-primary">
            <div class="box-body">
                <div class="alert alert-success" id="alert" role="alert" style="display: none;">
                    {{ trans('roles.success_msg') }}
                </div>
                
                <div class="form-group">
                    <a href="{!! url()->previous() !!}" class="btn btn-info">Back</a>
                </div>

                <div class="form-group">
                    @include('rap::roles_and_permission.modules')
                </div>

                {!! Form::open(['id' => 'roles-and-permission']) !!}
                    <div class="form-group">
                        @include('rap::roles_and_permission.actions')
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $('.select2').select2();

        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });

        var get_action_url = "{!! url('processdrive/rap/assignRolesAndPermission/getActionForRAP')!!}";
        var save_RAP_url = "{!! url('processdrive/rap/roles/saveRAP') !!}";
        var roll_id = "{{ @$id }}";
    </script>
@endsection
