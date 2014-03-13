@extends('RoleManager::layouts.main')

@section('title', 'View Permission: '.$permission->name)

@section('main')

<p>
  {{ link_to_action('MOK\RoleManager\PermissionController@index',
    'All permissions', array(), array(
      'class' => 'btn btn-default'
  )) }}
</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Display Name</th>
		</tr>
	</thead>

	<tbody>
		@include('RoleManager::permissions._tableRow')
	</tbody>
</table>

@stop
