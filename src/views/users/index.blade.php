@extends('RoleManager::layouts.main')

@section('title', 'Users')

@section('main')

<p>

</p>

@if ($users->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
        <th>Roles</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			@foreach ($users as $user)
				<tr>
          <td>{{{ $user->username }}}</td>
          <td>{{{ $user->rolesList }}}</td>
          <td class="controls">
            {{ link_to_action('MOK\RoleManager\UserController@roles',
            'Roles', array($user->id), array(
            'class' => 'btn btn-xs btn-success pull-right',
            )) }}
          </td>
        </tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no users
@endif

@stop
