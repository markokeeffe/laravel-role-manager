@extends('RoleManager::layouts.main')

@section('title', 'Manage Role Permissions: '.$role->name)

@section('main')


<div class="row">
  <div class="col-lg-6">
    <h2>Available Permissions</h2>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>Name</th>
        <th>
          {{ link_to_action('MOK\RoleManager\RoleController@addAllPermissions',
          'Add All', array(
            'id' => $role->id,
          ), array(
            'class' => 'btn btn-xs btn-success',
          )) }}
        </th>
      </tr>
      </thead>
      <tbody>
      @foreach ($permission->getGrouped($role, false) as $name => $group)
        <tr class="parent">
          <td>{{{ $name }}}</td>
          <td>
            <a href="#"  class="btn btn-info btn-xs"
               data-behavior="toggleHidden"
               data-selector="#{{{ camel_case($name) }}}_a_children"
               data-icon=".glyphicon"
               data-icon-class="glyphicon glyphicon-chevron-up"
            >
              <span class="glyphicon glyphicon-chevron-down"></span>
            </a>
            {{ link_to_action('MOK\RoleManager\RoleController@addPermissionGroup',
            'Add', array(
              'id' => $role->id,
              'group' => $name,
            ), array(
              'class' => 'btn btn-xs btn-success',
            )) }}
          </td>
        </tr>
        <tr class="child" id="{{{ camel_case($name) }}}_a_children" style="display: none;">
          <td colspan="2">
            <table class="table">
              <tbody>
              @foreach ($group as $permission)
              <tr>
                <td>{{{ $permission->display_name }}}</td>
                <td>
                  {{ link_to_action('MOK\RoleManager\RoleController@addPermission',
                  'Add', array(
                    'id' => $role->id,
                    'permission_id' => $permission->id,
                  ), array(
                    'class' => 'btn btn-xs btn-success',
                  )) }}
                </td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>

  </div>
  <div class="col-lg-6">
    <h2>{{{ $role->name }}} Permissions</h2>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>Name</th>
        <th>
          {{ link_to_action('MOK\RoleManager\RoleController@detachAllPermissions',
          'Remove All', array(
            'id' => $role->id,
          ), array(
            'class' => 'btn btn-xs btn-danger',
          )) }}
        </th>
      </tr>
      </thead>
      <tbody>
      @foreach ($permission->getGrouped($role, true) as $name => $group)
      <tr class="parent">
        <td>{{{ $name }}}</td>
        <td>
          <a href="#" class="btn btn-info btn-xs"
             data-behavior="toggleHidden"
             data-selector="#{{{ camel_case($name) }}}_b_children"
             data-icon=".glyphicon"
             data-icon-class="glyphicon glyphicon-chevron-up"
            >
            <span class="glyphicon glyphicon-chevron-down"></span>
          </a>
          {{ link_to_action('MOK\RoleManager\RoleController@detachPermissionGroup',
          'Remove', array(
            'id' => $role->id,
            'group' => $name,
          ), array(
            'class' => 'btn btn-xs btn-danger',
          )) }}
        </td>
      </tr>
      <tr class="child" id="{{{ camel_case($name) }}}_b_children" style="display: none;">
        <td colspan="2">
          <table class="table">
            <tbody>
            @foreach ($group as $permission)
            <tr>
              <td>{{{ $permission->display_name }}}</td>
              <td>
                {{ link_to_action('MOK\RoleManager\RoleController@detachPermission',
                'Remove', array(
                  'id' => $role->id,
                  'permission_id' => $permission->id,
                ), array(
                  'class' => 'btn btn-xs btn-danger',
                )) }}
              </td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

@stop
