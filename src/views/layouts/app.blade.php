<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="rap-master-layout" content="width=device-width, initial-scale=1">

        <title>RAP</title>

        {{-- Style Sheets --}}
        {!! Html::style('vendor/rap/public/assets/bootstrap/css/bootstrap.min.css') !!}
        {!! Html::style('vendor/rap/public/css/app.css') !!}
        {!! Html::style('vendor/rap/public/assets/icheck/skins/all.css') !!}
        {!! Html::style('vendor/rap/public/assets/select2/select2.min.css') !!}

        @yield('css')
    </head>
    <body>
        <div class="body-wrap">
            <div class="container-fluid">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li class="dropdown">
                                    <a href="#" class="glyphicon glyphicon-th-list dropdown-toggle" id="menu" data-toggle="dropdown"></a>
                                    <ul class="dropdown-menu navbar-left">
                                        <li><a href="{{ route('rap', 'roles.index') }}">Roles</a></li>
                                        <li><a onclick="" href="{{ route('rap', 'rapModules.index') }}">Modules</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav">
                                <li><a style="font-size: 30px;">{!! @$title !!}</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="panel-body">
                        <div class="alert alert-success" id="alert-msg" role="alert" style="display: none;"></div>
                        @if (@$msg)
                            @include('rap::flash.message')
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

		{{-- Scripts --}}
        {!! Html::script('vendor/rap/public/assets/bootstrap/js/jquery.min.js') !!} 
        {!! Html::script('vendor/rap/public/assets/bootstrap/js/bootstrap.min.js') !!}
        {!! Html::script('vendor/rap/public/js/AjaxHelper.js') !!}
        {!! Html::script('vendor/rap/public/assets/icheck/icheck.min.js') !!}
        {!! Html::script('vendor/rap/public/assets/select2/select2.full.min.js') !!}
        {!! Html::script('vendor/rap/public/js/rap.min.js') !!}

        @yield('js')

        <script type="text/javascript">
            var destroy_trans = '{!! trans("roles.destroy_msg") !!}'
            var store_trans = '{!! trans("roles.store_msg") !!}'
            var module = '{!! @$module !!}';
            var search_role_url = ''
            
            search_role_url = (module === 'rapAction') ? '{{ url('processdrive/rap/'.$module.'/search') }}/'+module_id : '{{ url('processdrive/rap/'.$module.'/search') }}'
        </script>
    </body>
</html>
