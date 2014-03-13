@extends('RoleManager::layouts.main')

@section('title', 'Roles')

@section('main')

<p>
  {{ link_to_action('MOK\RoleManager\RoleController@create',
    'Add new role', array(), array(
      'class' => 'btn btn-success'
  )) }}
</p>

@if ($roles->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
        <th>Permissions</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			@foreach ($roles as $role)
				@include('RoleManager::roles._tableRow')
			@endforeach
		</tbody>
	</table>
@else
	There are no roles
@endif

@stop
