@php 
    $route = @$role->id ? 'roles/update/'.$role->id : 'roles/store';
@endphp

@include('rap::layouts.form', [
	'route' => $route,
    'title'   => trans('roles.title'),
    'fields' => 'rap::roles.fields',
    'module' => 'roles'
])
