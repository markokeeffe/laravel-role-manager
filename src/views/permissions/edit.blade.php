@extends('RoleManager::layouts.main')

@section('title', 'Edit Permission')

@section('main')

{{ Form::model($permission, array('method' => 'PATCH',
  'action' => array('MOK\RoleManager\PermissionController@update', $permission->id),
  'class' => 'form-horizontal col-lg-6 col-lg-offset-3',
)) }}

  @include('RoleManager::permissions._form')

  <div class="form-group">
    <div class="col-lg-8 col-lg-offset-4">
      <button type="submit" class="btn btn-info">Update</button>
      {{ link_to_action('MOK\RoleManager\PermissionController@show',
        'Cancel', $permission->id, array(
          'class' => 'btn btn-default',
        )
      ) }}
    </div>
  </div>

{{ Form::close() }}

@stop
