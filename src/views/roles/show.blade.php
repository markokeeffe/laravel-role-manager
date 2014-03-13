@extends('RoleManager::layouts.main')

@section('title', 'View Role: '.$role->name)

@section('main')

<p>
  {{ link_to_action('MOK\RoleManager\RoleController@index',
    'All roles', array(), array(
      'class' => 'btn btn-default'
  )) }}
</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
      <th>Permissions</th>
		</tr>
	</thead>

	<tbody>
		@include('RoleManager::roles._tableRow')
	</tbody>
</table>

@stop
