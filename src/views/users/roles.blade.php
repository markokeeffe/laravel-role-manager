@extends('RoleManager::layouts.main')

@section('title', 'Manage User Roles: '.$user->username)

@section('main')


<div class="row">
  <div class="col-lg-6">
    <h2>Available Roles</h2>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>Name</th>
        <th>
          {{ link_to_action('MOK\RoleManager\UserController@addAllRoles',
          'Add All', array(
            'id' => $user->id,
          ), array(
            'class' => 'btn btn-xs btn-success',
          )) }}
        </th>
      </tr>
      </thead>
      <tbody>
      @foreach ($role->getForUser($user, false) as $role)
        <tr>
          <td>{{{ $role->name }}}</td>
          <td>
            {{ link_to_action('MOK\RoleManager\UserController@addRole',
            'Add', array(
            'id' => $user->id,
            'role_id' => $role->id,
            ), array(
            'class' => 'btn btn-xs btn-success',
            )) }}
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

  </div>
  <div class="col-lg-6">
    <h2>{{{ $user->username }}} Roles</h2>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>Name</th>
        <th>
          {{ link_to_action('MOK\RoleManager\UserController@detachAllRoles',
          'Remove All', array(
            'id' => $user->id,
          ), array(
            'class' => 'btn btn-xs btn-danger',
          )) }}
        </th>
      </tr>
      </thead>
      <tbody>
      @foreach ($role->getForUser($user, true) as $role)
        <tr>
          <td>{{{ $role->name }}}</td>
          <td>
            {{ link_to_action('MOK\RoleManager\UserController@detachRole',
            'Remove', array(
            'id' => $user->id,
            'role_id' => $role->id,
            ), array(
            'class' => 'btn btn-xs btn-danger',
            )) }}
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

@stop
