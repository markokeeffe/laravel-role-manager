@extends('RoleManager::layouts.main')

@section('title', 'Permissions')

@section('main')

<p>
  {{ link_to_action('MOK\RoleManager\PermissionController@create',
    'Add new permission', array(), array(
      'class' => 'btn btn-success'
  )) }}
</p>

@if ($permissions->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Display Name</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			@foreach ($permissions as $permission)
				@include('RoleManager::permissions._tableRow')
			@endforeach
		</tbody>
	</table>
@else
	There are no permissions
@endif

@stop
